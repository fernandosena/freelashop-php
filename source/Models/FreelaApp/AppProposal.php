<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 18/12/2021
 * Time: 18:39
 */

namespace Source\Models\FreelaApp;


use Source\App\App\Project;
use Source\Core\Model;
use Source\Core\View;
use Source\Models\Auth;
use Source\Models\FreelaApp\AppProject;
use Source\Models\Notification;
use Source\Models\User;
use Source\Support\Email;

/**
 * CLASSE QUE TRABALHA COM AS PROPOSTAS
 * Class AppProposal
 * @package Source\Models\FreelaApp
 */
class AppProposal extends Model
{
    /**
     * AppProposal constructor.
     */
    public function __construct()
    {
        parent::__construct("app_proposals", ["id"],["user_id", "project_id", "content"]);
    }

    /**
     * @param User $user
     * @param \Source\Models\FreelaApp\AppProject $project
     * @param array $data
     * @return bool
     */
    public function register(User $user, AppProject $project, array $data)
    {
        //Verifica se o se o perfil do usuario e freelancer
        if($user->type != "freelancer"){
            $this->message->warning("Para enviar uma proposta, seu perfil deve ser de freelancer!")->render();
            return false;
        }

        //Verifica se o usuário já confirmou o e-mail
        if($user->status != "confirmed"){
            $this->message->warning("Para mandar uma proposta primeiramente você deve confirmar seu e-mail")->render();
            return false;
        }

        //Verifica se o campo de content está vazio
        if(empty($data["content"])){
            $this->message->warning("Preencha o campo obrigátorio")->render();
            return false;
        }

        //Verifica se a data de incio é inferior a data de termino
        if(!empty($data["start"]) && !empty($data["delivery"])){
            if($data["start"] >= $data["delivery"]){
                $this->message->warning("A data de termino deve ser superior a de inicio")->render();
                return false;
            }
        }

        //Verifica se o usuario está mandando proposta para ele mesmo
        if($project->author == $user->id){
            $this->message->warning("Você não pode mandar proposta para o seu proprio projeto");
            return false;
        }

        $msgProject = "recebida";
        $msgProposal = "enviada";
        //Verifica se tem o ID
        if(!empty($data['id'])){
            if(!$this->find("id = :id AND user_id = :user_id", "id={$data['id']}&user_id={$user->id}")->count()){
                $this->message->warning("O Projeto informado é invalido");
                return false;
            }

            $this->id = $data['id'];
            $msgProject = "atualizada";
            $msgProposal = "atualizada";
        }else{
            //Verifica se o usuario ja criou uma proposta para o projeto
            if($this->find("user_id = :user_id AND project_id = :project_id", "user_id={$user->id}&project_id={$project->id}")->count()){
                $this->message->warning("Você não pode cadatrar mais de uma proposta para o mesmo projeto");
                return false;
            }
        }

        $this->user_id = $user->id;
        $this->project_id = $project->id;
        $this->price = (!empty($data["value"]) ? str_replace([".", ","], "", $data["value"]) : null);
        $this->start = (!empty($data["start"]) ? $data["start"] : null);
        $this->delivery = (!empty($data["delivery"]) ? $data["delivery"] : null);
        $this->content = nl2br(str_textarea($data["content"]));
        $this->percentage = CONF_SITE_PERCENTAGE;

        if(!$this->save()){
            $this->message()->render();
            return false;
        }


        //Verifica se ja tem um grupo cadastrado para esse projeto e proposta
        $before = "";
        $group = (new AppGroupChat());
        $groupFind = $group->find("project_id = :project AND proposal_id = :proposal", "project={$project->id}&proposal={$this->id}")->fetch();
        if(!$groupFind){
            //Criar Grupo mensagem se não existir
            if(!$group->register($project, $this)){
                $this->message->error("Erro ao cadastrar grupo do chat")->render();
                return false;
            }
        }else{
            $group = $groupFind;
            $before = "
            <div style='border-bottom: 1px solid rgba(0,0,0,.2); margin: 10px 0; padding: 10px 0'>
                <h5>Proposta atualizada</h5>
            </div>
            ";
        }

        $chat = (new AppChat());
        $after = "
            <div style='border-top: 1px solid rgba(0,0,0,.2); margin: 10px 0; padding: 10px 0'>
                <label><strong>Data inicio: </strong><span>".($this->start ? date("d/m/Y", strtotime($this->start)) : "Não definido")."</span></label><br>
                <label><strong>Data final: </strong><span>".($this->delivery ? date("d/m/Y", strtotime($this->delivery)) : "Não definido")."</span></label><br>
                <label><strong>Valor: </strong><span>R$ ".($this->price ? str_price($this->price) : "Não definido")."</span></label><br>
            </div>
        ";

        if(!$chat->register($group, $user, $before.$this->content.$after)){
            $this->message->error("Erro ao cadastrar mandar mensagem no chat")->render();
            return false;
        }

        //Email Criador da proposta
        $subject = "Proposta {$msgProposal} com sucesso";
        (new Email())->bootstrap(
            $subject,
            $user->email,
            $user->fullName()
        )->view(
            "default", [
                "title" => $subject,
                "message" => "<p>Olá {$user->first_name}, </p>
                <p>sua proposta foi {$msgProposal} com sucesso referente ao projeto <strong>{$project->title}</strong></p>"
            ]
        )->queue();

        //Email Criador do projeto
        $subject = "Proposta $msgProject";
        (new Email())->bootstrap(
            $subject,
            $project->author()->email,
            $project->author()->fullName()
        )->view(
            "default", [
                "title" => $subject,
                "message" => "<p>Olá {$project->author()->first_name},</p>
                <p>Você recebeu uma proposta do freelancer <strong>{$user->first_name}</strong> referente ao projeto <strong>{$project->title}</strong></p>"
            ]
        )->queue();

        return true;
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return (new User())->findById($this->user_id);
    }

    /**
     * @return \Source\Models\FreelaApp\AppProject
     */
    public function project(): AppProject
    {
        return (new AppProject())->findById($this->project_id);
    }

    /**
     * Recupera dados da sala de chat
     * @return AppGroupChat
     */
    public function groupChat(): AppGroupChat
    {
        return (new AppGroupChat())->find("proposal_id = :proposal_id", "proposal_id={$this->id}")->fetch();
    }

    /**
     * @return array|mixed|null|Model
     */
    public function contract()
    {
        return (new AppContract())->find("proposal_id = :proposal_id", "proposal_id={$this->id}")->fetch();
    }
}
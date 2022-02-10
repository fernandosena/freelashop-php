<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 01/01/2022
 * Time: 17:12
 */

namespace Source\App\App;


use Source\Models\Auth;
use Source\Models\FreelaApp\AppBoleto;
use Source\Models\FreelaApp\AppBoletoPagSeguro;
use Source\Models\FreelaApp\AppContract;
use Source\Models\FreelaApp\AppCreditCardGetNet;
use Source\Models\FreelaApp\AppPix;
use Source\Models\FreelaApp\AppPixGetNet;
use Source\Models\FreelaApp\AppPlan;
use Source\Models\FreelaApp\AppProject;
use Source\Models\FreelaApp\AppProposal;
use Source\Models\FreelaApp\AppSubscription;
use Source\Models\PagSeguro;

/**
 * Class Proposal
 * @package Source\App\App
 */
class Proposal extends App
{

    /**
     * Cadastra nova proposta, mostrar propostas
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (!empty($data['content'])) {

            if (request_limit("projectProposal", 200, 60 * 5)) {
                $this->message->warning("Foi muito rápido {$this->user->first_name} por favor aguarde 5 minutos
                 para novas propostas")->flash();
                echo json_encode(["reload" => true]);
                return;
            }

            //consulta dados do projeto
            $project = (new AppProject())
                ->find("uri = :uri", "uri={$data['uri']}")
                ->fetch();

            $proposal = (new AppProposal());

            //Verifica se existe uam incrição ativa
            $subscriptions = (new AppSubscription())->find("user_id = :user_id AND status = 'active'",
                "user_id={$this->user->id}")->fetch();

            $day = date('w')-1;
            $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
            $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));

            if(empty($data['id'])){
                $qtd = $proposal->find("user_id = :user_id AND created_at BETWEEN :a AND :b", "user_id={$this->user->id}&a={$week_start}&b={$week_end}")->count();
                if(!$subscriptions){
                    $proposalQtd = CONF_SEND_PROPOSAL["FREE"];
                }else{
                    $plan = (new AppPlan())->findById($subscriptions->plan_id);
                    if($plan->name == "BASIC"){
                        $proposalQtd = CONF_SEND_PROPOSAL["BASIC"];
                    }
                    if($plan->name == "STANDARD"){
                        $proposalQtd = CONF_SEND_PROPOSAL["STARDARD"];
                    }
                }

                if(!empty($proposalQtd) && ($qtd >= $proposalQtd)){
                    $this->message->warning("Você excedeu o limite de envio de propostas semanais, caso queira enviar mais propostas contrate um novo plano")->flash();
                    echo json_encode(["redirect" => url("/app/assinatura")]);
                    return;
                }
            }

            $register = $proposal->register(Auth::user(), $project, $data);
            if (!$register) {
                $proposal->message()->flash();
                echo json_encode(["reload" => true]);
                return;
            }

            $this->message->success("Proposta enviada com sucesso")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        $head = $this->seo->render(
            "Propostas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/app/propostas/{$data['uri']}"),
            theme("/assets/images/share.jpg"),
            false
        );

        $project = (new AppProject())->find("uri = :uri", "uri={$data['uri']}", "id, author, title, uri");
        if(!$project->count()){
            $this->message->warning("Projeto informado não existe")->flash();
            redirect("/app/propostas");
        }

        $project = $project->fetch();
        $userId = ($project->author != $this->user->id) ? "user_id = {$this->user->id} AND": "";
        $proposal = (new AppProposal())->find("{$userId} project_id = :project_id",
            "project_id={$project->id}")->fetch(true);

        echo $this->view->render("app/proposals", [
            "head" => $head,
            "title"=>"Propostas",
            "subtitle" => "<strong>Projeto:</strong> <a href='".url("/projetos/".$project->uri)."'>{$project->title}</a>",
            "proposals"=> $proposal,
            "paginator" => ""
        ]);
    }

    /**
     * Mostra detalhes da proposta
     * @param array|null $data
     */
    public function proposal(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $head = $this->seo->render(
            "Proposta - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/app/proposta/{$data['id']}"),
            theme("/assets/images/share.jpg"),
            false
        );

        $proposal = (new AppProposal())->find("id = :id",
            "id={$data['id']}")->fetch();

        if(!$proposal){
            $this->message->warning("Proposta informada não existe")->flash();
            redirect("/app/chat");
        }
        $project = (new AppProject())->findById($proposal->project_id);

        if(($proposal->user_id != $this->user->id)){
            if($this->user->id != $project->author){
                $this->message->warning("Projeto informada não existe")->flash();
                redirect("/projetos");
            }
        }

        //Contratante
        if($this->user->id == $project->author){
            //Verifica se existe algum contrto
            $contract = (new AppContract())->find("proposal_id = :proposal_id", "proposal_id={$proposal->id}");
            $action = null;
            if(!$contract->count()){
                //Verifica se a proposta e o projeto esta disponivel para ser aceita
                if($project->status == "accepted"){
                    $action = '
                        <div class="text-center mt-5 mb-3">
                            <a href="#" class="btn btn-border-ui btn-sm btn-warning action-project"
                               data-action="'.url("/app/freelancer/contract/{$project->id}/{$proposal->id}").'"
                               data-title="Deseja contratar esse freelancer?"
                               data-description="Ao clicar em SIM, você concorda que leu e aceita todas as cláusulas do contrato de prestação de serviço e que para a sua segurança todas as comunicações e transações
                            financeiras relativas a este trabalho será realizado na plataforma.">
                                <i class="fas fa-check"></i> Contratar freelancer</a>
                        </div>
                    ';
                }
            }else{
                if($project->status == "pending_pay"){
                    $action = '
                    <div class="text-center mt-5 mb-3">
                        <a href="'.url("/app/proposta/checkout/{$proposal->id}").'"
                         class="btn btn-border-ui btn-sm btn-warning">
                        R$ Realizar pagamento</a>
                    </div>
                    ';
                }

                //Verifica status do projeto active
                if($project->status == "active"){
                    $action = '
                        <div class="text-center mt-5 mb-3">
                            <a href="#" class="btn btn-border-ui btn-sm btn-primary action-project" 
                            data-description="Você concorda que o freelancer prestou o melhor serviço e entregou um projeto satisfatório e sem nenhuma pendência? ao clicar em SIM o valor será liberado para a conta do freelancer."
                            data-action="'.url("/app/action/aproved/".$project->uri).'">
                            <i class="fas fa-check"></i> Concluir projeto e liberar valor para o freelancer</a>
                        </div>
                    ';
                }
            }

            $action .= '
                <div class="text-center mt-2 mb-3">
                    <a href="#service-contract" class="popup-with-move-anim">Contrato de pestação de serviço</a>
                </div>
            ';
        }

        //Contratante
        if($this->user->id == $proposal->user_id){
            if($project->status == "accepted"){
                $action = '
                    <div class="text-center mt-5 mb-3">
                        <a class="btn btn-border-ui btn-sm btn-primary popup-with-move-anim" href="#modal-proposal">
                            <i class="fas fa-pen"></i> Editar proposta</a>
                    </div>
                ';
            }
        }

        if(($this->user->id == $proposal->user_id) || ($this->user->id == $project->author)){
            $buttom = '
                <a href="'.url("/app/chat/".$proposal->groupChat()->id).'" class="btn btn-border-ui btn-sm btn-primary">
                <i class="fa-solid fa-comments"></i> Sala de chat</a>
            ';
        }


        //Mensagem para o freelancer
        if($project->status == "pending_pay" || $project->status == "active" || $project->status == "concluded"){
            $contract = (new AppContract())->find("project_id = :project_id", "project_id={$project->id}")->fetch();
            if(!empty($contract) && ($this->user->id == $contract->proposal()->user_id)){
                if($project->status == "pending_pay"){
                    $message =  $this->message->info("O cliente aceitou a sua proposta, <strong> NÂO COMECE O TRABALHO AINDA</strong>. estamos aguardando o pagamento do cliente, enviaremos um e-mail confirmando o pagamento e liberando você para realizar o trabalho. <strong>aguarde nosso contato</strong>.")->render();
                }
                if($project->status == "active"){
                    $message =  $this->message->info("O cliente realizou o pagamento da proposta, você ja pode iniciar o serviço. bom trabalho ;)")->render();
                }
                if($project->status == "concluded" && $contract->status == "pending"){
                    $message =  $this->message->info("O cliente já liberou o valor da proposta para você. Aguarde, iremos tranferir o valor em até 5 dias úteis.")->render();
                }
            }
        }

        echo $this->view->render("app/proposal", [
            "head" => $head,
            "proposal"=> $proposal,
            "project" => $project,
            "paginator" => "",
            "buttom" => ($buttom ?? null),
            "action" => ($action ?? null),
            "message"=> ($message ?? null)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function checkout(?array $data)
    {
        $head = $this->seo->render(
            "Checkout Proposta - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/app/proposta/checkout/{$data['proposal']}"),
            theme("/assets/images/share.jpg"),
            false
        );

        $proposal = (new AppProposal())->find("id = :id",
            "id={$data['proposal']}")->fetch();

        if(!$proposal){
            $this->message->warning("Proposta informada não existe")->flash();
            redirect("/app/proposta/{$data['proposal']}");
        }

        $project = (new AppProject())->findById($proposal->project_id);
        if($this->user->id != $project->author){
            $this->message->warning("Projeto informado não existe")->flash();
            redirect("/app/proposta/{$data['proposal']}");
        }

        if($project->status != "pending_pay"){
            $this->message->warning("Esse projeto ja foi pago")->flash();
            redirect("/projetos");
        }

        $contract = (new AppContract())->find("proposal_id = :proposal_id", "proposal_id={$proposal->id}")->count();
        if(!$contract){
            $this->message->warning("Contrate o freelancer antes de realizar o pagamento")->flash();
            redirect("/app/proposta/{$data['proposal']}");
        }

        $boleto = (new AppBoleto())->find("proposal_id = :proposal_id AND due_at >= NOW()", "proposal_id={$proposal->id}")->fetch();
        $pix = (new AppPix())->find("proposal_id = :proposal_id AND expires_at >= NOW()", "proposal_id={$proposal->id}")->fetch();

        echo $this->view->render("app/checkout", [
            "head" => $head,
            "product"=> [
                "post" => "proposal",
                "title" => "Projeto",
                "id" => $proposal->id,
                "price" => $proposal->price,
                "name" => $project->title,
                "period" => "Pagamento único",
                "currency"=>"BRL"
            ],
            "project" => $project,
            "paginator" => "",
            "transfer" => true,
            "boleto" => $boleto,
            "pix" => $pix
        ]);
    }
}
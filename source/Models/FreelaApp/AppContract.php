<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 02/01/2022
 * Time: 07:02
 */

namespace Source\Models\FreelaApp;


use Source\App\App\Chat;
use Source\Core\Model;
use Source\Core\View;
use Source\Support\Email;
use Source\Support\Log;

/**
 * Class AppContract
 * @package Source\Models\FreelaApp
 */
class AppContract extends Model
{
    /**
     * AppContract constructor.
     */
    public function __construct()
    {
        parent::__construct("app_contract", ["id"], ["project_id", "proposal_id", "price", "status"]);
    }

    /**
     * @param AppProject $project
     * @param AppProposal $proposal
     * @return null|AppContract
     */
    public function register(AppProject $project, AppProposal $proposal): ?AppContract
    {
        $this->project_id = $project->id;
        $this->proposal_id = $proposal->id;
        $this->price = $proposal->price;
        $this->status = "pending";

        //Verifica se o freelancer preencheu todos os dados
        if(empty($proposal->price) || empty($proposal->start) || empty($proposal->delivery)){
            $this->message->warning("Peça ao freelancer para preencher todos os dados da proposta, valor, inicio e entrega");
            return null;
        }

        if(!$this->save()){
            $this->message->error("Erro ao contratar freelancer");
            return null;
        }

        $project->status = "pending_pay";
        if(!$project->save()){
            $this->message->error("Erro ao atualizar projeto");
            return null;
        }

        /* EMAIAL PARA O AUTHOR */
        $subject = "Freelancer contratado com sucesso";
        (new Email())->bootstrap(
            $subject,
            $project->author()->email,
            $project->author()->fullName()
        )->view("default", [
            "title" => $subject,
            "message" => "<p>Olá {$project->author()->first_name} você contratou <strong>{$proposal->user()->first_name}</strong>
            com sucesso para trabalhar no projeto <strong>{$project->title}</strong></p>
            <p>Realize o pagamento da proposta clicando no link abaixo</p>",
            "link" => url("/app/proposta/checkout/{$proposal->id}"),
            "title_link" => "REALIZAR O PAGAMENTO"
        ])->queue();

        /* EMIAL PARA O FREELANCER */
        $subject = "Meus parabéns, você foi contratado";
        (new Email())->bootstrap(
            $subject,
            $proposal->user()->email,
            $proposal->user()->fullName()
        )->view("default", [
            "title" => $subject,
            "message" => "<p>Olá {$proposal->user()->first_name} você foi contratado para trabalhar no projeto <strong>{$project->title}</strong></p>
            <p><strong>AINDA NÂO REALIZE O PROJETO</strong> assim que o contratante realizar o pagamento você será alertado na platafoma e por e-mail para inicializar o trabalho.</p>"
        ])->queue();

        return $this;
    }

    /**
     * @return null|AppProject
     */
    public function project(): ?AppProject
    {
        return (new AppProject())->findById($this->project_id);
    }

    /**
     * @return null|AppProposal
     */
    public function proposal(): ?AppProposal
    {
        return (new AppProposal())->findById($this->proposal_id);
    }
}
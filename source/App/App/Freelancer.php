<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 02/01/2022
 * Time: 06:39
 */

namespace Source\App\App;


use Source\Models\FreelaApp\AppContract;
use Source\Models\FreelaApp\AppProject;
use Source\Models\FreelaApp\AppProposal;

/**
 * Class Freelancer
 * @package Source\App\App
 */
class Freelancer extends App
{
    /**
     * Contrata freelancer
     * @param array $data
     */
    public function contract(array $data)
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);

        //Verifica se o contratnte é também dono do projeto
        $projeto = (new AppProject())->find("author = :author AND id = :id AND status = 'accepted'",
            "author={$this->user->id}&id={$data['project']}")->fetch();

        if(!$projeto){
            $json['warning'] = $this->message->warning("O projeto informado não está disponivel")->render();
            echo json_encode($json);
            return;
        }

        //Verifica se a proposta é para esse projeto
        $proposta = (new AppProposal())->find("id = :id AND project_id = :project_id",
            "id={$data['proposal']}&project_id={$projeto->id}")->fetch();
        if(!$proposta){
            $json['warning'] = $this->message->warning("A proposta informada não existe")->render();
            echo json_encode($json);
            return;
        }

        //Cadastra cntratação de freelancer
        $contract = (new AppContract());
        if(!$contract->register($projeto, $proposta)){
            $json['warning'] = $contract->message()->render();
            echo json_encode($json);
            return;
        }


        $json['success'] = "Freelancer contratado com sucesso";
        $json['redirect'] = url("/app/proposta/checkout/{$proposta->id}");
        echo json_encode($json);
    }
}
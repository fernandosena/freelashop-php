<?php

namespace Source\App\Pay;

use Source\App\App\Proposal;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\FreelaApp\AppBoleto;
use Source\Models\FreelaApp\AppBoletoGetNet;
use Source\Models\FreelaApp\AppCard;
use Source\Models\FreelaApp\AppCreditCardGetNet;
use Source\Models\FreelaApp\AppOrder;
use Source\Models\FreelaApp\AppPix;
use Source\Models\FreelaApp\AppPixGetNet;
use Source\Models\FreelaApp\AppPlan;
use Source\Models\FreelaApp\AppProject;
use Source\Models\FreelaApp\AppProposal;
use Source\Models\FreelaApp\AppSubscription;
use Source\Models\Pay\Boleto;
use Source\Models\Pay\CreditCard;
use Source\Models\Pay\Order;
use Source\Models\Pay\Signature;

/**
 * CLASSE QUE TRABALHA COM OS PAGAMENTOS
 * Class GetNet
 * @package Source\App
 */
class Pay extends Controller
{
    /**
     * GetNet constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../shared/pagarme/");
    }

    /**
     * Realizar o pagamento do plano com o gerencia net
     * @param array $data
     * @throws \Exception
     */
    public function plan(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $user = Auth::user();
        $plan = (new AppPlan())->findById($data["product"]);

        if (request_limit("payplan", 3, 60 * 5)) {
            $json["message"] = $this->message->warning("Desculpe {$user->first_name}, mas por segurança aguarde pelo menos 5 minutos para tentar realizar o pagamento.")->render();
            echo json_encode($json);
            return;
        }

        if(empty($user->datebirth) || empty($user->document)){
            $this->message->warning("Preencha a sua data de nascimento e CPF para poder seguir com o pagamento")->flash();
            $json["redirect"] = url("/app/perfil");
            echo json_encode($json);
            return;
        }

        if(!empty($data["type"]) &&  $data["type"] == "cred-card"){
            $date = \DateTime::createFromFormat('m/Y', $data["cardExpiry"]);
            if($date->format("Y-m") < date("Y-m")){
                $json["message"] = $this->message->warning("O seu cartão está vencido, favor tente outro")->render();
                echo json_encode($json);
                return;
            }
        }

        /* CHECA SE O USUÀRIO JA TEM UM PLANO ATIVO */
        $subscribe = (new AppSubscription())->find("user_id = :user AND status != :status",
            "user={$user->id}&status=canceled")->fetch();

        if ($subscribe) {
            $json["message"] = $this->message->warning("Você já tem uma assinatura ativa {$user->first_name}. Não é necessário assinar o {$plan->name} mais de uma vez.")->render();
            echo json_encode($json);
            return;
        }

        $addUser = (new Signature())->createSignaturePlan($plan, $data);
        if(!$addUser->getCallback()){
            $json["message"] = $addUser->message()->render();
            echo json_encode($json);
            return;
        }

        $json["redirect"] = url("/app/assinatura");
        echo json_encode($json);
    }


    /**
     * @param array $data
     */
    public function proposal(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $user = Auth::user();

        if (request_limit("payproposal", 3, 60 * 5)) {
            $json["message"] = $this->message->warning("Desculpe {$user->first_name}, mas por segurança aguarde pelo menos 5 minutos para tentar realizar o pagamento")->render();
            echo json_encode($json);
            return;
        }

        if(empty($user->datebirth) || empty($user->document)){
            $this->message->warning("Preencha a sua data de nascimento e CPF para poder seguir com o pagamento")->flash();
            $json["redirect"] = url("/app/perfil");
            echo json_encode($json);
            return;
        }

        $proposal = (new AppProposal())->findById($data["product"]);
        if(!$proposal){
            $json["message"] = $this->message->warning("A Proposta informada não existe")->render();
            echo json_encode($json);
            return;
        }

        $project = (new AppProject())->findById($proposal->project_id);
        if(!$project){
            $json["message"] = $this->message->warning("O Projeto informada não existe")->render();
            echo json_encode($json);
            return;
        }

        if($data['type'] == "pix"){
            $order = (new Order())->createOrder(
                "Proposta Nº {$proposal->id}",
                $proposal->price
            )->client($user)
            ->pix(
                "Proposta Nº {$proposal->id}",
                $proposal->price
            );

            $dataPix = ($order->charges[0]["last_transaction"] ?? null);
            if(empty($dataPix["status"]) || $dataPix["status"] == "failed"){
                $this->log->telegram()->emergency("Erro ao gerar PIX", ["API"=>$dataPix]);
                $json["message"] = $this->message->warning("Erro ao gerar pix. tente novamente mais tarde ou teste outro meio de pagamento")->render();
                echo json_encode($json);
                return;
            }

            $pix = (new AppPix());
            $pix->user_id = $user->id;
            $pix->proposal_id = $proposal->id;
            $pix->project_id = $project->id;
            $pix->order_code = $order->id;
            $pix->charge_code = $order->charges[0]["id"];
            $pix->transaction_code = $dataPix["id"];
            $pix->qr_code = $dataPix["qr_code"];
            $pix->qr_code_url = $dataPix["qr_code_url"];
            $pix->expires_at = $dataPix["expires_at"];
            $pix->amount = $dataPix["amount"];
            $pix->status = $dataPix["status"];
            $pix->save();

            $json["redirect"] = url("/app/proposta/checkout/{$proposal->id}");
            echo json_encode($json);
            return;
        }

        if($data['type'] == "boleto"){
            $order = (new Order())->createOrder(
                "Proposta Nº {$proposal->id}",
                $proposal->price
            )->client($user)
            ->boleto();


            $dataBoleto = ($order->charges[0]["last_transaction"] ?? null);
            if(empty($dataBoleto["status"]) || $dataBoleto["status"] == "failed"){
                $this->log->telegram()->emergency("Erro ao gerar BOLETO", ["API"=>$dataBoleto]);
                $json["message"] = $this->message->warning("Erro ao gerar boleto. tente novamente mais tarde ou teste outro meio de pagamento")->render();
                echo json_encode($json);
                return;
            }

            $boleto = (new AppBoleto());
            $boleto->user_id = $user->id;
            $boleto->proposal_id = $proposal->id;
            $boleto->project_id = $project->id;
            $boleto->order_code = $order->id;
            $boleto->charge_code = $order->charges[0]["id"];
            $boleto->transaction_code = $dataBoleto["id"];
            $boleto->amount = $dataBoleto["amount"];
            $boleto->url = $dataBoleto["url"];
            $boleto->line = $dataBoleto["line"];
            $boleto->qr_code = $dataBoleto["qr_code"];
            $boleto->due_at = $dataBoleto["due_at"];
            $boleto->save();

            $json["redirect"] = url("/app/proposta/checkout/{$proposal->id}");
            echo json_encode($json);
            return;
        }
    }
}
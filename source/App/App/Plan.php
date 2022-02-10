<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 05/01/2022
 * Time: 17:02
 */

namespace Source\App\App;



use Source\Models\FreelaApp\AppBoletoGetNet;
use Source\Models\FreelaApp\AppOrder;
use Source\Models\FreelaApp\AppPlan;
use Source\Models\FreelaApp\AppSubscription;
use Source\Models\FreelaApp\AppTransaction;

/**
 * Class Plan
 * @package Source\App\App
 */
class Plan extends App
{

    /**
     * Planos para assinatura
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $head = $this->seo->render(
            "Assinatura - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/app/assinatura"),
            theme("/assets/images/share.jpg"),
            false
        );

        switch ((new AppTransaction())->last()->status ?? "waiting"){
            case "captured":
            case "active":
            case "paid":
                $message =  message()->info("seu plano está ativo ;)")->before("Estamos felizes em te ver aqui, ")->render();
                break;
            case "not_authorized":
            case "failed":
                $message =  message()->warning("sua assinatura está inativa no momento, o pagamento não foi efetuado")->before("Oooops, ")->render();
                break;
            case "waiting":
                $message =  message()->warning("Estamos aguardando o pagamento da fatura.")
                    ->after(" Aguarde ou mande seu comprovante para o suporte.")->render();
                break;
            case "canceled":
                $message =  message()->error("seu plano foi cancelado por falta de pagamento")->before("Que triste, ")->render();
                break;
        }

        echo $this->view->render("app/signature", [
            "head" => $head,
            "subscription" => (new AppSubscription())
                ->find("user_id = :user AND status != :status", "user={$this->user->id}&status=canceled")
                ->fetch(),
            "transactions" => (new AppTransaction())
                ->find("user_id = :user", "user={$this->user->id}")
                ->order("created_at ASC")
                ->fetch(true),
            "message" => ($message ?? null),
            "plans" => (new AppPlan())
                ->find("status = :status AND type = :type", "status=active&type={$this->user->type}")
                ->order("minimum_price, name")
                ->limit(3)
                ->fetch(true),
            "linkBoleto" => (!empty($boleto) ? $boleto->link : null)
        ]);
    }

    /**
     * Checkout do plano
     * @param array $data
     */
    public function checkout(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $head = $this->seo->render(
            "Checkout - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/app/plan/checkout/{$data['plan']}"),
            theme("/assets/images/share.jpg"),
            false
        );

        //Verifica se plano infomado realmente existe
        $plans = (new AppPlan())->find("id = :id AND type = :type", "id={$data['plan']}&type={$this->user->type}")
            ->fetch();
        if(!$plans){
            $this->message->warning("O plano informado não existe!")->flash();
            redirect("/app/assinatura");
        }

        //Verifica se o usuário ja tem um plano contratado
        $sub = (new AppSubscription())->find("user_id = :id","id={$this->user->id}")->count();
        if($sub){
            $this->message->warning("Você já tem um plano cadastrado em seu perfil. ")
                ->before("Oooops! ")
                ->after("Caso queira alterar o seu plano favor entrar em contato com o suporte <a class='popup-with-move-anim' href='#moda-support'>CLICANDO AQUI</a>")
                ->flash();
            redirect("/app/assinatura");
        }

        echo $this->view->render("app/checkout", [
            "head" => $head,
            "product"=> [
                "post" => "plan",
                "title" => "Plano",
                "id" => $plans->id,
                "price" => $plans->minimum_price,
                "name" => $plans->name,
                "period" => $plans->interval,
                "currency" => $plans->currency,
            ]
        ]);
    }
}
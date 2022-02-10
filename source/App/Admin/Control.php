<?php

namespace Source\App\Admin;

use Source\App\App\Plan;
use Source\Models\FreelaApp\AppCreditCardGetNet;
use Source\Models\FreelaApp\AppPlan;
use Source\Models\FreelaApp\AppSubscription;
use Source\Models\Pay\Item;
use Source\Support\Pager;

/**
 * Class Control
 * @package Source\App\Admin
 */
class Control extends Admin
{
    /**
     * Control constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if($this->user->level != 5){
            $this->message->warning("Você não tem premição para acessar essa página")->flash();
            redirect("/admin/");
        }
    }

    /**
     *
     */
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Control",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/control/home", [
            "app" => "control/home",
            "head" => $head,
            "stats" => (object)[
                "subscriptions" => (new AppSubscription())->find("status = :s", "s=paid")->count(),
                "subscriptionsMonth" => (new AppSubscription())->find("status = :s AND year(start_at) = year(now()) AND month(start_at) = month(now())",
                    "s=paid")->count(),
                "recurrence" => (new AppSubscription())->recurrence(),
                "recurrenceMonth" => (new AppSubscription())->recurrenceMonth()
            ],
            "subscriptions" => (new AppSubscription())->find()->order("start_at DESC")->limit(10)->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function subscriptions(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/control/subscriptions/{$s}/1")]);
            return;
        }

        $search = null;
        $subscriptions = (new AppSubscription())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $subscriptions = (new AppSubscription())->find("user_id IN(SELECT id FROM users WHERE MATCH(first_name, last_name, email) AGAINST(:s))",
                "s={$search}");
            if (!$subscriptions->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/control/subscriptions");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/control/subscriptions/{$all}/"));
        $pager->pager($subscriptions->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Assinantes",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/control/subscriptions", [
            "app" => "control/subscriptions",
            "head" => $head,
            "subscriptions" => $subscriptions->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search
        ]);
    }

    /**
     * @param array $data
     */
    public function subscription(array $data): void
    {
        //update subscription
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $subscriptionUpdate = (new AppSubscription())->findById($data["id"]);

            if (!$subscriptionUpdate) {
                $this->message->error("Você tentou atualizar uma assinatura que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/control/subscriptions")]);
                return;
            }

            $subscriptionUpdate->plan_id = $data["plan_id"];
            $subscriptionUpdate->card_id = $data["card_id"];
            $subscriptionUpdate->status = $data["status"];
            $subscriptionUpdate->pay_status = $data["pay_status"];
            $subscriptionUpdate->due_day = $data["due_day"];
            $subscriptionUpdate->next_due = date_fmt_back($data["next_due"]);
            $subscriptionUpdate->last_charge = date_fmt_back($data["last_charge"]);

            if (!$subscriptionUpdate->save()) {
                $json["message"] = $subscriptionUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Assinatura atualizada com sucesso")->render();
            echo json_encode($json);
            return;
        }

        //read subscription
        $id = filter_var($data["id"], FILTER_VALIDATE_INT);
        if (!$id) {
            redirect("/admin/control/subscriptions");
        }

        $subscription = (new AppSubscription())->findById($id);
        if (!$subscription) {
            $this->message->error("Você tentou editar uma assinatura que não existe")->flash();
            redirect("/admin/control/subscriptions");
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Assinatura de " . $subscription->user()->fullName(),
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/control/subscription", [
            "app" => "control/subscriptions",
            "head" => $head,
            "subscription" => $subscription,
            "plans" => (new AppPlan())->find("status = :status", "status=active")->fetch(true),
            "cards" => (new AppCreditCardGetNet())->find("user_id = :user", "user={$subscription->user()->id}")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function plans(?array $data): void
    {
        $plans = (new AppPlan())->find();
        $pager = new Pager(url("/admin/control/plans/"));
        $pager->pager($plans->count(), 5, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Planos de Assinatura",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/control/plans", [
            "app" => "control/plans",
            "head" => $head,
            "plans" => $plans->order("status ASC, created_at DESC")
                ->limit($pager->limit())
                ->offset($pager->offset())
                ->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     */
    public function plan(?array $data): void
    {
        //create plan
        if (!empty($data["action"]) && $data["action"] == "create") {
            $benefits = $data["benefits"];
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $plan = [
                "shippable" => "false",
                "currency" => "BRL",
                "billing_type" => "prepaid",
                "payment_methods" => ["credit_card", "boleto", "debit_card"],
                "installments" => ["1","1","1"]
            ];
            $data["minimum_price"] = str_replace([".",","], "", $data["minimum_price"]);
            $data = array_merge($data, $plan);
            $createPlan = (new \Source\Models\Pay\Plan())->createPlan(
                $data
            );

            if(!empty($createPlan->getCallback()->errors)){
                $json["message"] = $this->message->error("Erro ao cadastrar Plano na API")->render();
                $this->log->telegram()->emergency("Erro ao cadastrar Plano", ["message"=>json_encode($createPlan->getCallback()->errors)]);
                echo json_encode($json);
                return;
            }

            $return = (array) $createPlan->getCallback();
            $planCreate = new AppPlan();
            $planCreate->name = $return["name"];
            $planCreate->description = $return["description"];
            $planCreate->url = $return["url"];
            $planCreate->statement_descriptor = $return["statement_descriptor"];
            $planCreate->minimum_price = $return["minimum_price"];
            $planCreate->interval = $return["interval"];
            $planCreate->interval_count = $return["interval_count"];
            $planCreate->billing_type = $return["billing_type"];
            $planCreate->payment_methods = implode(",", $return["payment_methods"]);
            $planCreate->installments = implode(",", $return["installments"]);
            $planCreate->status = $return["status"];
            $planCreate->code = $return["id"];
            $planCreate->currency = $return["currency"];
            $planCreate->nivel = $return["metadata"]["nivel"];
            $planCreate->type = $return["metadata"]["type"];
            $planCreate->benefits = $benefits;

            if (!$planCreate->save()) {
                $json["message"] = $planCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Plano criado com sucesso. Confira...")->flash();
            $json["redirect"] = url("/admin/control/plan/{$planCreate->id}");

            echo json_encode($json);
            return;
        }

        //update plan
        if (!empty($data["action"]) && $data["action"] == "update") {
            $benefits = $data["benefits"];
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $plan = [
                "shippable" => "false",
                "currency" => "BRL",
                "billing_type" => "prepaid",
                "payment_methods" => ["credit_card", "boleto", "debit_card"],
                "installments" => ["1","1","1"]
            ];
            $data["minimum_price"] = str_replace([".",","], "", $data["minimum_price"]);
            $data = array_merge($data, $plan);

            $planEdit = (new AppPlan())->findById($data["plan_id"]);

            //Verifica existencia do plano no banco de dados
            if (!$planEdit) {
                $this->message->error("Você tentou editar um plano que não existe ou foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/control/plans")]);
                return;
            }

            //Verifica existencia do plano na API
            $planAPI = (new \Source\Models\Pay\Plan());
            $getPlan = $planAPI->getPlan($planEdit);
            if(!empty(($getPlan->getCallback()->message))){
                $this->message->error("Plano não encontrado na API")->flash();
                echo json_encode(["redirect" => url("/admin/control/plans")]);
                return;
            }

            $itemId = ($getPlan->getCallback()->items[0]["id"]);
            $editPlan = $planAPI->editPlan($planEdit->code, $itemId, $data);
            $return = (array) $editPlan->getCallback();

            if(!empty(($editPlan->getCallback()->message))){
                $this->message->error("Não foi possivel editar o plano na API")->flash();
                echo json_encode(["redirect" => url("/admin/control/plans")]);
                return;
            }

            $planEdit->name = $return["name"];
            $planEdit->description = $return["description"];
            $planEdit->url = $return["url"];
            $planEdit->statement_descriptor = $return["statement_descriptor"];
            $planEdit->minimum_price = $return["minimum_price"];
            $planEdit->interval = $return["interval"];
            $planEdit->interval_count = $return["interval_count"];
            $planEdit->billing_type = $return["billing_type"];
            $planEdit->payment_methods = implode(",", $return["payment_methods"]);
            $planEdit->installments = implode(",", $return["installments"]);
            $planEdit->status = $return["status"];
            $planEdit->currency = $return["currency"];
            $planEdit->nivel = $return["metadata"]["nivel"];
            $planEdit->type = $return["metadata"]["type"];
            $planEdit->benefits = $benefits;

            if (!$planEdit->save()) {
                $json["message"] = $planEdit->message()->render();
                echo json_encode($json);
                return;
            }

            //Edita Item
            $item = (new Item())->editItem($planEdit->code, $itemId, $data);
            if(!empty(($item->getCallback()->message))){
                $this->message->error("Não foi possivel editar o itemdo plano na API")->flash();
                echo json_encode(["redirect" => url("/admin/control/plans")]);
                return;
            }

            $json["message"] = $this->message->success("Plano atualizado com sucesso...")->render();
            echo json_encode($json);

            return;
        }

        //delete plan
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $planDelete = (new AppPlan())->findById($data["plan_id"]);

            if (!$planDelete) {
                $this->message->error("Você tentou excluir um plano que não existe ou já foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/control/plans")]);
                return;
            }

            //Verifica existencia do plano na API
            $planAPI = (new \Source\Models\Pay\Plan());
            $getPlan = $planAPI->getPlan($planDelete);
            if(!empty(($getPlan->getCallback()->message))){
                $this->message->error("Você tentou excluir um plano que não existe ou já foi removido na API")->flash();
                echo json_encode(["redirect" => url("/admin/control/plans")]);
                return;
            }

            if ($planDelete->subscribers(null)->count()) {
                $json["message"] = $this->message->warning("Não é possível remover planos com assinaturas...")->render();
                echo json_encode($json);
                return;
            }

            $deleAPI = (new \Source\Models\Pay\Plan())->deletPlan($planDelete->code);
            if(!empty(($deleAPI->getCallback()->message))){
                $this->message->error("Erro ao deletar plano na API")->flash();
                echo json_encode(["redirect" => url("/admin/control/plans")]);
                return;
            }

            $planDelete->destroy();

            $this->message->success("Plano removido com sucesso...")->flash();
            $json["redirect"] = url("/admin/control/plans");

            echo json_encode($json);
            return;
        }

        //read plan
        $planEdit = null;
        if (!empty($data["plan_id"])) {
            $planId = filter_var($data["plan_id"], FILTER_VALIDATE_INT);
            $planEdit = (new AppPlan())->findById($planId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Gerenciar Plano",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/control/plan", [
            "app" => "control/plans",
            "head" => $head,
            "plan" => $planEdit,
            "subscribers" => ($planEdit ? $planEdit->subscribers(null)->count() : null)
        ]);
    }
}
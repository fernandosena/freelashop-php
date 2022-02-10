<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 02/02/2022
 * Time: 19:59
 */

namespace Source\Models\Pay;


use PHPMailer\PHPMailer\Exception;
use Source\Models\FreelaApp\AppCard;
use Source\Models\FreelaApp\AppOrder;
use Source\Models\FreelaApp\AppPlan;
use Source\Models\FreelaApp\AppSubscription;

/**
 * Class Signature
 * @package Source\Models\Pay
 */
class Signature extends Pay
{

    /**
     * @param AppPlan $plan
     * @param array $data
     * @return $this
     */
    public function createSignaturePlan(AppPlan $plan, array $data)
    {

        try{
            $this->endpoint = "/subscriptions";
            $this->build = [
                "plan_id" => $plan->code,
                "customer" => [
                    "name" => $this->user->fullName(),
                    "email" => $this->user->email,
                    "code" => $this->user->id,
                    "document" => $this->clear($this->user->document),
                    "document_type" => "CPF",
                    "type" => "individual",
                    "gender" => $this->user->genre,
                    "phones" => [
                        "mobile_phone" => [
                            "country_code" => "55",
                            "area_code" => substr($this->clear($this->user->cell), 0,2),
                            "number" => substr($this->clear($this->user->cell), 2)
                        ]
                    ],
                    "birthdate" => $this->user->datebirth,
                ],

            ];

            if($data["type"] == "cred-card"){
                $cardExpiry = explode("/", $data["cardExpiry"]);
                $arrayCard = [
                    "payment_method" => "credit_card",
                    "card" => [
                        "number" => $this->clear($data["cardNumber"]),
                        "holder_name" => $data["cardName"],
                        "holder_document" => $this->clear($this->user->document),
                        "exp_month" => $cardExpiry[0],
                        "exp_year" => $cardExpiry[1],
                        "cvv" => $data["cardCVV"],
                        "billing_address" => [
                            "line_1" => CONF_SITE_ADDR_STREET,
                            "line_2" => "",
                            "zip_code" => $this->clear(CONF_SITE_ADDR_ZIPCODE),
                            "city" => CONF_SITE_ADDR_CITY,
                            "state" => CONF_SITE_ADDR_STATE,
                            "country" => "BR",
                        ]
                    ]
                ];

                $this->build = array_merge($this->build, $arrayCard);
            }


            $this->post();

            if(!empty($this->getCallback()->id)){
                $callback = $this->getCallback();

                //Cadastro do cartão
                $creditCard = (new AppCard());
                if($data["type"] == "cred-card"){
                    $creditCard->code = $callback->card["id"];
                    $creditCard->user_id = $this->user->id;
                    $creditCard->name = $data["cardName"];
                    $creditCard->brand = $callback->card["brand"];
                    $creditCard->last_digits = $callback->card["last_four_digits"];
                    $creditCard->cvv = $data["cardCVV"];
                    $creditCard->type = $callback->card["type"];
                    $creditCard->status = $callback->card["status"];
                    $creditCard->save();
                }

                //Cadastro Subscription
                $subscription = (new AppSubscription());
                $subscription->code = $callback->id;
                $subscription->user_id = $this->user->id;
                $subscription->plan_id = $plan->id;
                $subscription->status = $callback->status;
                $subscription->start_at = $callback->start_at;
                $subscription->next_billing_at = $callback->next_billing_at;
                $subscription->last_charge = date("Y-m-d");

                //CARDIT CARD
                if($data["type"] == "cred-card"){
                    $subscription->card_id = $creditCard->data()->id;
                }
                $subscription->save();

                //USER
                $this->user->code = $callback->customer["id"];
                $this->user->save();
            }
        }catch (Exception $exception){
            $this->message->error("Erro ao consultar o cartão");
            $this->log->telegram()->emergency($this->message->getText(), ["exception" => $exception->getMessage()]);
        }
        return $this;
    }

    public function getSignature(string $code)
    {
        $this->endpoint = "/subscriptions/{$code}";
        $this->get();
        return $this;
    }

    /**
     * @return $this
     */
    public function listSignature()
    {
        $this->endpoint = "/subscriptions";
        $this->build = [
            "page" => 10,
            "size" => 10,
            "status" => "active",
        ];
        $this->get();
        return $this;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function cancelSignature(string $code)
    {
        $this->endpoint = "/subscriptions/{$code}";
        $this->delete();
        return $this;
    }
}
<?php

namespace Source\Models\FreelaApp;

use Source\Core\Model;
use Source\Models\PagSeguro;
use Source\Models\User;

/**
 * CLASSE QUE TRABALHA COM AS COBRANÇAS RECORRENTES
 * Class AppSubscription
 * @package Source\Models\FreelaApp
 */
class AppSubscription extends Model
{
    /**
     * AppSubscription constructor.
     */
    public function __construct()
    {
        parent::__construct("app_subscriptions", ["id"],
            ["code", "user_id", "plan_id", "status", "start_at", "next_billing_at", "last_charge"]);
    }

    public function releasePlan(): bool
    {
        if(!(new AppTransaction())->last()->status){
            return true;
        }

        switch ((new AppTransaction())->last()->status){
            case "captured":
                return true;
                break;
            default:
                return false;
                break;
        }
    }
    /**
     * @return mixed|Model|null
     */
    public function user()
    {
        return (new User())->findById($this->user_id);
    }

    /**
     * @return mixed|Model|null
     */
    public function plan()
    {
        return (new AppPlan())->findById($this->plan_id);
    }

    /**
     * @return mixed|Model|null
     */
    public function creditCard()
    {
        return (new AppCard())->findById($this->card_id);
    }

    /**
     * @return mixed|null|Model
     */
    public function boleto()
    {
        return (new AppBoleto())->findById($this->boleto_id);
    }

    /**
     * @return int
     */
    public function recurrence()
    {
        $recurrence = 0;
        $activeSubscribers = $this->find("status = :s", "s=paid")->fetch(true);

        if ($activeSubscribers) {
            foreach ($activeSubscribers as $subscriber) {
                $recurrence += $subscriber->plan()->minimum_price;
            }
        }

        return $recurrence;
    }

    /**
     * @return int
     */
    public function recurrenceMonth()
    {
        $recurrence = 0;
        $activeSubscribers = $this->find("status = :s AND year(start_at) = year(now()) AND month(start_at) = month(now())",
            "s=paid")->fetch(true);

        if ($activeSubscribers) {
            foreach ($activeSubscribers as $subscriber) {
                $recurrence += $subscriber->plan()->minimum_price;
            }
        }

        return $recurrence;
    }
}
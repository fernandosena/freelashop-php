<?php

namespace Source\Models\FreelaApp;

use Source\Core\Model;

/**
 * Class AppPlan
 * @package Source\Models\FreelaApp
 */
class AppPlan extends Model
{
    /**
     * AppPlan constructor.
     */
    public function __construct()
    {
        parent::__construct("app_plans", ["id"],
            ["name", "description", "minimum_price", "statement_descriptor", "benefits", "type", "nivel", "status", "code", "url"]);
    }

    /**
     * @param string|null $status
     * @return AppSubscription|null
     */
    public function subscribers(?string $status = "paid"): ?AppSubscription
    {
        if ($status) {
            return (new AppSubscription())->find("plan_id = :plan AND status = :s", "plan={$this->id}&s={$status}");
        }

        return (new AppSubscription())->find("plan_id = :plan", "plan={$this->id}");
    }

    /**
     * @return int
     */
    public function recurrence(): int
    {
        return ($this->subscribers()->count() * $this->minimum_price);
    }
}
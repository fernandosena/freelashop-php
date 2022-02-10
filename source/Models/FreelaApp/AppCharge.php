<?php

namespace Source\Models\FreelaApp;

use Source\Core\Model;

/**
 * CLASSE QUE TRABALHA COM OS ORÇAMENTOS
 * Class SubCategory
 * @package Source\Budget
 */
class AppCharge extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("app_charge", ["id"], ["user_id","code", "amount", "status", "payment_method", "due_at", ""]);
    }
}
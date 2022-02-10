<?php

namespace Source\Models\FreelaApp;

use Source\Core\Model;

/**
 * CLASSE QUE TRABALHA COM OS ORÇAMENTOS
 * Class SubCategory
 * @package Source\Budget
 */
class AppBudget extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("app_budget", ["id"], ["text"]);
    }
}
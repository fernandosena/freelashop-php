<?php

namespace Source\Models\FreelaApp;

use Source\Core\Model;

/**
 * CLASSE QUE TRABALHA COM OS ORÇAMENTOS
 * Class SubCategory
 * @package Source\Budget
 */
class AppInvoice extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("app_invoice", ["id"], []);
    }
}
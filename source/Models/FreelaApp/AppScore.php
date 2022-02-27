<?php

namespace Source\Models\FreelaApp;

use Source\Core\Model;

/**
 * Class AppScore
 * @package Source\Models\FreelaApp
 */
class AppScore extends Model
{
    /**
     * AppPlan constructor.
     */
    public function __construct()
    {
        parent::__construct("app_score", ["id"],
            ["user_id", "value", "comment"]);
    }
}
<?php

namespace Source\Models\Teste;

use Source\Core\Model;
use Source\Models\Project\AppProject;

/**
 * Class Options
 * @package Source\Models
 */
class Options extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("options", ["id"], ["question_id", "option"]);
    }
}
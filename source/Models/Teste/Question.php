<?php

namespace Source\Models\Teste;

use Source\Core\Model;
use Source\Models\Project\AppProject;

/**
 * Class Question
 * @package Source\Models
 */
class Question extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("question", ["id"], ["teste_id", "question"]);
    }

    public function options(): ?array
    {
        return (new Options())->find("question_id = {$this->id}")->fetch(true);
    }
}
<?php

namespace Source\Models\Teste;

use Source\Core\Model;

/**
 * Class Teste
 * @package Source\Models
 */
class Teste extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("teste", ["id"], ["title", "uri"]);
    }

    public function questions(): ?array
    {
        return (new Question())->find("teste_id = {$this->id}")->fetch(true);
    }

    public function questionsCout(): ?int
    {
        return (new Question())->find("teste_id = {$this->id}")->count();
    }

}
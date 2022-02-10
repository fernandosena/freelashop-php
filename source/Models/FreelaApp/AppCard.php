<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 03/02/2022
 * Time: 10:47
 */

namespace Source\Models\FreelaApp;


use Source\Core\Model;

class AppCard extends Model
{
    public function __construct()
    {
        parent::__construct("app_cards", ["id"], ["code", "user_id", "name", "brand", "last_digits", "cvv", "type", "status"]);
    }
}
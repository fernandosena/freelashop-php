<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 01/01/2022
 * Time: 13:44
 */

namespace Source\Models\FreelaApp;


use Source\Core\Model;
use Source\Models\User;

class AppDepositions extends Model
{
    public function __construct()
    {
        parent::__construct("app_depositions", ["id"], ["user_id", "text"]);
    }

    public function user()
    {
        return (new User())->findById($this->user->id)->fetch();
    }
}
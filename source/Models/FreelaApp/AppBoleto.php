<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 03/02/2022
 * Time: 10:47
 */

namespace Source\Models\FreelaApp;


use Source\Core\Model;

class AppBoleto extends Model
{
    public function __construct()
    {
        parent::__construct("app_boleto", ['id'], ['user_id']);
    }
}
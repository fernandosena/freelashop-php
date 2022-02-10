<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 06/02/2022
 * Time: 12:49
 */

namespace Source\Models\FreelaApp;


use Source\Core\Model;

class AppPix extends Model
{
    public function __construct()
    {
        parent::__construct("app_pix", ['id'], ["user_id"]);
    }
}
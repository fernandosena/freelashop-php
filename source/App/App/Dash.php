<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 14/12/2021
 * Time: 14:38
 */

namespace Source\App\App;


/**
 * Class Dash
 * @package Source\App\App
 */
class Dash extends App
{

    /**
     * DASH HOME
     */
    public function home(): void
    {
        if($this->user->type == "freelancer"){
            redirect("/projetos");
        }else{
            redirect("/freelancers");
        }
    }
}
<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Support\Email;

/**
 * Class Newsletter
 * @package Source\Models
 */
class Newsletter extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("newsletter", ["id"], ["email"]);
    }

    /**
     * @param string $email
     */
    public function bootstrap(string $email)
    {
        $this->email = $email;
        $this->save();

        $subject = "E-mail cadastrado com sucesso";
        (new Email())->bootstrap(
            $subject,
            $this->email,
            $this->email
        )->view(
            "default", [
                "title" => "Estamos felizes em te ver aqui ;)",
                "message" => "<p>Seu e-mail foi cadastrado com sucesso. Agora você receberá todas as nossas novidades e dicas.</p>"
            ]
        )->queue();
    }

    /**
     * @param string $email
     * @return mixed|Model
     */
    public function findByEmail(string $email)
    {
        return (new Newsletter())->find("email = :email", "email={$email}");
    }
}
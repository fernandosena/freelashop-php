<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\FreelaApp\AppScore;
use Source\Support\Email;
use Source\Support\Log;

/**
 * Class Auth
 * @package Source\Models
 */
class Auth extends Model
{
    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["id"], ["email", "password"]);
    }

    /**
     * @return null|User
     */
    public static function user(): ?User
    {
        $session = new Session();
        if (!$session->has("authUser")) {
            return null;
        }

        return (new User())->findById($session->authUser);
    }

    /**
     * log-out
     */
    public static function logout(): void
    {
        $session = new Session();
        $session->unset("authUser");
    }

    /**
     * @param User $user
     * @return bool
     */
    public function register(User $user): bool
    {
        try{
            if (!$user->save()) {
                $this->message = $user->message;
                return false;
            }

            (new Email())->bootstrap(
                "Ative sua conta no " . CONF_SITE_NAME,
                $user->email,
                $user->fullName()
            )->view(
            "confirm",[
                    "first_name" => $user->first_name,
                    "confirm_link" => url("/obrigado/" . base64_encode($user->email))
                ]
            )->queue();

            return true;
        }catch (\Exception $exception){
            $this->message->error("Erro ao criar usuário");
            return false;
        }
    }

    /**
     * @param string $email
     * @param string $password
     * @param int $level
     * @return User|null
     */
    public function attempt(string $email, string $password, int $level = 1): ?User
    {
        if (!is_email($email)) {
            $this->message->warning("O e-mail informado não é válido");
            return null;
        }

        if (!is_passwd($password)) {
            $this->message->warning("A senha informada não é válida");
            return null;
        }

        $user = (new User())->findByEmail($email);

        if (!$user) {
            $this->message->warning("O e-mail informado não está cadastrado");
            return null;
        }

        if (!passwd_verify($password, $user->password)) {
            $this->message->warning("A senha informada não confere");
            return null;
        }

        if ($user->level < $level) {
            $this->message->error("Desculpe, mas você não tem permissão para logar-se aqui");
            return null;
        }

        if (passwd_rehash($user->password)) {
            $user->password = $password;
            $user->save();
        }

        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @param bool $save
     * @param int $level
     * @return bool
     */
    public function login(string $email, string $password, bool $save = false, int $level = 1): bool
    {
        $user = $this->attempt($email, $password, $level);
        if (!$user) {
            return false;
        }

        if ($save) {
            setcookie("authEmail", $email, time() + 604800, "/");
        } else {
            setcookie("authEmail", null, time() - 3600, "/");
        }

        //LOGIN
        (new Session())->set("authUser", $user->id);
        return true;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function forget(string $email): bool
    {
        $user = (new User())->findByEmail($email);

        if (!$user) {
            $this->message->warning("O e-mail informado não está cadastrado.");
            return false;
        }

        $user->forget = md5(uniqid(rand(), true));
        $user->save();

        (new Email())->bootstrap(
            "Recupere sua senha no " . CONF_SITE_NAME,
            $user->email,
            $user->fullName()
        )->view(
            "forget", [
                "first_name" => $user->first_name,
                "forget_link" => url("/recuperar/{$user->email}|{$user->forget}")
            ]
        )->queue();

        return true;
    }

    /**
     * @param string $email
     * @param string $code
     * @param string $password
     * @param string $passwordRe
     * @return bool
     */
    public function reset(string $email, string $code, string $password, string $passwordRe): bool
    {
        $user = (new User())->findByEmail($email);

        if (!$user) {
            $this->message->warning("A conta para recuperação não foi encontrada.");
            return false;
        }

        if ($user->forget != $code) {
            $this->message->warning("Desculpe, mas o código de verificação não é válido.");
            return false;
        }

        if (!is_passwd($password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->info("Sua senha deve ter entre {$min} e {$max} caracteres.");
            return false;
        }

        if ($password != $passwordRe) {
            $this->message->warning("Você informou duas senhas diferentes.");
            return false;
        }

        $user->password = $password;
        $user->forget = null;
        $user->save();

        (new Email())->bootstrap(
            "Senha alterada com sucesso no " . CONF_SITE_NAME,
            $user->email,
            $user->fullName()
        )->view(
            "forget_success", [
                "first_name" => $user->first_name
            ]
        )->queue();
        return true;
    }
}
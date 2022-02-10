<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\View;
use Source\Models\FreelaApp\AppBoleto;
use Source\Models\FreelaApp\AppBoletoGetNet;
use Source\Models\FreelaApp\AppChat;
use Source\Models\FreelaApp\AppCard;
use Source\Models\FreelaApp\AppCreditCardGetNet;
use Source\Models\FreelaApp\AppOrder;
use Source\Models\FreelaApp\AppPlan;
use Source\Models\FreelaApp\AppSubscription;
use Source\Models\FreelaApp\AppTransaction;
use Source\Support\Log;

/**
 * FSPHP | Class User Active Record Pattern
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Models
 */
class User extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["id"], ["first_name", "last_name", "email", "password", "cell"]);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $cell
     * @param string $password
     * @param string $type
     * @param string|null $document
     * @return User
     */
    public function bootstrap(
        string $firstName,
        string $lastName,
        string $email,
        string $cell,
        string $password,
        ?string $type = null,
        ?string $document = null
    ): User {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->cell = $cell;
        $this->password = $password;
        $this->type = ($type == "freelancer") ? "freelancer" : "contractor";
        $this->document = $document;
        return $this;
    }

    /**
     * Rertorna Dados do usuário consultado pelo E-mail
     * @param string $email
     * @param string $columns
     * @return null|User
     */
    public function findByEmail(string $email, string $columns = "*"): ?User
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }

    public function findFreelancer(?string $terms = null, ?string $params = null, string $columns = "*")
    {
        $terms = "type = :type" . ($terms ? " {$terms}" : "");
        $params = "type=freelancer" . ($params ? "&{$params}" : "");

        return parent::find($terms, $params, $columns);
    }

    /**
     * Retorna o nome completo do Usuário
     * @return string
     */
    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Retorna a imagem do usuário caso exista, se não existir retorna null
     * @return string|null
     */
    public function photo(): ?string
    {
        if ($this->photo && file_exists(__DIR__ . "/../../" . CONF_UPLOAD_DIR . "/{$this->photo}")) {
            return $this->photo;
        }
        return null;
    }

    /**
     * @return null|Profission
     */
    public function profission(): ?Profission
    {
        if ($this->profession) {
            return (new Profission())->findById($this->profession);
        }
        return null;
    }

    public function filter(?array $filter, ?User $user = null): ?User
    {
        $author =  (!empty($user) ? "AND author = {$user->id}" : null);

        $category = (!empty($filter['category']) && $filter['category'] != "all" ? "AND category = {$filter['category']}" : null);
        $subcategory = (!empty($filter['subcategory']) && $filter['subcategory'] != "all" ? "AND subcategory = {$filter['subcategory']}" : null);
        $terms = (!empty($filter['terms']) && $filter['terms'] != "all" ? "AND MATCH (title, content) AGAINST ('{$filter['terms']}')" : null);
        $type = (!empty($filter['type']) && $filter['type'] != "all" ? "AND type = {$filter['type']}" : null);

        $due = $this->find(
            " type = 'freelancer' AND status = 'confirmed' {$author} {$category} {$subcategory} {$terms} {$type}"
        );

        return $due;
    }

    /**
     * Metodo de salvamento personalizado para o usuário
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Nome, sobrenome, email, celular e senha são obrigatórios");
            return false;
        }

        if (!is_email($this->email)) {
            $this->message->warning("O e-mail informado não tem um formato válido");
            return false;
        }

        if (!is_passwd($this->password)) {
            $this->message->warning("A senha deve ter entre ".CONF_PASSWD_MIN_LEN." e ".CONF_PASSWD_MAX_LEN." caracteres");
            return false;
        } else {
            //Gera a Hash da senha
            $this->password = passwd($this->password);
        }

        /** User Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}", "id")->fetch()) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findByEmail($this->email, "id")) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $userId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return true;
    }

    public function subscription(): ?AppSubscription
    {
        return (new AppSubscription())->find("user_id = :user_id", "user_id={$this->id}")->fetch();
    }

    public function plan(): ?AppPlan
    {
        if(!empty($this->subscription())){
            return (new AppPlan())->findById($this->subscription()->plan_id);
        }
        return null;
    }

    public function subscriptionPayment(): ?array
    {
        $array = [];
        $subscription = (new AppSubscription())->find("user_id = :user_id", "user_id={$this->id}")->fetch();
        if($subscription->card_id){
            $card = (new AppCard())->findById($subscription->card_id);
            $array = [
                "Tipo" => "Cartão de ".ucfirst(translate($card->type)),
                "Bandeira" => ucfirst($card->brand),
                "Cartão" => "**** **** **** **** {$card->last_digits}",
                "Status" => ucfirst(translate($card->status))
            ];
        }
        if($subscription->boleto_id){
            $boleto = (new AppBoleto())->findById($subscription->boleto_id);
            $array = [
                "Tipo" => "Boleto",
                "Status" => ucfirst(translate($boleto->status))
            ];
        }

        return $array;
    }

    public function history()
    {
        return (new AppTransaction())->find("user_id = :user_id AND subscription_id = :subscription_id", "user_id={$this->id}&subscription_id={$this->subscription()->id}")
            ->order("created_at DESC")
            ->limit(10)
            ->fetch(true);
    }

    public function chatCount()
    {
        return (new AppChat())->find("");
    }
}
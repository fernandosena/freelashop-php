<?php

namespace Source\Models;

use Source\Core\Model;

class Leads extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("leads", ["id"], ["full_name", "email", "phone"]);
    }


    public function bootstrap(
        string $fullName,
        string $email,
        string $phone,
        int $teste = 1
    ): Leads {
        $this->full_name = $fullName;
        $this->email = $email;
        $this->phone = $phone;
        $this->teste = $teste;

        return $this;
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|User
     */
    public function findByEmail(string $email, string $columns = "*"): ?User
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Nome, email e phone são obrigatórios");
            return false;
        }

        if (!is_email($this->email)) {
            $this->message->warning("O e-mail informado não tem um formato válido");
            return false;
        }

        /** User Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            $this->update($this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            $userId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return true;
    }
}
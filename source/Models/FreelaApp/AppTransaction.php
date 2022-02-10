<?php

namespace Source\Models\FreelaApp;

use Source\Core\Model;
use Source\Models\Auth;
use Source\Models\User;

/**
 * CLASSE ESPECIALIZADA EM TRABALHAR TODOS OS PEDIDOS DE COBRANÇA NO CARTÃO
 * Class AppOrder
 * @package Source\Models\FreelaApp
 */
class AppTransaction extends Model
{
    /**
     * AppOrder constructor.
     */
    public function __construct()
    {
        parent::__construct("app_transaction", ["id"],
            ["code", "user_id", "amount", "status"]);
    }

    public function last()
    {
        return $this->find("user_id = :user", "user=".Auth::user()->id)
            ->order("created_at DESC")
            ->fetch();
    }

    /**
     * @return mixed|Model|null
     */
    public function card()
    {
        return (new AppCard())->findById($this->card_id);
    }

    public function boleto()
    {
        return (new AppBoleto())->findById($this->boleto_id);
    }

    public function subscription(): ?AppSubscription
    {
        return (new AppSubscription())->findById($this->subscription_id);
    }

    public function project(): ?AppProject
    {
        return (new AppProject())->findById($this->project_id);
    }

    public function proposal(): ?AppProposal
    {
        return (new AppProposal())->findById($this->proposal_id);
    }
}
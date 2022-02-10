<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 03/01/2022
 * Time: 20:08
 */

namespace Source\Models\FreelaApp;


use Source\Core\Model;
use Source\Support\Log;

/**
 * Class AppGroupChat
 * @package Source\Models\FreelaApp
 */
class AppGroupChat extends Model
{
    /**
     * AppGroupChat constructor.
     */
    public function __construct()
    {
        parent::__construct("app_chat_group", ["id"], ["project_id", "proposal_id", "contractor_id", "freelancer_id"]);
    }

    /**
     * @param AppProject $project
     * @param AppProposal $proposal
     * @return null|AppGroupChat
     */
    public function register(AppProject $project, AppProposal $proposal): ?AppGroupChat
    {
        $this->project_id = $project->id;
        $this->proposal_id = $proposal->id;
        $this->contractor_id = $project->author;
        $this->freelancer_id = $proposal->user_id;

        if(!$this->save()){
            return null;
        }

        return $this;
    }

    /**
     * @return AppProject
     */
    public function project(): AppProject
    {
        return (new AppProject())->findById($this->project_id);
    }

    /**
     * @return AppProposal
     */
    public function proposal(): AppProposal
    {
        return (new AppProposal())->findById($this->proposal_id);
    }

    /**
     * @return int
     */
    public function chat()
    {
        return (new AppChat())
            ->find("group_id = :group_id AND user_id != :user_id AND visualized = 'n'",
                "group_id={$this->id}&user_id=".user()->id)
            ->count();
    }
}
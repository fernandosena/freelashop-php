<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 03/01/2022
 * Time: 20:08
 */

namespace Source\Models\FreelaApp;


use Source\Core\Model;
use Source\Models\Notification;
use Source\Models\User;

/**
 * Class AppChat
 * @package Source\Models\FreelaApp
 */
class AppChat extends Model
{
    /**
     * AppChat constructor.
     */
    public function __construct()
    {
        parent::__construct("app_chat", ["id"], ["group_id", "user_id", "content"]);
    }

    /**
     * @param AppGroupChat $groupChat
     * @param User $user
     * @param string $content
     * @return null|AppChat
     */
    public function register(AppGroupChat $groupChat, User $user, string $content): ?AppChat
    {
        $this->group_id = $groupChat->id;
        $this->user_id = $user->id;
        $this->content = $content;

        if(!$this->save()){
            return null;
        }

        if($groupChat->proposal()->user_id == $user->id){
            $userId = $groupChat->project()->author;
        }else{
            $userId = $groupChat->proposal()->user_id;
        }

        //Cria Notificação
        (new Notification())->newNotification($userId,"Nova Mensagem", url("/app/chat/{$groupChat->id}"));

        return $this;
    }

    /**
     * @return null|User
     */
    public function user(): ?User
    {
        return (new User())->findById($this->user_id);
    }

    /**
     * @return mixed|null|Model
     */
    public function chatGroup()
    {
        return (new AppGroupChat())->findById($this->group_id);
    }
}
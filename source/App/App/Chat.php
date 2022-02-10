<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 14/12/2021
 * Time: 14:35
 */

namespace Source\App\App;



use Source\Models\FreelaApp\AppChat;
use Source\Models\FreelaApp\AppGroupChat;
use Source\Models\FreelaApp\AppProject;
use Source\Models\FreelaApp\AppProposal;
use Source\Models\Notification;

/**
 * Class Chat
 * @package Source\App\App
 */
class Chat extends App
{
    public function home(): void
    {
        $head = $this->seo->render(
            "Minha Mensagens - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/app/chat"),
            theme("/assets/images/share.jpg"),
            false
        );

        $notificacoes = (new Notification())->find("user_id = :user_id AND view < 1", "user_id={$this->user->id}")->fetch(true);
        if($notificacoes){
            foreach ($notificacoes as $notificacoe) {
                $notificacoe->view = 1;
                $notificacoe->save();
            }
        }

        echo $this->view->render("app/chat/home", [
            "head" => $head,
            "title" => "Minhas Mensagens",
            "rooms" =>(new AppGroupChat())
                ->find("contractor_id =:contractor_id OR freelancer_id = :freelancer_id",
                    "contractor_id={$this->user->id}&freelancer_id={$this->user->id}")
                ->order("created_at DESC")
                ->fetch(true),
            "paginator" => ""
        ]);
    }

    /**
     * @param array|null $data
     */
    public function room(?array $data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);

        $chat = (new AppGroupChat())->findById($data['group']);

        if(!$chat){
            $this->message->warning("Sala de chat não encontrado")->flash();
            redirect("/chat");
        }

        if(($chat->proposal()->user_id != $this->user->id) && ($chat->project()->author != $this->user->id)){
            $this->message->warning("Sala de chat não encontrado")->flash();
            redirect("/chat");
            return;
        }

        $head = $this->seo->render(
            "Chat - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/app/chat/{$data['group']}"),
            theme("/assets/images/share.jpg"),
            false
        );

        $view = (new AppChat())->find("group_id = :group_id AND user_id != :user_id AND visualized = 'n'",
            "group_id={$data['group']}&user_id={$this->user->id}")->fetch(true);
        if($view){
            foreach ($view as $item) {
                $item->visualized = 'y';
                $item->save();
            }
        }


        echo $this->view->render("app/chat/chat", [
            "head" => $head,
            "chat" => $chat,
            "conversations" => (new AppChat())->find("group_id = :group_id", "group_id={$data['group']}")
                                ->order("created_at ASC")
                                ->fetch(true)
        ]);
    }

    /**
     * @param array $data
     */
    public function send(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $groupChat = (new AppGroupChat())->findById($data['group']);

        if(!$groupChat){
            $json['message'] = $this->message->warning("Sala de chat não encontrado")->render();
            echo json_encode($json);
            return;
        }

        $proposal = (new AppProposal())->findById($groupChat->proposal_id);
        if(!$proposal){
            $json['message'] = $this->message->warning("Proposta informadp não existe")->render();
            echo json_encode($json);
            return;
        }

        $project = (new AppProject())->findById($groupChat->project_id);
        if(!$project){
            $json['message'] = $this->message->warning("Projeto informadp não existe")->render();
            echo json_encode($json);
            return;
        }

        if(($proposal->user_id != $this->user->id) && ($project->author != $this->user->id)){
            $json['message'] = $this->message->warning("Você não tem autorização para enviar mensagem")->render();
            echo json_encode($json);
            return;
        }

        $chat = (new AppChat());
        if(!$chat->register($groupChat, $this->user, $data['content'])){
            $json['message'] = $chat->message()->render();
            echo json_encode($json);
            return;
        }

        $json['name'] =  $this->user->fullName();
        $json['date'] =  date_fmt($chat->create_at, "d/m/Y H:m:s");
        $json['image'] =  image($this->user->photo(), 300,300);
        $json['content'] = $data['content'];

        echo json_encode(["chat" => $json]);
    }
}
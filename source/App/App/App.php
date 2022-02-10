<?php

namespace Source\App\App;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\Auth;
use Source\Models\FreelaApp\AppProject;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Class App
 * @package Source\App\App
 */
class App extends Controller
{
    /** @var User */
    protected $user;

    /**
     * App constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_THEME . "/");

        if (!$this->user = Auth::user()) {
            $this->message->warning("Efetue login para acessar a plataforma")->flash();
            redirect("/entrar");
        }

        (new Access())->report();
        (new Online())->report();

        //UNCONFIRMED EMAIL
        if ($this->user->status != "confirmed") {
            $session = new Session();
            if (!$session->has("appconfirmed")) {
                $this->message->info("IMPORTANTE: Acesse seu e-mail para confirmar seu cadastro e ativar todos os recursos.")->flash();
                $session->set("appconfirmed", true);
                (new Auth())->register($this->user);
            }
        }
    }

    /**
     * Cadastro de mensagem formulário suporte
     * @param array $data
     * @throws \Exception
     */
    public function support(array $data): void
    {
        $message = filter_var($data["message"], FILTER_SANITIZE_STRING);

        //Verifica se a mensagem foi informada
        if (empty($data["message"])) {
            $this->message->warning("Para enviar escreva sua mensagem.")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }

        //So pode enviar 3 mensagens a cada 5 minutos
        if (request_limit("appsupport", 3, 60 * 5)) {
            $this->message->warning("Por favor, aguarde 5 minutos para enviar novos contatos, sugestões
            ou reclamações")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }

        //Não deixar o usuário enviar a mensagem mensagem para diferentes canais
        if (request_repeat("message", $data["message"])) {
            $this->message->info("Já recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo 
            contato e responderemos em breve.")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }

        /* EMIAL PARA O SUPORTE */
        $subject = date_fmt() . " - {$data["subject"]}";
        (new Email())->bootstrap(
            $subject,
            CONF_MAIL_SUPPORT,
            "Suporte " . CONF_SITE_NAME
        )->view("support", [
            "subject" => $subject,
            "message" => "<p>".str_textarea($message)."</p>",
            "extra" => [
                "user" => [
                    "id" => $this->user->id,
                    "name" => $this->user->fullName(),
                    "email" => $this->user->email
                ]
            ]
        ])->queue();

        /* EMIAL PARA O CLIENTE */
        $subject = "Mensagem enviada";
        (new Email())->bootstrap(
            $subject,
            $this->user->email,
            $this->user->fullName()
        )->view("default", [
            "title" => "Sua mensagem foi enviada com sucesso para o suporte da ".CONF_SITE_NAME,
            "subject" => $subject,
            "message" => "<p>Em até <strong>48h</strong> responderemos sua mensagem para esse e-mail.</p>"
        ])->queue();

        $this->message->success("Recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo contato e responderemos em breve para o seu e-mail {$this->user->email}.")->flash();
        $json["reload"] = true;
        echo json_encode($json);
    }

    /**
     * PÁGINA DE PERFIL
     * @param array|null $data
     * @throws \Exception
     */
    public function profile(?array $data): void
    {

        if (!empty($data["update"])) {
            list($d, $m, $y) = explode("/", $data["datebirth"]);

            if(!empty($data["document"])){
                $document = preg_replace("/[^0-9]/", "", $data["document"]);
                $findDocument = (new User())->find("document = :document", "document={$document}")->count();
                if($findDocument){
                    $json["message"] = $this->message->warning("esse CPF ja se encontra cadastrado")->before("Ooops {$this->user->first_name}! ")->after(".")->render();
                    echo json_encode($json);
                    return;
                }
            }

            $user = (new User())->findById($this->user->id);
            $user->first_name = $data["first_name"];
            $user->last_name = $data["last_name"];
            $user->genre = $data["genre"];
            $user->datebirth = "{$y}-{$m}-{$d}";
            $user->document = preg_replace("/[^0-9]/", "", $data["document"]);

            if (!empty($_FILES["photo"])) {
                $file = $_FILES["photo"];
                $upload = new Upload();

                if ($this->user->photo()) {
                    (new Thumb())->flush("storage/{$this->user->photo}");
                    $upload->remove("storage/{$this->user->photo}");
                }

                if (!$user->photo = $upload->image($file, "{$user->first_name} {$user->last_name} " . time(), 360)) {
                    $json["message"] = $upload->message()->before("Ooops {$this->user->first_name}! ")->after(".")->render();
                    echo json_encode($json);
                    return;
                }
            }

            if(!empty($data['document']) && !is_cpf($data['document'])){
                $json["message"] = $this->message->warning("O CPF informado é inválido, favor verifique os dados")->render();
                echo json_encode($json);
                return;
            }

            if (!empty($data["password"])) {
                if (empty($data["password_re"]) || $data["password"] != $data["password_re"]) {
                    $json["message"] = $this->message->warning("Para alterar sua senha, informa e repita a nova senha!")->render();
                    echo json_encode($json);
                    return;
                }

                $user->password = $data["password"];
            }

            if (!$user->save()) {
                $json["message"] = $user->message()->render();
                echo json_encode($json);
                return;
            }

            //Envia e-mail de alteração para o usuario
            $subject = "Perfil atualizado com sucesso";
            (new Email())->bootstrap(
                $subject,
                $this->user->email,
                $this->user->fullName()
            )->view(
                "default", [
                    "title" => $subject,
                    "message" => "<p>Olá {$this->user->first_name},</p>
                    <p> o seu perfil foi atualizado com sucesso</p>"
                ]
            )->queue();

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}. Seus dados foram atualizados com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Meu perfil - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $project = (new AppProject())->balance($this->user);

        echo $this->view->render("app/profile", [
            "head" => $head,
            "title" => "Perfil",
            "user" => $this->user,
            "photo" => ($this->user->photo() ? image($this->user->photo, 360, 360) :
                theme("/assets/images/avatar.jpg", CONF_VIEW_APP)),
            "project" => [
                "full"=>abs($project->full),
                "accepted"=>abs($project->accepted),
                "concluded"=>abs($project->concluded)
            ]
        ]);
    }

    /**
     * APP LOGOUT
     */
    public function logout(): void
    {
        $this->message->info("Você saiu com sucesso " . Auth::user()->first_name . ". Volte logo :)")->flash();

        Auth::logout();
        redirect("/entrar");
    }
}
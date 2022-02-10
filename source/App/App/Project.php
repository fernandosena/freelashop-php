<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 14/12/2021
 * Time: 18:09
 */

namespace Source\App\App;

use Source\Core\View;
use Source\Models\Category;
use Source\Models\FreelaApp\AppCreditCardGetNet;
use Source\Models\FreelaApp\AppPlan;
use Source\Models\FreelaApp\AppProject;
use Source\Support\Email;
use Source\Support\Message;
use Source\Support\Pager;
use Source\Models\FreelaApp\AppProject as Projects;
use Source\Models\FreelaApp\AppBudget;

/**
 * Class Project
 * @package Source\App\App
 */
class Project extends App
{
    /**
     * Project constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Meus Projetos
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $head = $this->seo->render(
            "Meus Projetos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/app/projetos"),
            theme("/assets/images/share.jpg"),
            false
        );

        $data['status'] = "all";

        $projects = (new Projects())->filter($data ?? null, "author = :author", "author={$this->user->id}");
        $pager = new Pager(url("/app/projetos/all/"));
        $pager->pager($projects->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));


        //Renderiza template
        echo $this->view->render("projects", [
            "head" => $head,
            "title" => "Meus projetos",
            "projects" => $projects->limit($pager->limit())
                ->offset($pager->offset())
                ->order("created_at DESC")
                ->fetch(true),
            "paginator" => $pager->render(),
            "categories" => (new Category())
                ->find("type = :type", "type=project")
                ->fetch(true),
            "message" =>(new Message())
                ->warning("Você não tem Nenhum projeto ainda, ")
                ->before("Que pena! ")
                ->after("<a href='".url("/criar-projeto")."'>CRIAR PROJETO</a>")
        ]);
    }

    /**
     * Pesquisa pelo projeto
     */
    public function searchProject(array $data): void
    {
        $terms = null;
        $parms = null;

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $find = new \stdClass();
        $find->category_id = (!empty($data["category"]) ? $data["category"]: null);
        $find->subcategory_id = (!empty($data["subcategory"]) ? $data["subcategory"]: null);
        $find->search = (!empty($data["search"]) ? $data["search"]: null);
        $find->type = (!empty($data["type"]) ? $data["type"] : null);

        $array = [
            "category_id" => (!empty($find->category_id) ? $find->category_id : null),
            "subcategory_id" => (!empty($find->subcategory_id) ? $find->subcategory_id : null),
//              "search" => (!empty($find->search) ? $find->search : null),
            "type" => (!empty($find->type) ? $find->type : null)
        ];

        $array = array_filter($array);

        $dateTerms = [];
        $dateParams = [];
        foreach ($array as $bind => $value) {
            $dateTerms[] = "{$bind} = :{$bind}";
            $dateParams[] = "{$bind}={$value}";
        }
        $dateTerms = implode(" AND ", $dateTerms);
        $dateParams = implode("&", $dateParams);

        parse_str($dateParams);
        parse_str($dateTerms);

        $terms = $dateTerms;
        $parms = $dateParams;

        $projects = (new Projects())->findProject($terms, $parms);

        $pager = new Pager(url("/app/all/"));
        $pager->pager($projects->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        if($projects->count()){
            $this->message->success("Encontramos {$projects->count()} projeto(s) para você")->flash();
        }

        //SEO DA PÁGINA
        $head = $this->seo->render(
            "Olá {$this->user->first_name}. Vamos controlar? - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        //Renderiza template
        echo $this->view->render("home", [
            "head" => $head,
            "title" => "Projetos",
            "projects" => $projects->limit($pager->limit())
                ->offset($pager->offset())
                ->order("created_at DESC")
                ->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * Reporta erros no proejto
     * @param array $data
     */
    public function report(array $data): void
    {
        $message = filter_var($data["message"], FILTER_SANITIZE_STRING);

        $project = (new AppProject())->findByUri($data["project"]);

        if(!$project){
            $this->message->warning("O projeto informado não existe")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        if (empty($data["message"])) {
            $this->message->warning("Para enviar escreva sua mensagem.")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        if (request_limit("appreport", 3, 60 * 5)) {
            $this->message->warning("Por favor, aguarde 5 minutos para enviar novos contatos, sugestões ou reclamações")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        if (request_repeat("message", $data["message"])) {
            $this->message->info("Já recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo contato e responderemos em breve.")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        /* EMIAL PARA O SUPPORT */
        $subject = date_fmt() . " - {$data["subject"]}";
        (new Email())->bootstrap(
            $subject,
            CONF_MAIL_SUPPORT,
            "Problema " . CONF_SITE_NAME
        )->view("support", [
            "subject" => $subject,
            "message" => "<p>".str_textarea($message)."</p>",
            "extra" => [
                "project" => [
                    "id" => $project->id,
                    "title" => $project->title,
                    "uri" => $project->uri,
                    "author" => $project->author()->fullName(),
                    "email" => $project->author()->email
                ],
                "user" => [
                    "uid" => $this->user->id,
                    "name" => $this->user->fullName(),
                    "email" => $this->user->email
                ]
            ]

        ])->queue();

        /* EMIAL PARA O CLIENTE */
        $subject = "Problema reportado";
        (new Email())->bootstrap(
            $subject,
            $this->user->email,
            $this->user->fullName()
        )->view("default", [
            "title" => "O problema informado foi enviada para o nosso time de suporte do ".CONF_SITE_NAME,
            "message" => "<p>Em até <strong>48h</strong> responderemos sua mensagem para esse e-mail.</p>"
        ])->queue();

        $this->message->success("Recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo contato e responderemos em breve.")->flash();
        echo json_encode(["reload" => true]);
    }

    /**
     * Ativa ou desativa o projeto
     * @param array $data
     */
    public function action(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);


        //Consulta projeto pela uri
        $project = (new Projects())->findByUri($data["uri"]);

        //Verifica se o porjeto existe
        if(!$project){
            $json["warning"] = "O projeto informado não existe";
            echo json_encode($json);
            return;
        }
        //Verifica se o usuário logado é proprietario do projeto
        if($project->author != $this->user->id){
            $json["warning"] = "Você não tem autorização para realizar essa ação";
            echo json_encode($json);
            return;
        }

        if($data['type'] == "pause"){
            $project->status = "paused";

            if(!$project->save()){
                $json["error"] = "Erro para pausar o projeto, favor tente novamente";
                echo json_encode($json);
                return;
            }

            //Envia e-mail de alteração para o usuario
            $subject = "Projeto pausado com sucesso";
            (new Email())->bootstrap(
                $subject,
                $this->user->email,
                $this->user->fullName()
            )->view(
                "mail", [
                    "subject" => $subject,
                    "message" => "<p>Olá {$this->user->first_name},</p>
                    <p> o seu projeto <strong>{$project->title} foi pausado com sucesso</strong></p>"
                ]
            )->queue();

            $json["success"] = "Projeto pausado com sucesso";
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }


        if($data['type'] == "start"){
            $project->status = "pending";
            if(!$project->save()){
                $json["error"] = "Erro para pausar o projeto, favor tente novamente";
                echo json_encode($json);
                return;
            }

            //Envia e-mail de alteração para o usuario
            $subject = "Projeto inciado com sucesso";
            (new Email())->bootstrap(
                $subject,
                $this->user->email,
                $this->user->fullName()
            )->view(
                "mail", [
                    "subject" => $subject,
                    "message" => "<p>Olá {$this->user->first_name},</p>
                    <p>o seu projeto <strong>{$project->title} foi inciado com sucesso</strong></p>"
                ]
            )->queue();

            $json["success"] = "Projeto inicializado com sucesso";
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }

        //Aprova trabalho do freelancer
        if($data['type'] == "aproved"){
            $project->status = "concluded";
            if(!$project->save()){
                $json["error"] = "Erro para atualizar status do projeto, favor tente novamente";
                echo json_encode($json);
                return;
            }

            /* EMAIL PARA O CLIENTE */
            $subject = "Valor do projeto liberado";
            (new Email())->bootstrap(
                $subject,
                $this->user->email,
                $this->user->fullName()
            )->view("default", [
                "title" => $subject,
                "message" => "<p>Olá {$this->user->first_name}, <p>
                <p>O valor foi enviado para a conta do freelancer. A <a href='".CONF_URL_BASE."'>".CONF_SITE_NAME."</a> agradecemos a sua confiança e preferência. </p>
                <p>Muito sucesso em sua carreira e que venha mais e mais projetos ;).</p>"
            ])->queue();


            /* EMAIL PARA O FREELANCCER */
            $subject = "Pagamento liberado";
            (new Email())->bootstrap(
                $subject,
                $project->proposal()->fetch()->user()->email,
                $project->proposal()->fetch()->user()->fullName()
            )->view("default", [
                "title" => $subject,
                "message" => "<p>Olá {$project->proposal()->fetch()->user()->first_name}, <p>
                <p>O valor foi liberado pelo contratante e será enviado para sua conta em até 5 dias úteis. A <a href='".CONF_URL_BASE."'>".CONF_SITE_NAME."</a> agradece a sua confiança e preferência. </p>
                <p>Muito sucesso em sua carreira e que venha mais e mais trabalhos ;).</p>"
            ])->queue();

            $json["success"] = "O valor foi liberado para o freelancer";
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }

    }
}
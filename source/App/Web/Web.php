<?php

namespace Source\App\Web;

use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Category;
use Source\Models\Faq\Channel;
use Source\Models\Faq\Question;
use Source\Models\FreelaApp\AppDepositions;
use Source\Models\FreelaApp\AppScore;
use Source\Models\Newsletter;
use Source\Models\FreelaApp\AppProject;
use Source\Models\Post;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\SubCategory;
use Source\Models\User;
use Source\Support\Email;

/**
 * Web Controller
 * @package Source\App
 */
class Web extends Controller
{
    /** @var null|User */
    protected $user;

    /**
     * Web constructor.
     */
    public function __construct()
    {
        if(CONF_MANUTENCAO){
            redirect("/ops/manutencao");
        }
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_THEME . "/");

        (new Access())->report();
        (new Online())->report();

        $this->user = (Auth::user() ?? null);
    }

    /**
     * SITE HOME
     */
    public function home(): void
    {
        $schema = [
            "@context" => "http://schema.org",
            "@type" => "WebSite",
            "name" => CONF_SITE_NAME,
            "alternateName" => CONF_SITE_NAME." Brasil",
            "url" => url(),
            "image" => [
                "@type" => "ImageObject",
                "url" => url("/storage/images/favicon.png"),
                "height" => "400",
                "width" => "400"
            ],
            "sameAs" => [
                "https://www.facebook.com/".CONF_SOCIAL_PAGE["facebook"],
                "https://twitter.com/".CONF_SOCIAL_PAGE["twitter"]
            ],
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => url()."/?query={search_term_string}",
                "query-input" => "required name=search_term_string"
            ]
        ];

        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            true,
            $schema
        );


        echo $this->view->render("home", [
            "head" => $head,
            "footerEffect" => true,
            "categories" => (new Category())->find("cover IS NOT NULL AND type = 'project'")
                            ->limit(8)
                            ->fetch(true),
            "video" => "",
            "depositions" => (new AppDepositions())
                ->find("active = 'Y'")
                ->fetch(true),
            "posts" => (new Post())->find("status = 'post'")
                        ->order("views ASC")
                        ->limit(8)
                        ->fetch(true)
        ]);

    }

    /**
     * SITE ABOUT
     */
    public function about(): void
    {
        $schema = [
            "@context" => "http://schema.org",
            "@type" => "Organization",
            "name" => CONF_SITE_NAME,
            "alternateName" => "Contratação de freelancer ".CONF_SITE_NAME,
            "foundingDate" => "2022",
            "logo" => url("/storage/images/favicon.png"),
            "image" =>  url("/storage/images/favicon.png"),
            "url" => url("/sobre"),
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => CONF_SITE_ADDR_STREET.", ".CONF_SITE_ADDR_CITY." - ".CONF_SITE_ADDR_STATE.", ".CONF_SITE_ADDR_ZIPCODE,
                "addressLocality" => CONF_SITE_ADDR_CITY,
                "postalCode" => CONF_SITE_ADDR_ZIPCODE,
                "addressCountry" => "BRA"
            ],
            "contactPoint" => [
                "@type" => "ContactPoint",
                "contactType" => "Sales",
                "email" => "mailto:".CONF_SITE_EMAIL,
                "url" => url()."#footer",
            ],
            "sameAs" => [
                "https://www.facebook.com/".CONF_SOCIAL_PAGE["facebook"],
                "https://twitter.com/".CONF_SOCIAL_PAGE["twitter"]
            ],
        ];

        $head = $this->seo->render(
            "Saiba quem somos -  " . CONF_SITE_NAME,
            "Desde o seu começo, em 2021, a missão da ".CONF_SITE_NAME." é oferecer serviços de comunicação que facilitam a vida dos freelancers e dos seus clientes.",
            url("/sobre"),
            theme("/assets/images/share.jpg"),
            true,
            $schema
        );

        echo $this->view->render("about", [
            "head" => $head,
            "video" => "",
            "faq" => (new Question())
                ->find("channel_id = :id", "id=1", "question, response")
                ->order("order_by")
                ->fetch(true)
        ]);
    }

    /**
     * SITE FAQ
     */
    public function faq(): void
    {
        $type = filter_input(INPUT_GET, "route", FILTER_SANITIZE_STRIPPED);
        $type = explode("/",substr($type, 1));

        $head = $this->seo->render(
            "FAQ ".ucfirst($type[1])." - ". CONF_SITE_NAME,
            "Dicas e respostas da Equipe Sucesso do Cliente. Contratação ou trabalhos. Tudo o que você precisa saber para criar, excluir, configurar, redirecionar. tudo isso para você ".ucfirst($type[1]),
            url("/faq/$type[1]"),
            theme("/assets/images/share.jpg")
        );

        $channelSite = (new Channel())->find("channel = 'site'")->fetch();
        if($channelSite){
            $questionSite = $channelSite->questions()->order("order_by ASC")->fetch(true);
        }

        $channel = (new Channel())->find("channel = :channel", "channel={$type[1]}")->fetch();
        if($channel){
            $question = $channel->questions()->order("order_by ASC")->fetch(true);
        }

        echo $this->view->render("faq", [
            "head" => $head,
            "title" => "Perguntas frequentes",
            "faq_name" => ucfirst($type[1]),
            "faq_site" => ($questionSite ?? null),
            "faqs" => ($question ?? null)
        ]);
    }

    /**
     * SITE TERMS
     */
    public function terms(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - Termos de uso",
            CONF_SITE_DESC,
            url("/termos"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("terms-conditions", [
            "head" => $head,
            "top" => true
        ]);
    }

    /**
     * SITE PRIVACY
     */
    public function privacy(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - Politica de privacidade",
            CONF_SITE_DESC,
            url("/politica-de-privacidade"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("privacy-policy", [
            "head" => $head,
            "top" => true
        ]);
    }

    /**
     * SITE OPT-IN CONFIRM
     */
    public function confirm(): void
    {
        $head = $this->seo->render(
            "Confirme Seu Cadastro - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/confirma"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("optin", [
            "head" => $head,
            "data" => (object)[
                "title" => "Falta pouco! Confirme seu cadastro.",
                "desc" => "Enviamos um link de confirmação para seu e-mail. Acesse e siga as instruções para concluir seu cadastro e comece a criar seus projetos com o ".CONF_SITE_NAME,
                "image" => image(theme("/assets/images/freelashop-optin-confirm.jpg"), 500)
            ],
            "top" => true
        ]);
    }

    /**
     * SITE DASH
     */
    public function dash(): void
    {
        if(Auth::user()){
            if(Auth::user()->type == "contractor"){
                $projects = (new AppProject())
                    ->find("author = :author", "author=".Auth::user()->id)
                    ->count();
                if($projects){
                    redirect("/freelancers");
                }
                redirect("/criar-projeto");
            }
            redirect("/projetos");
        }
        redirect("/");
    }

    /**
     * SITE OPT-IN SUCCESS
     * @param array $data
     */
    public function success(array $data): void
    {
        $email = base64_decode($data["email"]);
        $user = (new User())->findByEmail($email);

        if ($user && $user->status != "confirmed") {
            $user->status = "confirmed";
            $user->save();

            if(!empty($user->user_id)){
                $score = (new AppScore());
                $score->user_id = $user->user_id;
                $score->value = CONF_SCORE["USER"]["CREATE"];
                $score->comment = "Ativação do usuário {$user->first_name}";
                $score->save();
            }

            $subject = "E-mail confirmado com sucesso";
            (new Email())->bootstrap(
                $subject,
                $user->email,
                $user->fullName()
            )->view(
                "default", [
                    "title" => $subject." ;)",
                    "message" => "<p>Que bom que você confirmou seu e-mail {$user->first_name}.<p><p>Agora você será notificado de 
            todas as nossas informações e novidades mais importantes, aproveite nossa plataforma.</p>"
                ]
            )->queue();
        }

        $head = $this->seo->render(
            "Bem-vindo(a) ao " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/obrigado"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("optin", [
            "head" => $head,
            "data" => (object)[
                "title" => "Tudo pronto. Você já pode iniciar seu projeto :)",
                "desc" => "Bem-vindo(a) ao seu sistema ".CONF_SITE_NAME.", vamos começar?",
                "image" => image(theme("/assets/images/freelashop-optin-success.jpg"), 500),
                "link" => url("/entrar"),
                "linkTitle" => "Fazer Login"
            ],
            "track" => (object)[
                "fb" => "Lead",
                "aw" => ""
            ],
            "top" => true
        ]);
    }

    /**
     * CADASTRAR E-MAIL NO NEWSLETTER
     * @param array $data
     */
    public function newsletter(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $newsletter = (new Newsletter());

        if (!csrf_verify($data)) {
            $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
            echo json_encode($json);
            return;
        }

        if(!is_email($data['email'])){
            $json['message'] = $this->message->error("O e-mail iformado é inválido")->render();
            echo json_encode($json);
            return;
        }

        //Verifica se e-mail ja encontra-se cadastrado
        if($newsletter->findByEmail($data['email'])->count()){
            $json['message'] = $this->message->warning("O e-mail informado já se encontra cadastrado")->render();
            echo json_encode($json);
            return;
        }

        $newsletter->bootstrap($data['email']);
        if(!$newsletter){
            $json['message'] = $newsletter->message()->render();
            echo json_encode($json);
            return;
        }

        $json['message'] = $this->message->success("E-mail cadastrado com sucesso")->render();
        echo json_encode($json);
        return;
    }

    /**
     * RETORNA AS SUBCATEGORIAS AO CONSULTAR UMA CATEGORIA
     * @param array|null $data
     */
    public function subcategory(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $categoryId = (new Category())->findByUri($data["id"]);
        $categoryId = $categoryId->id;

        $subCategory = (new SubCategory())->find("category_id = :c", "c={$categoryId}");
        $select = "";
        if($subCategory->count()){
            $select .= "<option value='' disabled selected>&ofcir; Selecione uma subcategoria</option>";
            foreach ($subCategory->fetch(true) as $category) {
                $select .= "<option value='{$category->data()->uri}'>&ofcir; {$category->data()->title}</option>";
            }
        }else{
            $select .= "<option value='' disabled selected>&ofcir; Nenhuma subcategoria encontrada</option>";
        }

        echo $select;
    }

    /**
     * SITE NAV ERROR
     * @param array $data
     */
    public function error(array $data): void
    {
        $error = new \stdClass();

        switch ($data['errcode']) {
            case "problemas":
                $error->code = "OPS";
                $error->title = "Estamos enfrentando problemas!";
                $error->message = "Parece que nosso serviço não está diponível no momento. Já estamos vendo isso mas caso precise, envie um e-mail :)";
                $error->linkTitle = "ENVIAR E-MAIL";
                $error->link = "mailto:" . CONF_MAIL_SUPPORT;
                break;

            case "manutencao":
                $error->code = "OPS";
                $error->title = "Desculpe. Estamos em manutenção!";
                $error->message = "Voltamos logo! Por hora estamos trabalhando para melhorar nosso conteúdo para você controlar melhor as suas contas :P";
                $error->linkTitle = null;
                $error->link = null;
                break;

            default:
                $error->code = $data['errcode'];
                $error->title = "Ooops. Conteúdo indispinível :/";
                $error->message = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi removido :/";
                $error->linkTitle = "Continue navegando!";
                $error->link = url_back();
                break;
        }

        $head = $this->seo->render(
            "{$error->code} | {$error->title}",
            $error->message,
            url("/ops/{$error->code}"),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("error", [
            "head" => $head,
            "error" => $error,
            "top" => true
        ]);
    }
}
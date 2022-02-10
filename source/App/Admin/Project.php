<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 17/01/2022
 * Time: 21:38
 */

namespace Source\App\Admin;


use Source\Core\View;
use Source\Models\Category;
use Source\Models\FreelaApp\AppContract;
use Source\Models\FreelaApp\AppProject;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

class Project extends Admin
{
    private $balance;
    /**
     * Blog constructor.
     */
    public function __construct()
    {
        parent::__construct();

        if($this->user->level < 4){
            $this->message->warning("Você não tem premição para acessar essa página")->flash();
            redirect("/admin/");
        }

        $this->balance = new \stdClass();
        $this->balance->full = 0;
        $this->balance->pending = 0;
        $this->balance->pending_pay = 0;
        $this->balance->accepted = 0;
        $this->balance->active = 0;
        $this->balance->concluded = 0;
        $this->balance->paused = 0;
        $this->balance->canceled = 0;
        $this->balance->closed = 0;

        $balance = (new AppProject())->find("","","
                (SELECT COUNT(id) FROM app_projects) AS 'full',
                (SELECT COUNT(id) FROM app_projects WHERE `status` = 'pending') AS 'pending',
                (SELECT COUNT(id) FROM app_projects WHERE `status` = 'pending_pay') AS 'pending_pay',
                (SELECT COUNT(id) FROM app_projects WHERE `status` = 'accepted') AS 'accepted',
                (SELECT COUNT(id) FROM app_projects WHERE `status` = 'active') AS 'active',
                (SELECT COUNT(id) FROM app_projects WHERE `status` = 'concluded') AS 'concluded',
                (SELECT COUNT(id) FROM app_projects WHERE `status` = 'paused') AS 'pause',
                (SELECT COUNT(id) FROM app_projects WHERE `status` = 'canceled') AS 'canceled',
                (SELECT COUNT(id) FROM app_projects WHERE `status` = 'closed') AS 'closed'
            ")->fetch();

        if ($balance) {
            $this->balance->full = abs($balance->full);
            $this->balance->pending = abs($balance->pending);
            $this->balance->pending_pay = abs($balance->pending_pay);
            $this->balance->accepted = abs($balance->accepted);
            $this->balance->active = abs($balance->active);
            $this->balance->concluded = abs($balance->concluded);
            $this->balance->paused = abs($balance->paused);
            $this->balance->canceled = abs($balance->canceled);
            $this->balance->closed = abs($balance->closed);
        }
    }

    /**
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/project/home/{$s}/1")]);
            return;
        }

        $search = null;
        $posts = (new AppProject())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $posts = (new AppProject())->find("MATCH(title, content) AGAINST(:s)", "s={$search}");
            if (!$posts->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/project/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/project/home/{$all}/"));
        $pager->pager($posts->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Projetos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/project/home", [
            "app" => "project/home",
            "balance" => $this->balance,
            "head" => $head,
            "posts" => $posts->limit($pager->limit())
                ->offset($pager->offset())
                ->order("status,created_at DESC")
                ->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search
        ]);
    }


    /**
     * @param array|null $data
     */
    public function pending(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/project/pending/{$s}/1")]);
            return;
        }

        $search = null;
        $posts = (new AppProject())->find("status = 'pending'");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $posts = (new AppProject())->find("MATCH(title, content) AGAINST(:s)", "s={$search}");
            if (!$posts->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/project/pending");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/project/pending/{$all}/"));
        $pager->pager($posts->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Projetos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/project/home", [
            "app" => "project/pending",
            "balance" => $this->balance,
            "head" => $head,
            "posts" => $posts->limit($pager->limit())
                ->offset($pager->offset())
                ->order("created_at DESC")
                ->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search
        ]);
    }

    public function pendingPay(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/project/pending-pay/{$s}/1")]);
            return;
        }

        $search = null;
        $posts = (new AppProject())->find("status = 'pending_pay'");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $posts = (new AppProject())->find("MATCH(title, content) AGAINST(:s)", "s={$search}");
            if (!$posts->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/project/pending-pay");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/project/pending-pay/{$all}/"));
        $pager->pager($posts->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Projetos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/project/home", [
            "app" => "project/pending-pay",
            "balance" => $this->balance,
            "head" => $head,
            "posts" => $posts->limit($pager->limit())
                ->offset($pager->offset())
                ->order("created_at DESC")
                ->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search
        ]);
    }

    public function concluded(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/project/concluded/{$s}/1")]);
            return;
        }

        $search = null;
        $posts = (new AppProject())->find("status = 'concluded'");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $posts = (new AppProject())->find("MATCH(title, content) AGAINST(:s)", "s={$search}");
            if (!$posts->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/project/concluded");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/project/concluded/{$all}/"));
        $pager->pager($posts->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Projetos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/project/home", [
            "app" => "project/concluded",
            "balance" => $this->balance,
            "head" => $head,
            "posts" => $posts->limit($pager->limit())
                ->offset($pager->offset())
                ->order("created_at DESC")
                ->fetch(true),
            "paginator" => $pager->render(),
            "search" => $search
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function post(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $postCreate = new AppProject();
            $postCreate->author = $data["author"];
            $postCreate->category = $data["category"];
            $postCreate->title = $data["title"];
            $postCreate->uri = str_slug($postCreate->title . "-" . uniqid(rand()));
            $postCreate->subtitle = $data["subtitle"];
            $postCreate->content = str_replace(["{title}"], [$postCreate->title], $content);
            $postCreate->video = $data["video"];
            $postCreate->status = $data["status"];
            $postCreate->post_at = date_fmt_back($data["post_at"]);

            //upload cover
            if (!empty($_FILES["cover"])) {
                $files = $_FILES["cover"];
                $upload = new Upload();
                $image = $upload->image($files, $postCreate->title);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $postCreate->cover = $image;
            }

            if (!$postCreate->save()) {
                $json["message"] = $postCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Post publicado com sucesso...")->flash();
            $json["redirect"] = url("/admin/blog/post/{$postCreate->id}");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $postEdit = (new AppProject())->findById($data["post_id"]);

            if (!$postEdit) {
                $this->message->error("Você tentou atualizar um post que não existe ou foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/project/home")]);
                return;
            }

            $postEdit->status = $data["status"];

            if (!$postEdit->save()) {
                $json["message"] = $postEdit->message()->render();
                echo json_encode($json);
                return;
            }

            if($postEdit->status == "accepted"){
                $freelancers = (new User())->find("type = :type", "type=freelancer")->fetch(true);
                if($freelancers){
                    foreach ($freelancers as $freelancer) {
                        $subject = "Novo projeto no ". CONF_SITE_NAME;
                        (new Email())->bootstrap(
                            $subject,
                            $freelancer->email,
                            $freelancer->fullName()
                        )->view(
                            "new-project",[
                                "first_name" => $freelancer->first_name,
                                "title_project" => $postEdit->title,
                                "project_link" => url("/projetos/{$postEdit->uri}")
                            ]
                        )->queue();
                    }
                }
            }


            if($postEdit->status == "active"){
                $contract = (new AppContract())->find("project_id = :project_id", "project_id={$postEdit->id}")
                    ->fetch();
                if($contract){
                    $subject = "Boa notícia!! comece  trabalho no ". CONF_SITE_NAME;
                    (new Email())->bootstrap(
                        $subject,
                        $contract->proposal()->user()->email,
                        $contract->proposal()->user()->fullName()
                    )->view(
                        "default",[
                            "title" => "Pagamento realizado a plataforma ".CONF_SITE_NAME,
                            "message" => "<p>O contratante <strong>{$postEdit->author()->first_name}</strong> já realizou o pagamento na plataforma, você está liberado a realizar o trabalho
                                        do projeto <Strong>{$postEdit->title}</Strong>.</p>
                                        <p><strong>Obs.</strong> Caso queira válidar esse e-mail, acesse a página do projeto ou da proposta e leia o alerta que está na página</p>",
                            "link" => url("/projetos/{$postEdit->uri}"),
                            "title_link" => "Ver projeto"
                        ]
                    )->queue();
                }
            }

            if($postEdit->status == "closed"){
                $contract = (new AppContract())->find("project_id = :project_id", "project_id={$postEdit->id}")
                    ->fetch();
                if($contract){
                    $subject = "Tranferencia realizada!! ";
                    (new Email())->bootstrap(
                        $subject,
                        $contract->proposal()->user()->email,
                        $contract->proposal()->user()->fullName()
                    )->view(
                        "default",[
                            "title" => "Pagamento tranferido para a sua conta ",
                            "message" => "<p>Olá {$contract->proposal()->user()->first_name},<p>
                            <p>O valor foi enviado para a sua conta definida em seu perfil. A ".CONF_SITE_NAME." agradecemos a sua confiança e preferência.</p>
                            <p>Muito sucesso em sua carreira e que venha mais e mais trabalhos ;).<p>"
                        ]
                    )->queue();
                }
            }


            //Enviar e-mail para o author do projeto
            $subject = "Seu projeto esta ".translate($postEdit->status);
            (new Email())->bootstrap(
                $subject,
                $postEdit->author()->email,
                $postEdit->author()->fullName()
            )->view(
                "default",[
                    "title" => $subject,
                    "message" => "<p>O status do seu projeto <strong>{$postEdit->title}</strong> foi alterado para <strong>".translate($postEdit->status).".</strong></p>
                    <p>Clique no link abaixo para acessar o seu projeto</p>
                    ",
                    "title_link" => "VER PROJETO",
                    "link" => url("/projetos/{$postEdit->uri}")
                ]
            )->queue();

            $this->message->success("Projeto atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        $postEdit = null;
        if (!empty($data["post_id"])) {
            $postId = filter_var($data["post_id"], FILTER_VALIDATE_INT);
            $postEdit = (new AppProject())->findById($postId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($postEdit->title ?? "Novo Artigo"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $select = [];
        switch ($postEdit->status){
            case "pending":
                $select = [
                    "pending",
                    "accepted",
                    "canceled"
                ];
                break;
            case "pending_pay":
                $select = [
                    "pending_pay",
                    "active"
                ];
                break;
            case "concluded":
                $select = [
                    "concluded",
                    "closed"
                ];
                break;
        }

        echo $this->view->render("widgets/project/post", [
            "app" => "project/post",
            "balance" => $this->balance,
            "head" => $head,
            "post" => $postEdit,
            "categories" => (new Category())->find("type = :type", "type=project")->order("title")->fetch(true),
            "options" => $select
        ]);
    }

    /**
     * @param array|null $data
     */
    public function categories(?array $data): void
    {
        $categories = (new Category())->find("type = 'project'");
        $pager = new Pager(url("/admin/project/categories/"));
        $pager->pager($categories->count(), 6, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Categorias",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/project/categories", [
            "app" => "project/categories",
            "balance" => $this->balance,
            "head" => $head,
            "categories" => $categories->order("title")
                ->limit($pager->limit())
                ->offset($pager->offset())
                ->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function category(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $categoryCreate = new Category();
            $categoryCreate->title = $data["title"];
            $categoryCreate->uri = str_slug($categoryCreate->title);
            $categoryCreate->description = $data["description"];

            //upload cover
            if (!empty($_FILES["cover"])) {
                $files = $_FILES["cover"];
                $upload = new Upload();
                $image = $upload->image($files, $categoryCreate->title);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $categoryCreate->cover = $image;
            }

            if (!$categoryCreate->save()) {
                $json["message"] = $categoryCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Categoria criada com sucesso...")->flash();
            $json["redirect"] = url("/admin/blog/category/{$categoryCreate->id}");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $categoryEdit = (new Category())->findById($data["category_id"]);

            if (!$categoryEdit) {
                $this->message->error("Você tentou editar uma categoria que não existe ou foi removida")->flash();
                echo json_encode(["redirect" => url("/admin/blog/categories")]);
                return;
            }

            $categoryEdit->title = $data["title"];
            $categoryEdit->uri = str_slug($categoryEdit->title);
            $categoryEdit->description = $data["description"];

            //upload cover
            if (!empty($_FILES["cover"])) {
                if ($categoryEdit->cover && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$categoryEdit->cover}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$categoryEdit->cover}");
                    (new Thumb())->flush($categoryEdit->cover);
                }

                $files = $_FILES["cover"];
                $upload = new Upload();
                $image = $upload->image($files, $categoryEdit->title);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $categoryEdit->cover = $image;
            }

            if (!$categoryEdit->save()) {
                $json["message"] = $categoryEdit->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Categoria atualizada com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $categoryDelete = (new Category())->findById($data["category_id"]);

            if (!$categoryDelete) {
                $json["message"] = $this->message->error("A categoria não existe ou já foi excluída antes")->render();
                echo json_encode($json);
                return;
            }

            if ($categoryDelete->posts()->count()) {
                $json["message"] = $this->message->warning("Não é possível remover pois existem posts cadastrados")->render();
                echo json_encode($json);
                return;
            }

            if ($categoryDelete->cover && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$categoryDelete->cover}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$categoryDelete->cover}");
                (new Thumb())->flush($categoryDelete->cover);
            }

            $categoryDelete->destroy();

            $this->message->success("A categoria foi excluída com sucesso...")->flash();
            echo json_encode(["reload" => true]);

            return;
        }

        $categoryEdit = null;
        if (!empty($data["category_id"])) {
            $categoryId = filter_var($data["category_id"], FILTER_VALIDATE_INT);
            $categoryEdit = (new Category())->findById($categoryId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Categoria",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/blog/category", [
            "app" => "blog/categories",
            "balance" => $this->balance,
            "head" => $head,
            "category" => $categoryEdit
        ]);
    }
}
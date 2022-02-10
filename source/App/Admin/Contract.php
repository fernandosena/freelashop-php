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

class Contract extends Admin
{
    /**
     * Blog constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if($this->user->level != 5){
            $this->message->warning("Você não tem premição para acessar essa página")->flash();
            redirect("/admin/");
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
            echo json_encode(["redirect" => url("/admin/contract/home/{$s}/1")]);
            return;
        }

        $search = null;
        $posts = (new AppContract())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $posts = (new AppProject())->find("MATCH(title, content) AGAINST(:s)", "s={$search}");
            if (!$posts->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/contract/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/contract/home/{$all}/"));
        $pager->pager($posts->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Projetos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/contract/home", [
            "app" => "project/home",
            "head" => $head,
            "contracts" => $posts->limit($pager->limit())
                ->offset($pager->offset())
                ->order("status,created_at DESC")
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
        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $contractEdit = (new AppContract())->findById($data["post_id"]);

            if (!$contractEdit) {
                $this->message->error("Você tentou atualizar um contracto que não existe ou foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/contract/home")]);
                return;
            }

            $contractEdit->status = $data["status"];

            if (!$contractEdit->save()) {
                $json["message"] = $contractEdit->message()->render();
                echo json_encode($json);
                return;
            }

            if($contractEdit->status == "pay"){
                $subject = "O Pagamento foi liberado para sua conta";
                (new Email())->bootstrap(
                    $subject,
                    $contractEdit->proposal()->user()->email,
                    $contractEdit->proposal()->user()->fullName()
                )->view(
                    "default",[
                        "title" => $subject,
                        "message" => "<p>Olá {$contractEdit->proposal()->user()->first_name},</p>
                        <p>Meus parabéns, O valor já foi creditado em sua conta configurada na plataforma ".CONF_SITE_NAME.", 
                        obrigado pela sua confiança.</p>
                        <p>Quanquer problema ou dificuldade favor entrar em contato com o suporte.</p>"
                    ]
                )->queue();
            }

            $this->message->success("Projeto atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        $contractEdit = null;
        if (!empty($data["post_id"])) {
            $postId = filter_var($data["post_id"], FILTER_VALIDATE_INT);
            $contractEdit = (new AppContract())->findById($postId);
        }

        $head = $this->seo->render(
             "Contratos | ".CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/contract/post", [
            "app" => "contract/post",
            "head" => $head,
            "contract" => $contractEdit,
            "categories" => (new Category())->find("type = :type", "type=project")->order("title")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function categories(?array $data): void
    {
        $categories = (new Category())->find("type = 'project'");
        $pager = new Pager(url("/admin/contract/categories/"));
        $pager->pager($categories->count(), 6, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Categorias",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/contract/categories", [
            "app" => "project/categories",
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
            "head" => $head,
            "category" => $categoryEdit
        ]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 21/01/2022
 * Time: 08:16
 */

namespace Source\App\Web;


use Source\Models\Category;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

class Freelancer extends Web
{
    /**
     * @param array|null $data
     */
    public function freelancer(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $head = $this->seo->render(
            "Freelancers - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/freelancers"),
            theme("/assets/images/share.jpg")
        );

        $freelancers = (new User())->filter($data ?? null);
        $pager = new Pager(url("/freelancer/all/"));
        $pager->pager($freelancers->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        echo $this->view->render("freelancers", [
            "head" => $head,
            "title" => "Freelancers",
            "freelancers" => $freelancers->limit($pager->limit())
                ->offset($pager->offset())
                ->order("created_at DESC")
                ->fetch(true),
            "paginator" => $pager->render(),
            "categories" => (new Category())
                ->find("type = :type", "type=project")
                ->fetch(true),
            "filter" => (object) [
                "category" => ($data["category"] ?? null),
                "subcategory" => ($data["subcategory"] ?? null),
                "terms" => ($data["terms"] ?? null),
                "type" => ($data["type"] ?? null)
            ],
            "message" =>(new Message())
                ->warning("Nenhum freelancer ainda disponível")
                ->before("Que pena! ")
        ]);
    }
    /**
     * SITE BLOG SEARCH
     * @param array $data
     */
    public function search(array $data): void
    {
        if (!empty($data['search'])){
            $category = str_search($data['category']);
            $terms = str_search($data['terms']);

            echo json_encode(["redirect" => url("/freelancers/buscar/{$category}/{$terms}/1")]);
            return;
        }

        $category = str_search($data['category']);
        $terms = str_search($data['terms']);

        $page = (filter_var($data['page'], FILTER_VALIDATE_INT) >= 1 ? $data['page'] : 1);

        if (($category == "all") && ($terms == "all")){
            redirect("/freelancers");
        }

        $head = $this->seo->render(
            "Pesquisa freelancer - " . CONF_SITE_NAME,
            "Confira os resultados de sua pesquisa dos freelancers",
            url("/freelancers/buscar/{$category}/{$terms}/{$page}"),
            theme("/assets/images/share.jpg")
        );

        $category = ($category != "all" ? "AND category_id = '$category'": null);
        $terms = ($terms != "all" ? "AND MATCH(first_name, last_name, email) AGAINST('$terms')" : null);

        $freelancerSearch = (new User())->findFreelancer("{$category} {$terms}");

        if (!$freelancerSearch->count()) {
            echo $this->view->render("freelancers", [
                "head" => $head,
                "categories" => (new Category())
                    ->find("type = :type", "type=project")
                    ->fetch(true),
                "filter" => (object) [
                    "category" => ($data["category"] != "all" ? $data["category"]: null),
                    "terms" => ($data["terms"] != "all" ? $data["terms"]: null)
                ],
                "title" => "FREELANCERS",
                "message"=> message()->warning("Sua pesquisa não retornou nenhum resultado")->render()
            ]);
            return;
        }

        $pager = new Pager(url("/freelancers/buscar/{$category}/{$terms}/{$page}"));
        $pager->pager($freelancerSearch->count(), 9, $page);

        echo $this->view->render("freelancers", [
            "head" => $head,
            "title" => "PESQUISA FREELANCER",
            "categories" => (new Category())
                ->find("type = :type", "type=project")
                ->fetch(true),
            "filter" => (object) [
                "category" => ($data["category"] != "all" ? $data["category"]: null),
                "terms" => ($data["terms"] != "all" ? $data["terms"]: null)
            ],
            "blog" => $freelancerSearch->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * Mostra o perfil do freelancer
     * @param array $data
     */
    public function profile(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $user = (new User())->findByEmail(base64_decode($data['email']));
        if(!$user){
            $this->message->warning("O perfil informado não foi encontrado")->flash();
            redirect("/freelancers");
        }

        $head = $this->seo->render(
            "Perfil - {$user->fullName()} - " . CONF_SITE_NAME,
            "Perfil do {$user->fullName()}",
            url("/perfil"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("profile", [
            "head" => $head,
            "user" => $user
        ]);
    }

    /**
     * @param array|null $data
     */
//    public function freelancers(?array $data): void
//    {
//        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
//
//        $head = $this->seo->render(
//            "Freelancers - " . CONF_SITE_NAME,
//            CONF_SITE_DESC,
//            url("/freelancers"),
//            theme("/assets/images/share.jpg")
//        );
//
//        $projects = (new AppProject())->filter($data ?? null);
//        $pager = new Pager(url("/app/all/"));
//        $pager->pager($projects->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));
//
//        echo $this->view->render("freelancers", [
//            "head" => $head,
//            "title" => "Projetos",
//            "projects" => $projects->limit($pager->limit())
//                ->offset($pager->offset())
//                ->order("created_at DESC")
//                ->fetch(true),
//            "paginator" => $pager->render(),
//            "categories" => (new Category())
//                ->find("type = :type", "type=project")
//                ->fetch(true),
//            "filter" => (object) [
//                "category" => ($data["category"] ?? null),
//                "subcategory" => ($data["subcategory"] ?? null),
//                "terms" => ($data["terms"] ?? null),
//                "type" => ($data["type"] ?? null)
//            ],
//            "message" =>(new Message())
//                ->warning("Nenhum freelancer ainda disponivel")
//                ->before("Que pena! ")
//                ->after(", Tente novamente mais tarde")
//        ]);
//    }
}
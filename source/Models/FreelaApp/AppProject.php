<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 12/12/2021
 * Time: 04:05
 */

namespace Source\Models\FreelaApp;


use Source\App\App\App;
use Source\App\App\Project;
use Source\Core\Model;
use Source\Core\View;
use Source\Models\Category;
use Source\Models\PagSeguro;
use Source\Models\SubCategory;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\Log;

/**
 * CLASSE QUE TRABALHA COM OS PROJETOS
 * Class AppProject
 * @package Source\Models\FreelaApp\AppProject
 */
class AppProject extends Model
{
    /**
     * AppProject constructor.
     */
    public function __construct()
    {
        parent::__construct("app_projects", ["id"], ["author","title", "uri", "content"]);
    }


    /**
     * @param int $userId
     * @param array $data
     * @return null|AppProject
     */
    public function register(int $userId, array $data): ?AppProject
    {
        try{
            $seachCategory = (new Category())->findByUri($data["category"]);
            $seachSubategory = (new SubCategory())->findByUri($data["subcategory"]);

            $this->author = $userId;
            $this->category_id = $seachCategory->id;
            $this->subcategory_id = $seachSubategory->id;
            $this->title = $data["title"];
            $this->uri = str_slug($data["title"] . "-" . uniqid(rand()));
            $this->content = nl2br(str_textarea($data["content"]));
            $this->localization = $data["localization"];
            $this->budget = $data["budget"];


            $msg = "cadastrado";
            //Verifica se o usuario esta atualizando um projeto
            if($data['action'] == "update"){
                $consulta = $this->find("id = :id AND author = :author", "id={$data['project']}&author={$userId}")->fetch();
                if(!$consulta){
                    $this->message()->warning("O projeto informado não existe")->render();
                    return null;
                }

                $this->id = $consulta->id;
                $this->status = "pending";
                $msg = "atualizado";

                //Envia e-mail de atualização para os freelancers ue mandaram propostas
                $proposals = $this->proposal();
                if($proposals->count()){
                    foreach ($proposals->fetch(true) as $proposal) {
                        (new Email())->bootstrap(
                            "Projeto atualizado no " . CONF_SITE_NAME,
                            $proposal->user()->email,
                            $proposal->user()->fullName()
                        )->view(
                            "default",[
                                "title" => "O Projeto {$this->title} foi atualizado",
                                "message" => "<p>O contratante atualizou o projeto <strong>{$this->title}</strong></p>",
                                "link" => url("/projetos/".$this->uri),
                                "title_link" => "Acessar projeto"
                            ]
                        )->queue();
                    }
                }
            }

            if (!$this->save()){
                $this->message()->error("Não foi possivel {$msg} o projeto")->render();
                return null;
            }

            (new Email())->bootstrap(
                "Projeto {$msg} no " . CONF_SITE_NAME,
                $this->author()->email,
                $this->author()->fullName()
            )->view(
                "project-create",[
                    "msg" => $msg,
                    "first_name" => $this->author()->first_name,
                    "project_name" => $this->title,
                    "link" => url("/projetos/".$this->uri)
                ]
            )->queue();

            return $this;
        }catch (\Exception $e){
            return null;
        }
    }

    /**
     * @param null|string $terms
     * @param null|string $params
     * @param string $columns
     * @return mixed|Model
     */
    public function findProject(?string $terms = null, ?string $params = null, string $columns = "*")
    {
        $terms = "status = :status" . ($terms ? " {$terms}" : "");
        $params = "status=accepted" . ($params ? "&{$params}" : "");

        return parent::find($terms, $params, $columns);
    }

    /**
     * CONSULTA PROJETO PELA URL
     * @param string $uri
     * @param string $columns
     * @return null|AppProject
     */
    public function findByUri(string $uri, string $columns = "*"): ?AppProject
    {
        $find = $this->find("uri = :uri", "uri={$uri}", $columns);
        return $find->fetch();
    }

    /**
     * @param User $user
     * @return object
     */
    public function balance(User $user): object
    {
        $balance = new \stdClass();
        $balance->full = 0;
        $balance->pending = 0;
        $balance->pending_pay = 0;
        $balance->accepted = 0;
        $balance->active = 0;
        $balance->concluded = 0;
        $balance->paused = 0;
        $balance->canceled = 0;
        $balance->closed = 0;

        $find = $this->find("author = :author",
            "author={$user->id}",
            "
                (SELECT COUNT(id) FROM app_projects WHERE author = :author) AS 'full',
                (SELECT COUNT(id) FROM app_projects WHERE author = :author AND `status` = 'pending') AS 'pending',
                (SELECT COUNT(id) FROM app_projects WHERE author = :author AND `status` = 'pending_pay') AS 'pending_pay',
                (SELECT COUNT(id) FROM app_projects WHERE author = :author AND `status` = 'accepted') AS 'accepted',
                (SELECT COUNT(id) FROM app_projects WHERE author = :author AND `status` = 'active') AS 'active',
                (SELECT COUNT(id) FROM app_projects WHERE author = :author AND `status` = 'concluded') AS 'concluded',
                (SELECT COUNT(id) FROM app_projects WHERE author = :author AND `status` = 'paused') AS 'pause',
                (SELECT COUNT(id) FROM app_projects WHERE author = :author AND `status` = 'paused') AS 'canceled',
                (SELECT COUNT(id) FROM app_projects WHERE author = :author AND `status` = 'closed') AS 'closed'
            ")->fetch();

        if ($find) {
            $balance->full = abs($find->full);
            $balance->pending = abs($find->pending);
            $balance->pending_pay = abs($find->pending_pay);
            $balance->accepted = abs($find->accepted);
            $balance->active = abs($find->active);
            $balance->concluded = abs($find->concluded);
            $balance->paused = abs($find->paused);
            $balance->canceled = abs($find->canceled);
            $balance->closed = abs($find->closed);
        }

        return $balance;
    }

    /**
     * CONSULTA DADOS DO AUTOR
     * @return null|User
     */
    public function author(): ?User
    {
        if ($this->author) {
            return (new User())->findById($this->author);
        }
        return null;
    }

    /**
     * CONSULTA DADOS DA CATEGORIA
     * @return Category
     */
    public function category(): ?Category
    {
        if ($this->category_id) {
            return (new Category())->findById($this->category_id);
        }
        return null;
    }

    /**
     * CONSULTA DADOS DAS PROPOSTAS
     * @param null|string $terms
     * @param null|string $params
     * @param string $columns
     * @return null|AppProposal
     */
    public function proposal(?string $terms = null, ?string $params = null, string $columns = "*"): ?AppProposal
    {
        $terms = "project_id = :project_id" . ($terms ? " AND {$terms}" : "");
        $params = "project_id={$this->id}" . ($params ? "&{$params}" : "");

        return (new AppProposal())->find($terms, $params);
    }

    /**
     * CONSULTA DADOS DA SUBCATEGORIA
     * @return null|SubCategory
     */
    public function subCategory(): ?SubCategory
    {
        if ($this->subcategory_id) {
            return (new SubCategory())->findById($this->subcategory_id);
        }
        return null;
    }

    public function contract(): ?AppContract
    {
        return (new AppContract())->find("project_id = :project_id", "project_id={$this->id}");
    }

    /**
     * CONSULTA DADOS DE ORÇAMENTO
     * @return mixed|null|Model
     */
    public function budget()
    {
        if ($this->budget) {
            return (new AppBudget())->findById($this->budget);
        }
        return null;
    }


    /**
     * FILTRAR OS RESULTADOS ATRAVES DE UM ARRAY
     * @param array|null $filter
     * @param null|string $terms
     * @param null|string $params
     * @param string $columns
     * @return null|AppProject
     */
    public function filter(?array $filter, ?string $terms = null, ?string $params = null, string $columns = "*"): ?AppProject
    {
        $terms = (!empty($terms) ? "AND {$terms}" : null);
        $category = (!empty($filter['category']) && $filter['category'] != "all" ? "AND category_id = {$filter['category']}" : null);
        $subcategory = (!empty($filter['subcategory']) && $filter['subcategory'] != "all" ? "AND subcategory_id = {$filter['subcategory']}" : null);
        $skill = (!empty($filter['skill']) && $filter['skill'] != "all" ? "AND MATCH (title, content) AGAINST ('{$filter['skill']}')" : null);
        $type = (!empty($filter['type']) && $filter['type'] != "all" ? "AND type = {$filter['type']}" : null);

        $due = $this->find(
            "deleted_at IS NULL {$category} {$subcategory} {$skill} {$type} {$terms}",
            $params,
            $columns
        );

        return $due;
    }

}
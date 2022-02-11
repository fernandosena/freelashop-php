<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 21/01/2022
 * Time: 08:12
 */

namespace Source\App\Web;

use Source\Models\Auth;
use Source\Models\Category;
use Source\Models\FreelaApp\AppBudget;
use Source\Models\FreelaApp\AppContract;
use Source\Models\FreelaApp\AppProject;
use Source\Models\SubCategory;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

class Project extends Web
{

    /**
     * Lista os projetos ativos
     * @param array|null $data
     */
    public function project(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $head = $this->seo->render(
            "Projetos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/projetos"),
            theme("/assets/images/share.jpg")
        );

        $projects = (new AppProject())->findProject();
        $pager = new Pager(url("/projetos/p/"));
        $pager->pager($projects->count(), 7, (!empty($data["page"]) ? $data["page"] : 1));

        echo $this->view->render("projects", [
            "head" => $head,
            "title" => "Projetos",
            "projects" => $projects->limit($pager->limit())
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
                ->warning("Nenhum projeto ainda disponível")
                ->before("Que pena! ")
                ->after(", seja o primeiro a <a href='".url("/criar-projeto")."' class='link-underline'>CRIAR UM PROJETO</a>")
        ]);
    }

    /**
     * SITE BLOG SEARCH
     * @param array $data
     */
    public function search(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (!empty($data['search'])){
            $category = str_search($data['category']);
            $subcategory = str_search($data['subcategory']);
            $terms = str_search($data['terms']);
            $type = str_search($data['type']);

            echo json_encode(["redirect" => url("/projetos/buscar/{$category}/{$subcategory}/{$terms}/{$type}/1")]);
            return;
        }

        $category = str_search($data['category']);
        $subcategory = str_search($data['subcategory']);
        $terms = str_search($data['terms']);
        $type = str_search($data['type']);

        $page = (filter_var($data['page'], FILTER_VALIDATE_INT) >= 1 ? $data['page'] : 1);

        if (($category == "all") &&
            $subcategory == "all" &&
            $terms == "all" &&
            $type == "all") {
            redirect("/projetos");
        }

        $head = $this->seo->render(
            "Projetos - " . CONF_SITE_NAME,
            "Confira os resultados de sua pesquisa",
            url("/projetos/buscar/{$category}/{$subcategory}/{$terms}/{$type}/{$page}"),
            theme("/assets/images/share.jpg")
        );

        if($category != "all"){
            $category = (new Category())->findByUri($category);
            $categoryTitle = $category->title;
            $category = $category->id;
        }

        if($subcategory != "all"){
            $subcategory = (new SubCategory())->findByUri($subcategory);
            $subcategoryTitle = "/ ".$subcategory->title;
            $subcategory = $subcategory->id;
        }

        $category = ($category != "all" ? "AND category_id = '{$category}'": null);
        $subcategory = ($subcategory != "all" ? "AND subcategory_id = '$subcategory'" : null);
        $terms = ($terms != "all" ? "AND MATCH(title, content) AGAINST('$terms')" : null);
        $type = ($type != "all" ? "AND type = '$type'" : null);

        $projectSearch = (new AppProject())->findProject("{$category} {$subcategory} {$terms} {$type}");

        if (!$projectSearch->count()) {
            echo $this->view->render("projects", [
                "head" => $head,
                "title" => "Projetos ".($categoryTitle ?? null)." ".($subcategoryTitle ?? null),
                "categories" => (new Category())
                    ->find("type = :type", "type=project")
                    ->fetch(true),
                "filter" => (object) [
                    "category" => ($data["category"] != "all" ? $data["category"]: null),
                    "subcategory" => ($data["subcategory"] != "all" ? $data["subcategory"]: null),
                    "terms" => ($data["terms"] != "all" ? $data["terms"]: null),
                    "type" => ($data["type"] != "all" ? $data["type"]: null),
                ],
                "message"=> message()->warning("Sua pesquisa não retornou nenhum resultado")->render()
            ]);
            return;
        }

        $pager = new Pager(url("/projetos/buscar/{$category}/{$subcategory}/{$terms}/{$type}/"));
        $pager->pager($projectSearch->count(), 9, $page);

        echo $this->view->render("projects", [
            "head" => $head,
            "title" => "Projetos",
            "categories" => (new Category())
                ->find("type = :type", "type=project")
                ->fetch(true),
            "filter" => (object) [
                "category" => ($data["category"] != "all" ? $data["category"]: null),
                "subcategory" => ($data["subcategory"] != "all" ? $data["subcategory"]: null),
                "terms" => ($data["terms"] != "all" ? $data["terms"]: null),
                "type" => ($data["type"] != "all" ? $data["type"]: null),
            ],
            "projects" => $projectSearch->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * PAGINA DE DETALHED DO PROJETO
     * @param array|null $data
     */
    public function single(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $project =  (new AppProject())->
        find("uri = :uri","uri={$data['uri']}")
            ->fetch();

        $head = $this->seo->render(
            "{$project->title} - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/projetos/{$data['uri']}"),
            theme("/assets/images/share.jpg")
        );

        if(!$project){
            $this->message->warning("Você tentou acessar um projeto que não existe")->before("Oooops! ")->flash();
            redirect("/projetos");
        }

        if (!$this->user || $this->user->level < 5) {
            $project->views +=1;
            $project->save();
        }

        $message = null;

        if(!empty($this->user) && ($this->user->id == $project->author)){
            switch($project->status){
                case "pending":
                    $message =  $this->message->warning("Estamos analizando o seu projeto, assim que possivel ele estará no ar")->render();
                    break;
                case "canceled":
                    $message =  $this->message->error("Seu projeto infelizmente foi cancelado, te enviamos uma email com mais detalhes do ocorrido, confira sua caixa de mensagem")->render();
                    break;
                case "active":
                    $message =  $this->message->success("Seu projeto esta ativo para o freelancer iniciar o trabalho")->render();
                    break;
                case "pending_pay":
                    $message =  $this->message->warning("Realize o pagameto do valor da proposta para o freelancer dar inicio ao trabalho
                    <a href='".url("/app/proposta/checkout/".$project->proposal()->fetch()->id)."'>CLIQUE AQUI</a> para realizar o pagamento")->render();
                    break;
            }
        }

        //Mensagem para o freelancer
        if($project->status == "pending_pay" || $project->status == "active"){
            $contract = (new AppContract())->find("project_id = :project_id", "project_id={$project->id}")->fetch();

            if($this->user->id == $contract->proposal()->user_id){
                if($project->status == "pending_pay"){
                    $message =  $this->message->info("O cliente aceitou a sua proposta, <strong> NÂO COMECE O TRABALHO AINDA</strong>. estamos aguardando o pagamento do cliente, enviaremos um e-mail confirmando o pagamento e liberando você para realizar o trabalho. <strong>aguarde nosso contato</strong>.")->render();
                }
                if($project->status == "active"){
                    $message =  $this->message->info("O cliente realizou o pagamento da proposta, você já pode iniciar o serviço. bom trabalho ;)")->render();
                }
                if($project->status == "concluded"){
                    $message =  $this->message->info("O cliente já liberou o valor da proposta para você. Aguarde, iremos tranferir o valor em até 5 dias úteis.")->render();
                }
            }
        }

        if(!empty($this->user)){
            //Contratante proprietario
            if($this->user->id == $project->author){
                //Verifica status do projeto accepted
                if($project->status == "accepted"){
                    $action = '
                        <div class="text-center mt-5 mb-3">
                            <a class="btn btn-border-ui btn-sm btn-primary popup-with-move-anim" href="#modal-project">
                            <i class="fas fa-pencil-alt"></i> Editar Projeto</a>
                            <a href="#" class="btn btn-border-ui btn-sm btn-warning action-project" 
                            data-action="'.url("/app/action/pause/".$project->uri).'" >
                            <i class="fas fa-pause-circle"></i> Pausar Projeto</a>
                        </div>
                    ';
                }

                //Verifica status do projeto paused
                if($project->status == "paused"){
                    $action = '
                        <div class="text-center mt-5 mb-3">
                            <a href="#" class="btn btn-border-ui btn-sm btn-info action-project" 
                            data-action="'.url("/app/action/start/".$project->uri).'">
                            <i class="fas fa-play-circle"></i> Continuar Projeto</a>
                        </div>
                    ';
                }

                //Verifica status do projeto active
                if($project->status == "active"){
                    $action = '
                        <div class="text-center mt-5 mb-3">
                            <a href="#" class="btn btn-border-ui btn-sm btn-primary action-project" 
                            data-description="Você concorda que o freelancer prestou o melhor serviço e entregou um projeto satisfatório e sem nenhuma pendência? ao clicar em SIM o valor será liberado para a conta do freelancer."
                            data-action="'.url("/app/action/aproved/".$project->uri).'">
                            <i class="fas fa-check"></i> Concluir projeto e liberar valor para o freelancer</a>
                        </div>
                    ';
                }

                //Verifica se existe propostas
                if($project->proposal()->count()){
                    $plusStr = ($project->proposal()->count() > 1) ? 's' : null;
                    $buttom = '
                        <a href="'.url("/app/propostas/{$project->uri}").'" class="btn btn-primary btn-block">
                            <strong><i class="fas fa-eye"></i> Ver proposta'.$plusStr.'</strong>
                        </a>
                    ';
                }
            }

            //Freelancer
            if(($this->user->id != $project->author) && ($this->user->type == "freelancer")){
                //Verifica status do projeto paused
                if($project->status == "accepted"){
                    $action = '
                        <div class="text-center mt-5 mb-3">
                            <a href="#modal-problem" class="btn btn-sm btn-warning popup-with-move-anim">
                                <i class="fas fa-exclamation-circle"></i> Reporta problema
                            </a>
                        </div>
                    ';

                    //Consulta proposata do freelancer caso exista
                    $proposalFreela = $project->proposal("user_id = :user_id", "user_id=".$this->user->id);
                    if($proposalFreela->count() && $proposalFreela->fetch()->user_id == $this->user->id){
                        $buttom = '
                             <a href="'.url("/app/proposta/{$proposalFreela->fetch()->id}").'" 
                             class="btn btn-primary btn-block">
                                <strong><i class="fas fa-eye"></i> Ver minha proposta</strong>
                            </a>
                        ';
                    }else{
                        $buttom = '
                            <a href="#modal-proposal" class="btn btn-primary btn-block  popup-with-move-anim">
                                <strong><i class="fas fa-paper-plane"></i> Enviar proposta</strong>
                            </a>
                        ';
                    }
                }
            }
        }else{
            $buttom = '
                <a href="'.url("/entrar").'" class="btn btn-primary btn-block">
                    <strong><i class="fas fa-paper-plane"></i> Enviar proposta</strong>
                </a>
            ';
        }

        echo $this->view->render("project-single", [
            "head" => $head,
            "title"=>"Projeto",
            "categories" => (new Category())
                ->find("type = :type", "type=project", "id, title")
                ->fetch(true),
            "budgets" => (new AppBudget())->find()->fetch(true),
            "project" => $project,
            "message" => $message,
            "buttom" => ($buttom ?? null),
            "action" => ($action ?? null)
        ]);
    }

    /**
     * Formulário de criar e atualizar projeto HOME, SINGLE
     * POST E GET
     * @param array|null $data
     */
    public function action(?array $data): void
    {
        //Recebe os dados e filtra
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //Recupera o id do usuario logado caso exista
        $idUser = (Auth::user()->id) ?? null;
        $msg = null;

        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
                echo json_encode($json);
                return;
            }

            //Criar projeto
            if($data["action"] == "create"){
                $msg = "Projeto cadastro com sucesso";
            }

            //atualizar projeto
            if($data["action"] == "update"){
                $msg = "Projeto atualizado com sucesso";
            }

            $auth = new Auth();
            $user = new User();
            if(!$idUser){
                //Verifica se as duas senhas são iguais
                if ($data["password"] != $data["password_repeat"]) {
                    $json['message'] = $this->message->warning("As senhas informadas não são iguais")->render();
                    echo json_encode($json);
                    return;
                }

                $user->bootstrap(
                    $data["first_name"],
                    $data["last_name"],
                    $data["email"],
                    $data["cell"],
                    $data["password"]
                );

                if ($auth->register($user)) {
                    $json['redirect'] = url("/confirma");
                } else {
                    $json['message'] = $auth->message()->before("Ooops! ")->render();
                    echo json_encode($json);
                    return;
                }

                $idUser = $user->id;
            }

            //Cadastra/Atualiza Projeto
            $project = (new AppProject())->register($idUser, $data);
            if (!$project) {
                $json['message'] = $project->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success($msg)->flash();
            if($this->user){
                echo json_encode(["redirect" => url("/projetos/{$project->uri}")]);
            }else{
                echo json_encode(["redirect" => url("/confirma")]);
            }
            return;
        }

        $head = $this->seo->render(
            "Criar Projetos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/blog/criar-projeto"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("create-project", [
            "head" => $head,
            "top" => true,
            "budgets" => (new AppBudget())->find()->fetch(true),
            "categories" => (new Category())
                ->find("type = :type", "type=project")
                ->fetch(true)
        ]);
    }
}
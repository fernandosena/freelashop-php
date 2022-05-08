<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 21/01/2022
 * Time: 08:12
 */

namespace Source\App\Web;

use Source\Models\Auth;
use Source\Models\Leads;
use Source\Models\Teste\Teste;

class Testes extends Web
{
    public function home(?array $data): void
    {
        if (!empty($data['csrf'])) {
            if (in_array("", $data)) {
                $json['message'] = $this->message->info("Informe seus dados para acessar seu teste.")->render();
                echo json_encode($json);
                return;
            }

            $auth = new Auth();
            $leads = new Leads();
            $leads->bootstrap(
                $data["full_name"],
                $data["email"],
                $data["phone"]
            );

            if ($auth->registerLeads($leads)) {
                $json['redirect'] = url("/teste/{$data["teste"]}");
            } else {
                $json['message'] = $auth->message()->before("Ooops! ")->render();
            }

            echo json_encode($json);
            return;
        }

        $teste = (new Teste())->find("uri = :uri", "uri={$data["page"]}");

        if(!$teste->count()){
            redirect(CONF_URL_REDIRECT);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME." - {$teste->fetch()->title}",
            CONF_SITE_DESC,
            url("/cadastrar"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("home", [
            "head" => $head,
            "teste" => $data["page"]
        ]);
    }


    public function teste(?array $data): void
    {
        //Recebe os dados e filtra
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (!Auth::lead()){
            redirect("/home/{$data["teste"]}");
        }

        $head = $this->seo->render(
            "Criar Projetos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/blog/criar-projeto"),
            theme("/assets/images/share.jpg"),
            false
        );

        $teste = (new Teste())->find("uri = :uri", "uri={$data["teste"]}")->fetch();
        echo $this->view->render("widgets/teste/home", [
            "head" => $head,
            "teste" => $teste,
            "info" => $teste->desc,
            "quantidade" => $teste->questionsCout()
        ]);
    }

    public function testeCheckout(?array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $head = $this->seo->render(
            "Criar Projetos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/blog/criar-projeto"),
            theme("/assets/images/share.jpg"),
            false
        );

        if($data["teste"] == "sistema-operacional"){
            $visual = [1,6,8,10,13,18,19,23,26,29,32,34];
            $visualSoma = 0;
            $auditivo = [2,5,9,11,15,16,20,22,25,30,31,35];
            $auditivoSoma = 0;
            $cinestesico = [3,4,7,12,14,17,21,24,27,28,33,36];
            $cinestesicoSoma = 0;

            foreach ($data as $key => $value) {
                if(in_array($key, $visual)){
                    $visualSoma += $value;
                }

                if(in_array($key, $auditivo)){
                    $auditivoSoma += $value;
                }

                if(in_array($key, $cinestesico)){
                    $cinestesicoSoma += $value;
                }
            }

            $resultado = [
                "Visual" => $visualSoma,
                "auditivo" => $auditivoSoma,
                "cinestesico" => $cinestesicoSoma,
            ];
            arsort($resultado);
            $title = "é mais ".array_keys($resultado)[0];
        }

        if($data["teste"] == "linguagem-do-amor"){
            $a = [1,6,11,16,21];
            $aSoma = 0;
            $b = [2,7,12,17,22];
            $bSoma = 0;
            $c = [3,8,13,18,23];
            $cSoma = 0;
            $d = [4,9,14,19,24];
            $dSoma = 0;
            $e = [5,10,15,20,25];
            $eSoma = 0;

            foreach ($data as $key => $value) {
                if(in_array($key, $a)){
                    $aSoma += $value;
                }

                if(in_array($key, $b)){
                    $bSoma += $value;
                }

                if(in_array($key, $c)){
                    $cSoma += $value;
                }

                if(in_array($key, $d)){
                    $dSoma += $value;
                }

                if(in_array($key, $e)){
                    $eSoma += $value;
                }
            }

            $total = $aSoma + $bSoma + $cSoma + $dSoma + $eSoma;

            $resultado = [
                "Palavras de encorajamento" => ($aSoma/$total)*100,
                "Atos de serviço" => ($bSoma/$total)*100,
                "Presentes" => ($cSoma/$total)*100,
                "Tempo de qualidade" => ($dSoma/$total)*100,
                "Toque físico" => ($eSoma/$total)*100,
            ];

            arsort($resultado);
            $title = "tem mais ".array_keys($resultado)[0];
        }


        if($data["teste"] == "disc"){
            $executor = [1,5,9,13,17,21,25,29,33,37];
            $executorSoma = 0;
            $comunicador = [2,6,10,14,18,22,26,30,33,38];
            $comunicadorSoma = 0;
            $planejador = [3,7,11,15,19,23,27,31,35,39];
            $planejadorSoma = 0;
            $analista = [4,8,12,16,20,24,28,32,36,40];
            $analistaSoma = 0;

            foreach ($data as $key => $value) {
                if(in_array($key, $executor)){
                    $executorSoma += $value;
                }

                if(in_array($key, $comunicador)){
                    $comunicadorSoma += $value;
                }

                if(in_array($key, $planejador)){
                    $planejadorSoma += $value;
                }

                if(in_array($key, $analista)){
                    $analistaSoma += $value;
                }
            }

            $resultado = [
                "Executor" => $executorSoma/100,
                "Comunicador" => $comunicadorSoma/100,
                "Planejador" => $planejadorSoma/100,
                "Analista" => $analistaSoma/100,
            ];

            arsort($resultado);
            $title = "é mais ".array_keys($resultado)[0];
        }

        echo $this->view->render("widgets/teste/checkout", [
            "head" => $head,
            "title" => $title,
            "resultado" => $resultado
        ]);
    }
}
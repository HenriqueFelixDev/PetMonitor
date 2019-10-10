<?php

namespace  App\Controllers;

use App\Controllers\Controller;
use App\Lib\Mensagem;
use App\Lib\TipoMensagem;
use App\Model\Rastreador;

class RastreadoresController extends Controller{

    public function index() {
        $this->render("rastreadores/consulta_rastreadores");
    }

    public function ativacao() {
        $this->render("rastreadores/ativacao_rastreador");
    }

    public function selecaopet() {
        $this->render("rastreadores/selecao_pet");
    }

    public function ativar() {
        if (isset($_POST["codigo-rastreador"])) {
            $rastreador = new Rastreador();
            $rastreador->setCodigo($_POST["codigo-rastreador"]);

            $validade = $rastreador->validar();

            if (!$validade) {
                $this->redirect("rastreadores/ativacao");
            }

            $result = $rastreador->inserir();

            if ($result) {
                Mensagem::gravarMensagem("geral", "Rastreador ativado com sucesso!", TipoMensagem::SUCESSO);
                $this->redirect("rastreadores/ativacao");
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao ativar o rastreador. Tente novamente mais tarde!", TipoMensagem::ERRO);
                $this->redirect("rastreadores/ativacao");
            }
        }
    }

    public function selecionarPet() {
        
    }
}
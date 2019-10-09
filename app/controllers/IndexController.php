<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Lib\Sessao;
use App\Lib\Mensagem;
use App\Lib\TipoMensagem;
use App\Model\Dono;

class IndexController extends Controller{

    public function index(){
        $form = Sessao::obter("form", "dono");
        $this->setViewParam("form", $form);
        $this->render("login");
    }

    public function entrar() {

    }

    public function cadastrar() {
        if (isset($_POST)) {

            $dados = $_POST;
            unset($dados["senha"]);
            Sessao::gravar("form", "dono", $dados);

            $dono = new Dono();
            $dono->setNome($_POST["nome"]);
            $dono->setSobrenome($_POST["sobrenome"]);
            $dono->setSenha($_POST["senha"]);
            $dono->setCelular($_POST["cel"]);
            $dono->setEmail($_POST["email"]);

            $validade = $dono->validar();

            if (!$validade) {
                $this->redirect("");
            }

            // Criptografa a senha do usuário
            $dono->setSenha(password_hash($dono->getSenha(), PASSWORD_DEFAULT));

            $result = $dono->inserir();
            
            if ($result) {
                Mensagem::gravarMensagem("geral", "Dono Cadastrado com sucesso!", TipoMensagem::SUCESSO);
                Sessao::limpar("form", "dono");
                $this->redirect("");
            }
        }
    }
}
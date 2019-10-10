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
            
            $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
            $sobrenome = filter_input(INPUT_POST, "sobrenome", FILTER_SANITIZE_SPECIAL_CHARS);
            $senha = $_POST["senha"];
            $celular = filter_input(INPUT_POST, "cel", FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

            $dono = new Dono();
            $dono->setNome($nome);
            $dono->setSobrenome($sobrenome);
            $dono->setSenha($senha);
            $dono->setCelular($celular);
            $dono->setEmail($email);

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
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao cadastrar o novo Dono!", TipoMensagem::ERRO);
                $this->redirect("");
            }
        }
    }
}
<?php

namespace App\Controllers;

use App\App;
use App\Controllers\Controller;
use App\Lib\Sessao;
use App\Lib\Mensagem;
use App\Model\Dono;
use App\Lib\Acesso;
use App\Repository\DonoRepository;

class IndexController extends Controller{

    private $donoRepository;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->donoRepository = new DonoRepository($this->dao);
    }

    public function index(){
        $form = Sessao::obter("form", "dono");
        $this->setViewParam("form", $form);
        $this->render("login", "Login");
    }

    public function entrar() {

        if (isset($_POST["email-celular"]) && isset($_POST["senha-login"])) {
            
            if (!(isset($_POST["_csrf"]) && Sessao::obter("csrf", "login") == $_POST["_csrf"])) {
                Mensagem::gravarMensagem("login", "O formulário enviado é inválido ou tem origem em uma fonte não confiável", Mensagem::ERRO);
                $this->redirect("");
            }

            $email_celular = filter_input(INPUT_POST, 'email-celular', FILTER_SANITIZE_SPECIAL_CHARS);
            $senha = $_POST["senha-login"];

            $dono = new Dono();

            $dono = $this->donoRepository->getUsuario($email_celular, $senha);
                
            if ($dono) {
                Acesso::entrar($dono->getCodigo(), $dono->getNome());
                $this->redirect("pets");  
            }

            Mensagem::gravarMensagem("login", "Não existe um usuário cadastrado com essas informações de login!", Mensagem::ERRO);
        }
        $this->redirect("");
    }

    public function cadastrar() {
        if (isset($_POST["nome"]) && isset($_POST["sobrenome"]) && isset($_POST["senha"]) && isset($_POST["cel"]) && isset($_POST["email"])) {
            
            if (!(isset($_POST["_csrf"]) && Sessao::obter("csrf", "cadastro") == $_POST["_csrf"])) {
                Mensagem::gravarMensagem("cadastro", "O formulário enviado é inválido ou tem origem em uma fonte não confiável", Mensagem::ERRO);
                $this->redirect("");
            }

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
            $validadeSenha = $dono->validarSenha();

            if (!($validade && $validadeSenha)) {
                $this->redirect("");
            }

            $result = $this->donoRepository->getUsuarioPorCelular($dono->getCelular());
            
            if ($result[0]["qtd"]) {
                Mensagem::gravarMensagem("cadastro", "Já existe um usuário com o mesmo telefone cadastrado no sistema", Mensagem::ERRO);
                $this->redirect("");
            }

            $result = $this->donoRepository->getUsuarioPorEmail($dono->getEmail());

            if ($result[0]["qtd"]) {
                Mensagem::gravarMensagem("cadastro", "Já existe um usuário com o mesmo email cadastrado no sistema", Mensagem::ERRO);
                $this->redirect("");
            }

            $dono->setSenha(password_hash($senha, PASSWORD_DEFAULT));

            $result = $this->donoRepository->cadastrar($dono);
            
            if ($result) {
                Mensagem::gravarMensagem("cadastro", "Dono Cadastrado com sucesso! <a href=\"#login-form\" class=\"link-azul\">Fazer Login</a>", Mensagem::SUCESSO);
                Sessao::limpar("form", "dono");
            } else {
                Mensagem::gravarMensagem("cadastro", "Ocorreu um erro ao cadastrar o novo Dono!", Mensagem::ERRO);
            }
        }
        $this->redirect("");
    }

    public function sair()
    {
        Acesso::sair();
        $this->redirect("");
    }
}
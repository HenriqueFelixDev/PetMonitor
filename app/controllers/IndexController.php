<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Lib\Sessao;
use App\Lib\Mensagem;
use App\Model\Dono;
use App\Util\ValidacaoUtil;
use App\Lib\Conexao;
use App\Lib\Acesso;
use PDO;

class IndexController extends Controller{

    public function index(){
        $form = Sessao::obter("form", "dono");
        $this->setViewParam("form", $form);
        $this->setViewParam("csrf_login", ValidacaoUtil::csrf("login"));
        $this->setViewParam("csrf_cadastro", ValidacaoUtil::csrf("cadastro"));
        $this->render("login");
    }

    public function entrar() {

        if (isset($_POST["email-celular"]) && isset($_POST["senha-login"])) {
            
            if (!(isset($_POST["_csrf"]) && Sessao::obter("csrf", "login") == $_POST["_csrf"])) {
                Mensagem::gravarMensagem("login", "O formulário enviado é inválido ou tem origem em uma fonte não confiável", Mensagem::ERRO);
                $this->redirect("");
            }

            $email_celular = filter_input(INPUT_POST, 'email-celular', FILTER_SANITIZE_SPECIAL_CHARS);
            $senha = $_POST["senha-login"];

            $con = Conexao::conectar();

            $stm = $con->prepare("SELECT cod_dono, nome, sobrenome, senha FROM dono WHERE email=:email OR celular=:celular");
            $stm->bindValue(":email", $email_celular);
            $stm->bindValue(":celular", $email_celular);
            $stm->execute();
                
            if ($stm->rowCount() > 0) {
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $dono) {
                    if (password_verify($senha, $dono["senha"])) {
                        Acesso::entrar($dono["cod_dono"], $dono["nome"]);
                        $this->redirect("pets");
                    }
                }
            }
            Mensagem::gravarMensagem("login", "Não existe um usuário cadastrado com essas informações de login!", Mensagem::ERRO);
            $this->redirect("");
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

            $senhaValida = ValidacaoUtil::tamanho($dono->getSenha(), 8, 32);
            
            if (!$senhaValida) {
                $validade = false;
                Mensagem::gravarMensagem("senha", "A senha deve ter entre 8 e 32 caracteres", Mensagem::ERRO);
            }

            if (!$validade) {
                $this->redirect("");
            }

            $result = $dono->buscar("SELECT count(*) as 'qtd' FROM dono WHERE celular = :cel", [":cel"=>$dono->getCelular()]);
            
            if ($result[0]["qtd"]) {
                Mensagem::gravarMensagem("cadastro", "Já existe um usuário com o mesmo telefone cadastrado no sistema", Mensagem::ERRO);
                $this->redirect("");
            }

            $result = $dono->buscar("SELECT count(*) as 'qtd' FROM dono WHERE email = :email", [":email"=>$dono->getEmail()]);

            if ($result[0]["qtd"]) {
                Mensagem::gravarMensagem("cadastro", "Já existe um usuário com o mesmo email cadastrado no sistema", Mensagem::ERRO);
                $this->redirect("");
            }

            // Criptografa a senha do usuário
            $dono->setSenha(password_hash($dono->getSenha(), PASSWORD_DEFAULT));

            $result = $dono->inserir();
            
            if ($result) {
                Mensagem::gravarMensagem("geral", "Dono Cadastrado com sucesso!", Mensagem::SUCESSO);
                Sessao::limpar("form", "dono");
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao cadastrar o novo Dono!", Mensagem::ERRO);
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
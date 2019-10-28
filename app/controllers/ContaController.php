<?php

namespace App\Controllers;

use App\App;
use App\Controllers\Controller;
use App\Lib\Sessao;
use App\Lib\Mensagem;
use App\Util\ValidacaoUtil;
use App\Model\Dono;
use App\Repository\DonoRepository;

class ContaController extends Controller {
    private $donoRepository;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->donoRepository = new DonoRepository($this->dao);
    }

    public function index() {
        $codigo = Sessao::obter("usuario", "codigo");
        $dono = $this->donoRepository->buscarPorId($codigo);
        $form = Sessao::obter("form", "dono");
        if(!isset($form)) {
            $form["nome"] = $dono->getNome();
            $form["sobrenome"] = $dono->getSobrenome();
            $form["cel"] = $dono->getCelular();
            $form["email"] = $dono->getEmail();
        }
        $this->setViewParam("form", $form);
        $this->render("conta/minha_conta", "Minha Conta");
    }

    public function alteracaoSenha() {
        $this->render("conta/altera_senha", "Alterar Senha");
    }

    public function alterarSenha() {
        if (isset($_POST["senha-anterior"]) && isset($_POST["nova-senha"]) && isset($_POST["rep-nova-senha"])) {

            if (!(isset($_POST["_csrf"]) && Sessao::obter("csrf", "altera_senha") == $_POST["_csrf"])) {
                Mensagem::gravarMensagem("geral", "O formulário enviado é inválido ou tem origem em uma fonte não confiável", Mensagem::ERRO);
                $this->redirect("conta/alteracao-senha");
            }

            $senhaAnterior = $_POST["senha-anterior"];
            $novaSenha = $_POST["nova-senha"];
            $repNovaSenha = $_POST["rep-nova-senha"];

            $temErro = false;

            $codigo = Sessao::obter("usuario", "codigo");
            $dono = $this->donoRepository->buscarPorId($codigo);

            
            if (!password_verify($senhaAnterior, $dono->getSenha())) {
                $temErro = true;
                Mensagem::gravarMensagem("senha-anterior", "A senha informada não é a mesma cadastrada no sistema!", Mensagem::ERRO);
            }
            
            if ($novaSenha != $repNovaSenha) {
                $temErro = true;
                Mensagem::gravarMensagem("nova-senha", "A senha dos campos Nova senha e Repita a Nova Senha não são iguais!", Mensagem::ERRO);
                Mensagem::gravarMensagem("rep-nova-senha", "A senha dos campos Nova senha e Repita a Nova Senha não são iguais!", Mensagem::ERRO);
            } else {
                if (!ValidacaoUtil::tamanho($novaSenha, 8, 32)) {
                    Mensagem::gravarMensagem("nova-senha", "A senha deve ter entre 8 e 32 caracteres", Mensagem::ERRO);
                    Mensagem::gravarMensagem("rep-nova-senha", "A senha deve ter entre 8 e 32 caracteres", Mensagem::ERRO);
                }
            }

            if ($temErro) {
                $this->redirect("conta/alteracao-senha");
            }
        
            $dono->setSenha(password_hash($novaSenha, PASSWORD_DEFAULT));
            
            $result = $this->donoRepository->alterarSenha($codigo, $dono->getSenha());

            if ($result) {
                Mensagem::gravarMensagem("geral", "Senha alterada com sucesso!", Mensagem::SUCESSO);
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao tentar alterar a senha. Tente novamente mais tarde!", Mensagem::ERRO);
            }

            $this->redirect("conta/alteracao-senha");
        }
    }

    public function salvar() {
        if (isset($_POST["nome"]) && isset($_POST["sobrenome"]) && isset($_POST["cel"]) && isset($_POST["email"])) {
            if (!(isset($_POST["_csrf"]) && Sessao::obter("csrf", "conta") == $_POST["_csrf"])) {
                Mensagem::gravarMensagem("geral", "O formulário enviado é inválido ou tem origem em uma fonte não confiável", Mensagem::ERRO);
                $this->redirect("conta");
            }
            $dados = $_POST;
            Sessao::gravar("form", "dono", $dados);

            $codigo = Sessao::obter("usuario", "codigo");
                
            $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
            $sobrenome = filter_input(INPUT_POST, "sobrenome", FILTER_SANITIZE_SPECIAL_CHARS);
            $celular = filter_input(INPUT_POST, "cel", FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

            $dono = new Dono();
            $dono->setCodigo($codigo);
            $dono->setNome($nome);
            $dono->setSobrenome($sobrenome);
            $dono->setCelular($celular);
            $dono->setEmail($email);

            
            $validade = $dono->validar();
            
            if (!$validade) {
                $this->redirect("conta");
            }

            $result = $this->donoRepository->atualizar($dono);

            if ($result) {
                Mensagem::gravarMensagem("geral", "Dados atualizados com sucesso!", Mensagem::SUCESSO);
                Sessao::limpar("form", "dono");
                Sessao::gravar("usuario", "nome", $dono->getNome());
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao atualizar os dados. Tente novamente mais tarde!", Mensagem::ERRO);
            }
        }
        $this->redirect("conta");
    }
}
<?php

namespace App\Controllers;

use App\App;
use App\Dao\MySqlDao;
use App\Lib\Sessao;
use App\Lib\Mensagem;
use App\Lib\Acesso;
use App\Util\DadosUtil;

abstract class Controller
{
    protected $app;
    private $viewVar;
    protected $dao;

    public function __construct(App $app)
    {
        $this->setViewParam("controllerName", $app->getControllerName());
        $this->dao = new MySqlDao();
    }

    public abstract function index();

    public function redirect($rota)
    {
        $caminhoRota = $this->route($rota);
        header("Location: ${caminhoRota}");
        exit;
    }

    protected function render($view, $titulo = "")
    {
        
        $this->setViewParam("msg", Mensagem::obterMensagens());
        $viewVar = $this->getViewVar();

        $mensagem = Mensagem::class;
        $usuario = Sessao::obter("usuario", "nome");
        $acesso = Acesso::class;
        $dadosUtil = DadosUtil::class;

        require_once PATH."/app/views/layouts/header.php";
        require_once PATH."/app/views/layouts/menu.php";
        require_once PATH."/app/views/".$view.".php";
        require_once PATH."/app/views/layouts/footer.php";
        Mensagem::limparMensagens();
        Sessao::limparTudo("form");
    }

    public function route($rota)
    {
        return "http://".APP_HOST."/${rota}";
    }

    public function asset($arquivo)
    {
        return $this->route("resources/assets/".$arquivo);
    }

    public function csrf($nomeFormulario)
    {
        $csrf = uniqid(rand(), true);
        Sessao::gravar("csrf", $nomeFormulario, $csrf);
        return "<input type=\"hidden\" name=\"_csrf\" value=\"${csrf}\" />";
    }

    public function getViewVar()
    {
        return $this->viewVar;
    }

    public function setViewParam($nome, $valor)
    {
        if (isset($nome) && isset($valor)) {
            $this->viewVar[$nome] = $valor;
        }
    }
}
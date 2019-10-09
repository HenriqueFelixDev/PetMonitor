<?php

namespace App\Controllers;

use App\App;
use App\Lib\Sessao;
use App\Lib\Mensagem;

abstract class Controller{

    protected $app;
    private $viewVar;

    public function __construct(App $app){
        $this->setViewParam("controllerName", $app->getControllerName());
    }

    public abstract function index();

    protected function redirect($view){
        header("Location: http://".APP_HOST."/".$view);
        exit;
    }

    protected function render($view){
        
        $this->setViewParam("msg", Mensagem::obterMensagens());
        $viewVar = $this->getViewVar();

        $mensagem = Mensagem::class;
        /*
         * Requisição para as páginas do site
         *  require_once PATH."/app/views/pagina.php";
         *
        */
        require_once PATH."/app/views/layouts/header.php";
        require_once PATH."/app/views/layouts/menu.php";
        require_once PATH."/app/views/".$view.".php";
        require_once PATH."/app/views/layouts/footer.php";
        Mensagem::limparMensagens();
        Sessao::limparTudo("form");
    }

    public function getViewVar(){
        return $this->viewVar;
    }

    public function setViewParam($nome, $valor){
        if(isset($nome) && isset($valor)){
            $this->viewVar[$nome] = $valor;
        }
    }
}
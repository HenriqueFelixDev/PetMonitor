<?php

namespace App;

use App\Util\DadosUtil;
use App\Controllers\IndexController;
use App\Lib\Acesso;
use Exception;

class App{
    private $controller;
    private $controllerName;
    private $controllerFile;
    private $action;
    private $params;
    private static $envArray;

    public function __construct($envArray){
       
        self::$envArray = $envArray;
        define("APP_HOST", $_SERVER["HTTP_HOST"]."/projetos/PetMonitor/public");
        define("PATH", realpath("../"));
        define("TITLE", $envArray["TITLE"]);
        define("DB_DRIVER", $envArray["DB_DRIVER"]);
        define("DB_HOST", $envArray["DB_HOST"]);
        define("DB_NAME", $envArray["DB_NAME"]);
        define("DB_USER", $envArray["DB_USER"]);
        define("DB_PASS", $envArray["DB_PASS"]);
        
        $this->url();
    }

    public function run(){
       if(!isset($this->controller)){
            $this->controllerName = "IndexController";
       }else{
           $this->controllerName = ucwords($this->controller)."Controller";
           $this->controllerName = preg_replace("/[^a-zA-Z]/i", "", $this->controllerName);
       }

       $this->controllerFile = $this->controllerName.".php";
       $this->action = preg_replace("/[^a-zA-Z]/i", "", $this->action);

       if(!isset($this->controller)){
            $this->controller = new IndexController($this);
            if(!Acesso::estaLogado()){
                $this->controller->index();
            }
            $this->controller->redirect("pets");
       }

       if(!file_exists(PATH."/app/controllers/".$this->controllerFile)){
           throw new Exception("Página não encontrada!", 404);
       }

       $controllerClass = "App\\Controllers\\".$this->controllerName;

       if(!class_exists($controllerClass)){
           throw new Exception("Ocorreu um erro interno!", 500);
       }

       $objectController = new $controllerClass($this);

       if (Acesso::estaLogado()) {
            if($this->controllerName == "IndexController" && $this->action != "sair") {
                $objectController->redirect("pets");
                return;
            }
       } else {
            if($this->controllerName != "IndexController") {
                $objectController->redirect("");
                return;
            }
        }
       if(method_exists($objectController, $this->action)){
            $objectController->{$this->action}($this->params);
            return;
       }else if(!$this->action && method_exists($objectController, "index")){
           $objectController->index();
           return;
       }else{
           throw new Exception("A ação que você tentou executar não está disponível", 500);
       }
    }

    public function url(){
        
        if(isset($_GET["url"])){
            $path = $_GET["url"];
            $path = rtrim($path, "/");
            $path = filter_var($path, FILTER_SANITIZE_URL);

            $path = explode("/", $path);

            $this->controller = DadosUtil::getValorArray($path, 0);
            $this->action = DadosUtil::getValorArray($path, 1);

            if(DadosUtil::getValorArray($path, 2)){
                unset($path[0]);
                unset($path[1]);
                $this->params = array_values($path);
            }
        }
    }

    public function getControllerName(){
        return $this->controllerName;
    }

    public static function getEnvArray()
    {
        return self::$envArray;
    }
}
<?php

namespace App;

use App\Util\DadosUtil;
use App\Controllers\IndexController;
use Exception;

class App{
    private $controller;
    private $controllerName;
    private $controllerFile;
    private $action;
    private $params;

    public function __construct(){
       
        define("APP_HOST", $_SERVER["HTTP_HOST"]);
        define("PATH", realpath("../"));
        define("TITLE", "PETMonitor");
        define("DB_DRIVER", "mysql");
        define("DB_HOST", "localhost");
        define("DB_NAME", "blogdb");
        define("DB_USER", "root");
        define("DB_PASS", "");
        
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
            $this->controller->index();
       }

       if(!file_exists(PATH."/app/controllers/".$this->controllerFile)){
           throw new Exception("Página não encontrada!", 404);
       }

       $controllerClass = "App\\Controllers\\".$this->controllerName;

       if(!class_exists($controllerClass)){
           throw new Exception("Ocorreu um erro interno!", 500);
       }

       $objectController = new $controllerClass($this);

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
}
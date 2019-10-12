<?php

use App\App;
use App\Util\ValidacaoUtil;
use App\Model\Dono;

require_once "../vendor/autoload.php";

session_start();

error_reporting(E_ALL & ~E_WARNING);

try{
    $app = new App();
    $app->run();
}catch(\Exception $e){
    echo $e->getMessage();
}
/*
define("DB_DRIVER", "mysql");
define("DB_HOST", "localhost");
define("DB_NAME", "petmonitor_db");
define("DB_USER", "root");
define("DB_PASS", "");
$dono = new Dono();
$dono->setCodigo(3);
$dono->setNome("Marcos");
$dono->setSobrenome("Antonio");
$dono->setSenha("novasenha1234");
$dono->setCelular(31983317156);
$dono->setEmail("nemlanternagem@yahoo.com");
var_dump($dono->atualizar());*/
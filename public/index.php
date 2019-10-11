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
$dono = new Dono();
$dono->setNOme("Henrique");
$dono->setSobrenome("Félix");
var_dump($dono->inserir());*/
<?php

use App\App;
use App\Util\ValidacaoUtil;
use App\Model\Dono;
use App\Model\Pet;
use App\Lib\Paginacao;
use App\Model\Rastreador;

require_once "../vendor/autoload.php";

session_start();

error_reporting(E_ALL & ~E_WARNING);

try{
    $envPath = "../env.json";
    $envSize = filesize($envPath);
    $envFile = fopen($envPath, "r");

    $envData = "";

    while (!feof($envFile)) {
        $envData .= fgets($envFile, $envSize);
    }

    $envArray = json_decode($envData, true);
    
    $app = new App($envArray);
    $app->run();
}catch(\Exception $e){
    echo $e->getMessage();
}

//var_dump(ValidacaoUtil::dataPassada("2019-10-15"));


//Paginacao::paginar(16, 5, 2);
/*
define("DB_DRIVER", "mysql");
define("DB_HOST", "localhost");
define("DB_NAME", "petmonitor_db");
define("DB_USER", "root");
define("DB_PASS", "");

/*
$dono = new Dono();
var_dump($dono->getUsuario("31983489321", "abcd1234"));
/*
$pet = new Pet();
$pet->setCodigo(40);
var_dump($pet->getRastreador());


/*
$rastreador = new Rastreador();
$rastreador->setCodigo("ABC123456");
var_dump($rastreador->getPet());


$pet = new Pet();
$dono = new Dono();
$pet->setCodigo(37);
var_dump($pet->getDono());
/*
$dono->setNome("Marcos");
$dono->setSobrenome("Antonio");
$dono->setSenha("novasenha1234");
$dono->setCelular(31983317156);
$dono->setEmail("nemlanternagem@yahoo.com");
var_dump($pet->buscar("SELECT * FROM pet", null));
$pet = new Pet();
var_dump($pet->buscarComPaginacao("SELECT * FROM pet", null, 5, 1));*/
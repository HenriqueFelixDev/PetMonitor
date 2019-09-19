<?php

use App\App;

require_once "../vendor/autoload.php";

session_start();

error_reporting(E_ALL & ~E_WARNING);

try{
    $app = new App();
    $app->run();
}catch(\Exception $e){
    echo $e->getMessage();
}
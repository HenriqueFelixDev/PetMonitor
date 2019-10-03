<?php

namespace App\Lib;

use Exception;

class Conexao
{
    private static $conexao;

    public static function conectar()
    {
        try{
            if(!isset($conexao)) {
                $conexao = new PDO(DB_DRIVER.":".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
            }

            return $conexao;

        } catch(\PDOException $e) {
            throw new Exception("Ocorreu um erro ao conectar com o banco de dados: ".$e->getMessage());
        }
    }
}
<?php

namespace App\Lib;

use App\Util\DadosUtil;

class Sessao
{
    public static function gravar($param, $valor)
    {
        if (isset($param)) {
            $_SESSION[$param] = $valor;
        }
    }

    public static function temParam($param) 
    {
        return isset($_SESSION[$param]);
    }

    public static function obter($param)
    {
        if (isset($param) && temParam($param)) {
            return $_SESSION[$param];
        }

        return null;
    }
}
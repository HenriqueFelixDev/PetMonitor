<?php

namespace App\Lib;

class Sessao
{
    public static function gravar($identificador, $param, $valor)
    {
        if (isset($param)) {
            $_SESSION[$identificador][$param] = $valor;
        }
    }

    private static function temParam($identificador, $param) 
    {
        return isset($_SESSION[$identificador][$param]);
    }

    public static function obter($identificador, $param = null)
    {
        if (isset($identificador)) {

            if (!isset($param)) {
                return isset($_SESSION[$identificador]) ? $_SESSION[$identificador] : null;
            }

            if (self::temParam($identificador, $param)) {
                return $_SESSION[$identificador][$param];
            }
           
        }

        return null;
    }

    public static function limpar($identificador, $param)
    {
        if (self::temParam($identificador, $param)) {
            unset($_SESSION[$identificador][$param]);
        }
    }

    public static function limparTudo($identificador)
    {
        if (isset($_SESSION[$identificador])) {
            unset($_SESSION[$identificador]);
        }
    }
}
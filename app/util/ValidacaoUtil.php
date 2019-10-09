<?php

namespace App\Util;

class ValidacaoUtil
{
    public static function tamanho($valor, $min = 0, $max = 0)
    {
        if (is_string($valor)) {
            return strlen($valor) >= $min && strlen($valor) <= $max;
        }

        if(is_array($valor))
        {
            return count($valor) >= $min && count($valor) <= $max;
        }
    }

    public static function imagem($img, array $formatos, $tamanhoMax = 2048)
    {
        
    }

    public static function temNumeros($valor)
    {
        return preg_match("/[0-9]+/", $valor);
    }

    public static function somenteLetras($valor)
    {
        return !preg_match("/[^a-zA-Zà-ÚÀ-Ú ]+/", $valor);
    }

    public static function celular($valor)
    {
        return preg_match("/\(?(\d){2}\)?(\s)?9(\s)?(\d){4}[-]?(\d){4}/", $valor);
    }
}
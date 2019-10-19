<?php

namespace App\Util;

class DadosUtil{

    public static function getValorVar($var, $default){
        if (isset($var)) {
            return $var;
        }

        if (isset($default)) {
            return $default;
        }

        return null;
    }

    public static function getValorArray($array, $indice, $default = null){
        if(isset($array[$indice])) {
            return self::getValorVar($array[$indice], $default);
        }
    }
}
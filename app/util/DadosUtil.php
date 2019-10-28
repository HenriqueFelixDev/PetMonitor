<?php

namespace App\Util;

class DadosUtil{

    public static function getValorVar($var, $padrao){
        if (isset($var)) {
            return $var;
        }

        if (isset($padrao)) {
            return $padrao;
        }

        return null;
    }

    public static function getValorArray($nomeArray, $indice, $padrao = null){
        if(isset($nomeArray[$indice])) {
            return self::getValorVar($nomeArray[$indice], $padrao);
        }

        return self::getValorVar(null, $padrao);
    }
}
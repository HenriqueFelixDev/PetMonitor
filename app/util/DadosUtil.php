<?php

namespace App\Util;

class DadosUtil{

    public static function getValorVar($var){
        return isset($var) && !empty($var) ? $var : null;
    }

    public static function getValorArray($array, $indice){
        return isset($array[$indice]) && !empty($array[$indice]) ? $array[$indice] : null;
    }
}
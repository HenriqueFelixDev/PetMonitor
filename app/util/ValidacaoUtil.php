<?php

namespace App\Util;

use \DateTime;
use App\Lib\Sessao;

class ValidacaoUtil
{
    public static function csrf($formularioNome)
    {
        $csrf = uniqid(rand(), true);
        Sessao::gravar("csrf", $formularioNome, $csrf);
        return "<input type=\"hidden\" name=\"_csrf\" value=\"${csrf}\" />";
    }

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

    public static function somenteNumeros($valor)
    {
        return !preg_match("/[^0-9]/", $valor);
    }

    public static function celular($valor)
    {
        return preg_match("/\(?(\d){2}\)?(\s)?9(\s)?(\d){4}[-]?(\d){4}/", $valor);
    }

    public static function data($data)
    {
        if (!preg_match("/(\d){4}-(\d){2}-(\d){2}/", $data)) {
            return false;
        }

        $data = explode("-", $data);

        if (isset($data[2]) && intval($data[2]) > 31) {
            return false;
        }

        if (isset($data[1]) && intval($data[1]) > 12) {
            return false;
        }

        return true;
    }

    public static function dataFutura($data, $dataModelo = "now")
    {
        $dataRecebida = new DateTime($data);
        $dataAtual = new DateTime($dataModelo);
        $result = $dataAtual->diff($dataRecebida);
        return !$result->invert;
    }

    public static function dataPassada($data, $dataModelo = "now")
    {
        return !self::dataFutura($data);
    }

}
<?php

namespace App\Lib;

use App\Lib\Sessao;
use App\Lib\TipoMensagem;

class Mensagem
{
    public static function gravarMensagem($identificador, $mensagem, $tipoMensagem = TipoMensagem::INFO)
    {
        Sessao::gravar("msg", $identificador, array("msg" => $mensagem, "tipo" => $tipoMensagem));
    }

    public static function obterMensagem($identificador)
    {
        return Sessao::obter("msg", $identificador);
    }

    public static function temMensagem($identificador)
    {
        return self::obterMensagem($identificador) != null;
    }

    public static function obterMensagens()
    {
        return Sessao::obter("msg");
    }

    public static function limparMensagens()
    {
        Sessao::limparTudo("msg");
    }
}
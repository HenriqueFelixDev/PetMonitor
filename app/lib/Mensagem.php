<?php

namespace App\Lib;

use App\Lib\Sessao;
use App\Lib\TipoMensagem;

class Mensagem
{
    public static function gravarMensagem($identificador, $mensagem, TipoMensagem $tipoMensagem = TipoMensagem::INFO)
    {
        Sessao::gravar($identificador, array("msg" => $mensagem, "tipo" => $tipoMensagem));
    }

    public static function obterMensagem($identificador)
    {
        return Sessao::obter($identificador);
    }

    public static function temMensagem($identificador)
    {
        return Sessao::temParam($identificador);
    }
}
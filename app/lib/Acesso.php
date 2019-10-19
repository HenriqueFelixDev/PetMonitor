<?php

namespace App\Lib;

use App\Lib\Sessao;

class Acesso
{
    public static function entrar($codUsuario, $nomeUsuario)
    {
        Sessao::gravar("usuario", "codigo", $codUsuario);
        Sessao::gravar("usuario", "nome", $nomeUsuario);
    }

    public static function sair()
    {
        Sessao::limparTudo("usuario");
    }

    public static function estaLogado()
    {
        return Sessao::obter("usuario") != null;
    }
}
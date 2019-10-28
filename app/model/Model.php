<?php

namespace App\Model;

use App\Lib\IValidacao;

abstract class Model implements IValidacao
{
    public static function getTabela($classe)
    {
        $tabela = $classe;
        $tabela = explode("\\", $tabela);
        $tabela = strtolower($tabela[count($tabela)-1]);
        return $tabela;
    }
}
<?php

namespace App\Model;

use App\Lib\IValidacao;

abstract class Model implements IValidacao
{
    public function inserir()
    {
        return true;
    }

    public function atualizar()
    {
        return true;
    }

    public function buscar()
    {
        
    }

    public function encontrarPorId()
    {
        
    }

    public function deletar()
    {
        
    }

    public function buscarComPaginacao()
    {
        
    }
}
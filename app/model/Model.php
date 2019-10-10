<?php

namespace App\Model;

use App\Lib\iValidacao;

abstract class Model implements iValidacao
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
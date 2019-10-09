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
        
    }

    public function buscar()
    {
        
    }

    public function encontrar()
    {
        
    }

    public function deletar()
    {
        
    }

    public function buscarComPaginacao()
    {
        
    }
}
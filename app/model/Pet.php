<?php

namespace App\Model;

use App\Model\Model;

class Pet extends Model
{
    private $cod_pet;
    private $nome;
    private $especie;
    private $raca;
    private $sexo;
    private $cor;
    private $dt_nascimento;
    private $foto;
    
    public function validar() : bool
    {
        return true;
    }
}
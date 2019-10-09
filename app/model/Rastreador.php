<?php

namespace App\Model;

use App\Model\Model;

class Rastreador extends Model
{
    private $cod_rastreador;
    private $cod_dono;
    private $cod_pet;
    private $data_ativacao;
     
    public function validar() : bool
    {
        return true;
    }
}
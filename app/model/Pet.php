<?php

namespace App\Model;

use App\Model\Model;

class Pet extends Model
{
    public function validar() : bool
    {
        return true;
    }
}
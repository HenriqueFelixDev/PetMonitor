<?php

namespace App\Repository;

use App\Dao\IDao;
use App\Model\Trajeto;

class TrajetoRepository
{
    private $dao;

    public function __construct(IDao $dao)
    {
        $this->dao = $dao;
    }
    
    public function cadastrar(Trajeto $trajeto)
    {
        $campos = [ "data_hora", "cod_pet", "latitude", "longitude"];
        $valores = [$trajeto->getDataHora(), $trajeto->getCodigoPet(), $trajeto->getLatitude(), $trajeto->getLongitude()];
        return $this->dao->inserir($trajeto, $campos, $valores);
    }
}
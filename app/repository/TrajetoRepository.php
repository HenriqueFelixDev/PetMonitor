<?php

namespace App\Repository;

use App\Dao\IDao;
use App\Repository\IRepository;
use App\Model\Model;

class TrajetoRepository implements IRepository
{
    private $dao;

    public function __construct(IDao $dao)
    {
        $this->dao = $dao;
    }
    
    public function cadastrar(Model $trajeto)
    {
        $campos = [ "data_hora", "cod_pet", "latitude", "longitude"];
        $valores = [$trajeto->getDataHora(), $trajeto->getCodigoPet(), $trajeto->getLatitude(), $trajeto->getLongitude()];
        return $this->dao->inserir($trajeto, $campos, $valores);
    }

    public function atualizar(Model $trajeto)
    {

    }

    public function consultar(array $filtros, string $urlPaginacao)
    {

    }

    public function excluir($id)
    {

    }

    public function buscarPorId($id)
    {

    }
}
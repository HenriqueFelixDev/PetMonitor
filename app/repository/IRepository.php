<?php

namespace App\Repository;

use App\Dao\IDao;
use App\Model\Model;

interface IRepository
{
    public function __construct(IDao $dao);
    public function cadastrar(Model $model);
    public function atualizar(Model $model);
    public function consultar(array $filtros, string $urlPaginacao);
    public function excluir($id);
    public function buscarPorId($id);
}
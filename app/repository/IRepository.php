<?php

namespace App\Repository;

use App\Dao\IDao;

interface IRepository
{
    public function __construct(IDao $dao);
    public function cadastrar($model);
    public function atualizar($model);
    public function consultar(array $filtros, string $urlPaginacao);
    public function excluir($id);
    public function buscarPorId($id);
}
<?php

namespace App\Dao;

use App\Model\Model;

interface IDao
{
    // Quantidade de itens que devem ser retornados da função buscar
    const UNICO = 0;
    const MULTIPLOS = 1;

    public function inserir(Model $model, array $campos, array $valores);
    public function encontrarPorId($id, String $classe);
    public function executar($sql, $bindings);
    public function buscar($sql, $bindings, $formatoRetorno, $argumentoRetorno, $quantidadeRetorno);
    public function atualizar(String $classe, $id, array $campos, array $valores);
    public function deletar($id, String $classe);
}
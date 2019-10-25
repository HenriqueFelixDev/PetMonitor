<?php

namespace App\Dao;

use App\Dao\IDao;
use App\Lib\Conexao;
use App\Model\Model;
use PDO;

class MySqlDao implements IDao
{
    

    public function inserir(Model $model, array $campos, array $valores)
    {
        $con = Conexao::conectar();

        $tabela = Model::getTabela(get_class($model));

        $camposStr = implode(", ", $campos);
        $bindingsStr = implode (", :", $campos);
        $bindingsStr = ":{$bindingsStr}";
        $sql = "INSERT INTO ${tabela} (${camposStr}) VALUES (${bindingsStr})";
        
        $stm = $con->prepare($sql);

        for ($i = 0; $i < count($valores); $i++) {
            $stm->bindValue(":".$campos[$i], $valores[$i]);
        }

        $stm->execute();
        return boolval($stm->rowCount() > 0);
    }

    public function encontrarPorId($id, String $classe)
    {
        $con = Conexao::conectar();

        $tabela = Model::getTabela($classe);

        $stm = $con->prepare("SELECT * FROM ${tabela} WHERE cod_${tabela}=:codigo");
        $stm->setFetchMode(PDO::FETCH_CLASS, $classe);
        $stm->bindValue(":codigo", $id);
        $stm->execute();

        if ($stm->rowCount() > 0) {
            $result = $stm->fetch();
            return $result;
        }

        return null;
    }

    public function executar($sql, $bindings)
    {
        $con = Conexao::conectar();

        $stm = $con->prepare($sql);
        foreach ($bindings as $chave=>$valor) {
            $stm->bindValue($chave, $valor);
        }
        $stm->execute();

        return boolval($stm->rowCount());
    }

    public function buscar($sql, $bindings, $formatoRetorno = PDO::FETCH_ASSOC, $argumentoRetorno = null, $quantidadeRetorno = IDao::MULTIPLOS)
    {
        $con = Conexao::conectar();

        $stm = $con->prepare($sql);
        foreach ($bindings as $chave=>$valor) {
            $stm->bindValue($chave, $valor);
        }
        $stm->execute();

        if ($stm->rowCount()) {

            if (isset($argumentoRetorno)) {
                $result = $stm->fetchAll($formatoRetorno, $argumentoRetorno);
            } else {
                $result = $stm->fetchAll($formatoRetorno);
            }
            
            if ($quantidadeRetorno == IDao::UNICO) {
                return $result[0];
            }

            return $result;
        }

        return null;
    }

    public function atualizar(String $classe, $id, array $campos, array $valores)
    {
        $con = Conexao::conectar();

        $tabela = Model::getTabela($classe);

        $sql = "UPDATE ${tabela} SET ";
        foreach ($campos as $campo=>$valor) {
            if (empty($valores[$campo])) {
                unset($campos[$campo]);
                unset($valores[$campo]);
                continue;
            }
            $sql .= "${valor}=:${valor}, ";
        }

        $sql = rtrim($sql, ", ");
        $sql .= " WHERE cod_${tabela}=:codigo";

        $stm = $con->prepare($sql);
        
        foreach ($campos as $campo=>$valor) {
            $stm->bindValue(":{$campos[$campo]}", $valores[$campo]);
        }

        $stm->bindValue(":codigo", $id);

        $stm->execute();
        return boolval($stm->rowCount() > 0);
    }

    public function deletar($id, String $classe)
    {
        $con = Conexao::conectar();

        $tabela = Model::getTabela($classe);

        $stm = $con->prepare("DELETE FROM ${tabela} WHERE cod_${tabela}=:codigo");
        $stm->bindValue(":codigo", $id);
        $stm->execute();

        return boolval($stm->rowCount() > 0);
    }
}
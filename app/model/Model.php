<?php

namespace App\Model;

use App\Lib\IValidacao;
use App\Lib\Conexao;
use App\Lib\Paginacao;
use PDO;

abstract class Model implements IValidacao
{
    public function inserir()
    {
        $con = Conexao::conectar();

        $tabela = $this->getNomeTabela();

        $campos = get_object_vars($this);

        $chaves = null;
        $valores = null;

        foreach ($campos as $campo=>$valor) {
            if (empty($valor)) {
                unset($campos[$campo]);
                continue;
            }
            /*
            if (empty($valor) || $campo == "cod_${tabela}") {
                unset($campos[$campo]);
                continue;
            }
            */

            $chaves .= "${campo}, ";
            $valores .= ":${campo}, ";

        }

        $chaves = rtrim($chaves, ", ");
        $valores = rtrim($valores, ", ");

        $sql = "INSERT INTO ${tabela} (${chaves}) VALUES (";

        if(method_exists($this, "getCodigo")){
            if ($this->getCodigo() != null) {
                $sql .= ":cod_${tabela}, ";
            } else {
                $sql .= "default, ";
            }
        }
        $sql .= "${valores})";
        
        $stm = $con->prepare($sql);

        $valores = str_replace(":", "", $valores);
        $valores = explode(", ", $valores);

        if(method_exists($this, "getCodigo")){
            if ($this->getCodigo() != null) {
                $stm->bindValue(":cod_${tabela}", $this->getCodigo());
            }
        }

        for ($i = 1; $i <= count($valores); $i++) {
            $campo = $valores[$i-1];
            $stm->bindValue(":".$campo, $campos[$campo]);
        }

        $stm->execute();
        return $stm->rowCount() > 0;
    }

    public function atualizar()
    {
        $con = Conexao::conectar();

        $tabela = $this->getNomeTabela();

        $campos = get_object_vars($this);

        foreach ($campos as $campo=>$valor) {
            if (empty($valor) || $campo == "cod_${tabela}") {
                unset($campos[$campo]);
            }
        }

        $sql = "UPDATE ${tabela} SET ";
        foreach ($campos as $campo=>$valor) {
            $sql .= "${campo}=:${campo}, ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE cod_${tabela}=:codigo";

        $stm = $con->prepare($sql);
        
        foreach ($campos as $campo=>$valor) {
            $stm->bindValue(":${campo}", $valor);
        }

        $stm->bindValue(":codigo", $this->getCodigo());

        $stm->execute();

        return $stm->rowCount() > 0;
    }

    public function buscar($sql, $bindings, $tipoFetch = PDO::FETCH_ASSOC, $argFetch = null)
    {

        $con = Conexao::conectar();

        $stm = $con->prepare($sql);
        foreach ($bindings as $chave=>$valor) {
            $stm->bindValue($chave, $valor);
        }
        $stm->execute();

        if ($stm->rowCount()) {

            if (isset($argFetch)) {
                $result = $stm->fetchAll($tipoFetch, $argFetch);
            } else {
                $result = $stm->fetchAll($tipoFetch);
            }
            
            return $result;
        }

        return null;
        
    }

    public function encontrarPorId()
    {
        $con = Conexao::conectar();

        $tabela = $this->getNomeTabela();

        $stm = $con->prepare("SELECT * FROM ${tabela} WHERE cod_${tabela}=:codigo");
        $stm->setFetchMode(PDO::FETCH_CLASS, get_class($this));
        $stm->bindValue(":codigo", $this->getCodigo());
        $stm->execute();

        if ($stm->rowCount() > 0) {
            $result = $stm->fetch();
            return $result;
        }

        return null;
    }

    public function deletar()
    {
        $con = Conexao::conectar();

        $tabela = $this->getNomeTabela();

        $stm = $con->prepare("DELETE FROM ${tabela} WHERE cod_${tabela}=:codigo");
        $stm->bindValue(":codigo", $this->getCodigo());
        $stm->execute();

        return $stm->rowCount() > 0;
    }


    public function buscarComPaginacao($sql, $bindings, $totalItens, $itensPorPagina, $indice, $url)
    {
        $con = Conexao::conectar();

        $stm = $con->prepare($sql);
        foreach ($bindings as $chave=>$valor) {
            $stm->bindValue($chave, $valor);
        }
        
        $stm->execute();

        if ($stm->rowCount() > 0) {
            $dados = $stm->fetchAll(PDO::FETCH_CLASS, get_class($this));
            $paginacao = Paginacao::paginar($totalItens, $itensPorPagina, $indice, $url);
            $result = array("paginacao" => $paginacao, "dados" => $dados, "totalItens" => $totalItens);
            return $result;
        }

        return null;
    }



/*
    public function buscarComPaginacao($campos, $join, $whereArgs, $orderBy, $bindings, $itensPorPagina, $indice, $url)
    {
        $con = Conexao::conectar();


        $itemAtual = $indice * $itensPorPagina;

        if (!empty($campos)) {
            $sql = "SELECT ${campos} FROM ".$this->getNomeTabela();
        } else {
            $sql = "SELECT * FROM ".$this->getNomeTabela();
        }
        
        $sqlCount = "SELECT count(*) FROM ".$this->getNomeTabela();

        if (!empty($join)) {
            $sql .= " ${join} ";
            $sqlCount .= " ${join} ";
        }
        if (!empty($whereArgs)) {
            $sql .= " WHERE ${whereArgs}";
            $sqlCount .= " WHERE ${whereArgs}";
        }
        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy";
        }
        $sql .= " LIMIT ${itemAtual}, ${itensPorPagina}";

        $stm = $con->prepare($sqlCount);
        foreach ($bindings as $chave=>$valor) {
            $stm->bindValue($chave, $valor);
        }
        $stm->execute();

        if ($stm->rowCount() == 0) {
            return null;
        }
        
        $totalItens = $stm->fetch(PDO::FETCH_COLUMN);

        $stm = $con->prepare($sql);
        foreach ($bindings as $chave=>$valor) {
            $stm->bindValue($chave, $valor);
        }
        
        $stm->execute();

        
        if ($stm->rowCount() > 0) {
            $dados = $stm->fetchAll(PDO::FETCH_CLASS, get_class($this));
            $paginacao = Paginacao::paginar($totalItens, $itensPorPagina, $indice, $url);
            $result = array("paginacao" => $paginacao, "dados" => $dados, "totalItens" => $totalItens);
            return $result;
        }

        return null;
    }
*/
    public function getNomeTabela()
    {
        $tabela = get_class($this);
        $tabela = explode("\\", $tabela);
        $tabela = strtolower($tabela[count($tabela)-1]);
        return $tabela;
    }
}
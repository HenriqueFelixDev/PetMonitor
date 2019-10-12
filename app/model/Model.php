<?php

namespace App\Model;

use App\Lib\IValidacao;
use App\Lib\Conexao;
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
            if (empty($valor) || $campo == "cod_${tabela}") {
                unset($campos[$campo]);
                continue;
            }

            $chaves .= "${campo}, ";
            $valores .= ":${campo}, ";

        }

        $chaves = rtrim($chaves, ", ");
        $valores = rtrim($valores, ", ");

        $sql = "INSERT INTO ${tabela} (cod_${tabela}, ${chaves}) VALUES (";
        $sql .= ($this->getCodigo() != null) ? ":cod_${tabela}, " : "default, ";
        $sql .= "${valores});";
        
        $stm = $con->prepare($sql);

        $valores = str_replace(":", "", $valores);
        $valores = explode(", ", $valores);

        if (($this->getCodigo() != null)) {
            $stm->bindValue(":cod_${tabela}", $this->getCodigo());
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

    public function buscar()
    {
        
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

    public function buscarComPaginacao()
    {
        
    }

    public function getNomeTabela()
    {
        $tabela = get_class($this);
        $tabela = explode("\\", $tabela);
        $tabela = strtolower($tabela[count($tabela)-1]);
        return $tabela;
    }
}
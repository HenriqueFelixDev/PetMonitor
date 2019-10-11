<?php

namespace App\Model;

use App\Lib\IValidacao;
use App\Lib\Conexao;

abstract class Model implements IValidacao
{
    public function inserir()
    {
        $con = Conexao::conectar();

        $tabela = get_class($this);
        $tabela = explode("\\", $tabela);
        $tabela = strtolower($tabela[count($tabela)-1]);

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
        return true;
    }

    public function buscar()
    {
        
    }

    public function encontrarPorId()
    {
        
    }

    public function deletar()
    {
        
    }

    public function buscarComPaginacao()
    {
        
    }
}
<?php

namespace App\Model;

use App\Model\Model;
use App\Lib\Mensagem;
use PDO;

class Rastreador extends Model
{
    protected $cod_rastreador;
    protected $cod_pet;
    protected $nome_pet;
    protected $dt_ativacao;
     
    public function validar() : bool
    {
        $temErro = false;

        if(!preg_match("/[a-zA-Z]{3}(\d){6}/", $this->cod_rastreador)) {
            $temErro = true;
            Mensagem::gravarMensagem("codigo-rastreador", "O código informado não possui o formato válido: AAA000000", Mensagem::ERRO);
        }

        return !$temErro;
    }

    public function inserir() 
    {
        $dataAtual = new \DateTime();
        $this->dt_ativacao = $dataAtual->format("Y-m-d");
        return parent::inserir();
    }

    public function buscarComPaginacao($filtros, $url)
    {

        $codigo = $filtros["codigo"];
        $busca = $filtros["busca"];
        $dataInicial = $filtros["dataInicial"];
        $dataFinal = $filtros["dataFinal"];
        $indice = $filtros["indice"];
        $limite = $filtros["limite"];
        $ordem = $filtros["ordem"];

        $join = "INNER JOIN pet p on rastreador.cod_pet = p.cod_pet";
        $whereArgs = "p.cod_dono = :codigo";

        $bindings[":codigo"] = $codigo;
        if (!empty($busca)) {
            $whereArgs .= " AND (p.nome LIKE :busca OR rastreador.cod_rastreador LIKE :busca)";
            $bindings[":busca"] = "%${busca}%";
        }

        if (!empty($dataInicial)) {
            $whereArgs .= " AND rastreador.dt_ativacao >= :dataInicial";
            $bindings[":dataInicial"] = $dataInicial;
            
        }

        if (!empty($dataFinal)) {
            $whereArgs .= " AND rastreador.dt_ativacao <= :dataFinal";
            $bindings[":dataFinal"] = $dataFinal;
        }

        $campos = "rastreador.cod_rastreador, p.nome as 'nome_pet', rastreador.dt_ativacao";
        $itemAtual = $indice * $limite;
        $sql = "SELECT ${campos} FROM rastreador ${join} WHERE ${whereArgs} ORDER BY ${ordem} LIMIT ${itemAtual}, ${limite}";
        $sqlCount = "SELECT count(*) FROM rastreador ${join} WHERE ${whereArgs}";
        
        $totalItens = $this->buscar($sqlCount, $bindings, PDO::FETCH_COLUMN)[0];
        return parent::buscarComPaginacao($sql, $bindings, $totalItens, $limite, $indice, $url);
    }
    
    public function getCodigo()
    {
        return $this->cod_rastreador;
    }
    
    public function setCodigo($cod_rastreador)
    {
        $this->cod_rastreador = $cod_rastreador;
    }
    
    public function getCodigoDono()
    {
        return $this->cod_dono;
    }
    
    public function setCodigoDono($cod_dono)
    {
        $this->cod_dono = $cod_dono;
    }
    
    public function getCodigoPet()
    {
        return $this->cod_pet;
    }
    
    public function setCodigoPet($cod_pet)
    {
        $this->cod_pet = $cod_pet;
    }

    public function getNomePet()
    {
        return $this->nome_pet;
    }
    
    public function setNomePet($nome_pet)
    {
        $this->nome_pet = $nome_pet;
    }
    
    public function getDataAtivacao()
    {
        return $this->dt_ativacao;
    }
    
    public function setDataAtivacao($dt_ativacao)
    {
        $this->dt_ativacao = $dt_ativacao;
    }
}
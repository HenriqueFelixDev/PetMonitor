<?php

namespace App\Repository;

use App\Model\Rastreador;
use App\Dao\IDao;
use App\Repository\IRepository;
use App\Lib\Paginacao;
use App\Model\Model;
use PDO;

class RastreadorRepository implements IRepository
{
    private $dao;

    public function __construct(IDao $dao)
    {
        $this->dao = $dao;
    }
    
    public function cadastrar(Model $rastreador)
    {
        $campos = ["cod_rastreador", "cod_pet", "dt_ativacao"];
        $valores = [$rastreador->getCodigo(), $rastreador->getCodigoPet(), $rastreador->getDataAtivacao()];
        return $this->dao->inserir($rastreador, $campos, $valores);
    }

    public function atualizar(Model $rastreador)
    {
        $campos = ["cod_rastreador", "cod_pet", "dt_ativacao"];
        $valores = [$rastreador->getCodigo(), $rastreador->getCodigoPet(), $rastreador->getDataAtivacao()];
        return $this->dao->atualizar(Rastreador::class, $rastreador->getCodigo(), $campos, $valores);
    }

    public function consultar(array $filtros, string $urlPaginacao)
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
        
        $totalItens = $this->dao->buscar($sqlCount, $bindings, PDO::FETCH_COLUMN, null, IDao::UNICO);
        $pets = $this->dao->buscar($sql, $bindings, PDO::FETCH_CLASS, Rastreador::class, IDao::MULTIPLOS);
        $paginacao = Paginacao::paginar($totalItens, $limite, $indice, $urlPaginacao);

        return array("paginacao" => $paginacao, "dados" => $pets, "totalItens" => $totalItens);
    }
    
    public function excluir($id)
    {
        return $this->dao->deletar($id, Rastreador::class);
    }

    public function buscarPorId($id)
    {
        return $this->dao->encontrarPorId($id, Rastreador::class);
    }

    public function getPet($idRastreador) 
    {
        $sql = "SELECT p.* FROM pet p INNER JOIN rastreador r ON p.cod_pet = r.cod_pet WHERE r.cod_rastreador=:codigo";
        return $this->dao->buscar($sql, [":codigo" => $idRastreador], PDO::FETCH_CLASS, \App\Model\Pet::class, IDao::UNICO);
    }

}
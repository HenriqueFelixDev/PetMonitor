<?php

namespace App\Repository;

use App\Model\Pet;
use App\Dao\IDao;
use App\Repository\IRepository;
use App\Lib\Paginacao;
use App\Model\Model;
use PDO;

class PetRepository implements IRepository
{
    private $dao;

    public function __construct(IDao $dao)
    {
        $this->dao = $dao;
    }
    
    public function cadastrar(Model $pet)
    {
        $campos = ["cod_dono", "nome", "especie", "raca", "cor", "dt_nascimento", "foto"];
        $valores = [$pet->getCodigoDono(), $pet->getNome(), $pet->getEspecie(), $pet->getRaca(), $pet->getCor(), $pet->getDataNascimento(), $pet->getFoto()];
        return $this->dao->inserir($pet, $campos, $valores);
    }

    public function atualizar(Model $pet)
    {
        $campos = ["nome", "especie", "raca", "sexo", "cor", "dt_nascimento", "foto"];
        $valores = [$pet->getNome(), $pet->getEspecie(), $pet->getRaca(), $pet->getSexo(), $pet->getCor(), $pet->getDataNascimento(), $pet->getFoto()];
        return $this->dao->atualizar(Pet::class, $pet->getCodigo(), $campos, $valores);
    }

    public function consultar(array $filtros, string $urlPaginacao)
    {
        
        $codigo = $filtros["codigo"];
        $busca = $filtros["busca"];
        $sexo = $filtros["sexo"];
        $dataInicial = $filtros["dataInicial"];
        $dataFinal = $filtros["dataFinal"];
        $indice = $filtros["indice"];
        $limite = $filtros["limite"];

        $whereArgs = "cod_dono = :codigo";
        $binding = [":codigo"=>$codigo];

        if (!empty(trim($busca))) {
            $whereArgs .= " AND (nome LIKE :busca OR especie LIKE :busca OR raca LIKE :busca)";
            $binding[":busca"] = "%".$busca."%";
        }

        if (!empty(trim($sexo))) {
            $whereArgs .= " AND sexo = :sexo";
            $binding[":sexo"] = $sexo;
        }

        if (!empty(trim($dataInicial))) {
            $whereArgs .= " AND dt_nascimento >= :dataInicial";
            $binding[":dataInicial"] = $dataInicial;
        }

        if (!empty(trim($dataFinal))) {
            $whereArgs .= " AND dt_nascimento <= :dataFinal";
            $binding[":dataFinal"] = $dataFinal;
        }
        
        $itemAtual = $indice * $limite;
        $sql = "SELECT * FROM pet WHERE ${whereArgs} ORDER BY {$filtros["ordem"]} LIMIT {$itemAtual}, ${limite}";

        $pets = $this->dao->buscar($sql, $binding, PDO::FETCH_CLASS, PET::class, IDao::MULTIPLOS);
        $totalItens = count($pets);
        $paginacao = Paginacao::paginar($totalItens, $limite, $indice, $urlPaginacao);

        return array("paginacao" => $paginacao, "dados" => $pets, "totalItens" => $totalItens);
    }
    
    public function excluir($id)
    {
        return $this->dao->deletar($id, Pet::class);
    }

    public function buscarPorId($id)
    {
        return $this->dao->encontrarPorId($id, Pet::class);
    }

    public function getDono($idPet) 
    {
        $sql = "SELECT d.* FROM dono d INNER JOIN pet p ON p.cod_dono = d.cod_dono WHERE p.cod_pet=:codigo";
        return $this->dao->buscar($sql, [":codigo"=>$idPet], PDO::FETCH_CLASS, \App\Model\Dono::class, IDAO::UNICO);
    }

    public function getRastreador($idPet)
    {
        $sql = "SELECT r.* FROM rastreador r INNER JOIN pet p ON r.cod_pet = p.cod_pet WHERE p.cod_pet=:cod_pet";
        return $this->dao->buscar($sql, [":cod_pet"=>$idPet], PDO::FETCH_CLASS, \App\Model\Rastreador::class, IDAO::UNICO);
    }

    public function getTrajetos($idPet, $dataHoraInicial = null, $dataHoraFinal = null)
    {
        $sql = "SELECT * FROM trajeto t INNER JOIN pet p ON t.cod_pet = p.cod_pet WHERE p.cod_pet = :codigo";
        $bindings[":codigo"] = $idPet;

        if (!empty(trim($dataHoraInicial))) {
            $sql .= " AND data_hora >= :dataInicial";
            $bindings[":dataInicial"] = $dataHoraInicial;
        }

        if (!empty(trim($dataHoraFinal))) {
            $sql .= " AND data_hora <= :dataFinal";
            $bindings[":dataFinal"] = $dataHoraFinal;
        }
        return $this->dao->buscar($sql, $bindings, PDO::FETCH_CLASS, \App\Model\Trajeto::class, IDao::MULTIPLOS);
    }
}
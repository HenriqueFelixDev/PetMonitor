<?php

namespace App\Repository;

use App\Dao\IDao;
use App\Repository\IRepository;
use App\Model\Dono;
use App\Model\Model;
use PDO;

class DonoRepository implements IRepository
{
    private $dao;

    public function __construct(IDao $dao)
    {
        $this->dao = $dao;
    }

    public function cadastrar(Model $dono)
    {
        $campos = ["nome", "sobrenome", "senha", "celular", "email"];
        $valores = [$dono->getNome(), $dono->getSobrenome(), $dono->getSenha(), $dono->getCelular(), $dono->getEmail()];
        return $this->dao->inserir($dono, $campos, $valores);
    }

    public function atualizar(Model $dono)
    {
        $campos = ["nome", "sobrenome", "senha", "celular", "email"];
        $valores = [$dono->getNome(), $dono->getSobrenome(), $dono->getSenha(), $dono->getCelular(), $dono->getEmail()];
        return $this->dao->atualizar(Dono::class, $dono->getCodigo(), $campos, $valores);
    }

    
    public function consultar(array $filtros, string $urlPaginacao)
    {
        
    }

    public function excluir($id)
    {
        
    }

    public function buscarPorId($id)
    {
        return $this->dao->encontrarPorId($id, Dono::class);
    }

    public function getUsuarioPorEmail($email)
    {
        return $this->dao->buscar("SELECT count(*) as 'qtd' FROM dono WHERE email = :email", [":email"=>$email], PDO::FETCH_COLUMN, null, IDao::UNICO);
    }

    public function getUsuarioPorCelular($celular)
    {
        return $this->dao->buscar("SELECT count(*) as 'qtd' FROM dono WHERE celular = :cel", [":cel"=>$celular], PDO::FETCH_COLUMN, null, IDao::UNICO);
    }

    public function getUsuario($email_celular, $senha)
    {
        $sql = "SELECT * FROM dono WHERE email=:email OR celular=:celular";
        $bindings = [":email"=>$email_celular, ":celular"=>$email_celular];
        $result = $this->dao->buscar($sql, $bindings, PDO::FETCH_CLASS, Dono::class, IDao::MULTIPLOS);
            
        if ($result) {
            foreach($result as $dono) {
                if (password_verify($senha, $dono->getSenha())) {
                    return $dono;
                }
            }
        }

        return null;
    }

    public function alterarSenha($codDono, $senha)
    {
        $sql = "UPDATE dono SET senha=:senha WHERE cod_dono=:codigo";
        return $this->dao->executar($sql, [":senha"=>$senha, ":codigo"=>$codDono]);
    }
}
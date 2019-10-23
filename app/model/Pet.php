<?php

namespace App\Model;

use App\Lib\Mensagem;
use App\Model\Model;
use App\Util\ImagemUtil;
use App\Util\ValidacaoUtil;
use PDO;
use App\Lib\Sessao;

class Pet extends Model
{
    protected $cod_pet;
    protected $cod_dono;
    protected $nome;
    protected $especie;
    protected $raca;
    protected $sexo;
    protected $cor;
    protected $dt_nascimento;
    protected $foto;



    public function getDono() 
    {
        $sql = "SELECT d.* FROM dono d INNER JOIN pet p ON p.cod_dono = d.cod_dono WHERE p.cod_pet=:codigo";
        return parent::buscar($sql, [":codigo"=>$this->getCodigo()], PDO::FETCH_CLASS, \App\Model\Dono::class)[0];
    }

    public function getRastreador()
    {
        $sql = "SELECT r.* FROM rastreador r INNER JOIN pet p ON r.cod_pet = p.cod_pet WHERE p.cod_pet=:codigo";
        return parent::buscar($sql, [":codigo"=>$this->getCodigo()], PDO::FETCH_CLASS, \App\Model\Rastreador::class)[0];
    }

    public function getTrajetos($dataInicial = null, $dataFinal = null)
    {
        $sql = "SELECT * FROM trajeto t INNER JOIN pet p ON t.cod_pet = p.cod_pet WHERE p.cod_pet = :codigo";
        $bindings[":codigo"] = $this->getCodigo();

        if (!empty(trim($dataInicial))) {
            $sql .= " AND data_hora >= :dataInicial";
            $bindings[":dataInicial"] = $dataInicial;
        }

        if (!empty(trim($dataFinal))) {
            $sql .= " AND data_hora <= :dataFinal";
            $bindings[":dataFinal"] = $dataFinal;
        }
        return parent::buscar($sql, $bindings, PDO::FETCH_CLASS, \App\Model\Trajeto::class);
    }
    
    public function validar() : bool
    {
        $temErro = false;

        if (!ValidacaoUtil::tamanho($this->nome, 2, 64)) {
            $temErro = true;
            Mensagem::gravarMensagem("nome", "O nome deve ter entre 2 e 64 caracteres", Mensagem::ERRO);
        }

        if (!ValidacaoUtil::tamanho($this->especie, 3, 32)) {
            $temErro = true;
            Mensagem::gravarMensagem("especie", "A espécie deve ter entre 3 e 32 caracteres", Mensagem::ERRO);
        }

        if (!empty($this->raca)) {
            if (!ValidacaoUtil::tamanho($this->raca, 3, 32)) {
                $temErro = true;
                Mensagem::gravarMensagem("raca", "A raça deve ter entre 3 e 32 caracteres", Mensagem::ERRO);
            }
        }

        if (isset($this->sexo)) {
            if (array_search($this->sexo, ["m", "f", "mc", "fc"]) < 0) {
                $temErro = true;
                Mensagem::gravarMensagem("sexo", "O sexo selecionado não é válido!", Mensagem::ERRO);
            }
        }

        if (!ValidacaoUtil::tamanho($this->cor, 4, 32)) {
            $temErro = true;
            Mensagem::gravarMensagem("cor", "A cor deve ter entre 4 e 32 caracteres", Mensagem::ERRO);
        }

        if (!ValidacaoUtil::somenteLetras($this->cor)) {
            $temErro = true;
            Mensagem::gravarMensagem("cor", "A cor informada é inválida", Mensagem::ERRO);
        }

        if (!empty($this->foto["name"])) {
            if (!ImagemUtil::validarFormato($this->foto["name"], ["jpg", "jpeg", "png"])) {
                $temErro = true;
                Mensagem::gravarMensagem("foto", "O formato da imagem não é válido! A imagem deve ter os formatos jpg ou png", Mensagem::ERRO);
            } elseif (!ImagemUtil::validarTamanho($this->foto, 2097152)) {
                $temErro = true;
                Mensagem::gravarMensagem("foto", "A imagem deve ter um tamanho máximo de 2 MB(Megabytes)", Mensagem::ERRO);
            } elseif ($this->foto["error"] > 0) {
                $temErro = true;
                $erro = $this->foto["error"];

                switch ($erro) {
                    case 1:
                    case 2:
                        Mensagem::gravarMensagem("foto", "A imagem deve ter um tamanho máximo de 2 MB(Megabytes)", Mensagem::ERRO);
                        break;

                    case 3:
                        Mensagem::gravarMensagem("foto", "Ocorreu um erro e a imagem não foi completamente carregada. Tente novamente mais tarde!", Mensagem::ERRO);
                        break;

                    case 4:
                        Mensagem::gravarMensagem("foto", "Nenhum arquivo foi enviado", Mensagem::ERRO);
                        break;

                    case 6:
                    case 7:
                    case 8:
                        Mensagem::gravarMensagem("foto", "Ocorreu um erro interno e não foi possível salvar a imagem. Tente novamente mais tarde!", Mensagem::ERRO);
                        break;
                }
            }
        }

        if (!empty($this->dt_nascimento)) {
            if (!ValidacaoUtil::data($this->dt_nascimento)) {
                $temErro = true;
                Mensagem::gravarMensagem("data-nasc", "Formato de data inválido! O formato da data deve ser aaaa-mm-dd", Mensagem::ERRO);
            } elseif (!ValidacaoUtil::dataPassada($this->dt_nascimento)) {
                $temErro = true;
                Mensagem::gravarMensagem("data-nasc", "A data informada não pode ser maior que a data atual", Mensagem::ERRO);
            }
        }

        return !$temErro;
    }


    public function buscarComPaginacao($filtros, $urlBase)
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
        $sqlCount = "SELECT count(*) FROM pet WHERE ${whereArgs}";
        $totalItens = $this->buscar($sqlCount, $binding, PDO::FETCH_COLUMN)[0];

        return parent::buscarComPaginacao($sql, $binding, $totalItens, $limite, $indice, $urlBase);
    }

    public function getCodigo()
    {
        return $this->cod_pet;
    }

    public function setCodigo($cod_pet)
    {
        $this->cod_pet = $cod_pet;
    }

    public function getCodigoDono()
    {
        return $this->cod_dono;
    }

    public function setCodigoDono($cod_dono)
    {
        $this->cod_dono = $cod_dono;
    }
    
    public function getNome()
    {
        return $this->nome;
    }
    
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    
    public function getEspecie()
    {
        return $this->especie;
    }
    
    public function setEspecie($especie)
    {
        $this->especie = $especie;
    }
    
    public function getRaca()
    {
        return $this->raca;
    }
    
    public function setRaca($raca)
    {
        $this->raca = $raca;
    }
    
    public function getSexo()
    {
        return $this->sexo;
    }
    
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }
    
    public function getCor()
    {
        return $this->cor;
    }
    
    public function setCor($cor)
    {
        $this->cor = $cor;
    }
    
    public function getDataNascimento()
    {
        return $this->dt_nascimento;
    }
    
    public function setDataNascimento($dt_nascimento)
    {
        $this->dt_nascimento = $dt_nascimento;
    }
    
    public function getFoto()
    {
        return $this->foto;
    }
    
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
}
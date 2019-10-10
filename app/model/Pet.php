<?php

namespace App\Model;

use App\Lib\Mensagem;
use App\Lib\TipoMensagem;
use App\Model\Model;
use App\Util\ImagemUtil;
use App\Util\ValidacaoUtil;

class Pet extends Model
{
    private $cod_pet;
    private $nome;
    private $especie;
    private $raca;
    private $sexo;
    private $cor;
    private $dt_nascimento;
    private $foto;
    
    public function validar() : bool
    {
        $temErro = false;

        if (!ValidacaoUtil::tamanho($this->nome, 2, 64)) {
            $temErro = true;
            Mensagem::gravarMensagem("nome", "O nome deve ter entre 2 e 64 caracteres", TipoMensagem::ERRO);
        }

        if (!ValidacaoUtil::tamanho($this->especie, 3, 32)) {
            $temErro = true;
            Mensagem::gravarMensagem("especie", "A espécie deve ter entre 3 e 32 caracteres", TipoMensagem::ERRO);
        }

        if (!empty($this->raca)) {
            if (!ValidacaoUtil::tamanho($this->raca, 3, 32)) {
                $temErro = true;
                Mensagem::gravarMensagem("raca", "A raça deve ter entre 3 e 32 caracteres", TipoMensagem::ERRO);
            }
        }

        if (isset($this->sexo)) {
            if (array_search($this->sexo, ["m", "f", "mc", "fc"]) < 0) {
                $temErro = true;
                Mensagem::gravarMensagem("sexo", "O sexo selecionado não é válido!", TipoMensagem::ERRO);
            }
        }

        if (!ValidacaoUtil::tamanho($this->cor, 4, 32)) {
            $temErro = true;
            Mensagem::gravarMensagem("cor", "A cor deve ter entre 4 e 32 caracteres", TipoMensagem::ERRO);
        }

        if (!empty($this->foto["name"])) {
            if (!ImagemUtil::validarFormato($this->foto["name"], ["jpg", "jpeg", "png"])) {
                $temErro = true;
                Mensagem::gravarMensagem("foto", "O formato da imagem não é válido! A imagem deve ter os formatos jpg ou png", TipoMensagem::ERRO);
            } elseif (!ImagemUtil::validarTamanho($this->foto, 2097152)) {
                $temErro = true;
                Mensagem::gravarMensagem("foto", "A imagem deve ter um tamanho máximo de 2 MB(Megabytes)", TipoMensagem::ERRO);
            } elseif ($this->foto["error"] > 0) {
                $temErro = true;
                $erro = $this->foto["error"];

                switch ($erro) {
                    case 1:
                    case 2:
                        Mensagem::gravarMensagem("foto", "A imagem deve ter um tamanho máximo de 2 MB(Megabytes)", TipoMensagem::ERRO);
                        break;

                    case 3:
                        Mensagem::gravarMensagem("foto", "Ocorreu um erro e a imagem não foi completamente carregada. Tente novamente mais tarde!", TipoMensagem::ERRO);
                        break;

                    case 4:
                        Mensagem::gravarMensagem("foto", "Nenhum arquivo foi enviado", TipoMensagem::ERRO);
                        break;

                    case 6:
                    case 7:
                    case 8:
                        Mensagem::gravarMensagem("foto", "Ocorreu um erro interno e não foi possível salvar a imagem. Tente novamente mais tarde!", TipoMensagem::ERRO);
                        break;
                }
            }
        }

        if (!empty($this->dt_nascimento)) {
            if (!ValidacaoUtil::data($this->dt_nascimento)) {
                $temErro = true;
                Mensagem::gravarMensagem("data-nasc", "Formato de data inválido! O formato da data deve ser aaaa-mm-dd", TipoMensagem::ERRO);
            }
        }

        return !$temErro;
    }

    public function getCodigo()
    {
        return $this->cod_pet;
    }

    public function setCodigo($cod_pet)
    {
        $this->cod_pet = $cod_pet;
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
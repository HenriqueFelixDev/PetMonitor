<?php

namespace App\Model;

use App\Model\Model;
use App\Util\ValidacaoUtil;
use App\Lib\Mensagem;

class Dono extends Model
{
    protected $cod_dono;
    protected $nome;
    protected $sobrenome;
    protected $senha;
    protected $celular;
    protected $email;

    public function validar() : bool
    {
        $temErro = false;

        if (!ValidacaoUtil::tamanho($this->nome, 3, 32)) {
            $temErro = true;
            Mensagem::gravarMensagem("nome", "O nome deve ter entre 3 e 32 caracteres", Mensagem::ERRO);
        }

        if (!ValidacaoUtil::somenteLetras($this->nome)) {
            $temErro = true;
            Mensagem::gravarMensagem("nome", "O nome deve possuir apenas letras", Mensagem::ERRO);
        }

        if (!ValidacaoUtil::tamanho($this->sobrenome, 3, 32)) {
            $temErro = true;
            Mensagem::gravarMensagem("sobrenome", "O sobrenome deve ter entre 3 e 32 caracteres", Mensagem::ERRO);
        }

        if (!ValidacaoUtil::somenteLetras($this->sobrenome)) {
            $temErro = true;
            Mensagem::gravarMensagem("sobrenome", "O sobrenome deve possuir apenas letras", Mensagem::ERRO);
        }

        if (!ValidacaoUtil::celular($this->celular)) {
            $temErro = true;
            Mensagem::gravarMensagem("celular", "O celular deve ter o formato (xx) 9xxxx-xxxx", Mensagem::ERRO);
        }

        if (!ValidacaoUtil::tamanho($this->email, 8, 64)) {
            $temErro = true;
            Mensagem::gravarMensagem("email", "O email deve ter entre 8 e 64 caracteres", Mensagem::ERRO);
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $temErro = true;
            Mensagem::gravarMensagem("email", "O email informado não é válido", Mensagem::ERRO);
        }

        return !$temErro;
    }

    public function alterarSenha()
    {
        return true;
    }

    public function getCodigo()
    {
        return $this->cod_dono;
    }

    public function setCodigo($cod_dono)
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
    
    public function getSobrenome()
    {
        return $this->sobrenome;
    }
    
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }
    
    public function getSenha()
    {
        return $this->senha;
    }
     
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
    
    public function getCelular()
    {
        return $this->celular;
    }
    
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
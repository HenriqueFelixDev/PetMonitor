<?php

namespace App\Model;

use App\Model\Model;
use App\Lib\Mensagem;

class Rastreador extends Model
{
    protected $cod_rastreador;
    protected $cod_dono;
    protected $cod_pet;
    protected $data_ativacao;
     
    public function validar() : bool
    {
        $temErro = false;

        if(!preg_match("/[a-zA-Z]{2}(\d){6}/", $this->cod_rastreador)) {
            $temErro = true;
            Mensagem::gravarMensagem("codigo-rastreador", "O código informado não possui o formato válido: AA000000", Mensagem::ERRO);
        }

        return !$temErro;
    }

    public function inserir() 
    {
        $dataAtual = new \DateTime();
        $this->data_ativacao = $dataAtual->format("Y-m-d");
        return parent::inserir();
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
    
    public function getDataAtivacao()
    {
        return $this->data_ativacao;
    }
    
    public function setDataAtivacao($data_ativacao)
    {
        $this->data_ativacao = $data_ativacao;
    }
}
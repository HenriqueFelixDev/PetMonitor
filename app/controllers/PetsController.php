<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Lib\Sessao;
use App\Lib\Mensagem;
use App\Lib\TipoMensagem;
use App\Model\Pet;
use App\Util\ImagemUtil;

class PetsController extends Controller 
{

    public function index() 
    {
        $this->render("pets/consulta_pets");
    }

    public function novo() 
    {
        $form = Sessao::obter("form", "pet");
        $this->setViewParam("form", $form);
        $this->render("pets/edicao_pet");
    }

    public function trajeto() 
    {
        $this->render("pets/monitoramento");
    }

    public function edicao() 
    {
        $this->render("pets/edicao_pet");
    }

    public function salvar() 
    {

        if (isset($_POST)) {

            Sessao::gravar("form", "pet", $_POST);
            
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $especie = filter_input(INPUT_POST, 'especie', FILTER_SANITIZE_SPECIAL_CHARS);
            $raca = filter_input(INPUT_POST, 'raca', FILTER_SANITIZE_SPECIAL_CHARS);
            $sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_SPECIAL_CHARS);
            $cor = filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_SPECIAL_CHARS);
            $dt_nascimento = filter_input(INPUT_POST, 'data-nasc', FILTER_SANITIZE_SPECIAL_CHARS);
            $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : null;

            $pet = new Pet();
            $pet->setNome($nome);
            $pet->setEspecie($especie);
            $pet->setRaca($raca);
            $pet->setSexo($sexo);
            $pet->setCor($cor);
            $pet->setDataNascimento($dt_nascimento);
            $pet->setFoto($foto);

            $validacao = $pet->validar();

            if (!$validacao) {
                $this->redirect("pets/novo");
            }

            $path = PATH."/public/resources/assets/fotos/";

            $res = ImagemUtil::moverImagem($pet->getFoto(), $path, \uniqid(time()));

            if (is_bool($res)) {
                $pet->setFoto(null);
            } else {
                $pet->setFoto($res);
            }

            $result = $pet->inserir();
            
            if ($result) {
                Mensagem::gravarMensagem("geral", "Pet Cadastrado com sucesso!", TipoMensagem::SUCESSO);
                Sessao::limpar("form", "pet");
                $this->redirect("pets/novo");
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao cadastrar o novo Pet!", TipoMensagem::ERRO);
                $this->redirect("pets/novo");
            }
            
        }
    }
}
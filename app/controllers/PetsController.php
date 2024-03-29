<?php

namespace App\Controllers;

use App\App;
use App\Controllers\Controller;
use App\Lib\Sessao;
use App\Lib\Mensagem;
use App\Model\Pet;
use App\Repository\PetRepository;
use App\Util\ImagemUtil;
use App\Util\DadosUtil;
use App\Util\ValidacaoUtil;

class PetsController extends Controller 
{
    private $petRepository;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->petRepository = new PetRepository($this->dao);
    }

    public function index() 
    {
        $busca = DadosUtil::getValorArray($_GET, "busca");
        $indice = intval(DadosUtil::getValorArray($_GET, "indice"));
        $sexo = DadosUtil::getValorArray($_GET, "sexo");
        $dataInicial = DadosUtil::getValorArray($_GET, "data-nasc-inicial");
        $dataFinal = DadosUtil::getValorArray($_GET, "data-nasc-final");
        $ordem = DadosUtil::getValorArray($_GET, "ordem");
        $limite = intval(DadosUtil::getValorArray($_GET, "limite"));

        $indice = ($indice >= 1) ? $indice - 1 : 0;
        $limite = ($limite >= 30) ? $limite : 30;

        $codigo = Sessao::obter("usuario", "codigo");

        switch ($ordem) {
            case "cma":
                $orderBy = "cod_pet DESC";
            break;

            case "naz":
                $orderBy = "nome ASC";
            break;

            case "nza":
                $orderBy = "nome DESC";
            break;

            // default = cme
            default:
                $orderBy = "cod_pet ASC";
        }

        if (!ValidacaoUtil::data($dataInicial)) {
            $dataInicial = null;
        }

        if (!ValidacaoUtil::data($dataFinal)) {
            $dataFinal = null;
        }

        if (!(empty($dataInicial) || empty($dataFinal))) {
            if (ValidacaoUtil::dataFutura($dataInicial, $dataFinal)) {
                $dt = $dataInicial;
                $dataInicial = $dataFinal;
                $dataFinal = $dt;
            }
        }

        $filtros["codigo"] = $codigo;
        $filtros["busca"] = $busca;
        $filtros["indice"] = $indice;
        $filtros["sexo"] = $sexo;
        $filtros["dataInicial"] = $dataInicial;
        $filtros["dataFinal"] = $dataFinal;
        $filtros["ordem"] = $orderBy;
        $filtros["limite"] = $limite;

        $url = $this->route("pets?busca=${busca}&sexo=${sexo}&data-nasc-inicial=${dataInicial}&data-nasc-final=${dataFinal}&ordem=${ordem}&limite=${limite}");

        $result = $this->petRepository->consultar($filtros, $url);

        $pets       = DadosUtil::getValorArray($result, "dados", array());
        $paginacao  = DadosUtil::getValorArray($result, "paginacao", "");
        $totalItens = DadosUtil::getValorArray($result, "totalItens", 0);

        $this->setViewParam("pets", $pets);
        $this->setViewParam("paginacao", $paginacao);
        $this->setViewParam("totalItens", $totalItens);
        $this->render("pets/consulta_pets", "PETs");
    }

    public function novo() 
    {
        $form = Sessao::obter("form", "pet");
        $this->setViewParam("form", $form);
        $this->render("pets/edicao_pet", "Novo PET");
    }

    public function edicao($params) 
    {
        if (!empty($params[0])) {
            $pet = $this->petRepository->buscarPorId($params[0]);

            if (empty($pet) || $pet->getCodigoDono() != Sessao::obter("usuario", "codigo")) {
                Mensagem::gravarMensagem("geral", "O PET informado não foi encontrado", Mensagem::ERRO);
                $this->redirect("pets");
            }

            $form = [
                "cod_pet" => $pet->getCodigo(),
                "foto" => $pet->getFoto(),
                "nome" => $pet->getNome(),
                "especie" => $pet->getEspecie(),
                "raca" => $pet->getRaca(),
                "sexo" => $pet->getSexo(),
                "cor" => $pet->getCor(),
                "data-nasc" => $pet->getDataNascimento()
            ];
            $this->setViewParam("form", $form);
            $this->render("pets/edicao_pet", "Editar PET");
        }
        $this->redirect("pets/novo");
    }

    public function salvar() 
    {

        if (isset($_POST["nome"]) && isset($_POST["especie"]) && isset($_POST["raca"]) && isset($_POST["sexo"]) && isset($_POST["cor"]) && isset($_POST["data-nasc"])) {

            if (!(isset($_POST["_csrf"]) && Sessao::obter("csrf", "edicao_pet") == $_POST["_csrf"])) {
                Mensagem::gravarMensagem("geral", "O formulário enviado é inválido ou tem origem em uma fonte não confiável", Mensagem::ERRO);
                $this->redirect("pets");
            }

            Sessao::gravar("form", "pet", $_POST);

            $codigo = DadosUtil::getValorArray($_POST, "cod_pet");
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $especie = filter_input(INPUT_POST, 'especie', FILTER_SANITIZE_SPECIAL_CHARS);
            $raca = filter_input(INPUT_POST, 'raca', FILTER_SANITIZE_SPECIAL_CHARS);
            $sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_SPECIAL_CHARS);
            $cor = filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_SPECIAL_CHARS);
            $dt_nascimento = filter_input(INPUT_POST, 'data-nasc', FILTER_SANITIZE_SPECIAL_CHARS);
            $foto = DadosUtil::getValorArray($_FILES, "foto");

            $pet = new Pet();
            $pet->setCodigoDono(Sessao::obter("usuario", "codigo"));
            $pet->setNome($nome);
            $pet->setEspecie($especie);
            $pet->setRaca($raca);
            $pet->setSexo($sexo);
            $pet->setCor($cor);
            $pet->setDataNascimento($dt_nascimento);
            $pet->setFoto($foto);

            $validacao = $pet->validar();

            if (!(isset($codigo) && ValidacaoUtil::somenteNumeros($codigo))) {
                $validacao = false;
                Mensagem::gravarMensagem("geral", "O código do PET é inválido", Mensagem::ERRO);
            }

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

            $view = "pets/novo";
            if (!empty($codigo)) {
                $pet->setCodigo($codigo);
                $result= $this->petRepository->atualizar($pet);
                $view = "pets/edicao/".$codigo;
            } else {
                $result = $this->petRepository->cadastrar($pet);
            }

            if ($result) {
                Mensagem::gravarMensagem("geral", "PET salvo com sucesso!", Mensagem::SUCESSO);
                Sessao::limpar("form", "pet");
                $this->redirect("pets");
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao salvar o PET!", Mensagem::ERRO);
                $this->redirect($view);
            }
        }

        $this->redirect("pets");
    }

    public function excluir($params)
    {
        if (!empty($params[0])) {
            $pet = $this->petRepository->buscarPorId($params[0]);

            if (empty($pet) || $pet->getCodigoDono() != Sessao::obter("usuario", "codigo")) {
                Mensagem::gravarMensagem("geral", "O PET informado não foi encontrado", Mensagem::ERRO);
                $this->redirect("pets");
            }

            $result = $this->petRepository->excluir($pet->getCodigo());
            
            if ($result) {
                Mensagem::gravarMensagem("geral", "Pet deletado com sucesso!", Mensagem::SUCESSO);
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao tentar deletar o pet", Mensagem::ERRO);
            }
        }

        $this->redirect("pets");
    }
}
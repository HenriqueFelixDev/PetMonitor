<?php

namespace  App\Controllers;

use App\Controllers\Controller;
use App\Dao\MySqlDao;
use App\Dao\IDao;
use App\Lib\Mensagem;
use App\Lib\Sessao;
use App\Model\Rastreador;
use App\Model\Pet;
use App\Model\Dono;
use App\Repository\PetRepository;
use App\Repository\RastreadorRepository;
use App\Util\DadosUtil;
use App\Util\ValidacaoUtil;

class RastreadoresController extends Controller{

    private $rastreadorRepository;
    private $dao;

    public function __construct()
    {
        $this->dao = new MySqlDao();
        $this->rastreadorRepository = new RastreadorRepository($this->dao);
    }
    public function index() {

        $busca = DadosUtil::getValorArray($_GET, "busca");
        $indice = intval(DadosUtil::getValorArray($_GET, "indice"));
        $dataInicial = DadosUtil::getValorArray($_GET, "data-ativacao-inicial");
        $dataFinal = DadosUtil::getValorArray($_GET, "data-ativacao-final");
        $ordem = DadosUtil::getValorArray($_GET, "ordem");
        $limite = intval(DadosUtil::getValorArray($_GET, "limite"));

        $indice = ($indice >= 1) ? $indice - 1 : 0;
        $limite = ($limite >= 15) ? $limite : 15;

        $codigo = Sessao::obter("usuario", "codigo");

        // default = cme
        switch ($ordem) {
            case "cma":
                $orderBy = "rastreador.cod_rastreador DESC";
            break;

            case "paz":
                $orderBy = "p.nome ASC";
            break;

            case "pza":
                $orderBy = "p.nome DESC";
            break;

            default:
                $orderBy = "rastreador.cod_rastreador ASC";
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
        $filtros["dataInicial"] = $dataInicial;
        $filtros["dataFinal"] = $dataFinal;
        $filtros["ordem"] = $orderBy;
        $filtros["limite"] = $limite;

        $url = $this->route("rastreadores?busca=${busca}&data-ativacao-inicial=${dataInicial}&data-ativacao-final=${dataFinal}&ordem=${ordem}&limite=${limite}");

        $result = $this->rastreadorRepository->consultar($filtros, $url);

        $rastreadores = DadosUtil::getValorArray($result, "dados", array());
        $paginacao    = DadosUtil::getValorArray($result, "paginacao", "");
        $totalItens   = DadosUtil::getValorArray($result, "totalItens", 0);

        $this->setViewParam("rastreadores", $rastreadores);
        $this->setViewParam("paginacao", $paginacao);
        $this->setViewParam("totalItens", $totalItens);
        $this->render("rastreadores/consulta_rastreadores", "Rastreadores");

    }

    public function vinculo($params) {
        if (isset($params[0])) {

            $petRepository = new PetRepository($this->dao);
            $pet = $petRepository->buscarPorId($params[0]);

            if (empty($pet) || $pet->getCodigoDono() != Sessao::obter("usuario", "codigo")) {
                Mensagem::gravarMensagem("geral", "Não foi possível encontrar o PET informado", Mensagem::ERRO);
                $this->redirect("pets");
            }

            $this->setViewParam("csrf_vinculo", ValidacaoUtil::csrf("vinculo"));
            $this->setViewParam("pet", $pet);
            $this->render("rastreadores/vinculo_rastreador", "Vincular Rastreador ao PET {$pet->getNome()}");
        } else {
            Mensagem::gravarMensagem("geral", "O código do pet informado é inválido", Mensagem::ERRO);
            $this->redirect("pets");
        }
    }

    public function vincular($params) {
        if (isset($_POST["codigo-rastreador"]) && !empty($params[0])) {
            
            if (!(isset($_POST["_csrf"]) && Sessao::obter("csrf", "vinculo") == $_POST["_csrf"])) {
                Mensagem::gravarMensagem("geral", "O formulário enviado é inválido ou tem origem em uma fonte não confiável", Mensagem::ERRO);
                $this->redirect("pets");
            }

            $rastreador = new Rastreador();
            $rastreador->setCodigo($_POST["codigo-rastreador"]);
            $rastreador->setCodigoPet($params[0]);

            $validade = $rastreador->validar();

            if (!$validade) {
                $this->redirect("rastreadores/vinculo/${params[0]}");
            }

            $result = $this->rastreadorRepository->buscarPorId($rastreador->getCodigo());
            if ($result) {
                Mensagem::gravarMensagem("geral", "Esse rastreador já está vinculado a algum PET. Você deve deletar o rastreador para desvinculá-lo do PET", Mensagem::ERRO);
                $this->redirect("rastreadores/vinculo/${params[0]}");
            }

            $petRepository = new PetRepository($this->dao);
            $result = $petRepository->getRastreador($rastreador->getCodigoPet());

            if ($result) {
                Mensagem::gravarMensagem("geral", "Esse PET já está vinculado a algum Rastreador. Você deve deletar o rastreador para desvinculá-lo do PET", Mensagem::ERRO);
                $this->redirect("rastreadores/vinculo/${params[0]}");
            }

            $dataAtual = new \DateTime();
            $rastreador->setDataAtivacao($dataAtual->format("Y-m-d"));

            $result = $this->rastreadorRepository->cadastrar($rastreador);
                
            if ($result) {
                Mensagem::gravarMensagem("geral", "Rastreador vinculado com sucesso!", Mensagem::SUCESSO);
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao ativar o rastreador. Tente novamente mais tarde!", Mensagem::ERRO);
                $this->redirect("rastreadores/vinculo/${params[0]}");
            }
            
        }
        $this->redirect("rastreadores");
    }

    public function excluir($params)
    {
        if (isset($params[0])) {
            $rastreador = $this->rastreadorRepository->buscarPorId($params[0]);

            if (empty($rastreador)) {
                Mensagem::gravarMensagem("geral", "O rastreador que você deseja deletar não está cadastrado no sistema", Mensagem::ERRO);
                $this->redirect("rastreadores");
            }

            $pet = $this->rastreadorRepository->getPet($params[0]);

            if (empty($pet) || $pet->getCodigoDono() != Sessao::obter("usuario", "codigo")) {
                Mensagem::gravarMensagem("geral", "Falha ao deletar! Você está tentando deletar um rastreador que não está cadastrado em sua conta", Mensagem::ERRO);
                $this->redirect("rastreadores");
            }

            $result = $this->rastreadorRepository->excluir($params[0]);
            if ($result) {
                Mensagem::gravarMensagem("geral", "Rastreador deletado com sucesso!", Mensagem::SUCESSO);
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao deletar o rastreador", Mensagem::ERRO);
            }
        }

        $this->redirect("rastreadores");

    }
}
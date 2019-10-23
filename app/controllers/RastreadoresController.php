<?php

namespace  App\Controllers;

use App\Controllers\Controller;
use App\Lib\Mensagem;
use App\Lib\Sessao;
use App\Model\Rastreador;
use App\Model\Pet;
use App\Util\DadosUtil;
use App\Util\ValidacaoUtil;

class RastreadoresController extends Controller{

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

        

        $rastreador = new Rastreador();
        $result = $rastreador->buscarComPaginacao($filtros, $url);

        $rastreadores = DadosUtil::getValorArray($result, "dados", array());
        $paginacao    = DadosUtil::getValorArray($result, "paginacao", "");
        $totalItens   = DadosUtil::getValorArray($result, "totalItens", 0);

        $this->setViewParam("rastreadores", $rastreadores);
        $this->setViewParam("paginacao", $paginacao);
        $this->setViewParam("totalItens", $totalItens);
        $this->render("rastreadores/consulta_rastreadores");

    }

    public function vinculo($params) {
        if (isset($params[0])) {
            $codigoPet = $params[0];

            $pet = new Pet();
            $pet->setCodigo($codigoPet);
            $pet = $pet->encontrarPorId();
            $this->setViewParam("csrf_vinculo", ValidacaoUtil::csrf("vinculo"));
            $this->setViewParam("pet", $pet);
            $this->render("rastreadores/vinculo_rastreador");
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

            $validade = $rastreador->validar();

            if (!$validade) {
                $this->redirect("rastreadores/vinculo/${params[0]}");
            }

            $result = $rastreador->encontrarPorId();
            if ($result) {
                Mensagem::gravarMensagem("geral", "Esse rastreador já está vinculado a algum PET. Você deve deletar o rastreador para desvinculá-lo do PET", Mensagem::ERRO);
                $this->redirect("rastreadores/vinculo/${params[0]}");
            }

            $result = $rastreador->buscar("SELECT count(*) as 'qtd' FROM rastreador r INNER JOIN pet p ON r.cod_pet = p.cod_pet WHERE p.cod_pet = :cod_pet", [":cod_pet"=>$params[0]]);
  
            if ($result) {
                Mensagem::gravarMensagem("geral", "Esse PET já está vinculado a algum Rastreador. Você deve deletar o rastreador para desvinculá-lo do PET", Mensagem::ERRO);
                $this->redirect("rastreadores/vinculo/${params[0]}");
            }

            $rastreador->setCodigoPet($params[0]);
            $result = $rastreador->inserir();
                
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
            $rastreador = new Rastreador();
            $rastreador->setCodigo($params[0]);
            $result = $rastreador->deletar();
            if ($result) {
                Mensagem::gravarMensagem("geral", "Rastreador deletado com sucesso!", Mensagem::SUCESSO);
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao deletar o rastreador", Mensagem::ERRO);
            }
        }

        $this->redirect("rastreadores");

    }
}
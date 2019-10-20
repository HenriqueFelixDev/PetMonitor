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



        $join = "INNER JOIN pet p on rastreador.cod_pet = p.cod_pet";
        $whereArgs = "p.cod_dono = :codigo";

        $bindings[":codigo"] = $codigo;
        if (!empty($busca)) {
            $whereArgs .= " AND (p.nome LIKE :busca OR rastreador.cod_rastreador LIKE :busca)";
            $bindings[":busca"] = "%${busca}%";
        }

        if (!empty($dataInicial)) {
            if (ValidacaoUtil::data($dataInicial)) {
                $whereArgs .= " AND rastreador.dt_ativacao >= :dataInicial";
                $bindings[":dataInicial"] = $dataInicial;
            } else {
                $dataInicial = null;
            }
        }

        if (!empty($dataFinal)) {
            if (ValidacaoUtil::data($dataFinal)) {
                $whereArgs .= " AND rastreador.dt_ativacao <= :dataFinal";
                $bindings[":dataFinal"] = $dataFinal;
            } else {
                $dataFinal = null;
            }
        }

        if (!(empty($dataInicial) || empty($dataFinal))) {
            if (ValidacaoUtil::dataFutura($dataInicial, $dataFinal)) {
                $bindings[":dataInicial"] = $dataFinal;
                $bindings[":dataFinal"] = $dataInicial;
            }
        }

        $orderBy = "";
        switch ($ordem) {
            case "cme":
                $orderBy = "rastreador.cod_rastreador ASC";
            break;

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
                $orderBy = null;
        }

        $url = $this->route("rastreadores?busca=${busca}&data-ativacao-inicial=${dataInicial}&data-ativacao-final=${dataFinal}&ordem=${ordem}&limite=${limite}");

        $campos = "rastreador.cod_rastreador, p.nome as 'nome_pet', rastreador.dt_ativacao";
        $rastreador = new Rastreador();
        $result = $rastreador->buscarComPaginacao($campos, $join, $whereArgs, $orderBy, $bindings, $limite, $indice, $url);
        
        $rastreadores = isset($result["dados"]) ? $result["dados"] : array();
        $paginacao = isset($result["paginacao"]) ? $result["paginacao"] : "";
        $totalItens = isset($result["totalItens"]) ? $result["totalItens"] : 0;

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
        if (isset($_POST["codigo-rastreador"]) && isset($params[0])) {
            
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

            $result = $rastreador->buscar("SELECT count(*) as 'qtd' FROM rastreador WHERE cod_rastreador = :codigo", [":codigo"=>$rastreador->getCodigo()]);

            if ($result[0]["qtd"]) {
                Mensagem::gravarMensagem("geral", "Esse rastreador já está vinculado a algum PET. Você deve deletá-lo para desvinculá-lo do PET", Mensagem::ERRO);
                $this->redirect("rastreadores/vinculo/${params[0]}");
            }

            $result = $rastreador->buscar("SELECT count(*) as 'qtd' FROM rastreador r INNER JOIN pet p ON r.cod_pet = p.cod_pet INNER JOIN dono d ON d.cod_dono = p.cod_dono WHERE p.cod_dono = :codigo", [":codigo"=>Sessao::obter("usuario", "codigo")]);

            if ($result[0]["qtd"]) {
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
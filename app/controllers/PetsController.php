<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Lib\Sessao;
use App\Lib\Mensagem;
use App\Model\Pet;
use App\Util\ImagemUtil;
use App\Util\DadosUtil;
use App\Util\ValidacaoUtil;

class PetsController extends Controller 
{

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
            if (ValidacaoUtil::data($dataInicial)) {
                $whereArgs .= " AND dt_nascimento >= :dataInicial";
                $binding[":dataInicial"] = $dataInicial;
            } else {
                $dataInicial = null;
            }
        }

        if (!empty(trim($dataFinal))) {
            if (ValidacaoUtil::data($dataFinal)) {
                $whereArgs .= " AND dt_nascimento <= :dataFinal";
                $binding[":dataFinal"] = $dataFinal;
            } else {
                $dataFinal = null;
            }
        }

        if (!(empty($dataInicial) || empty($dataFinal))) {
            if (ValidacaoUtil::dataFutura($dataInicial, $dataFinal)) {
                $binding[":dataInicial"] = $dataFinal;
                $binding[":dataFinal"] = $dataInicial;
            }
        }
        
        $orderBy = "";
        switch ($ordem) {
            case "cme":
                $orderBy = "cod_pet ASC";
            break;

            case "cma":
                $orderBy = "cod_pet DESC";
            break;

            case "naz":
                $orderBy = "nome ASC";
            break;

            case "nza":
                $orderBy = "nome DESC";
            break;

            default:
                $orderBy = null;
        }

        $url = $this->route("pets?busca=${busca}&sexo=${sexo}&data-nasc-inicial=${dataInicial}&data-nasc-final=${dataFinal}&ordem=${ordem}&limite=${limite}");
        $pet = new Pet();
        $result = $pet->buscarComPaginacao(null, null, $whereArgs, $orderBy, $binding, $limite, $indice, $url);

        $pets       = DadosUtil::getValorArray($result, "dados", array());
        $paginacao  = DadosUtil::getValorArray($result, "paginacao", "");
        $totalItens = DadosUtil::getValorArray($result, "totalItens", 0);

        $this->setViewParam("pets", $pets);
        $this->setViewParam("paginacao", $paginacao);
        $this->setViewParam("totalItens", $totalItens);
        $this->render("pets/consulta_pets");
    }

    public function novo() 
    {
        $form = Sessao::obter("form", "pet");
        $this->setViewParam("edicao_pet", ValidacaoUtil::csrf("edicao_pet"));
        $this->setViewParam("form", $form);
        $this->render("pets/edicao_pet");
    }

    public function trajeto() 
    {
        $this->render("pets/monitoramento");
    }

    public function edicao($params) 
    {
        if (isset($params[0])) {
            $pet = new Pet();
            $pet->setCodigo($params[0]);
            $pet = $pet->encontrarPorId();
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
            $this->setViewParam("edicao_pet", ValidacaoUtil::csrf("edicao_pet"));
            $this->setViewParam("form", $form);
            $this->render("pets/edicao_pet");
            var_dump($form);
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
            if (isset($codigo)) {
                $pet->setCodigo($codigo);
                $result= $pet->atualizar();
                $view = "pets/edicao/".$codigo;
            } else {
                $result = $pet->inserir();
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
        if (isset($params[0])) {
            $pet = new Pet();
            $pet->setCodigo($params[0]);
            $result = $pet->deletar();
            
            if ($result) {
                Mensagem::gravarMensagem("geral", "Pet deletado com sucesso!", Mensagem::SUCESSO);
            } else {
                Mensagem::gravarMensagem("geral", "Ocorreu um erro ao tentar deletar o pet", Mensagem::ERRO);
            }
        }

        $this->redirect("pets");
    }
}
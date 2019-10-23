<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\App;
use App\Lib\Mensagem;
use App\Lib\Sessao;
use App\Util\DadosUtil;
use DateTime;
use App\Model\Trajeto;
use App\Model\Pet;
use App\Model\Dono;

class MonitoramentoController extends Controller
{

    public function index()
    {
        $this->redirect("pets");
    }

    public function trajeto($params)
    {
        if (isset($params[0])) {

            $codigoPet = $params[0];
            $dataInicial = DadosUtil::getValorArray($_GET, "data-inicial");
            $dataFinal = DadosUtil::getValorArray($_GET, "data-final");
            $horaInicial = DadosUtil::getValorArray($_GET, "hora-inicial");
            $horaFinal = DadosUtil::getValorArray($_GET, "hora-final");
         
            $trajeto = new Trajeto();

            $pet = new Pet();
            $pet->setCodigo($codigoPet);
            $pet = $pet->encontrarPorId();

            if (empty($pet) || $pet->getDono()->getCodigo() != Sessao::obter("usuario", "codigo")) {
                Mensagem::gravarMensagem("geral", "O PET informado não foi encontrado", Mensagem::ERRO);
                $this->redirect("pets");
            }

            $trajetos = DadosUtil::getValorVar($pet->getTrajetos($dataInicial." ".$horaInicial, $dataFinal." ".$horaFinal), array());
            
            $coordenadas = "";

            foreach ($trajetos as $trajeto) {
                $coordenadas .= $trajeto->getLatitude().",".$trajeto->getLongitude().",";
            }

            $coordenadas = rtrim($coordenadas);

            $app_id = App::getEnvArray()["APP_ID"];
            $app_code = App::getEnvArray()["APP_CODE"];
            $baseUrl = "https://image.maps.api.here.com";
            $endpoint = "/mia/1.6/route?app_id=${app_id}&app_code=${app_code}"
                        ."&r=${coordenadas}"
                        ."&m=${coordenadas}"
                        ."&lc=FF0000FF"
                        ."&mthm=1"
                        ."&mlbl=0";

            $this->setViewParam("pet", $pet);
            $this->setViewParam("mapa-trajeto", $baseUrl.$endpoint);
            $this->setViewParam("trajetos", $trajetos);

            $this->render("pets/monitoramento", "Monitoramento do PET {$pet->getNome()}");
        }
        $this->redirect("pets");
    }

    public function gerarCoordenadas($params)
    {
        $trajeto = new Trajeto();
        $coords = $trajeto->gerarCoordenadasGeografica(5);
        $agora = new DateTime();
        $i = 1;
        $result = true;
        foreach ($coords as $coord) {
            $novaDataHora = $agora->add(new \DateInterval("PT10M"));
            $tr = new Trajeto();
            $tr->setCodigoPet($params[0]);
            $tr->setDataHora($novaDataHora->format("Y-m-d h:i:s"));
            $tr->setLatitude($coord["latitude"]);
            $tr->setLongitude($coord["longitude"]);
            $i++;

            $result = $tr->inserir();
        }
        if (is_bool($result)) {
            Mensagem::gravarMensagem("geral", "Coordenadas geradas com sucesso!", Mensagem::SUCESSO);
        } else {
            Mensagem::gravarMensagem("geral", "Ocorreu um erro ao gerar as coordenadas", Mensagem::ERRO);
        }
        $this->redirect("monitoramento/trajeto/{$params[0]}");
    }
}
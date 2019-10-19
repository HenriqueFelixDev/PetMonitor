<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\App;

class MonitoramentoController extends Controller
{

    public function index()
    {
        $app_id = App::getEnvArray()["APP_ID"];
        $app_code = App::getEnvArray()["APP_CODE"];
        $baseUrl = "https://image.maps.api.here.com";
        $endpoint = "/mia/1.6/route?app_id=${app_id}&app_code=${app_code}"
                    ."&r=-23.5503099,-46.6363896,-23.6003099,-46.6363896,-23.2503099,-46.6763896"
                    ."&m=-23.5503099,-46.6363896,-23.6003099,-46.6363896,-23.2503099,-46.6763896"
                    ."&lc=FF0000FF"
                    ."&mthm=1"
                    ."&mlbl=0";

        $this->setViewParam("trajeto", $baseUrl.$endpoint);

        $this->render("pets/monitoramento");
    }
}
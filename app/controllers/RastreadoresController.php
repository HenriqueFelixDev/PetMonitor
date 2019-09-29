<?php

namespace  App\Controllers;

use App\Controllers\Controller;

class RastreadoresController extends Controller{

    public function index() {
        $this->render("rastreadores/consulta_rastreadores");
    }

    public function ativacao() {
        $this->render("rastreadores/ativacao_rastreador");
    }

    public function selecaopet() {
        $this->render("rastreadores/selecao_pet");
    }

    public function ativar() {

    }

    public function selecionarPet() {
        
    }
}
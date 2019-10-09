<?php

namespace App\Controllers;

use App\Controllers\Controller;

class PetsController extends Controller {

    public function index() {
        $this->render("pets/consulta_pets");
    }

    public function novo() {
        $this->render("pets/edicao_pet");
    }

    public function trajeto() {
        $this->render("pets/monitoramento");
    }

    public function edicao() {
        $this->render("pets/edicao_pet");
    }

    public function salvar() {
    }
}
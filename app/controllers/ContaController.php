<?php

namespace App\Controllers;

use App\Controllers\Controller;

class ContaController extends Controller {

    public function index() {
        $this->render("conta/minha_conta");
    }

    public function alteracaoSenha() {
        $this->render("conta/altera_senha");
    }

    public function alterarSenha() {

    }

    public function salvar() {
        
    }
}
<?php

namespace App\Controllers;

use App\App;
use App\Controllers\Controller;
use Exception;

class ErroController extends Controller
{
    private $exception;
    public function __construct(App $app, Exception $e)
    {
        parent::__construct($app);
        $this->exception = $e;
    }
    public function index()
    {
        $codigo = $this->exception->getCode();
        $this->setViewParam("msgErro", $this->exception->getMessage());
        $this->render("erros/".$codigo, "Erro ".$codigo);
    }
}
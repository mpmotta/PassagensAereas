<?php
namespace App\Controller;
use App\Model\Voo;

class VooController {
    private $model;

    public function __construct($db) { 
        $this->model = new Voo($db); 
    }

    public function pesquisar($origem, $destino, $data) {
        return $this->model->gerarVoosDinamicos($origem, $destino, $data);
    }

    public function autocomplete($termo) {
        return $this->model->buscarLocais($termo);
    }

    public function salvarVooFisico($dados) {
        return $this->model->persistirVoo($dados);
    }
}
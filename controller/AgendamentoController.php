<?php
namespace App\Controller;
use App\Model\Agendamento;

class AgendamentoController {
    private $model;

    public function __construct($db) {
        $this->model = new Agendamento($db);
    }

    public function salvar($ida, $volta, $adultos, $criancas, $total) {
        return $this->model->criar($ida, $volta, $adultos, $criancas, $total);
    }

    public function atualizar($id, $ida, $volta, $adultos, $criancas, $total) {
        return $this->model->atualizar($id, $ida, $volta, $adultos, $criancas, $total);
    }

    public function listar() {
        return $this->model->listar();
    }

    public function cancelar($id) {
        return $this->model->cancelar($id);
    }
}
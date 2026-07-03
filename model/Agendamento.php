<?php
namespace App\Model;
use PDO;

class Agendamento {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($voo_ida, $voo_volta, $adultos, $criancas, $total) {
        $stmt = $this->conn->prepare("INSERT INTO agendamentos (voo_ida_id, voo_volta_id, qtd_adultos, qtd_criancas, valor_total) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$voo_ida, $voo_volta, $adultos, $criancas, $total]);
    }

    public function atualizar($id, $voo_ida, $voo_volta, $adultos, $criancas, $total) {
        $stmt = $this->conn->prepare("UPDATE agendamentos SET voo_ida_id = ?, voo_volta_id = ?, qtd_adultos = ?, qtd_criancas = ?, valor_total = ?, status = 'Confirmada' WHERE id = ?");
        return $stmt->execute([$voo_ida, $voo_volta, $adultos, $criancas, $total, $id]);
    }

    public function listar() {
        $sql = "SELECT a.*, 
                       o_ida.nome as origem_ida, d_ida.nome as destino_ida, v_ida.data_voo as data_ida, v_ida.horario as horario_ida, v_ida.preco_base as preco_base_ida,
                       o_vta.nome as origem_volta, d_vta.nome as destino_volta, v_vta.data_voo as data_volta, v_vta.horario as horario_volta, v_vta.preco_base as preco_base_volta
                FROM agendamentos a 
                JOIN voos v_ida ON a.voo_ida_id = v_ida.id 
                JOIN locais o_ida ON v_ida.origem_id = o_ida.id 
                JOIN locais d_ida ON v_ida.destino_id = d_ida.id
                LEFT JOIN voos v_vta ON a.voo_volta_id = v_vta.id
                LEFT JOIN locais o_vta ON v_vta.origem_id = o_vta.id
                LEFT JOIN locais d_vta ON v_vta.destino_id = d_vta.id
                ORDER BY a.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelar($id) {
        $stmt = $this->conn->prepare("UPDATE agendamentos SET status = 'Cancelada' WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
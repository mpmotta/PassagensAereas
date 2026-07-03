<?php
namespace App\Model;
use PDO;

class Voo {
    private $conn;

    public function __construct($db) { 
        $this->conn = $db; 
    }

    public function obterLocalPorNome($nome) {
        $stmt = $this->conn->prepare("SELECT * FROM locais WHERE nome = ?");
        $stmt->execute([$nome]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function gerarVoosDinamicos($origem, $destino, $data) {
        $locais = $this->obterIdsLocais($origem, $destino);
        if (!$locais) return [];

        $distancia = abs($locais['o_id'] - $locais['d_id']);
        $precoBase = 500 + ($distancia * 50);

        $dataObj = new \DateTime($data);
        $mes = (int)$dataObj->format('m');
        $diaSemana = (int)$dataObj->format('w');

        if (in_array($mes, [1, 7, 12])) $precoBase *= 1.5;
        if (in_array($diaSemana, [2, 3])) $precoBase *= 0.8;
        if (in_array($diaSemana, [5, 0])) $precoBase *= 1.2;

        $horarios = ['02:30', '08:15', '13:45', '17:20', '22:10'];
        $voos = [];

        foreach ($horarios as $idx => $h) {
            $precoFinal = $precoBase;
            $horaH = (int)explode(':', $h)[0];
            if ($horaH >= 0 && $horaH <= 5) $precoFinal *= 0.7;

            $voos[] = [
                'id_virtual' => "VIRT-" . time() . "-$idx",
                'origem_id' => $locais['o_id'],
                'destino_id' => $locais['d_id'],
                'origem_nome' => $origem,
                'destino_nome' => $destino,
                'preco_base' => round($precoFinal, 2),
                'data_voo' => $data,
                'horario' => $h . ':00'
            ];
        }
        return $voos;
    }

    private function obterIdsLocais($o, $d) {
        $stmt = $this->conn->prepare("SELECT (SELECT id FROM locais WHERE nome = ?) as o_id, (SELECT id FROM locais WHERE nome = ?) as d_id");
        $stmt->execute([$o, $d]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarLocais($termo) {
        $stmt = $this->conn->prepare("SELECT nome FROM locais WHERE nome LIKE ? LIMIT 10");
        $stmt->execute(["%$termo%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function persistirVoo($dados) {
        $stmt = $this->conn->prepare("INSERT INTO voos (origem_id, destino_id, preco_base, data_voo, horario) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$dados['origem_id'], $dados['destino_id'], $dados['preco_base'], $dados['data_voo'], $dados['horario']]);
        return $this->conn->lastInsertId();
    }
}
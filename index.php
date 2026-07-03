<?php
spl_autoload_register(function ($class) {
    $class = str_replace('App\\', '', $class);
    $file = str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Config\Conexao;
use App\Controller\VooController;
use App\Controller\AgendamentoController;

$action = $_GET['action'] ?? 'index';

if ($action !== 'index') {
    header('Content-Type: application/json');
}

try {
    $db = Conexao::getConnection();
    $vooController = new VooController($db);
    $agendamentoController = new AgendamentoController($db);

    if ($action == 'autocomplete') {
        echo json_encode($vooController->autocomplete($_GET['termo'] ?? ''));
    } elseif ($action == 'pesquisar') {
        $dataIda = !empty($_GET['data_ida']) ? $_GET['data_ida'] : date('Y-m-d');
        echo json_encode($vooController->pesquisar($_GET['origem'] ?? '', $_GET['destino'] ?? '', $dataIda));
    } elseif ($action == 'reservar') {
        $data = json_decode(file_get_contents('php://input'), true);
        $vooIdaFisico = $vooController->salvarVooFisico($data['voo_ida_detalhes']);
        $vooVoltaFisico = isset($data['voo_volta_detalhes']) ? $vooController->salvarVooFisico($data['voo_volta_detalhes']) : null;
        $sucesso = $agendamentoController->salvar($vooIdaFisico, $vooVoltaFisico, $data['adultos'], $data['criancas'], $data['total']);
        echo json_encode(['sucesso' => $sucesso]);
    } elseif ($action == 'atualizar_reserva') {
        $data = json_decode(file_get_contents('php://input'), true);
        $vooIdaFisico = $vooController->salvarVooFisico($data['voo_ida_detalhes']);
        $vooVoltaFisico = isset($data['voo_volta_detalhes']) ? $vooController->salvarVooFisico($data['voo_volta_detalhes']) : null;
        $sucesso = $agendamentoController->atualizar($data['id_reserva'], $vooIdaFisico, $vooVoltaFisico, $data['adultos'], $data['criancas'], $data['total']);
        echo json_encode(['sucesso' => $sucesso]);
    } elseif ($action == 'listar_reservas') {
        echo json_encode($agendamentoController->listar());
    } elseif ($action == 'cancelar_reserva') {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode(['sucesso' => $agendamentoController->cancelar($data['id'])]);
    } elseif ($action == 'index') {
        require_once 'view/index.php';
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}
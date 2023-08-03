<?php

header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/SaleController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    if (!$action) {
        echo json_encode(['status' => 'error', 'message' => 'Ação desconhecida']);
        return;
    }

    if ($action === 'create') {
        $saleData = $_POST['saleData'];

        if ($saleData === null) {
            echo json_encode(['status' => 'error', 'message' => 'Dados de venda inválidos']);
            return;
        }

        $salesController = new SaleController();
        $result = $salesController->createSale($saleData);

        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Falha ao criar venda']);
        }

        echo json_encode(['status' => 'success']);
    }
}

<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/DashboardController.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    if (!$action) {
        echo json_encode(['status' => 'error', 'message' => 'Ação desconhecida']);
        return;
    }

    if ($action === 'updateGoalOfDay') {
        $id = $_POST['id'];
        $goalOfDay = $_POST['goalOfDay'];

        $dashboardController = new DashboardController();
        $result = $dashboardController->updateGoalOfDay($id, $goalOfDay);

        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Falha ao criar produto']);
            return;
        }

        echo json_encode(['status' => 'success']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null;

    if (!$action) {
        echo json_encode(['status' => 'error', 'message' => 'Ação não especificada']);
        return;
    }

    if ($action === 'getSalesOfToday') {
        $dashboardController = new DashboardController();
        $result = $dashboardController->getSalesOfToday();
        echo $result;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ação desconhecida']);
    }
}

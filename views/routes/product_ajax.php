<?php

header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if (!$action) {
        echo json_encode(['status' => 'error', 'message' => 'Ação desconhecida']);
        return;
    }

    if ($action === 'create') {
        $product     = $_POST['product'];
        $typeProduct = $_POST['typeProduct'];
        $name        = $_POST['name'];
        $description = $_POST['description'];
        $price       = $_POST['price'];
        $tax         = $_POST['tax'];

        $productController = new ProductController();
        $result = $productController->createProduct($product, $typeProduct, $name, $description, $price, $tax);

        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Falha ao criar produto']);
            return;
        }

        echo json_encode(['status' => 'success']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if (!$action) {
        echo json_encode(['status' => 'error', 'message' => 'Ação desconhecida']);
        return;
    }

    if ($action === 'getProductById') {
        $id = $_POST['id'];

        $productController = new ProductController();
        $result = $productController->getProductById($id);

        if (!$result) {
            echo json_encode(null);
        }

        echo json_encode($result);

    }
}

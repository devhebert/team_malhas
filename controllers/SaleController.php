<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/models/SaleModel.php';

class SaleController {
    private SaleModel $saleModel;

    public function __construct() {
        $this->saleModel = new SaleModel();
    }

    public function createSale($saleData): bool|string
    {
        try {
            return  $this->saleModel->createSale($saleData);
        } catch (Exception $e) {
            return json_encode(["error" => "Ocorreu um erro ao criar a venda: " . $e->getMessage()]);
        }
    }

    public function getSalesByPagination(int $current_page, int $limit_per_page): array|string
    {
        try {
            return  $this->saleModel->getSalesByPagination($current_page, $limit_per_page);
        } catch (Exception $e) {
            return json_encode(["error" => "Ocorreu um erro ao obter as vendas: " . $e->getMessage()]);
        }
    }
}

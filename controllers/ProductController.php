<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/models/ProductModel.php';

class ProductController {
    private ProductModel $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function createProduct($product, $typeProduct, $name, $description, $price, $tax): bool|string
    {
        try {
            if (empty($product) || empty($typeProduct) || empty($name)  || empty($price)) {
                return json_encode(["error" => "Parâmetros inválidos. Certifique-se de fornecer todos os dados corretamente."]);
            }

            return $this->productModel->createProducts($product, $typeProduct, $name, $description, $price, $tax);
        } catch (Exception $e) {
            return json_encode(["error" => "Ocorreu um erro ao criar o produto: " . $e->getMessage()]);
        }
    }

    public function getAllProducts()
    {
        try {
            return $this->productModel->getAllProducts();
        } catch (Exception $e) {
            return json_encode(["error" => "Ocorreu um erro ao obter so produto: " . $e->getMessage()]);
        }
    }

    public function getProductById($id) {
        try {
            if (empty($id)) {
                return json_encode(["error" => "Ocorreu um erro ao processar a solicitação. Por favor, tente novamente mais tarde."]);
            }

            return  $this->productModel->getProductById($id);
        } catch (Exception $e) {
            return json_encode(["error" => "Ocorreu um erro ao obter o produto: " . $e->getMessage()]);
        }
    }

    public function getProductsByPagination(int $current_page, int $limit_per_page): array|string
    {
        try {
            if (empty($current_page) || empty($limit_per_page)) {
                return json_encode(["error" => "Ocorreu um erro ao processar a solicitação. Por favor, tente novamente mais tarde."]);
            }

            return $this->productModel->getProductsByPagination($current_page, $limit_per_page);
        } catch (Exception $e) {
            return json_encode(["error" => "Ocorreu um erro ao obter os produtos: " . $e->getMessage()]);
        }
    }
}

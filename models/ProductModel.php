<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/connection/Connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/enum/ProductEnum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/enum/TypeProductEnum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/Paginate.php';

use Enum\ProductEnum;
use Enum\TypeProductEnum;
const DEFAULT_VALUE = 0.00;
const DEFAULT_DESCRIPTION = 'Sem descrição';

class ProductModel extends Connect {
    private string $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'products';
    }

    public function createProducts(int $product, int $typeProduct, string $name, string $description, float $price, float $tax): bool
    {
        if (!$this->isValidProductData($product, $typeProduct, $name, $price)) {
            return false;
        }

        $product     = ProductEnum::getProductName($product);
        $typeProduct = TypeProductEnum::getTypeProductName($typeProduct);
        $name        = $name;
        $description = !empty($description) ? $description : DEFAULT_DESCRIPTION;
        $price       = $price;
        $tax         = !empty($tax) ? $tax : DEFAULT_VALUE;

        $sql = "INSERT INTO $this->table (product, type_product, name, description, price, tax)";
        $sql .= " VALUES (:product, :typeProduct, :name, :description, :price, :tax)";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':product', $product);
            $stmt->bindParam(':typeProduct',$typeProduct);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':tax', $tax);

            if (!$stmt->execute()) {
                return false;
            }

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllProducts() {
        $sql  = " SELECT id, product, type_product, description, name, price, tax";
        $sql .= " FROM $this->table";
        $sql .= " ORDER BY name ASC";

        return $this->connection->query($sql);
    }

    public function getProductsByPagination(int $current_page, int $limit_per_page): array
    {
        $paginate = new Paginate($this->getCountProduct(), $current_page, $limit_per_page);
        $sql  = " SELECT id, product, type_product, description, name, price, tax";
        $sql .= " FROM $this->table";
        $sql .= " ORDER BY name ASC";
        $sql .= " LIMIT " . $limit_per_page . " OFFSET " . $paginate->getLimitOffset();
        error_log($sql);
        return [
            'data'  => $this->connection->query($sql),
            'pages' => $paginate->generatePaginationData($current_page)
        ];
    }

    private function getCountProduct(): int
    {
        $query = $this->connection->query("SELECT COUNT(*) AS qtd FROM {$this->table}");
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return !empty($data['qtd']) ? (int)$data['qtd'] : 0;
    }

    public function getProductById($id)
    {
        $productId = (int) $id;
        $sql = $this->connection->prepare("SELECT * FROM $this->table WHERE id = :id");
        $sql->bindParam(':id', $productId);
        $sql->execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return $result;
    }

    public function isValidProductData(int $product, int $typeProduct, string $name, float $price): bool
    {
        if(empty($product) || empty($typeProduct) || empty($name) || empty($price)) {
            return false;
        }

        return true;
    }
}

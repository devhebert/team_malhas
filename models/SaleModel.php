<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/connection/Connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/Paginate.php';

class SaleModel extends Connect {
    private string $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'sales';
    }

    public function createSale(array $saleData): bool
    {
        if (empty($saleData['saleItems'])) {
            return false;
        }

        $success = true;

        foreach ($saleData['saleItems'] as $item) {
            $productId = $item['id'];
            $quantity  = $item['quantity'];
            $total     = $item['totalValue'];

            $sql = "INSERT INTO $this->table (product_id, quantity, total) VALUES (:productId, :quantity, :total)";

            try {
                $stmt = $this->connection->prepare($sql);
                $stmt->bindParam(':productId', $productId);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':total', $total);

                if (!$stmt->execute()) {
                    $success = false;
                }
            } catch (PDOException $e) {
                $success = false;
            }
        }

        return $success;
    }

    public function getSalesByPagination(int $current_page, int $limit_per_page): array
    {
        $paginate = new Paginate($this->getCountSales(), $current_page, $limit_per_page);
        $sql  = " SELECT * from $this->table as s LEFT JOIN products as p ON s.product_id= p.id";
        $sql .= " ORDER BY s.date_created DESC";
        $sql .= " LIMIT " . $limit_per_page . " OFFSET " . $paginate->getLimitOffset();

        return [
            'data'  => $this->connection->query($sql),
            'pages' => $paginate->generatePaginationData($current_page)
        ];
    }

    private function getCountSales(): int
    {
        $query = $this->connection->query("SELECT COUNT(*) AS qtd FROM {$this->table}");
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return !empty($data['qtd']) ? (int)$data['qtd'] : 0;
    }

}
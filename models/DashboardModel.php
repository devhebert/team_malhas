<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/connection/Connect.php';

class DashboardModel extends Connect
{
    private string $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'dashboards';
    }

    public function getSalesOfToday()
    {
        $this->table = 'sales';
        $sql  = " WITH tab1 AS (";
        $sql .= "   SELECT DATE_TRUNC('day', date_created) AS sales_date,";
        $sql .= "       COALESCE(SUM(total), 0) AS total_sales,";
        $sql .= "       (SELECT goal_of_day FROM dashboards LIMIT 1) AS goal_of_day";
        $sql .= "   FROM $this->table";
        $sql .= "   WHERE DATE(date_created) = CURRENT_DATE";
        $sql .= "   GROUP BY sales_date";
        $sql .= "   ORDER BY sales_date";
        $sql .= " )";
        $sql .= " SELECT tab1.*, ";
        $sql .= "   CASE ";
        $sql .= "       WHEN (tab1.goal_of_day - tab1.total_sales) < 0 OR tab1.total_sales IS NULL THEN 0 ";
        $sql .= "       ELSE (tab1.goal_of_day - tab1.total_sales) ";
        $sql .= "   END AS goal_ok ";
        $sql .= " FROM tab1;";

        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGoalOfDay()
    {
        $sql  = " SELECT * FROM $this->table WHERE id=1";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateGoalOfDay(int $id, float $goalOfDay): bool
    {
        if (empty($id) || empty($goalOfDay)) {
            return false;
        }

        $sql = "UPDATE $this->table SET goal_of_day=:goalOfDay WHERE id=:id";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':goalOfDay', $goalOfDay);
            $stmt->bindParam(':id', $id);

            if (!$stmt->execute()) {
                return false;
            }
            return true;

        } catch (PDOException $e) {
            return false;
        }
    }
}
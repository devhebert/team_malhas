<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/models/DashboardModel.php';
class DashboardController
{
    private DashboardModel $dashboardModel;

    public function __construct() {
        $this->dashboardModel = new DashboardModel();
    }

    public function getSalesOfToday(): false|string
    {
        try {
            $data = $this->dashboardModel->getSalesOfToday();
            return json_encode($data);
        } catch (Exception $e) {
            return json_encode(["error" => "Ocorreu um erro ao obter as vendas: " . $e->getMessage()]);
        }
    }

    public function getGoalOfDay(): false|string
    {
        try {
            $data = $this->dashboardModel->getGoalOfDay();
            return json_encode($data);
        } catch (Exception $e) {
            return json_encode(["error" => "Ocorreu um erro ao obter as vendas: " . $e->getMessage()]);
        }
    }

    public function updateGoalOfDay(int $id, float $goalOfDay): false|string
    {
        try {
            if (empty($id) || empty($goalOfDay)) {
                return json_encode(["error" => "Parâmetros inválidos. Certifique-se de fornecer uma meta do dia válida."]);
            }

            $data = $this->dashboardModel->updateGoalOfDay($id, $goalOfDay);
            return json_encode($data);
        } catch (Exception $e) {
            return json_encode(["error" => "Ocorreu um erro ao obter as vendas: " . $e->getMessage()]);
        }
    }
}
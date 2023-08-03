<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/DashboardController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initial Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/index.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<?php
$dashboard = new DashboardController();
$dashboardData = $dashboard->getGoalOfDay();
$dataArray = json_decode($dashboardData, true);

if ($dataArray && is_array($dataArray) && count($dataArray) > 0) {
    $id = $dataArray[0]['id'];
    $goalOfDay = $dataArray[0]['goal_of_day'];
}
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="position-sticky">
                <?php include 'components/sidebar.php'; ?>
            </div>
        </nav>

        <main class="col-md-10 px-md-4">
            <div class="container mt-5">
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title custom-font">Meta do dia</h3>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <div id="chart"></div>
                        <div id="chart-input-goal">
                            <div class="input-group mb-3">
                                <label class="input-group-text">Meta do dia</label>
                                <input type="hidden" id="id-goal-of-day" value="<?= $id ?>">
                                <input type="text" class="form-control" id="goal-of-day" value="<?= 'R$ ' . number_format($goalOfDay, 2, ',', '.'); ?>">
                                <button class="btn btn-primary btn-tm rounded" id="btn-save-goal">Salvar</button>
                                <div id="message-div" class="alert alert-warning mt-3" role="alert"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.3/dist/apexcharts.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/dashboard.js"></script>
<script src="/assets/js/utils.js"></script>

</body>
</html>

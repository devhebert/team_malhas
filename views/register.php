<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/enum/ProductEnum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/enum/TypeProductEnum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/SaleController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/index.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'components/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header custom-font">
                        <h2>Registro de vendas por item</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr class="custom-font">
                                    <th>Data</th>
                                    <th>Produto</th>
                                    <th>Tipo de produto</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Taxa</th>
                                    <th>Quantidade</th>
                                    <th>Valor Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sales = new SaleController();
                                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $limit_per_page = 10;
                                    $paginate_views_sales = $sales->getSalesByPagination($current_page, $limit_per_page);

                                    if (empty($paginate_views_sales['data'])) {
                                            echo '<tr><td colspan="9" class="text-center">Nenhum registro encontrado.</td></tr>';
                                    } else {
                                        foreach ($paginate_views_sales['data'] as $data): ?>
                                            <tr>
                                                <td><?= date('d/m/Y H:i:s', strtotime($data['date_created'])) ?></td>
                                                <td><?= Enum\ProductEnum::showProductName($data['product']) ?></td>
                                                <td><?= Enum\TypeProductEnum::showTypeProductName($data['type_product']) ?></td>
                                                <td><?= $data['name'] ?></td>
                                                <td><?= ucfirst(strtolower($data['description'])) ?></td>
                                                <td><?= 'R$ ' . number_format($data['price'], 2, ',', '.') ?></td>
                                                <td><?= number_format($data['tax'], 2, ',', '.') . '%' ?></td>
                                                <td><?= $data['quantity'] ?></td>
                                                <td><?= 'R$ ' . number_format($data['total'], 2, ',', '.')  ?></td>
                                            </tr>
                                        <?php endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            if (!empty($paginate_views_sales['data'])) {
                                echo '<div class="dynamic-pagination col text-center mb-3 custom-font">' . $paginate_views_sales['pages'] . '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<br><br>
<?php include 'components/footer.php'; ?>

<?php include __DIR__ . '/modal/modal-create-product.html'; ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/product.js"></script>
<script src="/assets/js/utils.js"></script>

</body>
</html>

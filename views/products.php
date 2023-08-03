<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/enum/ProductEnum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/enum/TypeProductEnum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/ProductController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
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
                        <h2>Produtos</h2>
                        <button type="button" id="btn-create-new-product" class="btn btn-primary btn-sm btn-tm" data-toggle="modal">Adicionar Produto</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr class="custom-font">
                                    <th>Produto</th>
                                    <th>Tipo de produto</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Taxa</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $products = new ProductController();
                                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $limit_per_page = 10;
                                    $paginate_views_product = $products->getProductsByPagination($current_page, $limit_per_page);

                                    if (empty($paginate_views_product['data'])) {
                                        echo '<tr><td colspan="6" class="text-center">Nenhum produto encontrado.</td></tr>';
                                    } else {
                                        foreach ($paginate_views_product['data'] as $data): ?>
                                            <tr>
                                                <td><?= Enum\ProductEnum::showProductName($data['product']) ?></td>
                                                <td><?= Enum\TypeProductEnum::showTypeProductName($data['type_product']) ?></td>
                                                <td><?= $data['name'] ?></td>
                                                <td><?= $data['description'] ?></td>
                                                <td><?= 'R$ ' . number_format($data['price'], 2, ',', '.') ?></td>
                                                <td><?= number_format($data['tax'], 2, ',', '.') . '%' ?></td>
                                            </tr>
                                        <?php endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                                if (!empty($paginate_views_product['data'])) {
                                    echo '<div class="dynamic-pagination col text-center mb-3 custom-font">' . $paginate_views_product['pages'] . '</div>';
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

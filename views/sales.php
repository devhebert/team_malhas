<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/enum/ProductEnum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/enum/TypeProductEnum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/ProductController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="/assets/css/index.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<?php
$products = new ProductController();
$productsData = $products->getAllProducts();
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'components/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header custom-font">
                        <h2>Vendas</h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="venda">Produto *</label>
                            <select class="form-select" id="product-select-sales" name="produto">
                                <option value="">Selecione um produto</option>
                                <?php
                                if (isset($productsData)) {
                                    foreach ($productsData as $produto) {
                                        echo
                                            '<option value="' . $produto['id'] . '">' .
                                            "Produto: " . Enum\ProductEnum::showProductName($produto['product']) .
                                            " - Tipo de produto: " . Enum\TypeProductEnum::showTypeProductName($produto['type_product']) .
                                            " - Nome: " . $produto['name'] .
                                            " - Valor : R$" . number_format($produto['price'], 2, ',', '.') .
                                            " - Imposto: " . number_format($produto['tax'], 2, ',', '.') . "%";
                                            '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantidade">Quantidade *</label>
                            <input type="number" class="form-control" id="product-quantity" name="quantidade" placeholder="Ex: 1" required>
                        </div>
                        <button id="btn-add-product-sale-list" class="btn btn-primary btn-tm custom-font">Adicionar à venda</button>

                        <table class="table mt-4">
                            <thead>
                                <tr class="custom-font">
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço Unitário</th>
                                    <th>Imposto</th>
                                    <th>Valor Total</th>
                                </tr>
                            </thead>
                            <tbody id="sale-items"></tbody>
                        </table>

                        <div class="mt-4">
                            <p class="totalizadores">Total da Compra: R$ <span id="total-purchase">0.00</span>
                            </p>
                            <p class="totalizadores">Total dos Impostos: R$ <span id="total-taxes">0.00</span>
                            </p>
                        </div>
                        <button id="btn-finish-sale" class="btn btn-primary btn-tm custom-font">Finalizar venda</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<br><br>
<?php include 'components/footer.php'; ?>

<?php
include __DIR__ . '/modal/modal-create-product.html';
?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/sales.js"></script>
<script src="/assets/js/utils.js"></script>

</body>
</html>

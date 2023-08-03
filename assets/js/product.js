$(document).ready(function () {
    $('#btn-create-new-product').on('click', function () {
        $('#add-new-product-modal').modal('show');
    });
});

function create() {
    const product = $('#product-select').val();
    const typeProduct = $('#type-product-select').val();
    const name = $('#product-name').val().trim();
    const description = $('#product-description').val().trim();
    const price = parseFloat($('#product-price').maskMoney('unmasked')[0]);
    const tax = parseFloat($('#product-tax').maskMoney('unmasked')[0]);

    const inputs = [product, typeProduct, name, price];
    if(!isRequiredInputs(inputs)) return;

    const inputsNumber = [price, tax];
    if(!isValidNumber(inputsNumber)) return;

    $.ajax({
        url: 'routes/product_ajax.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            product: product,
            typeProduct: typeProduct,
            name: name,
            description: description,
            price: price,
            tax: tax,
            action : 'create'
        },
        success: function(data) {
            console.log(data);
            Swal.fire({
                iconHtml: ICON_SUCCESS,
                title: 'Sucesso',
                text: 'Produto criado com sucesso!',
                timer: 2000
            });
            setTimeout(addBtnTmClass, 10);

            $('#add-new-product-modal').modal('hide');

            setTimeout(function() {
                window.location.reload();
            }, 500);
        },
        error: function(xhr, status, error) {
            console.error(error);
            Swal.fire({
                iconHtml: ICON_ERROR,
                title: 'Oops...',
                text:  'Ocorreu um erro durante a operação. Por favor, tente novamente mais tarde.',
                timer: 2000
            });
            setTimeout(addBtnTmClass, 10);
        }
    });
}


$('#create-new-product').on('click', create);

$(document).ready(function () {
    addMaskMoney('#product-price');
    addMaskPercentage('#product-tax');
});

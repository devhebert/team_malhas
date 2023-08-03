function addProductInSaleList() {
    const id = $("#product-select-sales").val();
    const quantity = parseInt($("#product-quantity").val());

    const inputs = [id, quantity];

    if (!isRequiredInputs(inputs)) return;
    if (!isValidNumber(inputs)) return;

    $.ajax({
        url: "routes/product_ajax.php",
        method: "POST",
        dataType: "JSON",
        data: {
            id: id,
            action: 'getProductById'
        },
        success: function (data) {
            console.log(data);

            const unitPrice = parseFloat(data.price);
            const tax = parseFloat(data.tax);
            const totalProductValue = quantity * unitPrice;
            const totalTaxValue = totalProductValue * (tax / 100);
            const totalValue = quantity * unitPrice + totalTaxValue;

            const row =
                "<tr>" +
                    "<td>"
                        + data.name +
                    "</td>" +
                    "<td>"
                        + quantity +
                    "</td>" +
                    "<td>"
                        + unitPrice.toFixed(2) +
                    "</td>" +
                    "<td>"
                        + totalTaxValue.toFixed(2) +
                    "</td>" +
                    "<td>"
                        + totalValue.toFixed(2) +
                    "</td>" +
                    "<td>"
                        + "<input type='hidden' name='productId' value='" + data.id + "'>" +
                    "</td>" +
                "</tr>";
            $("#sale-items").append(row);

            const totalPurchase = parseFloat($("#total-purchase").text());
            const totalTaxes = parseFloat($("#total-taxes").text());
            $("#total-purchase").text((totalPurchase + totalValue).toFixed(2));
            $("#total-taxes").text((totalTaxes + totalTaxValue).toFixed(2));

            $("#product-select-sales").val("");
            $("#product-quantity").val("");
        },
        error: function (xhr) {
            console.log(xhr)
            Swal.fire({
                iconHtml: ICON_ERROR,
                title: 'Oops...',
                text: 'Ocorreu um erro durante a operação. Por favor, tente novamente mais tarde.',
                timer: 2000
            });
        }
    });
}

function finishSale() {
    const totalPurchase = parseFloat($('#total-purchase').text());
    const totalTaxes = parseFloat($('#total-taxes').text());
    const saleItems = [];

    if (!isValidFinishSale(totalPurchase)) return;

    $("#sale-items tr").each(function () {
        const id = $(this).find("input[name='productId']").val();
        const product = $(this).find("td:eq(0)").text();
        const quantity = parseInt($(this).find("td:eq(1)").text());
        const unitPrice = parseFloat($(this).find("td:eq(2)").text());
        const tax = parseFloat($(this).find("td:eq(3)").text());
        const totalValue = parseFloat($(this).find("td:eq(4)").text());

        saleItems.push({
            id: id,
            product: product,
            quantity: quantity,
            unitPrice: unitPrice,
            tax: tax,
            totalValue: totalValue
        });
    });

    const saleData = {
        totalPurchase: totalPurchase,
        totalTaxes: totalTaxes,
        saleItems: saleItems
    };

    $.ajax({
        url: "routes/sale_ajax.php",
        method: "POST",
        dataType: "JSON",
        data: {
            saleData: saleData,
            action: 'create'
        },
        success: function (data) {
            console.log(data);
            Swal.fire({
                iconHtml: ICON_SUCCESS,
                title: 'Sucesso',
                text: 'Venda criada com sucesso!',
                timer: 2000
            });
            setTimeout(addBtnTmClass, 10);

            $("#sale-items").empty();
            $("#total-purchase").text('0.00');
            $("#total-taxes").text('0.00');
        },
        error: function (xhr) {
            console.log(xhr);
            Swal.fire({
                iconHtml: ICON_ERROR,
                title: 'Oops...',
                text: 'Ocorreu um erro durante a operação. Por favor, tente novamente mais tarde.',
                timer: 2000
            });
            setTimeout(addBtnTmClass, 10);
        }
    });
}

function isValidFinishSale(totalPurchase) {
    if (totalPurchase === '0'|| totalPurchase === 0) {
        Swal.fire({
            iconHtml: ICON_ERROR,
            title: 'Oops...',
            text: 'Para finalizar a venda, selecione um produto e adicione a quantidade desejada.',
            timer: 2000
        });
        setTimeout(addBtnTmClass, 10);

        return false;
    }
    return true;
}

$('#btn-add-product-sale-list').on('click', addProductInSaleList)
$('#btn-finish-sale').on('click', finishSale);


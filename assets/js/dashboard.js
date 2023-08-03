$(document).ready(function () {
    const options = {
        series: [0, 0.01],
        chart: {
            height: 450,
            width: 800,
            type: 'pie',
        },
        colors: ['#d5ab21', '#0b385d'],
        labels: ['Vendas do dia', 'Meta do dia'],
        tooltip: {
            y: {
                formatter: function (val) {
                    return `R$ ${val.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`;
                }
            }
        },
        responsive: [{
            breakpoint: 576,
            options: {
                chart: {
                    width: '100%',
                }
            }
        }],
    };

    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    $.ajax({
        url: 'routes/dashboard_ajax.php',
        method: 'GET',
        dataType: 'JSON',
        data: {
            action: 'getSalesOfToday'
        },
        success: function (data) {
            console.log("getSalesOfToday", data);

            const messageDiv = $('#message-div');

            if (data.length !== 0) {
                messageDiv.remove();
            }

            messageDiv.text("O gráfico será atualizado após a primeira venda.");

            const salesGoal = parseFloat(data[0].goal_ok);
            const totalSales = parseFloat(data[0].total_sales);

            chart.updateSeries([totalSales, salesGoal]);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);
        },
    });
});

function updateGoalOfDay() {
    const id = $('#id-goal-of-day').val();
    const goalOfDay = parseFloat($('#goal-of-day').maskMoney('unmasked')[0]);
    const inputs = [id, goalOfDay]

    if(!isValidNumber(inputs)) return;

    $.ajax({
        url: 'routes/dashboard_ajax.php',
        method: 'POST',
        dataType: 'JSON',
        data: {
            id: id,
            goalOfDay: goalOfDay,
            action: 'updateGoalOfDay'
        },
        success: function (data) {
            console.log(data);
            Swal.fire({
                iconHtml: ICON_SUCCESS,
                title: 'Sucesso',
                text: 'Meta atualizada com sucesso!',
                timer: 2000
            });
            setTimeout(addBtnTmClass, 10);

            setTimeout(function () {
                window.location.reload();
            }, 2000);
        },
        error: function (xhr) {
            console.error(xhr);
            Swal.fire({
                iconHtml: ICON_ERROR,
                title: 'Oops...',
                text: 'Ocorreu um erro durante a operação. Por favor, tente novamente mais tarde.',
                timer: 2000
            });
            setTimeout(addBtnTmClass, 10);
        },
    });
}

$('#btn-save-goal').on('click', updateGoalOfDay);

$(document).ready(function () {
    addMaskMoney('#goal-of-day');
});


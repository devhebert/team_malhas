const ICON_SUCCESS = '<div style="width: 50px; height: 50px; background-color: #2c911d; border-radius: 50%; display: flex; justify-content: center; align-items: center;"><img src="/assets/img/tm-logo-green%20-%20Copia.jpg" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 20px"></div>';
const ICON_ERROR = '<div style="width: 50px; height: 50px; background-color: rgba(220,12,12,0.78); border-radius: 50%; display: flex; justify-content: center; align-items: center;"><img src="/assets/img/tm-logo%20-%20Copia.jpg" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 20px"></div>';

function addMaskMoney(element) {
    $(element).maskMoney({
        prefix: 'R$ ',
        thousands: '.',
        decimal: ',',
        precision: 2
    });
}

function addMaskPercentage(element)
{
    $(element).maskMoney({
        suffix: '%',
        thousands: '.',
        decimal: ',',
        precision: 2
    });
}

function isRequiredInputs(inputs) {
    let inputNotNull = true;
    $.each(inputs, function(index, input) {
        if (!input || input.length === 0 || input === "") {
            Swal.fire({
                iconHtml: ICON_ERROR,
                title: 'Campos obrigatórios',
                text:  'Por favor, preencha todos os campos obrigatórios.',
                timer: 2000,
            });
            setTimeout(addBtnTmClass, 10);

            inputNotNull = false;
            return false;
        }
    });
    return inputNotNull;
}

function isValidNumber(inputs) {
    let inputNotNull = true;
    $.each(inputs, function(index, input) {
        if (input < 0) {
            Swal.fire({
                iconHtml: ICON_ERROR,
                title: 'Campos obrigatórios',
                text:  'O valor inserido não pode ser menor que 0.',
                timer: 2000,
            });
            setTimeout(addBtnTmClass, 10);

            inputNotNull = false;
            return false;
        }
    });
    return inputNotNull;
}

function addBtnTmClass() {
    const okButton = document.querySelector('.swal2-confirm');
    okButton.classList.add('btn-tm');
}

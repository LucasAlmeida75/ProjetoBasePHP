const baseUrl = window.location.protocol + "//" + window.location.host + "/ProjetoBasePHP/public";

document.addEventListener('DOMContentLoaded', () => {
    loadMasks();
});

function maskCellphone(input) {

    input.setAttribute('maxlength', '19');
    input.setAttribute('placeholder', '55 (00) 0 0000-0000');

    const inputValue = input.value.replace(/\D/g, '');

    const formato = inputValue.replace(/(\d{2})(\d{2})(\d{1})(\d{4})(\d{4})?/, '$1 ($2) $3 $4-$5');

    input.value = formato.trim();

}

function maskCpfCnpj(input) {

    input.setAttribute('maxlength', '18');

    let valor = input.value.replace(/\D/g, '');

    if (valor.length <= 11) {

        input.value = valor.replace(/(\d{3})(\d)/, '$1.$2')
                           .replace(/(\d{3})(\d)/, '$1.$2')
                           .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        input.value = valor.replace(/(\d{2})(\d)/, '$1.$2')
                           .replace(/(\d{3})(\d)/, '$1.$2')
                           .replace(/(\d{3})(\d)/, '$1/$2')
                           .replace(/(\d{4})(\d{1,2})$/, '$1-$2');
    }
}

function loadMasks() {
    //Cellphone
    document.querySelectorAll('.maskCellphone').forEach(input => { input.addEventListener('input', function() { maskCellphone(this); });});

    //CPF/CNPJ
    document.querySelectorAll('.maskCpfCnpj').forEach(input => { input.addEventListener('input', function() { maskCpfCnpj(this); });});
}

function processResponse(response) {
    response.text()
        .then(text => {
            if (text) {
                return JSON.parse(text);
            } else {
                return {};
            }
        });
}

function showErrors(data) {
    let msgErrors = "Por favor, corrija os campos informados abaixo:\n";
    Object.keys(data).forEach(field => {
        data[field].forEach(errorMessage => {
            const label = document.querySelector(`label[for="${field}"]`).textContent;
            msgErrors += `${label}:${errorMessage}\n`;
        });
    });

    alert(msgErrors);
}
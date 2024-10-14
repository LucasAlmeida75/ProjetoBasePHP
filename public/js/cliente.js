document.addEventListener('DOMContentLoaded', () => {
    const btnRegister = document.querySelector("#btnRegister");

    if (btnRegister) {
        btnRegister.addEventListener("click", function() { validateFields(); });
    }

    const btnRemoverCliente = document.querySelectorAll(".btnRemoverCliente");

    if (btnRemoverCliente) {
        btnRemoverCliente.forEach((element, index) => { element.addEventListener("click", function(e) { removeCustomer(index); }) });
    }
});

function validateFields() {
    const data = {
        validate  : true,
        cpf_cnpj  : document.getElementById("cpf_cnpj").value,
        name      : document.getElementById("name").value,
        email     : document.getElementById("email").value,
        cellphone : document.getElementById("cellphone").value,
    };

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    fetch(`${baseUrl}/cliente/validateCliente`, options)
    .then(response => {
        return processResponse(response);
    })
    .then(data => {
        if (data && Object.keys(data).length > 0) {
            showErrors(data);
        } else {
            document.getElementById("registerForm").submit();
        }
    })
    .catch(error => {
        console.error('Erro ao validar campos:', error);
    });
}

function removeCustomer(index) {
    if (window.confirm("Tem certeza que deseja remover o cliente?")) {
        const id = document.querySelectorAll(".idCliente")[index].value;

        fetch(`${baseUrl}/cliente/removeCustomer/${id}`)
        .then(response => {
            return processResponse(response);
        })
        .then(data => {
            if (!data || Object.keys(data).length == 0) {
                alert("Cliente removido com sucesso!");
                window.location.reload();
            } else {
                console.log(data);
            }
        })
        .catch(error => {
            console.error('Erro ao remover o cliente:', error);
        });
    }
}
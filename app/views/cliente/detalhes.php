<h1><?php echo isset($data["name"]) ? $data["name"] : "Novo cliente"; ?></h1>

<form id="registerForm" method="post" action="<?php echo $data["urlForm"]; ?>">
    <div class="mb-3">
        <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
        <input type="text" class="form-control maskCpfCnpj" name="cpf_cnpj" id="cpf_cnpj" required>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Nome do cliente</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" name="email" id="email">
    </div>
    <div class="mb-3">
        <label for="cellphone" class="form-label">Celular</label>
        <input type="text" class="form-control maskCellphone" name="cellphone" id="cellphone">
    </div>
    <button type="button" id="btnRegister" class="btn btn-primary">Registrar</button>
</form>
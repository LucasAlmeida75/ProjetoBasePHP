<div class="row">
    <div class="col-8">
        <h2><?php echo isset($data["cliente"]["name"]) ? $data["cliente"]["name"] : "Novo cliente"; ?></h2>
    </div>
    <div class="col-4">
        <button type="button" id="btnRegister" class="btn btn-success">
            <i class="bi bi-floppy"></i> Salvar
        </button>
        <a href="<?php echo $this->siteUrl("cliente/listar"); ?>" class="btn btn-primary" title="Voltar para a listagem de cliente.">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>

    </div>
</div>

<form id="registerForm" method="post" action="<?php echo $data["urlForm"]; ?>">
    <div class="mb-3">
        <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
        <input type="text" class="form-control maskCpfCnpj" name="cpf_cnpj" id="cpf_cnpj" required value="<?php echo isset($data["cliente"]["cpf_cnpj"]) ? $this->maskCpfCnpj($data["cliente"]["cpf_cnpj"]) : ""; ?>">
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Nome do cliente</label>
        <input type="text" class="form-control" name="name" id="name" required value="<?php echo isset($data["cliente"]["name"]) ? $data["cliente"]["name"] : ""; ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" name="email" id="email" value="<?php echo isset($data["cliente"]["email"]) ? $data["cliente"]["email"] : ""; ?>">
    </div>
    <div class="mb-3">
        <label for="cellphone" class="form-label">Celular</label>
        <input type="text" class="form-control maskCellphone" name="cellphone" id="cellphone" value="<?php echo isset($data["cliente"]["cellphone"]) ? $this->maskCellphone($data["cliente"]["cellphone"]) : ""; ?>">
    </div>
</form>
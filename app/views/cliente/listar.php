<h1>Clientes</h1>
<form action="<?php echo $this->siteUrl("cliente/listar"); ?>">
    <div class="row">
        <div class="mb-3 col-3">
            <input type="text" class="form-control" name="search" id="search" placeholder="Pesquisar..." value="<?php echo isset($data['search']) ? $data['search'] : ""; ?>">
        </div>

        <div class="col-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Pesquisar
            </button>
            <a href="<?php echo $this->siteUrl("cliente/detalhes"); ?>" class="btn btn-success">
                <i class="bi bi-plus"></i> Novo
            </a>
        </div>

    </div>

</form>

<?php if (isset($data["clientes"]) && count($data) > 0) { ?>
<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Ações</th>
            <th>CPF/CNPJ</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone Celular</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data["clientes"] as $cliente) { ?>
            <tr>
                <td>
                    <input type="hidden" class="idCliente" value="<?php echo $cliente["id"]; ?>">
                    <button type="button" class="btnRemoverCliente btn btn-danger btn-sm" title="Remover cliente.">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
                <td><?php echo isset($cliente["cpf_cnpj"]) ? $cliente["cpf_cnpj"] : ""; ?></td>
                <td><?php echo isset($cliente["name"]) ? $cliente["name"] : ""; ?></td>
                <td><?php echo isset($cliente["email"]) ? $cliente["email"] : ""; ?></td>
                <td><?php echo isset($cliente["cellphone"]) ? $cliente["cellphone"] : ""; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } else { ?>
<h5>Nenhum cliente encontrado!</h5>
<?php } ?>
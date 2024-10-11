<h2 class="text-center">Entrar</h2>
<form id="registerForm" method="post" action="<?php echo $this->siteUrl("user/save"); ?>">
    <div class="mb-3">
        <label for="username" class="form-label">Nome de Usuário</label>
        <input type="text" class="form-control" name="username" id="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Entrar</button>
</form>
<p class="mt-3 text-center">Não tem uma conta? <a href="<?php echo $this->siteUrl("user/signup"); ?>">Registre-se</a></p>
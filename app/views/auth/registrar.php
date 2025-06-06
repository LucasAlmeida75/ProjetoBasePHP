<div class="container d-flex align-items-center justify-content-center h-100vh">

    <form id="registerForm" method="post" class="border p-4 rounded" action="<?php echo $this->siteUrl("auth/signup"); ?>">
        <h2 class="text-center">Registro</h2>
        <div class="mb-3">
            <label for="username" class="form-label">Nome de Usuário</label>
            <input type="text" class="form-control" name="username" id="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirmar Senha</label>
            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
        <p class="mt-3 text-center">Já tem uma conta?
            <a href="<?php echo $this->siteUrl("auth/entrar"); ?>">Faça login</a>
        </p>
    </form>
    
</div>
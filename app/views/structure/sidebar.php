<div class="d-flex">
	<nav class="sidebar flex-shrink-0 p-3" id="sidebar">
		<h4 class="mt-2">Menu</h4>
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link active" href="#">
					<i class="bi bi-people-fill"></i> Clientes
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<i class="bi bi-cart4"></i> Produtos
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<i class="bi bi-card-text"></i> Pedidos
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<i class="bi bi-person-circle"></i> Usuários
				</a>
			</li>
		</ul>

		<div class="mt-auto">
			<button class="btn btn-secondary" id="themeToggle">
				<i class="fas fa-adjust"></i> Alternar Tema
			</button>
			<div class="dropdown mt-2">
				<a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="#" alt="User Image" class="rounded-circle me-2">
					<strong>Nome do Usuário</strong>
				</a>
				<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
					<li><a class="dropdown-item" href="#">Deslogar</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Botão para ocultar/exibir a sidebar, agora do lado externo -->
	<button class="btn btn-primary toggle-btn" id="toggleSidebar">
		<i class="fas fa-bars"></i>
	</button>

	<main class="flex-grow-1 p-4">
		<h2>Página Principal</h2>
		<p>Conteúdo principal aqui...</p>
	</main>
</div>
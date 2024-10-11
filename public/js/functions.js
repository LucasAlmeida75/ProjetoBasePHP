document.getElementById('toggleSidebar').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('hidden');
});

document.getElementById('toggleSidebar').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('hidden');
});

// Função para alternar entre o tema claro e escuro
const themeToggle = document.getElementById('themeToggle');
const themeStylesheet = document.getElementById('themeStylesheet');
themeToggle.addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
    const currentTheme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
    themeStylesheet.setAttribute('href', currentTheme === 'dark' 
        ? 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap-dark.min.css' 
        : 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
});
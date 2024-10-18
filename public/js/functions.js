const baseUrl = window.location.protocol + "//" + window.location.host + "/ProjetoBasePHP/public";

document.addEventListener('DOMContentLoaded', () => {
    initialize();
});

function initialize() {
    loadMasks();
    setupSidebarToggle();
    setupThemeToggle();
}

// === Funções para o Tema === //

function setupThemeToggle() {
    const themeToggle = document.getElementById('themeToggle');
    const html = document.querySelector('html');

    if (themeToggle) {
        const setTheme = (theme) => {
            if (theme === 'dark') {
                document.body.classList.add('dark-theme');
                themeToggle.textContent = 'Tema Claro'; // Atualiza o texto do botão
            } else {
                document.body.classList.remove('dark-theme');
                themeToggle.textContent = 'Tema Escuro'; // Atualiza o texto do botão
            }
            html.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme); // Armazena no localStorage
        };

        const currentTheme = localStorage.getItem('theme') || 'light';
        setTheme(currentTheme);

        themeToggle.addEventListener('click', () => {
            const newTheme = document.body.classList.contains('dark-theme') ? 'light' : 'dark';
            setTheme(newTheme);
        });
    }
}

// === Funções para Máscaras === //

function loadMasks() {
    setupCellphoneMask();
    setupCpfCnpjMask();
}

function setupCellphoneMask() {
    document.querySelectorAll('.maskCellphone').forEach(input => {
        input.addEventListener('input', () => maskCellphone(input));
    });
}

function setupCpfCnpjMask() {
    document.querySelectorAll('.maskCpfCnpj').forEach(input => {
        input.addEventListener('input', () => maskCpfCnpj(input));
    });
}

function maskCellphone(input) {
    input.setAttribute('maxlength', '19');
    input.setAttribute('placeholder', '55 (00) 0 0000-0000');

    const inputValue = input.value.replace(/\D/g, '');
    const formatted = inputValue.replace(/(\d{2})(\d{2})(\d{1})(\d{4})(\d{4})?/, '$1 ($2) $3 $4-$5');
    input.value = formatted.trim();
}

function maskCpfCnpj(input) {
    input.setAttribute('maxlength', '18');

    let value = input.value.replace(/\D/g, '');

    if (value.length <= 11) {
        input.value = value.replace(/(\d{3})(\d)/g, '$1.$2')
            .replace(/(\d{3})(\d)/g, '$1.$2')
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        input.value = value.replace(/(\d{2})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/g, '$1.$2')
            .replace(/(\d{3})(\d)/g, '$1/$2')
            .replace(/(\d{4})(\d{1,2})$/, '$1-$2');
    }
}

// === Funções para Sidebar === //

function setupSidebarToggle() {
    const sidebar = document.getElementById('sidebar');

    if (sidebar) {
        const toggleButton = document.getElementById('toggle-sidebar');
        const main = document.querySelector("main");

        const sidebarState = localStorage.getItem('sidebarState') || 'visible';
        if (sidebarState === 'hidden') {
            sidebar.classList.add('hidden');
            main.classList.add('full-width');
            toggleButton.classList.add('hiddenButton');
            toggleButton.innerHTML = '<i class="bi bi-chevron-right"></i>';
        } else {
            toggleButton.innerHTML = '<i class="bi bi-chevron-left"></i>';
        }

        toggleButton.addEventListener('click', () => {
            if (sidebar.classList.contains("hidden")) {
                sidebar.classList.remove("hidden");
                main.classList.remove("full-width");
                localStorage.setItem('sidebarState', 'visible');
                toggleButton.innerHTML = '<i class="bi bi-chevron-left"></i>';
            } else {
                sidebar.classList.add("hidden");
                main.classList.add("full-width");
                localStorage.setItem('sidebarState', 'hidden');
                toggleButton.innerHTML = '<i class="bi bi-chevron-right"></i>';
            }

            toggleButton.classList.toggle('hiddenButton');
        });
    }
}

// === Funções de Utilidade === //

function processResponse(response) {
    return response.text()
        .then(text => text ? JSON.parse(text) : {});
}

function showErrors(data) {
    let msgErrors = "Por favor, corrija os campos informados abaixo:\n";
    Object.keys(data).forEach(field => {
        data[field].forEach(errorMessage => {
            msgErrors += `${field}:${errorMessage}\n`;
        });
    });

    alert(msgErrors);
}
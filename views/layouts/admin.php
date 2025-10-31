<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title ?? 'CRUD') ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        /* Login Screen */
        .login-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            max-width: 420px;
            width: 100%;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            background-color: #667eea;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background-color: #2c3e50;
            color: white;
            z-index: 1030;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header .navbar-brand {
            color: white;
            font-weight: 600;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #3498db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background-color: #34495e;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1020;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: background-color 0.2s;
        }

        .sidebar .nav-link:hover {
            background-color: #2c3e50;
            color: white;
        }

        .sidebar .nav-link.active {
            background-color: #3498db;
            color: white;
        }

        .sidebar .nav-link i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            min-height: calc(100vh - var(--header-height));
            transition: margin-left 0.3s ease;
            padding: 2rem;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Footer */
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 1rem;
            text-align: center;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
        }

        .footer.expanded {
            margin-left: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content,
            .footer {
                margin-left: 0;
            }
        }

        /* Custom utilities */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
<!-- Login Screen -->
<!--<div class="login-wrapper" id="loginScreen">-->
<!--    <div class="login-card p-3">-->
<!--        <div class="card shadow-lg">-->
<!--            <div class="card-body p-4">-->
<!--                <div class="text-center mb-4">-->
<!--                    <div class="login-logo">-->
<!--                        <i class="bi bi-shield-lock"></i>-->
<!--                    </div>-->
<!--                    <h2 class="fw-bold mb-2">Bem-vindo</h2>-->
<!--                    <p class="text-muted">Faça login para acessar o painel administrativo</p>-->
<!--                </div>-->
<!--                <div class="alert alert-danger d-none" id="loginError" role="alert">-->
<!--                    Usuário ou senha incorretos-->
<!--                </div>-->
<!--                <form id="loginForm">-->
<!--                    <div class="mb-3">-->
<!--                        <label for="loginUsername" class="form-label">Usuário</label>-->
<!--                        <input type="text" class="form-control" id="loginUsername" placeholder="Digite seu usuário" required>-->
<!--                    </div>-->
<!--                    <div class="mb-3">-->
<!--                        <label for="loginPassword" class="form-label">Senha</label>-->
<!--                        <input type="password" class="form-control" id="loginPassword" placeholder="Digite sua senha" required>-->
<!--                    </div>-->
<!--                    <button type="submit" class="btn btn-primary w-100">Entrar</button>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Dashboard Screen -->
<div id="dashboardScreen">
    <!-- Header -->
    <nav class="header navbar navbar-dark">
        <div class="container-fluid">
            <button class="btn btn-link text-white" id="menuToggle">
                <i class="bi bi-list fs-4"></i>
            </button>
            <span class="navbar-brand mb-0 h1"><?= $this->e($title ?? 'CRUD') ?> - Painel Administrativo</span>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="user-avatar">AD</div>
                    <span id="usernameDisplay">Admin</span>
                </div>
                <button class="btn btn-outline-light btn-sm" id="btnLogout">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </button>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <nav class="nav flex-column">
            <a class="nav-link active" href="/admin" data-page="dashboard">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link" href="/admin/users/" data-page="users">
                <i class="bi bi-people"></i>
                <span>Usuários</span>
            </a>
            <a class="nav-link" href="/admin/products" data-page="products">
                <i class="bi bi-box-seam"></i>
                <span>Produtos</span>
            </a>
            <a class="nav-link" href="/admin/categories" data-page="categories">
                <i class="bi bi-box-seam"></i>
                <span>Categorias</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">

        <div class="mb-4">
            <h1 class="h2 fw-bold" id="pageTitle"><?= $this->e($title ?? '') ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $this->e($title ?? '') ?></li>
                </ol>
            </nav>
        </div>

        <!-- Table View -->
        <?= $this->section('body') ?>
    </main>

    <!-- Footer -->
    <footer class="footer" id="footer">
        <p class="mb-0">&copy; 2025 Painel Administrativo. Todos os direitos reservados.</p>
    </footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!--<script>-->
<!--    // Authentication logic-->
<!--    const loginScreen = document.getElementById('loginScreen');-->
<!--    const dashboardScreen = document.getElementById('dashboardScreen');-->
<!--    const loginForm = document.getElementById('loginForm');-->
<!--    const loginError = document.getElementById('loginError');-->
<!--    const btnLogout = document.getElementById('btnLogout');-->
<!--    const usernameDisplay = document.getElementById('usernameDisplay');-->
<!---->
<!--    // Check if user is already logged in-->
<!--    function checkAuth() {-->
<!--        const isLoggedIn = sessionStorage.getItem('isLoggedIn');-->
<!--        const username = sessionStorage.getItem('username');-->
<!---->
<!--        if (isLoggedIn === 'true' && username) {-->
<!--            showDashboard(username);-->
<!--        } else {-->
<!--            showLogin();-->
<!--        }-->
<!--    }-->
<!---->
<!--    // Login form submit-->
<!--    loginForm.addEventListener('submit', (e) => {-->
<!--        e.preventDefault();-->
<!---->
<!--        const username = document.getElementById('loginUsername').value;-->
<!--        const password = document.getElementById('loginPassword').value;-->
<!---->
<!--        // Simple authentication (in production, this would be a server request)-->
<!--        if (username === 'admin' && password === 'admin123') {-->
<!--            sessionStorage.setItem('isLoggedIn', 'true');-->
<!--            sessionStorage.setItem('username', username);-->
<!--            showDashboard(username);-->
<!--            loginError.classList.add('d-none');-->
<!--        } else {-->
<!--            loginError.classList.remove('d-none');-->
<!--        }-->
<!--    });-->
<!---->
<!--    // Logout-->
<!--    btnLogout.addEventListener('click', () => {-->
<!--        sessionStorage.removeItem('isLoggedIn');-->
<!--        sessionStorage.removeItem('username');-->
<!--        showLogin();-->
<!--    });-->
<!---->
<!--    // Show dashboard-->
<!--    function showDashboard(username) {-->
<!--        loginScreen.classList.add('d-none');-->
<!--        dashboardScreen.classList.remove('d-none');-->
<!--        usernameDisplay.textContent = username.charAt(0).toUpperCase() + username.slice(1);-->
<!--    }-->
<!---->
<!--    // Show login-->
<!--    function showLogin() {-->
<!--        loginScreen.classList.remove('d-none');-->
<!--        dashboardScreen.classList.add('d-none');-->
<!--        loginForm.reset();-->
<!--        loginError.classList.add('d-none');-->
<!--    }-->
<!---->
<!--    // Initialize-->
<!--    checkAuth();-->
<!---->
<!--    // Dashboard functionality-->
<!--    const menuToggle = document.getElementById('menuToggle');-->
<!--    const sidebar = document.getElementById('sidebar');-->
<!--    const mainContent = document.getElementById('mainContent');-->
<!--    const footer = document.getElementById('footer');-->
<!--    const tableView = document.getElementById('tableView');-->
<!--    const formView = document.getElementById('formView');-->
<!--    const btnNewUser = document.getElementById('btnNewUser');-->
<!--    const btnCancelForm = document.getElementById('btnCancelForm');-->
<!--    const btnCancelForm2 = document.getElementById('btnCancelForm2');-->
<!--    const userForm = document.getElementById('userForm');-->
<!--    const formTitle = document.getElementById('formTitle');-->
<!--    const menuLinks = document.querySelectorAll('.sidebar .nav-link');-->
<!---->
<!--    // Toggle sidebar-->
<!--    menuToggle.addEventListener('click', () => {-->
<!--        sidebar.classList.toggle('collapsed');-->
<!--        mainContent.classList.toggle('expanded');-->
<!--        footer.classList.toggle('expanded');-->
<!---->
<!--        // For mobile-->
<!--        if (window.innerWidth <= 768) {-->
<!--            sidebar.classList.toggle('mobile-open');-->
<!--        }-->
<!--    });-->
<!---->
<!--    // Menu navigation-->
<!--    menuLinks.forEach(link => {-->
<!--        link.addEventListener('click', (e) => {-->
<!--            e.preventDefault();-->
<!---->
<!--            // Remove active class from all links-->
<!--            menuLinks.forEach(l => l.classList.remove('active'));-->
<!---->
<!--            // Add active class to clicked link-->
<!--            link.classList.add('active');-->
<!---->
<!--            // Update page title-->
<!--            const pageName = link.querySelector('span').textContent;-->
<!--            document.getElementById('pageTitle').textContent = pageName;-->
<!---->
<!--            // Show table view-->
<!--            showTableView();-->
<!---->
<!--            // Close sidebar on mobile-->
<!--            if (window.innerWidth <= 768) {-->
<!--                sidebar.classList.remove('mobile-open');-->
<!--            }-->
<!--        });-->
<!--    });-->
<!---->
<!--    // Show form for new user-->
<!--    btnNewUser.addEventListener('click', () => {-->
<!--        formTitle.textContent = 'Novo Usuário';-->
<!--        userForm.reset();-->
<!--        showFormView();-->
<!--    });-->
<!---->
<!--    // Edit and delete buttons-->
<!--    document.addEventListener('click', (e) => {-->
<!--        if (e.target.closest('.btn-edit')) {-->
<!--            const userId = e.target.closest('.btn-edit').getAttribute('data-id');-->
<!--            formTitle.textContent = 'Editar Usuário';-->
<!--            showFormView();-->
<!--        }-->
<!---->
<!--        if (e.target.closest('.btn-delete')) {-->
<!--            const userId = e.target.closest('.btn-delete').getAttribute('data-id');-->
<!--            if (confirm('Tem certeza que deseja excluir este usuário?')) {-->
<!--                alert('Usuário excluído com sucesso!');-->
<!--            }-->
<!--        }-->
<!--    });-->
<!---->
<!--    // Cancel form-->
<!--    btnCancelForm.addEventListener('click', showTableView);-->
<!--    btnCancelForm2.addEventListener('click', showTableView);-->
<!---->
<!--    // Form submit-->
<!--    userForm.addEventListener('submit', (e) => {-->
<!--        e.preventDefault();-->
<!---->
<!--        const formData = {-->
<!--            name: document.getElementById('userName').value,-->
<!--            email: document.getElementById('userEmail').value,-->
<!--            role: document.getElementById('userRole').value,-->
<!--            status: document.getElementById('userStatus').value,-->
<!--            bio: document.getElementById('userBio').value-->
<!--        };-->
<!---->
<!--        alert('Usuário salvo com sucesso!');-->
<!--        showTableView();-->
<!--    });-->
<!---->
<!--    // Helper functions-->
<!--    function showTableView() {-->
<!--        tableView.classList.remove('d-none');-->
<!--        formView.classList.add('d-none');-->
<!--    }-->
<!---->
<!--    function showFormView() {-->
<!--        tableView.classList.add('d-none');-->
<!--        formView.classList.remove('d-none');-->
<!--    }-->
<!---->
<!--    // Close sidebar on mobile when clicking outside-->
<!--    document.addEventListener('click', (e) => {-->
<!--        if (window.innerWidth <= 768) {-->
<!--            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {-->
<!--                sidebar.classList.remove('mobile-open');-->
<!--            }-->
<!--        }-->
<!--    });-->
<!--</script>-->
</body>
</html>
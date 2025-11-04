<?php

use App\Services\AuthService;

$auth = AuthService::user();
?>

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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
                    <div class="user-avatar"><?= strtoupper(substr($auth['name'], 0, 2)) ?></div>
                    <span id="usernameDisplay"><?= $this->e($auth['name']) ?></span>
                </div>
                <form class="d-inline" method="post" action="/auth/logout">
                    <?= \App\Core\Csrf::input() ?>
                    <button class="btn btn-outline-light btn-sm" id="btnLogout">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </button>
                </form>
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
            <a class="nav-link" href="/admin/users" data-page="users">
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
        <?php $this->insert('partials/admin/flash') ?>
        <?= $this->section('body') ?>
    </main>

    <!-- Footer -->
    <footer class="footer" id="footer">
        <p class="mb-0">&copy; 2025 Painel Administrativo. Todos os direitos reservados.</p>
    </footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle sidebar
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        footer.classList.toggle('expanded');

        // For mobile
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('mobile-open');
        }
    });

    // Close sidebar on mobile when clicking outside
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        }
    });
</script>
</body>
</html>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $this->e($title ?? 'CRUD Evoluído + Upload') ?></title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 32px; }
    header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
    nav a { margin-right: 12px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background: #f5f5f5; text-align: left; }
    .error { color: #b30000; font-size: 14px; }
    .pagination a { margin-right:8px; }
    form.inline { display:inline; }
    input, button { padding:8px; }
    .thumb { width: 64px; height: 64px; object-fit: cover; border:1px solid #ddd; }
  </style>
</head>
<body>
  <header>
    <h1><?= $this->e($title ?? 'CRUD Evoluído + Upload') ?></h1>
    <nav>
      <a href="/">Produtos</a>
      <a href="/products/create">Novo</a>
    </nav>
  </header>
  <?= $this->section('body') ?>
</body>
</html>

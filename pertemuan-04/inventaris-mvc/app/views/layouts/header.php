<?php $flash = take_flash(); ?>
<!DOCTYPE html>
<html lang="id"><head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? e($title) . ' - ' : '' ?><?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>"><?= e(APP_NAME) ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('categories') ?>">Kategori</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('items') ?>">Barang</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('transactions') ?>">Transaksi</a></li>
            </ul>
            <?php $user = Middleware::user(); ?>
            <?php if ($user): ?>
                <span class="navbar-text text-white me-3"><?= e($user['full_name'] ?: $user['username']) ?></span>
                <a class="btn btn-outline-light btn-sm" href="<?= base_url('auth/logout') ?>">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<main class="container py-4">
<?php if ($flash): ?>
    <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>

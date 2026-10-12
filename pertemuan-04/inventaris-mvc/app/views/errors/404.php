<?php
$title = 'Halaman Tidak Ditemukan';
require ROOT_PATH . '/app/views/layouts/header.php';
?>
<div class="text-center py-5">
    <h1 class="display-1">404</h1>
    <h2>Halaman tidak ditemukan</h2>
    <p class="text-muted">Alamat yang kamu buka tidak tersedia.</p>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">Kembali ke dashboard</a>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

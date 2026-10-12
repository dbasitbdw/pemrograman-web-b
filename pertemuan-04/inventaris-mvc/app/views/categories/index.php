<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><?= e($title) ?></h2>
    <a href="<?= base_url('categories/create') ?>" class="btn btn-primary">Tambah Kategori</a>
</div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
<table class="table table-striped mb-0"><thead><tr><th>Nama</th><th>Deskripsi</th><th>Jumlah Barang</th><th class="text-end">Aksi</th></tr></thead><tbody>
<?php foreach ($categories as $category): ?>
<tr><td><?= e($category['name']) ?></td><td><?= e($category['description']) ?></td><td><?= e($category['item_count']) ?></td><td class="text-end">
    <a href="<?= base_url('categories/edit/' . $category['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
    <form method="post" action="<?= base_url('categories/delete/' . $category['id']) ?>" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')"><button class="btn btn-sm btn-danger">Hapus</button></form>
</td></tr>
<?php endforeach; ?>
<?php if (!$categories): ?><tr><td colspan="4" class="text-center py-4">Belum ada kategori.</td></tr><?php endif; ?>
</tbody></table></div></div></div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

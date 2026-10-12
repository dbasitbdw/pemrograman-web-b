<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3"><h2><?= e($title) ?></h2><a href="<?= base_url('items/create') ?>" class="btn btn-primary">Tambah Barang</a></div>
<form method="get" action="<?= base_url('items') ?>" class="row g-2 mb-3">
    <div class="col-md-5"><input type="search" name="search" class="form-control" placeholder="Cari kode, nama, atau kategori" value="<?= e($search) ?>"></div>
    <div class="col-md-3"><select name="category" class="form-select"><option value="">Semua kategori</option><?php foreach ($categories as $category): ?><option value="<?= e($category['id']) ?>" <?= (string) $categoryId === (string) $category['id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-2"><select name="limit" class="form-select"><?php foreach ([5, 10, 20, 50, 100] as $option): ?><option value="<?= $option ?>" <?= $limit === $option ? 'selected' : '' ?>><?= $option ?> / halaman</option><?php endforeach; ?></select></div>
    <div class="col-md-2"><button class="btn btn-outline-primary w-100">Cari</button></div>
</form>
<div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-striped align-middle mb-0">
<thead><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Harga</th><th class="text-end">Aksi</th></tr></thead><tbody>
<?php foreach ($items as $item): ?>
<tr><td><?= e($item['code']) ?></td><td><?= e($item['name']) ?></td><td><?= e($item['category_name'] ?: '-') ?></td><td><span class="<?= (int) $item['quantity'] <= 5 ? 'text-danger fw-bold' : '' ?>"><?= e($item['quantity'] . ' ' . $item['unit']) ?></span></td><td><?= e(rupiah($item['price'])) ?></td><td class="text-end">
    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#stockModal" data-item-id="<?= e($item['id']) ?>" data-item-name="<?= e($item['name']) ?>" data-action="in">Masuk</button>
    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#stockModal" data-item-id="<?= e($item['id']) ?>" data-item-name="<?= e($item['name']) ?>" data-action="out">Keluar</button>
    <a href="<?= base_url('items/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
    <form method="post" action="<?= base_url('items/delete/' . $item['id']) ?>" class="d-inline" onsubmit="return confirm('Hapus barang ini?')"><button class="btn btn-sm btn-danger">Hapus</button></form>
</td></tr>
<?php endforeach; ?>
<?php if (!$items): ?><tr><td colspan="6" class="text-center py-4">Belum ada barang.</td></tr><?php endif; ?>
</tbody></table></div></div></div>
<?php if ($pagination['total_pages'] > 1): ?>
<?php $query = ['search' => $search, 'category' => $categoryId, 'limit' => $limit]; ?>
<nav class="mt-3"><ul class="pagination justify-content-center">
    <?php $previous = max(1, $pagination['current_page'] - 1); $next = min($pagination['total_pages'], $pagination['current_page'] + 1); ?>
    <li class="page-item <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?= base_url('items') . '?' . http_build_query($query + ['page' => $previous]) ?>">Previous</a></li>
    <?php for ($page = 1; $page <= $pagination['total_pages']; $page++): ?><li class="page-item <?= $page === $pagination['current_page'] ? 'active' : '' ?>"><a class="page-link" href="<?= base_url('items') . '?' . http_build_query($query + ['page' => $page]) ?>"><?= $page ?></a></li><?php endfor; ?>
    <li class="page-item <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : '' ?>"><a class="page-link" href="<?= base_url('items') . '?' . http_build_query($query + ['page' => $next]) ?>">Next</a></li>
</ul></nav>
<?php endif; ?>
<div class="modal fade" id="stockModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="post" id="stockForm">
    <div class="modal-header"><h5 class="modal-title" id="stockTitle">Transaksi Stok</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body"><p id="stockItem" class="fw-bold"></p><div class="mb-3"><label class="form-label">Jumlah</label><input type="number" name="quantity" min="1" class="form-control" required></div><div><label class="form-label">Catatan</label><textarea name="notes" class="form-control" rows="3"></textarea></div><input type="hidden" name="item_id" id="stockItemId"></div>
    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary">Simpan</button></div>
</form></div></div></div>
<script>
document.getElementById('stockModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const action = button.dataset.action;
    document.getElementById('stockForm').action = '<?= base_url('transactions') ?>/' + (action === 'in' ? 'stockIn' : 'stockOut');
    document.getElementById('stockTitle').textContent = action === 'in' ? 'Barang Masuk' : 'Barang Keluar';
    document.getElementById('stockItem').textContent = button.dataset.itemName;
    document.getElementById('stockItemId').value = button.dataset.itemId;
});
</script>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

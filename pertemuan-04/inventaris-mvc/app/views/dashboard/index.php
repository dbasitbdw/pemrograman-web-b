<?php
require ROOT_PATH . '/app/views/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4"><div><h3 class="mb-0 fw-bold">Dashboard</h3><small class="text-muted">Ringkasan data inventaris barang</small></div></div>
<div class="row g-3 mb-4">
<?php foreach ([['Jenis Barang', $totalItems, 'box', 'primary'], ['Kategori', $totalCategories, 'tags', 'success'], ['Total Stok', $totalStock, 'stack', 'warning'], ['Nilai Aset', rupiah($totalAssetValue), 'cash-coin', 'danger']] as $stat): ?>
<div class="col-md-3"><div class="card border-0 shadow-sm h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><div class="text-muted small"><?= e($stat[0]) ?></div><div class="fs-4 fw-bold"><?= e($stat[1]) ?></div></div><i class="bi bi-<?= e($stat[2]) ?> text-<?= e($stat[3]) ?> stat-icon"></i></div></div></div>
<?php endforeach; ?>
</div>
<div class="row g-3"><div class="col-md-6"><div class="card border-0 shadow-sm h-100"><div class="card-header bg-white d-flex justify-content-between"><strong><i class="bi bi-exclamation-triangle text-warning"></i> Stok Menipis (≤ 5)</strong><span class="badge bg-warning text-dark"><?= e($lowStockCount) ?></span></div><div class="table-responsive"><table class="table table-hover mb-0"><tbody>
<?php foreach ($lowStockItems as $item): ?><tr><td><code><?= e($item['code']) ?></code></td><td><?= e($item['name']) ?></td><td class="text-center"><span class="badge bg-danger"><?= e($item['quantity']) ?></span></td></tr><?php endforeach; ?><?php if (!$lowStockItems): ?><tr><td class="text-center py-4">Semua stok barang masih aman.</td></tr><?php endif; ?></tbody></table></div><div class="card-footer bg-white text-end"><a href="<?= base_url('items') ?>" class="btn btn-sm btn-outline-primary">Kelola Barang</a></div></div></div>
<div class="col-md-6"><div class="card border-0 shadow-sm h-100"><div class="card-header bg-white d-flex justify-content-between"><strong><i class="bi bi-clock-history text-info"></i> Transaksi Terbaru</strong><span class="badge bg-info text-dark">Hari ini: <?= e($todayTransactions) ?></span></div><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>Waktu</th><th>Barang</th><th class="text-center">Tipe</th><th class="text-center">Qty</th></tr></thead><tbody>
<?php foreach ($recentTransactions as $trx): ?><tr><td><small><?= e(date('d/m H:i', strtotime($trx['created_at']))) ?></small></td><td><?= e($trx['item_name'] ?? '-') ?></td><td class="text-center"><span class="badge bg-<?= $trx['type'] === 'IN' ? 'success' : 'danger' ?>"><?= $trx['type'] === 'IN' ? 'Masuk' : 'Keluar' ?></span></td><td class="text-center"><?= e($trx['quantity']) ?></td></tr><?php endforeach; ?><?php if (!$recentTransactions): ?><tr><td colspan="4" class="text-center py-4">Belum ada transaksi.</td></tr><?php endif; ?></tbody></table></div><div class="card-footer bg-white text-end"><a href="<?= base_url('transactions') ?>" class="btn btn-sm btn-outline-info">Lihat Semua</a></div></div></div></div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

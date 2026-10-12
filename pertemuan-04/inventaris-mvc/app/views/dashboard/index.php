<?php
require ROOT_PATH . '/app/views/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><?= e($title) ?></h2>
</div>
<div class="row g-3">
    <div class="col-md-3"><div class="card"><div class="card-body"><h6 class="text-muted">Total Barang</h6><h3><?= e($totalItems) ?></h3><a href="<?= base_url('items') ?>">Lihat barang</a></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><h6 class="text-muted">Total Stok</h6><h3><?= e($totalStock) ?></h3></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><h6 class="text-muted">Nilai Aset</h6><h3><?= e(rupiah($totalAssetValue)) ?></h3></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><h6 class="text-muted">Transaksi Hari Ini</h6><h3><?= e($todayTransactionCount) ?></h3></div></div></div>
</div>
<div class="row g-3 mt-1">
    <div class="col-lg-5"><div class="card"><div class="card-header d-flex justify-content-between"><span>Stok Menipis</span><span class="badge text-bg-danger"><?= e($lowStockCount) ?></span></div><div class="card-body p-0"><table class="table table-sm mb-0"><tbody><?php foreach ($lowStockItems as $item): ?><tr><td><?= e($item['name']) ?></td><td class="text-end text-danger fw-bold"><?= e($item['quantity'] . ' ' . $item['unit']) ?></td></tr><?php endforeach; ?><?php if (!$lowStockItems): ?><tr><td class="text-center py-3">Tidak ada stok menipis.</td></tr><?php endif; ?></tbody></table></div></div></div>
    <div class="col-lg-7"><div class="card"><div class="card-header">Transaksi Terbaru</div><div class="card-body p-0"><div class="table-responsive"><table class="table table-sm mb-0"><thead><tr><th>Barang</th><th>Tipe</th><th>Jumlah</th><th>Tanggal</th></tr></thead><tbody><?php foreach ($recentTransactions as $transaction): ?><tr><td><?= e($transaction['item_name']) ?></td><td><span class="badge text-bg-<?= $transaction['type'] === 'IN' ? 'success' : 'secondary' ?>"><?= e($transaction['type']) ?></span></td><td><?= e($transaction['quantity']) ?></td><td><?= e($transaction['created_at']) ?></td></tr><?php endforeach; ?><?php if (!$recentTransactions): ?><tr><td colspan="4" class="text-center py-3">Belum ada transaksi.</td></tr><?php endif; ?></tbody></table></div></div></div></div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

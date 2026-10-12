<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<h2 class="mb-3"><?= e($title) ?></h2>
<div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-striped mb-0"><thead><tr><th>Tanggal</th><th>Barang</th><th>Tipe</th><th>Jumlah</th><th>Pengguna</th><th>Catatan</th></tr></thead><tbody>
<?php foreach ($transactions as $transaction): ?><tr><td><?= e($transaction['created_at']) ?></td><td><?= e($transaction['code'] . ' - ' . $transaction['item_name']) ?></td><td><span class="badge text-bg-<?= $transaction['type'] === 'IN' ? 'success' : 'secondary' ?>"><?= e($transaction['type']) ?></span></td><td><?= e($transaction['quantity']) ?></td><td><?= e($transaction['full_name']) ?></td><td><?= e($transaction['notes'] ?: '-') ?></td></tr><?php endforeach; ?>
<?php if (!$transactions): ?><tr><td colspan="6" class="text-center py-4">Belum ada transaksi.</td></tr><?php endif; ?></tbody></table></div></div></div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

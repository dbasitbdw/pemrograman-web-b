<?php
class TransactionsController extends Controller {
    public function __construct() {
        $this->requireLogin();
    }

    public function index(): void {
        $this->view('transactions/index', [
            'title' => 'Riwayat Transaksi',
            'transactions' => $this->model('Transaction')->all(),
        ]);
    }

    public function stockIn(): void {
        $this->store('IN', 'Barang masuk berhasil dicatat!');
    }

    public function stockOut(): void {
        $this->store('OUT', 'Barang keluar berhasil dicatat!');
    }

    private function store(string $type, string $message): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('transactions');
        $itemId = (int) ($_POST['item_id'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);
        if ($itemId <= 0 || $quantity <= 0) {
            $this->flash('danger', 'Data tidak valid.');
            $this->redirect('items');
        }
        $ok = $this->model('Transaction')->create([
            'item_id' => $itemId,
            'user_id' => $_SESSION['user']['id'],
            'type' => $type,
            'quantity' => $quantity,
            'notes' => trim($_POST['notes'] ?? '') ?: null,
        ]);
        $this->flash($ok ? 'success' : 'danger', $ok ? $message : 'Gagal. Stok tidak mencukupi.');
        $this->redirect('items');
    }
}

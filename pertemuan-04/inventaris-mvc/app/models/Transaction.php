<?php
class Transaction extends Model {
    protected string $table = 'transactions';

    public function all(): array {
        return $this->db->query(
            "SELECT t.*, i.code, i.name AS item_name, u.full_name
             FROM transactions t JOIN items i ON i.id = t.item_id
             JOIN users u ON u.id = t.user_id ORDER BY t.created_at DESC"
        )->fetchAll();
    }

    public function recent(int $limit = 5): array {
        $limit = max(1, min($limit, 20));
        return $this->db->query(
            "SELECT t.*, i.code, i.name AS item_name, u.full_name
             FROM transactions t JOIN items i ON i.id = t.item_id
             JOIN users u ON u.id = t.user_id ORDER BY t.created_at DESC LIMIT {$limit}"
        )->fetchAll();
    }

    public function todayCount(): int {
        return (int) $this->db->query(
            'SELECT COUNT(*) FROM transactions WHERE DATE(created_at) = CURDATE()'
        )->fetchColumn();
    }

    public function create(array $data): bool {
        try {
            $this->db->beginTransaction();
            $this->db->prepare(
                "INSERT INTO transactions (item_id, user_id, type, quantity, notes)
                 VALUES (:item_id, :user_id, :type, :quantity, :notes)"
            )->execute([
                ':item_id' => $data['item_id'], ':user_id' => $data['user_id'],
                ':type' => $data['type'], ':quantity' => $data['quantity'],
                ':notes' => $data['notes'] ?? null,
            ]);
            $operator = $data['type'] === 'IN' ? '+' : '-';
            $this->db->prepare(
                "UPDATE items SET quantity = quantity {$operator} :quantity WHERE id = :item_id"
            )->execute([':quantity' => $data['quantity'], ':item_id' => $data['item_id']]);
            $check = $this->db->prepare('SELECT quantity FROM items WHERE id = :item_id');
            $check->execute([':item_id' => $data['item_id']]);
            $stock = $check->fetchColumn();
            if ($stock === false || (int) $stock < 0) {
                if ($this->db->inTransaction()) $this->db->rollBack();
                return false;
            }
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            Logger::error('Gagal menyimpan transaksi stok.', ['error' => $e->getMessage(), 'data' => $data]);
            return false;
        }
    }
}

<?php
class Item extends Model {
    protected string $table = 'items';

    public function all(): array {
        return $this->db->query(
            "SELECT i.*, c.name AS category_name FROM items i
             LEFT JOIN categories c ON c.id = i.category_id ORDER BY i.name"
        )->fetchAll();
    }

    public function paginate(int $limit = 10, int $page = 1, string $search = '', string $categoryId = ''): array {
        $limit = max($limit, 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $limit;
        $where = [];
        $params = [];
        if ($search !== '') {
            $where[] = '(i.code LIKE :search_code OR i.name LIKE :search_name OR c.name LIKE :search_category)';
            $params['search_code'] = '%' . $search . '%';
            $params['search_name'] = '%' . $search . '%';
            $params['search_category'] = '%' . $search . '%';
        }
        if ($categoryId !== '') {
            $where[] = 'i.category_id = :category_id';
            $params['category_id'] = (int) $categoryId;
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $count = $this->db->prepare(
            "SELECT COUNT(*) FROM items i LEFT JOIN categories c ON i.category_id = c.id {$whereSql}"
        );
        $count->execute($params);
        $total = (int) $count->fetchColumn();
        $stmt = $this->db->prepare(
            "SELECT i.*, c.name AS category_name FROM items i
             LEFT JOIN categories c ON i.category_id = c.id {$whereSql}
             ORDER BY i.id DESC LIMIT {$limit} OFFSET {$offset}"
        );
        $stmt->execute($params);
        return [
            'data' => $stmt->fetchAll(),
            'current_page' => $page,
            'total_pages' => (int) ceil($total / $limit),
            'total_data' => $total,
        ];
    }

    public function totalItems(): int {
        return (int) $this->db->query('SELECT COUNT(*) FROM items')->fetchColumn();
    }

    public function totalStock(): int {
        return (int) $this->db->query('SELECT COALESCE(SUM(quantity), 0) FROM items')->fetchColumn();
    }

    public function totalAssetValue(): float {
        return (float) $this->db->query('SELECT COALESCE(SUM(quantity * price), 0) FROM items')->fetchColumn();
    }

    public function lowStockCount(): int {
        return (int) $this->db->query('SELECT COUNT(*) FROM items WHERE quantity <= 5')->fetchColumn();
    }

    public function lowStockItems(): array {
        return $this->db->query(
            'SELECT i.*, c.name AS category_name FROM items i
             LEFT JOIN categories c ON c.id = i.category_id WHERE i.quantity <= 5
             ORDER BY i.quantity ASC, i.name ASC LIMIT 10'
        )->fetchAll();
    }

    public function create(array $data): bool {
        return $this->db->prepare(
            "INSERT INTO items (code, name, category_id, quantity, unit, price, entry_date, description)
             VALUES (:code, :name, :category_id, :quantity, :unit, :price, :entry_date, :description)"
        )->execute($data);
    }

    public function update(int $id, array $data): bool {
        $data['id'] = $id;
        return $this->db->prepare(
            "UPDATE items SET code = :code, name = :name, category_id = :category_id,
             quantity = :quantity, unit = :unit, price = :price, entry_date = :entry_date,
             description = :description WHERE id = :id"
        )->execute($data);
    }

    public function generateCode(): string {
        $max = $this->db->query(
            "SELECT MAX(CAST(SUBSTRING(code, 4) AS UNSIGNED)) FROM items WHERE code LIKE 'ITM%'"
        )->fetchColumn();
        return 'ITM' . str_pad((string) (($max ? (int) $max : 0) + 1), 4, '0', STR_PAD_LEFT);
    }
}

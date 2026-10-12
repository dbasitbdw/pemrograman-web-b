<?php
class ItemsController extends Controller {
    private Item $item;

    public function __construct() {
        $this->requireLogin();
        $this->item = $this->model('Item');
    }

    public function index(): void {
        $allowedLimits = [5, 10, 20, 50, 100];
        $limit = (int) ($_GET['limit'] ?? 10);
        $limit = in_array($limit, $allowedLimits, true) ? $limit : 10;
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $search = trim($_GET['search'] ?? '');
        $categoryId = trim($_GET['category'] ?? '');
        if ($categoryId !== '' && !ctype_digit($categoryId)) $categoryId = '';
        $pagination = $this->item->paginate($limit, $page, $search, $categoryId);
        $this->view('items/index', [
            'title' => 'Data Barang',
            'items' => $pagination['data'],
            'pagination' => $pagination,
            'categories' => $this->model('Category')->all(),
            'search' => $search,
            'categoryId' => $categoryId,
            'limit' => $limit,
        ]);
    }

    public function create(): void {
        $this->view('items/create', [
            'title' => 'Tambah Barang',
            'categories' => $this->model('Category')->all(),
            'item' => ['code' => $this->item->generateCode()],
        ]);
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('items');
        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama barang wajib diisi.');
            $this->redirect('items/create');
        }
        $this->item->create($this->payload($input));
        $this->flash('success', 'Barang berhasil ditambahkan.');
        $this->redirect('items');
    }

    public function edit(int $id): void {
        $item = $this->item->find($id);
        if (!$item) $this->redirect('items');
        $this->view('items/edit', [
            'title' => 'Edit Barang',
            'item' => $item,
            'categories' => $this->model('Category')->all(),
        ]);
    }

    public function update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('items');
        $input = array_map('trim', $_POST);
        if (empty($input['name']) || empty($input['code'])) {
            $this->flash('danger', 'Kode dan nama barang wajib diisi.');
            $this->redirect('items/edit/' . $id);
        }
        $this->item->update($id, $this->payload($input));
        $this->flash('success', 'Barang berhasil diubah.');
        $this->redirect('items');
    }

    public function delete(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('items');
        $this->item->delete($id);
        $this->flash('success', 'Barang berhasil dihapus.');
        $this->redirect('items');
    }

    private function payload(array $input): array {
        return [
            'code' => $input['code'] ?? $this->item->generateCode(),
            'name' => $input['name'] ?? '',
            'category_id' => ($input['category_id'] ?? '') !== '' ? (int) $input['category_id'] : null,
            'quantity' => (int) ($input['quantity'] ?? 0),
            'unit' => $input['unit'] ?: 'unit',
            'price' => (float) ($input['price'] ?? 0),
            'entry_date' => ($input['entry_date'] ?? '') !== '' ? $input['entry_date'] : null,
            'description' => $input['description'] ?? '',
        ];
    }
}

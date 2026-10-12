<?php
class CategoriesController extends Controller {
    private Category $category;

    public function __construct() {
        $this->requireLogin();
        $this->category = $this->model('Category');
    }

    public function index(): void {
        $this->view('categories/index', [
            'title' => 'Data Kategori',
            'categories' => $this->category->all(),
        ]);
    }

    public function create(): void {
        $this->view('categories/create', ['title' => 'Tambah Kategori']);
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('categories');
        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/create');
        }
        $this->category->create([
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);
        $this->flash('success', 'Kategori berhasil ditambahkan.');
        $this->redirect('categories');
    }

    public function edit(int $id): void {
        $category = $this->category->find($id);
        if (!$category) $this->redirect('categories');
        $this->view('categories/edit', ['title' => 'Edit Kategori', 'category' => $category]);
    }

    public function update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('categories');
        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/edit/' . $id);
        }
        $this->category->update($id, [
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);
        $this->flash('success', 'Kategori berhasil diubah.');
        $this->redirect('categories');
    }

    public function delete(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('categories');
        $this->category->delete($id);
        $this->flash('success', 'Kategori berhasil dihapus.');
        $this->redirect('categories');
    }
}

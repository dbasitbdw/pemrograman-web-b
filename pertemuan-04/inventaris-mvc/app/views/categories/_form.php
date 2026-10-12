<form method="post" action="<?= base_url(isset($category['id']) ? 'categories/update/' . $category['id'] : 'categories/store') ?>" class="card card-body">
    <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="<?= e($category['name'] ?? '') ?>" required></div>
    <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="4"><?= e($category['description'] ?? '') ?></textarea></div>
    <div><button class="btn btn-primary">Simpan</button> <a href="<?= base_url('categories') ?>" class="btn btn-secondary">Batal</a></div>
</form>

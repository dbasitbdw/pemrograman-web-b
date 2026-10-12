<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="row justify-content-center"><div class="col-md-5">
    <div class="card"><div class="card-body">
        <h2 class="mb-4">Login</h2>
        <form method="post" action="<?= base_url('auth/authenticate') ?>">
            <div class="mb-3"><label class="form-label">Username</label><input type="text" name="username" class="form-control" required autofocus></div>
            <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <button class="btn btn-primary w-100">Login</button>
        </form>
    </div></div>
</div></div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

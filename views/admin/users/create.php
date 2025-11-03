<?php $this->layout('layouts/admin', ['title' => 'Novo Usuário']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="formView">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Novo usuário']) ?>
    <div class="card-body">
        <form method="post" action="/admin/users/store" enctype="multipart/form-data" class="">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome"
                           value="<?= $this->e(($old['name'] ?? '')) ?>" required>
                    <?php if (!empty($errors['name'])): ?>
                        <div class="text-danger"><?= $this->e($errors['name']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email"
                           placeholder="Digite o e-mail" value="<?= $this->e(($old['email'] ?? '')) ?>" required>
                    <?php if (!empty($errors['email'])): ?>
                        <div class="text-danger"><?= $this->e($errors['email']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Digite a senha" value="<?= $this->e(($old['password'] ?? '')) ?>" required>
                    <?php if (!empty($errors['password'])): ?>
                        <div class="text-danger"><?= $this->e($errors['password']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                </div>
            </div>
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Salvar
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> Limpar
                </button>
                <a href="/admin/users" class="btn align-self-end">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
            <?= \App\Core\Csrf::input() ?>
        </form>
    </div>
</div>
<?php $this->stop() ?>

<?php $this->layout('layouts/admin', ['title' => 'Nova Categoria']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="formView">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Nova Categoria']) ?>
    <div class="card-body">
        <form method="post" action="/admin/categories/store" enctype="multipart/form-data" class="">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome"
                           value="<?= $this->e(($old['name'] ?? '')) ?>">
                    <?php if (!empty($errors['name'])): ?>
                        <div class="text-danger"><?= $this->e($errors['name']) ?></div><?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="text" class="form-label">Texto</label>
                    <input type="text" class="form-control" id="text" name="text"
                           placeholder="Digite o texto" value="<?= $this->e(($old['text'] ?? '')) ?>">
                    <?php if (!empty($errors['text'])): ?>
                        <div class="text-danger"><?= $this->e($errors['text']) ?></div><?php endif; ?>
                </div>
            </div>
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Salvar
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> Limpar
                </button>
                <a href="/admin/categories" class="btn align-self-end">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
            <?= \App\Core\Csrf::input() ?>
        </form>
    </div>
</div>
<?php $this->stop() ?>

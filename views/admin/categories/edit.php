<?php $this->layout('layouts/admin', ['title' => 'Editar Produto']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="formView">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Editar Produto']) ?>
    <div class="card-body">
        <form method="post" action="/admin/products/update" enctype="multipart/form-data" class="">
              <input type="hidden" name="id" value="<?= $this->e($product['id']) ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome"
                           value="<?= $this->e(($product['name'] ?? '')) ?>" required>
                    <?php if (!empty($errors['name'])): ?>
                        <div class="text-danger"><?= $this->e($errors['name']) ?></div><?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Preço</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price"
                           placeholder="Digite o preço" value="<?= $this->e(($product['price'] ?? '')) ?>" required>
                    <?php if (!empty($errors['price'])): ?>
                        <div class="text-danger"><?= $this->e($errors['price']) ?></div><?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="formFile" class="form-label">Imagem (JPEG, PNG, WEBP) — substituir atual</label>
                    <?php if (!empty($product['image_path'])): ?>
                        <img class="d-block img-thumbnail ratio ratio-1x1" style="max-height: 200px;max-width: 200px" src="<?= $this->e($product['image_path']) ?>" alt=""><br>
                    <?php endif; ?>
                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                    <?php if (!empty($errors['image'])): ?>
                        <div class="error"><?= $this->e($errors['image']) ?></div><?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                </div>
            </div>
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Atualizar
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> Limpar
                </button>
                <a href="/admin/products" class="btn align-self-end">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
            <?= \App\Core\Csrf::input() ?>
        </form>
    </div>
</div>
<!--<form method="post" action="/admin/products/update" enctype="multipart/form-data">-->
<!--  <input type="hidden" name="id" value="--><?php //= $this->e($product['id']) ?><!--">-->
<!--  <label>Nome<br>-->
<!--    <input name="name" value="--><?php //= $this->e($product['name']) ?><!--" required>-->
<!--    --><?php //if (!empty($errors['name'])): ?><!--<div class="error">--><?php //= $this->e($errors['name']) ?><!--</div>--><?php //endif; ?>
<!--  </label><br><br>-->
<!---->
<!--  <label>Preço<br>-->
<!--    <input name="price" type="number" step="0.01" value="--><?php //= $this->e($product['price']) ?><!--" required>-->
<!--    --><?php //if (!empty($errors['price'])): ?><!--<div class="error">--><?php //= $this->e($errors['price']) ?><!--</div>--><?php //endif; ?>
<!--  </label><br><br>-->
<!---->
<!--  <label>Imagem (substitui a atual) — opcional<br>-->
<!--    --><?php //if (!empty($product['image_path'])): ?>
<!--      <img class="thumb" src="--><?php //= $this->e($product['image_path']) ?><!--" alt=""><br>-->
<!--    --><?php //endif; ?>
<!--    <input type="file" name="image" accept="image/*">-->
<!--    --><?php //if (!empty($errors['image'])): ?><!--<div class="error">--><?php //= $this->e($errors['image']) ?><!--</div>--><?php //endif; ?>
<!--  </label><br><br>-->
<!---->
<!--  --><?php //= \App\Core\Csrf::input() ?>
<!--  <button type="submit">Atualizar</button>-->
<!--</form>-->
<?php $this->stop() ?>

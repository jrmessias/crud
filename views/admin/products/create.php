<?php $this->layout('layouts/admin', ['title' => 'Novo Produto']) ?>

<?php $this->start('body') ?>
<form method="post" action="/admin/products/store" enctype="multipart/form-data">
  <label>Nome<br>
    <input name="name" value="<?= $this->e(($old['name'] ?? '') ) ?>" required>
    <?php if (!empty($errors['name'])): ?><div class="error"><?= $this->e($errors['name']) ?></div><?php endif; ?>
  </label><br><br>

  <label>Preço<br>
    <input name="price" type="number" step="0.01" value="<?= $this->e(($old['price'] ?? '') ) ?>" required>
    <?php if (!empty($errors['price'])): ?><div class="error"><?= $this->e($errors['price']) ?></div><?php endif; ?>
  </label><br><br>

  <label>Imagem (JPEG, PNG, WEBP) — opcional<br>
    <input type="file" name="image" accept="image/*">
    <?php if (!empty($errors['image'])): ?><div class="error"><?= $this->e($errors['image']) ?></div><?php endif; ?>
  </label><br><br>

  <?= \App\Core\Csrf::input() ?>
  <button type="submit">Salvar</button>
</form>
<?php $this->stop() ?>

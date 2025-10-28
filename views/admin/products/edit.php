<?php $this->layout('layouts/admin', ['title' => 'Editar Produto']) ?>

<?php $this->start('body') ?>
<form method="post" action="/admin/products/update" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $this->e($product['id']) ?>">
  <label>Nome<br>
    <input name="name" value="<?= $this->e($product['name']) ?>" required>
    <?php if (!empty($errors['name'])): ?><div class="error"><?= $this->e($errors['name']) ?></div><?php endif; ?>
  </label><br><br>

  <label>Preço<br>
    <input name="price" type="number" step="0.01" value="<?= $this->e($product['price']) ?>" required>
    <?php if (!empty($errors['price'])): ?><div class="error"><?= $this->e($errors['price']) ?></div><?php endif; ?>
  </label><br><br>

  <label>Imagem (substitui a atual) — opcional<br>
    <?php if (!empty($product['image_path'])): ?>
      <img class="thumb" src="<?= $this->e($product['image_path']) ?>" alt=""><br>
    <?php endif; ?>
    <input type="file" name="image" accept="image/*">
    <?php if (!empty($errors['image'])): ?><div class="error"><?= $this->e($errors['image']) ?></div><?php endif; ?>
  </label><br><br>

  <?= \App\Core\Csrf::input() ?>
  <button type="submit">Atualizar</button>
</form>
<?php $this->stop() ?>

<?php $this->layout('layouts/main', ['title' => 'Detalhe do Produto']) ?>

<?php $this->start('body') ?>
<p><b>ID:</b> <?= $this->e($product['id']) ?></p>
<p><b>Nome:</b> <?= $this->e($product['name']) ?></p>
<p><b>Preço:</b> R$ <?= number_format((float)$product['price'], 2, ',', '.') ?></p>
<?php if (!empty($product['image_path'])): ?>
  <p><b>Imagem:</b><br><img class="thumb" style="width:240px;height:auto" src="<?= $this->e($product['image_path']) ?>" alt=""></p>
<?php endif; ?>
<p><b>Criado em:</b> <?= $this->e($product['created_at'] ?? '') ?></p>
<p><a href="/">Voltar</a></p>
<?php $this->stop() ?>

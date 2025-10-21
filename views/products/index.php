<?php $this->layout('layouts/main', ['title' => 'Produtos']) ?>

<?php $this->start('body') ?>
<table>
  <thead>
    <tr><th>ID</th><th>Imagem</th><th>Nome</th><th>Preço</th><th>Criado em</th><th>Ações</th></tr>
  </thead>
  <tbody>
  <?php foreach ($products as $p): ?>
    <tr>
      <td><?= $this->e($p['id']) ?></td>
      <td><?php if (!empty($p['image_path'])): ?><img class="thumb" src="<?= $this->e($p['image_path']) ?>" alt=""><?php endif; ?></td>
      <td><?= $this->e($p['name']) ?></td>
      <td>R$ <?= number_format((float)$p['price'], 2, ',', '.') ?></td>
      <td><?= $this->e($p['created_at'] ?? '') ?></td>
      <td class="actions">
        <a href="/products/show?id=<?= $this->e($p['id']) ?>">Ver</a>
        <a href="/products/edit?id=<?= $this->e($p['id']) ?>">Editar</a>
        <form class="inline" action="/products/delete" method="post" onsubmit="return confirm('Excluir?');">
          <input type="hidden" name="id" value="<?= $this->e($p['id']) ?>">
          <?= \App\Core\Csrf::input() ?>
          <button type="submit">Excluir</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<div class="pagination" style="margin-top:12px;">
  <?php for ($i=1; $i<=$pages; $i++): ?>
    <?php if ($i == $page): ?>
      <strong>[<?= $i ?>]</strong>
    <?php else: ?>
      <a href="/?page=<?= $i ?>"><?= $i ?></a>
    <?php endif; ?>
  <?php endfor; ?>
</div>
<?php $this->stop() ?>

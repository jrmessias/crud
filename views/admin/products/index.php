<?php $this->layout('layouts/admin', ['title' => 'Produtos']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="tableView">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Lista de Produtos</h5>
        <a href="/admin/products/create" class="btn btn-primary" id="btnNewUser">
            <i class="bi bi-plus-lg"></i> Novo Produto
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody id="tableBody">
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $this->e($product['id']) ?></td>
                        <td>
                            <?php if (!empty($product['image_path'])): ?>
                                <img class="d-block img-thumbnail ratio ratio-1x1"
                                     style="max-height: 200px;max-width: 200px"
                                     src="<?= $this->e($product['image_path']) ?>"
                                     alt="<?= $this->e($product['name']) ?>"><br>
                            <?php endif; ?>
                        </td>
                        <td><?= $this->e($product['name']) ?></td>
                        <td><?= $this->e($categories[$product['category_id']]) ?></td>
                        <td>R$ <?= number_format((float)$product['price'], 2, ',', '.') ?></td>
                        <td><?= $this->e($product['created_at'] ?? '') ?></td>
                        <td>
                            <div class="action-buttons">
                                <a class="btn btn-sm btn-secondary btn-edit"
                                   href="/admin/products/show?id=<?= $this->e($product['id']) ?>">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a class="btn btn-sm btn-primary btn-edit"
                                   href="/admin/products/edit?id=<?= $this->e($product['id']) ?>">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form class="inline" action="/admin/products/delete" method="post"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este produto? (<?= $this->e($product['name']) ?>)');">
                                    <input type="hidden" name="id" value="<?= $this->e($product['id']) ?>">
                                    <?= \App\Core\Csrf::input() ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="pagination" style="margin-top:12px;">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
        <?php if ($i == $page): ?>
            <strong>[<?= $i ?>]</strong>
        <?php else: ?>
            <a href="/?page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>
</div>

<?php $this->stop() ?>

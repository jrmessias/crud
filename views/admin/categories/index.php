<?php $this->layout('layouts/admin', ['title' => 'Categorias']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="tableView">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Lista de Categorias</h5>
        <a href="/admin/categories/create" class="btn btn-primary" id="btnNewUser">
            <i class="bi bi-plus-lg"></i> Nova Categoria
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Texto</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody id="tableBody">
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $this->e($category['id']) ?></td>
                        <td><?= $this->e($category['name']) ?></td>
                        <td><?= $this->e($category['text']) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a class="btn btn-sm btn-secondary btn-edit"
                                   href="/admin/categories/show?id=<?= $this->e($category['id']) ?>">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a class="btn btn-sm btn-primary btn-edit"
                                   href="/admin/categories/edit?id=<?= $this->e($category['id']) ?>">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form class="inline" action="/admin/categories/delete" method="post"
                                      onsubmit="return confirm('Tem certeza que deseja excluir esta categoria? (<?= $this->e($category['name']) ?>)');">
                                    <input type="hidden" name="id" value="<?= $this->e($category['id']) ?>">
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

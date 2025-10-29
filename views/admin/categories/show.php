<?php $this->layout('layouts/admin', ['title' => 'Detalhe do Produto']) ?>

<?php $this->start('body') ?>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Detalhes do Produto</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label class="form-label"><strong>ID:</strong></label>
                    <input type="text" class="form-control" value="<?= $this->e($product['id']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Nome:</strong></label>
                    <input type="text" class="form-control" value="<?= $this->e($product['name']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Preço:</strong></label>
                    <input type="text" class="form-control"
                           value="R$ <?= number_format((float)$product['price'], 2, ',', '.') ?>" readonly>
                </div>
                <?php if (!empty($product['image_path'])): ?>
                    <div class="mb-3">
                        <label class="form-label"><strong>Imagem:</strong></label><br>
                        <img class="img-thumbnail" style="max-width:240px;height:auto"
                             src="<?= $this->e($product['image_path']) ?>" alt="Imagem do Produto">
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label"><strong>Criado em:</strong></label>
                    <input type="text" class="form-control" value="<?= $this->e($product['created_at'] ?? '') ?>"
                           readonly>
                </div>
                <div class="text-end">
                    <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->stop() ?>

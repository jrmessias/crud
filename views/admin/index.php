<?php $this->layout('layouts/admin', ['title' => 'Admin']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm" id="tableView">
    <?php $this->insert('partials/admin/flash') ?>
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Bem vindo</h5>
    </div>
</div>

<?php $this->stop() ?>

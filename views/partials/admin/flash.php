<?php $flashes = \App\Core\Flash::pullAll(); if ($flashes): ?>
    <?php foreach ($flashes as $f): ?>
        <div class="alert alert-<?= $this->e($f['type']) ?>"><?= $this->e($f['message']) ?></div>
    <?php endforeach; ?>
<?php endif; ?>
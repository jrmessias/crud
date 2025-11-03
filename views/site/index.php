<?php
$this->layout('layouts/site', ['title' => 'Inicial']);

$this->start('body');
?>
<div class="bg-body-tertiary p-5 rounded mt-3">
<h1>Bem-vindo</h1>
    <p class="lead">Esta é a exibição do site.</p>
    <a class="btn btn-lg btn-primary" href="/admin" role="button">Veja o admin »</a>
</div>
<?php
$this->stop();
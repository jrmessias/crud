<?php $this->layout('layouts/auth') ?>

<?php $this->start('body') ?>
<div class="login-wrapper" id="loginScreen">
    <div class="login-card p-3">
        <div class="card shadow-lg">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="login-logo">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h2 class="fw-bold mb-2">Bem-vindo</h2>
                    <p class="text-muted">Faça login para acessar o painel administrativo</p>
                </div>
                <?php $this->insert('partials/admin/flash') ?>
                <form id="loginForm" method="post" action="/auth/login">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Digite sua senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    <?= \App\Core\Csrf::input() ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->stop() ?>
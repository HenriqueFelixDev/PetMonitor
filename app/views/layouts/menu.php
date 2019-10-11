    <nav>
        <a href="http://<?= APP_HOST ?>/" class="logo ml-2 left"><img src="http://<?php echo APP_HOST ?>/resources/assets/img/logo.png" /> PETMonitor</a>
<?php if($view !== "login"): ?>

        <ul class="mr-2">
            <li><a href="http://<?= APP_HOST ?>/pets"><i class="fas fa-paw"></i> PETs</a></li>
            <li><a href="http://<?= APP_HOST ?>/rastreadores"><i class="fas fa-crosshairs"></i> Rastreadores</a></li>
            <!-- Local onde ficará o nome do usuário com um menu dropdown para acesso
             à sua conta, assinatura e para fazer logout -->
            <li><a href="#"><i class="fas fa-user-circle"></i> João</a> <ul>
                <li><a href="http://<?= APP_HOST ?>/conta"><i class="fas fa-user fa-sm" style="position:relative;top:-2px;"></i> Conta</a></li>
                <li><a href="http://<?= APP_HOST ?>/index/sair"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
            </ul></li>
        </ul>

<?php else: ?>

        <section id="login-form" class="right mr-2">
            <form action="http://<?= APP_HOST ?>/pets" method="POST">
                <div class="form-group-inline">
                    <input type="text" placeholder="Usuário" name="usuario" id="usuario" maxlength="32" required autofocus/>
                </div>

                <div class="form-group-inline">
                    <input type="password" placeholder="Senha" name="senha" id="senha" maxlength="32" required />
                </div>

                <div class="form-group-inline">
                    <button type="submit" class="btn-primary"><i class="fas fa-sign-in-alt"></i> Entrar</button>
                </div>
            </form>
        </section>
<?php endif; ?>
    </nav>
    
    <main>

<?php if ($mensagem::temMensagem("geral")) : ?>
    <div class="alert-box alert-box-<?= $mensagem::obterMensagem("geral")["tipo"] ?> alert-<?= $mensagem::obterMensagem("geral")["tipo"] ?>">
        <i class="fas fa-<?= $mensagem::obterMensagem("geral")["tipo"] == "erro" ? "times" :"check-circle" ?>"></i>
        <?= $mensagem::obterMensagem("geral")["msg"] ?>
    </div>
<?php endif; ?>
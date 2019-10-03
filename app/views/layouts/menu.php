    <nav>
        <a href="" class="logo ml-2 left"><img src="http://<?php echo APP_HOST ?>/resources/assets/img/logo.png" /> PETMonitor</a>
<?php if($view !== "login"): ?>

        <ul class="mr-2">
            <li><a href="/?url=pets">PETs</a></li>
            <li><a href="/?url=rastreadores">Rastreadores</a></li>
            <!-- Local onde ficará o nome do usuário com um menu dropdown para acesso
             à sua conta, assinatura e para fazer logout -->
            <li><a href="#">João</a> <ul>
                <li><a href="/?url=conta">Conta</a></li>
                <li><a href="#">Sair</a></li>
            </ul></li>
        </ul>

<?php else: ?>

        <section id="login-form" class="right mr-2">
            <form action="" method="POST">
                <div class="form-group-inline">
                    <input type="text" placeholder="Usuário" name="usuario" id="usuario" maxlength="32" required autofocus/>
                </div>

                <div class="form-group-inline">
                    <input type="password" placeholder="Senha" name="senha" id="senha" maxlength="32" required />
                </div>

                <div class="form-group-inline">
                    <button type="submit" class="btn-primary">Entrar</button>
                </div>
            </form>
        </section>
<?php endif; ?>
    </nav>
    
    <main>
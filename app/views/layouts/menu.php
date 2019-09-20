    <nav>
        <a href="">PETMonitor</a>
<?php if($view !== "login"): ?>

        <ul>
            <li><a href="#">PETs</a></li>
            <li><a href="#">Rastreadores</a></li>
            <!-- Local onde ficará o nome do usuário com um menu dropdown para acesso
             à sua conta, assinatura e para fazer logout -->
            <li></li>
        </ul>

<?php else: ?>

        <section>
            <form action="" method="POST">
                <div>
                    <input type="text" placeholder="Usuário" name="usuario" id="usuario" maxlength="32" required autofocus/>
                </div>

                <div>
                    <input type="password" placeholder="Senha" name="senha" id="senha" maxlength="32" required />
                </div>

                <div>
                    <button type="submit">Entrar</button>
                </div>
            </form>
        </section>
    </nav>
<?php endif; ?>
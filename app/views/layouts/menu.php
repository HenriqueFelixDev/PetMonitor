    <nav>
        <a href="">PETMonitor</a>
<?php if($view !== "login"): ?>

        <ul>
            <li></li>
            <li></li>
            <li></li>
        </ul>

<?php else: ?>

        <section>
            <form>
                <div>
                    <input type="text" placeholder="Usuário" />
                </div>

                <div>
                    <input type="password" placeholder="Senha" />
                </div>

                <div>
                    <button>Entrar</button>
                </div>
            </form>
        </section>
    </nav>
<?php endif; ?>
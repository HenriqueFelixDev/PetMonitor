
    <section class="box right mr-5 mt-2" id="cadastro-form">
        <header>
            <h2>Crie uma nova conta gratuitamente!</h2>
        </header>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" maxlength="32" required />
            </div>

            <div class="form-group">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" name="sobrenome" id="sobrenome" maxlength="32" required />
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" maxlength="32" required />

                <div class="form-group-inline">
                    <input type="checkbox" name="mostrar-senha" id="mostrar-senha" />
                    <label for="mostrar-senha">Mostrar Senha</label>
                </div>
            </div>

            <div class="form-group">
                <label for="cel">Telefone Celular</label>
                <input type="tel" name="cel" id="cel" maxlength="11" required />
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" maxlength="64" required />
            </div>

            <div class="form-group">
                <button type="submit" class="btn-primary right">Cadastrar</button>
            </div>
        </form>
    </section>

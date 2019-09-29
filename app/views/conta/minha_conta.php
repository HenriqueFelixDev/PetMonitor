    <section class="container">
        
        <div>
            <h2 class="title">Minha Conta</h2>
        </div>

        <div>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" maxlength="32" required autofocus />
                </div>

                <div class="form-group">
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" name="sobrenome" id="sobrenome" maxlength="32" required />
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" maxlength="32" required />
                </div>

                <div class="form-group">
                    <a href="#" class="btn btn-primary">Alterar Senha</a>
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
                    <button type="submit" class="btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </section>
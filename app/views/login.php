    
    <section>
        <form action="" method="POST">
            <div>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" maxlength="32" required />
            </div>

            <div>
                <label for="sobrenome">Sobrenome</label>
                <input type="text" name="sobrenome" id="sobrenome" maxlength="32" required />
            </div>

            <div>
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" maxlength="32" required />
            </div>

            <div>
                <label for="mostrar-senha">Mostrar Senha</label>
                <input type="checkbox" name="mostrar-senha" id="mostrar-senha" />
            </div>

            <div>
                <label for="cel">Telefone Celular</label>
                <input type="tel" name="cel" id="cel" maxlength="11" required />
            </div>

            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" maxlength="64" required />
            </div>

            <button type="submit">Cadastrar</button>
        </form>
    </section>

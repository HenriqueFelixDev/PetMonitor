    <section>
        <div>
            <h2>Alterar Senha</h2>
        </div>
        <div>
            <form action="" method="POST">

                <div>
                    <label for="senha-anterior">Senha Anterior</label>
                    <input type="password" name="senha-anterior" id="senha-anterior" maxlength="32" required autofocus />
                </div>

                <div>
                    <label for="mostrar-senha-anterior">Mostrar</label>
                    <input type="checkbox" name="mostrar-senha-anterior" id="mostrar-senha-anterior" />
                </div>

                <div>
                    <label for="nova-senha">Nova Senha</label>
                    <input type="password" name="nova-senha" id="nova-senha" maxlength="32" required />
                </div>

                <div>
                    <label for="mostrar-nova-senha">Mostrar</label>
                    <input type="checkbox" name="mostrar-nova-senha" id="mostrar-nova-senha" />
                </div>

                <div>
                    <label for="rep-nova-senha">Repita a Nova Senha</label>
                    <input type="password" name="rep-nova-senha" id="rep-nova-senha" maxlength="32" required />
                </div>

                <div>
                    <label for="mostrar-rep-nova-senha">Mostrar</label>
                    <input type="checkbox" name="mostrar-rep-nova-senha" id="mostrar-rep-nova-senha" />
                </div>

                <button type="submit">Salvar</button>
            </form>
        </div>
    </section>
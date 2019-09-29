    <section class="container">
        <div>
            <h2 class="title">Alterar Senha</h2>
        </div>
        <div>
            <form action="" method="POST">

                <div class="form-group">
                    <label for="senha-anterior">Senha Anterior</label>
                    <input type="password" name="senha-anterior" id="senha-anterior" maxlength="32" required autofocus />

                    <div class="form-group-inline">
                        <input type="checkbox" name="mostrar-senha-anterior" id="mostrar-senha-anterior" />
                        <label for="mostrar-senha-anterior">Mostrar</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nova-senha">Nova Senha</label>
                    <input type="password" name="nova-senha" id="nova-senha" maxlength="32" required />

                    <div class="form-group-inline">
                        <input type="checkbox" name="mostrar-nova-senha" id="mostrar-nova-senha" />
                        <label for="mostrar-nova-senha">Mostrar</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="rep-nova-senha">Repita a Nova Senha</label>
                    <input type="password" name="rep-nova-senha" id="rep-nova-senha" maxlength="32" required />

                    <div class="form-group-inline">
                        <input type="checkbox" name="mostrar-rep-nova-senha" id="mostrar-rep-nova-senha" />
                        <label for="mostrar-rep-nova-senha">Mostrar</label>
                    </div>
                </div>

                

                <div class="form-group">
                    <button type="submit" class="btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </section>
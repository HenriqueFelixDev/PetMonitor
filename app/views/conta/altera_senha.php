        <div>
            <form action="<?= $this->route("conta/alterar-senha") ?>" method="POST">
                <?= $this->csrf("altera_senha") ?>
                <div class="form-group">
                    <label for="senha-anterior">Senha Anterior</label>
                    <input type="password" name="senha-anterior" id="senha-anterior" maxlength="32" required autofocus />

                    <div class="form-group-inline">
                        <input type="checkbox" name="mostrar-senha-anterior" id="mostrar-senha-anterior" />
                        <label for="mostrar-senha-anterior">Mostrar</label>
                    </div>

<?php if ($mensagem::temMensagem("senha-anterior")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("senha-anterior")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("senha-anterior")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="nova-senha">Nova Senha</label>
                    <input type="password" name="nova-senha" id="nova-senha" maxlength="32" required />

                    <div class="form-group-inline">
                        <input type="checkbox" name="mostrar-nova-senha" id="mostrar-nova-senha" />
                        <label for="mostrar-nova-senha">Mostrar</label>
                    </div>

<?php if ($mensagem::temMensagem("nova-senha")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("nova-senha")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("nova-senha")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="rep-nova-senha">Repita a Nova Senha</label>
                    <input type="password" name="rep-nova-senha" id="rep-nova-senha" maxlength="32" required />

                    <div class="form-group-inline">
                        <input type="checkbox" name="mostrar-rep-nova-senha" id="mostrar-rep-nova-senha" />
                        <label for="mostrar-rep-nova-senha">Mostrar</label>
                    </div>

<?php if ($mensagem::temMensagem("rep-nova-senha")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("rep-nova-senha")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("rep-nova-senha")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Salvar</button>
                </div>
            </form>
        </div>
    </section>
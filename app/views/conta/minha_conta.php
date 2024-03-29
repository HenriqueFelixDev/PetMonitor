        <div>
            <?php $form = $dadosUtil::getValorArray($viewVar, "form") ?>
            <form action="<?= $this->route("conta/salvar") ?>" method="POST">
                <?= $this->csrf("conta") ?>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" maxlength="32" required autofocus value="<?= $dadosUtil::getValorArray($form, "nome") ?>" />
                    
<?php if ($mensagem::temMensagem("nome")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("nome")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("nome")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" name="sobrenome" id="sobrenome" maxlength="32" required value="<?= $dadosUtil::getValorArray($form, "sobrenome") ?>" />

<?php if ($mensagem::temMensagem("sobrenome")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("sobrenome")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("sobrenome")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <a href="<?= $this->route("conta/alteracao-senha") ?>" class="btn btn-primary"><i class="fas fa-lock"></i> Alterar Senha</a>
                </div>

                <div class="form-group">
                    <label for="cel">Telefone Celular</label>
                    <input type="tel" name="cel" id="cel" maxlength="11" required value="<?= $dadosUtil::getValorArray($form, "cel") ?>" />

<?php if ($mensagem::temMensagem("celular")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("celular")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("celular")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" maxlength="64" required value="<?= $dadosUtil::getValorArray($form, "email") ?>" />

<?php if ($mensagem::temMensagem("email")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("email")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("email")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Salvar</button>
                </div>
            </form>
        </div>
    </section>
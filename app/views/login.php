<?php if ($mensagem::temMensagem("geral")) : ?>

    <div class="alert-box alert-box-<?= $mensagem::obterMensagem("geral")["tipo"] ?> alert-<?= $mensagem::obterMensagem("geral")["tipo"] ?>">
        <?= $mensagem::obterMensagem("geral")["msg"] ?>
    </div>
<?php endif; ?>

    <section class="box right mr-5 mt-2" id="cadastro-form">
        <header>
            <h2>Crie uma nova conta gratuitamente!</h2>
        </header>

        <form action="http://<?= APP_HOST ?>/index/cadastrar" method="POST">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" maxlength="32" required value="<?= isset($viewVar["form"]["nome"]) ? $viewVar["form"]["nome"] : null ?>" />

<?php if ($mensagem::temMensagem("nome")) : ?>

                <div class="alert-<?= $mensagem::obterMensagem("nome")["tipo"] ?>">
                    <small><?= $mensagem::obterMensagem("nome")["msg"] ?></small>
                </div>
<?php endif; ?>

            </div>

            <div class="form-group">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" name="sobrenome" id="sobrenome" maxlength="32" required value="<?= isset($viewVar["form"]["sobrenome"]) ? $viewVar["form"]["sobrenome"] : null ?>" />

<?php if ($mensagem::temMensagem("sobrenome")) : ?>

                <div class="alert-<?= $mensagem::obterMensagem("sobrenome")["tipo"] ?>">
                    <small><?= $mensagem::obterMensagem("sobrenome")["msg"] ?></small>
                </div>
<?php endif; ?>

            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" maxlength="32" required />

<?php if ($mensagem::temMensagem("senha")) : ?>

                <div class="alert-<?= $mensagem::obterMensagem("senha")["tipo"] ?>">
                    <small><?= $mensagem::obterMensagem("senha")["msg"] ?></small>
                </div>
<?php endif; ?>

                <div class="form-group-inline">
                    <input type="checkbox" name="mostrar-senha" id="mostrar-senha" />
                    <label for="mostrar-senha">Mostrar Senha</label>
                </div>
            </div>

            <div class="form-group">
                <label for="cel">Telefone Celular</label>
                <input type="tel" name="cel" id="cel" maxlength="11" required value="<?= isset($viewVar["form"]["cel"]) ? $viewVar["form"]["cel"] : null ?>" />

<?php if ($mensagem::temMensagem("celular")) : ?>

                <div class="alert-<?= $mensagem::obterMensagem("celular")["tipo"] ?>">
                    <small><?= $mensagem::obterMensagem("celular")["msg"] ?></small>
                </div>
<?php endif; ?>

            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" maxlength="64" required value="<?= isset($viewVar["form"]["email"]) ? $viewVar["form"]["email"] : null ?>" />

<?php if ($mensagem::temMensagem("email")) : ?>

                <div class="alert-<?= $mensagem::obterMensagem("email")["tipo"] ?>">
                    <small><?= $mensagem::obterMensagem("email")["msg"] ?></small>
                </div>
<?php endif; ?>

            </div>

            <div class="form-group">
                <button type="submit" class="btn-primary right">Cadastrar</button>
            </div>
        </form>
    </section>

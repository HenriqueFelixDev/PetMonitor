<?php $form = $dadosUtil::getValorArray($viewVar, "form"); ?>
    
    <div class="container secao-pagina">
        <section id="login-form" class="box">
            <header>
                <h2>Entrar</h2>
            </header>
            <form action="<?= $this->route("index/entrar") ?>" method="POST">
                <?php echo $viewVar["csrf_login"] ?>
                <div class="form-group">
                    <label for="email-celular">E-mail ou Celular</label>
                    <input type="text" placeholder="E-mail ou Celular" name="email-celular" id="email-celular" maxlength="64" required autofocus/>
                </div>

                <div class="form-group">
                    <label for="senha-login">Senha</label>
                    <input type="password" placeholder="Senha" name="senha-login" id="senha-login" maxlength="32" required />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-primary"><i class="fas fa-sign-in-alt"></i> Entrar</button>
                </div>

<?php if ($mensagem::temMensagem("login")) : ?>
    <div id="alerta-geral" class="alert-<?= $mensagem::obterMensagem("login")["tipo"] ?> my-1">
        <small><?= $mensagem::obterMensagem("login")["msg"] ?></small>
    </div>
<?php endif; ?>

                <span>Não possui uma conta? <a href="#cadastro-form">Criar uma nova conta</a>!</span>
            </form>
        </section>
    </div>

    <div class="container secao-pagina">
        <section class="box" id="cadastro-form">
            <header>
                <h2>Crie uma nova conta gratuitamente!</h2>
            </header>
<?php if ($mensagem::temMensagem("cadastro")) : ?>
    <div id="alerta-geral" class=" alert-<?= $mensagem::obterMensagem("cadastro")["tipo"] ?> mb-1">
        <?= $mensagem::obterMensagem("cadastro")["msg"] ?>
    </div>
<?php endif; ?>
            <form action="<?= $this->route("index/cadastrar") ?>" method="POST">
                <?= $viewVar["csrf_cadastro"] ?>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" maxlength="32" required value="<?= $dadosUtil::getValorArray($form, "nome") ?>" />

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
                    <button type="submit" class="btn-primary right">Cadastrar</button>
                </div>
            </form>
        </section>
    </div>

<?php if (isset($form)): ?>
    <script>scrollPara("#cadastro-form")</script>
<?php endif; ?>


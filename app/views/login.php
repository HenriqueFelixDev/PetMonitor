<?php $form = $dadosUtil::getValorArray($viewVar, "form"); ?>
    
    <div class="secao-pagina login">
        <section id="login-form" class="">
            <header>
                <h2>Entrar</h2>
            </header>
            <form action="<?= $this->route("index/entrar") ?>" method="POST">
                <?php echo $this->csrf("login") ?>
                <div class="form-group">
                    <label for="email-celular">E-mail ou Celular</label>
                    <input type="text" placeholder="E-mail ou Celular" name="email-celular" id="email-celular" maxlength="64" required autofocus/>
                </div>

                <div class="form-group">
                    <label for="senha-login">Senha</label>
                    <input type="password" placeholder="Senha" name="senha-login" id="senha-login" maxlength="32" required />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-cancel"><i class="fas fa-sign-in-alt"></i> Entrar</button>
                </div>

<?php if ($mensagem::temMensagem("login")) : ?>
    <div id="alerta-geral" class="alert-<?= $mensagem::obterMensagem("login")["tipo"] ?> my-1">
        <small><?= $mensagem::obterMensagem("login")["msg"] ?></small>
    </div>
<?php endif; ?>

                <span>Não possui uma conta? <a href="#cadastro-form" class="link-azul">Criar uma nova conta</a></span>
            </form>
        </section>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 279.24" preserveAspectRatio="none"><path d="M1000 0S331.54-4.18 0 279.24h1000z" opacity=".25"/><path d="M1000 279.24s-339.56-44.3-522.95-109.6S132.86 23.76 0 25.15v254.09z"/></svg>
    </div>

    <div class="container secao-pagina mt-1">
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
                <?= $this->csrf("cadastro") ?>
                <div class="form-group-inline">
                    <div class="form-group"><label for="nome">Nome</label></div>
                    <input type="text" name="nome" id="nome" maxlength="32" required value="<?= $dadosUtil::getValorArray($form, "nome") ?>" />

<?php if ($mensagem::temMensagem("nome")) : ?>

                    <div class="alert-<?= $mensagem::obterMensagem("nome")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("nome")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group-inline">
                    <div class="form-group"><label for="sobrenome">Sobrenome</label></div>
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

<?php if (isset($form) || $mensagem::temMensagem("cadastro")): ?>
    <script>scrollPara("#cadastro-form")</script>
<?php endif; ?>


        <div>
            <form action="http://<?= APP_HOST ?>/rastreadores/vincular/<?= $viewVar["pet"]->getCodigo() ?>" method="POST">
                <div>
                    <?= $viewVar["csrf_vinculo"] ?>
                    <input type="hidden" name="cod_pet" value="<?= $viewVar["pet"]->getCodigo() ?>"/>
                    <div class="form-group">
                        <label for="codigo-rastreador">Código do Rastreador</label>
                        <input type="text" name="codigo-rastreador" id="codigo-rastreador" maxlength="16" required autofocus />
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn-primary">Vincular</button>
                    </div>
                    
<?php if ($mensagem::temMensagem("codigo-rastreador")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("codigo-rastreador")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("codigo-rastreador")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>
            </form>
        <div>
    </section>
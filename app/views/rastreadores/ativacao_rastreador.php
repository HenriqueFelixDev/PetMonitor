    <section class="container">
        <div>
            <h2 class="title">Ativar Rastreador</h2>
        </div>

        <div>
            <form action="http://<?= APP_HOST ?>/rastreadores/ativar" method="POST">
                <div>
                    <div class="form-group-inline">
                        <label for="codigo-rastreador">Código do Rastreador</label>
                        <input type="text" name="codigo-rastreador" id="codigo-rastreador" maxlength="16" required autofocus />
                    </div>
                    
                    <div class="form-group-inline">
                        <button type="submit" class="btn-primary">Ativar</button>
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
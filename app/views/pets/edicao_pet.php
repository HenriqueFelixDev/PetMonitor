    <section class="container">
        <div>
            <h2 class="title">Novo PET</h2>
        </div>

        <div>
            <form action="http://<?= APP_HOST ?>/pets/salvar" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    
                    <img src="http://<?= APP_HOST."/resources/assets/fotos/default.png" ?>" id="foto-pet" alt="Foto do Pet"/>
                    <input type="file" name="foto" id="foto" style="display:none;" />
                    <label for="foto"><span class="btn"><i class="fas fa-camera"></i> Escolher Foto<span></label>
                    
<?php if ($mensagem::temMensagem("foto")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("foto")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("foto")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" maxlength="64" required autofocus value="<?= isset($viewVar["form"]["nome"]) ? $viewVar["form"]["nome"] : '' ?>" />

<?php if ($mensagem::temMensagem("nome")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("nome")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("nome")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="especie">Espécie</label>
                    <input type="text" name="especie" id="especie" maxlength="32" required value="<?= isset($viewVar["form"]["especie"]) ? $viewVar["form"]["especie"] : '' ?>" />

<?php if ($mensagem::temMensagem("especie")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("especie")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("especie")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="raca">Raça<small>(Opcional)</small></label>
                    <input type="text" name="raca" id="raca" maxlength="32" value="<?= isset($viewVar["form"]["raca"]) ? $viewVar["form"]["raca"] : '' ?>" />

<?php if ($mensagem::temMensagem("raca")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("raca")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("raca")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" id="sexo" required>
                        <option>Selecione um sexo</option>
                        <option value="m">Macho</option>
                        <option value="f">Fêmea</option>
                        <option value="mc">Macho Castrado</option>
                        <option value="fc">Fêmea Castrada</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cor">Cor</label>
                    <input type="text" name="cor" id="cor" maxlength="32" required value="<?= isset($viewVar["form"]["cor"]) ? $viewVar["form"]["cor"] : '' ?>" />
                    
<?php if ($mensagem::temMensagem("cor")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("cor")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("cor")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="data-nasc">Data de Nascimento</label>
                    <input type="date" name="data-nasc" id="data-nasc" value="<?= isset($viewVar["form"]["data-nasc"]) ? $viewVar["form"]["data-nasc"] : '' ?>" />

<?php if ($mensagem::temMensagem("data-nasc")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("data-nasc")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("data-nasc")["msg"] ?></small>
                    </div>
<?php endif; ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </section>
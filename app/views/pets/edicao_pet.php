        <div>
            <?php $form = $dadosUtil::getValorArray($viewVar, "form") ?>
            <form action="<?= $this->route("pets/salvar") ?>" method="POST" enctype="multipart/form-data">
                <?= $this->csrf("edicao_pet") ?>
                <input type="hidden" name="cod_pet" value="<?= $dadosUtil::getValorArray($form, "cod_pet") ?>" />
                <div class="form-group">
                    
                    <?php $foto = $dadosUtil::getValorArray($form, "foto", "default.png") ?>
                    <div id="container-foto">
                        <img src="<?= $this->asset("fotos/${foto}") ?>" id="foto-pet" alt="Foto do Pet"/>
                    </div>
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
                    <input type="text" name="nome" id="nome" maxlength="64" required autofocus value="<?= $dadosUtil::getValorArray($form, "nome") ?>" />

<?php if ($mensagem::temMensagem("nome")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("nome")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("nome")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="especie">Espécie</label>
                    <input type="text" name="especie" id="especie" maxlength="32" required value="<?= $dadosUtil::getValorArray($form, "especie") ?>" />

<?php if ($mensagem::temMensagem("especie")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("especie")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("especie")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <div class="form-group">
                    <label for="raca">Raça <small>(Opcional)</small></label>
                    <input type="text" name="raca" id="raca" maxlength="32" value="<?= $dadosUtil::getValorArray($form, "raca") ?>" />

<?php if ($mensagem::temMensagem("raca")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("raca")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("raca")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>
                
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <?php $sexo = $dadosUtil::getValorArray($form, "sexo") ?>
                    <select name="sexo" id="sexo" required>
                        <option>Selecione um sexo</option>
                        <option <?= $sexo == "m" ? "selected" : "" ?> value="m">Macho</option>
                        <option <?= $sexo == "f" ? "selected" : "" ?> value="f">Fêmea</option>
                        <option <?= $sexo == "mc" ? "selected" : "" ?> value="mc">Macho Castrado</option>
                        <option <?= $sexo == "fc" ? "selected" : "" ?> value="fc">Fêmea Castrada</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cor">Cor</label>
                    <input type="text" name="cor" id="cor" maxlength="32" required value="<?= $dadosUtil::getValorArray($form, "cor") ?>" />
                    
<?php if ($mensagem::temMensagem("cor")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("cor")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("cor")["msg"] ?></small>
                    </div>
<?php endif; ?>

                </div>

                <?php
                     $dataAtual = new DateTime();
                     $dataMaxima = $dataAtual->format("Y-m-d");
                ?>
                <div class="form-group">
                    <label for="data-nasc">Data de Nascimento</label>
                    <input type="date" name="data-nasc" id="data-nasc" max="<?= $dataMaxima  ?>" value="<?= $dadosUtil::getValorArray($form, "data-nasc") ?>" />

<?php if ($mensagem::temMensagem("data-nasc")) : ?>
                    <div class="alert-<?= $mensagem::obterMensagem("data-nasc")["tipo"] ?>">
                        <small><?= $mensagem::obterMensagem("data-nasc")["msg"] ?></small>
                    </div>
<?php endif; ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Salvar</button>
                </div>
            </form>
        </div>
    </section>
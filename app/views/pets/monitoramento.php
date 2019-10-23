<?php $pet = $viewVar["pet"] ?>
        <div>
            <div class="my-1">
                <a href="<?= $this->route("monitoramento/gerarCoordenadas/{$pet->getCodigo()}") ?>" class="btn btn-primary">Gerar Coordenadas</a>
            </div>
            <form action="" method="GET">
                <div class="form-group-inline">
                    <div class="mb-1"><label for="data-inicial">Data Inicial</label></div>
                    <input type="date" name="data-inicial" id="data-inicial" value="<?= $dadosUtil::getValorArray($_GET, "data-inicial") ?>" />
                </div>

                <div class="form-group-inline">
                    <div class="mb-1"><label for="hora-inicial">Hora Inicial</label></div>
                    <input type="time" name="hora-inicial" id="hora-inicial" value="<?= $dadosUtil::getValorArray($_GET, "hora-inicial") ?>" />
                </div>

                <div class="form-group-inline">
                    <div class="mb-1"><label for="data-final">Data Final</label></div>
                    <input type="date" name="data-final" id="data-final" value="<?= $dadosUtil::getValorArray($_GET, "data-final") ?>" />
                </div>
                
                <div class="form-group-inline">
                    <div class="mb-1"><label for="hora-final">Hora Final</label></div>
                    <input type="time" name="hora-final" id="hora-final" value="<?= $dadosUtil::getValorArray($_GET, "hora-final") ?>" />
                </div>

                <div class="form-group-inline">
                    <button type="submit" class="btn-primary">Visualizar Trajeto</button>
                </div>
            </form>
        </div>

        <div class="mt-1">
            <!-- Seção onde ficará o mapa com o trajeto do pet -->
            <section id="mapa-trajeto">
                <img src=" <?= $viewVar["mapa-trajeto"] ?>" />
            </section>
        </div>

        <div class="tabela-responsiva mt-1">
<?php echo count($viewVar["trajetos"])." coordenadas foram encontradas" ?>
<?php if (!empty($viewVar["trajetos"])) : ?>
            <div class="mt-1">
                <table>
                    <thead>
                        <tr>
                            <th>DATA E HORA</th>
                            <th>LATITUDE</th>
                            <th>LONGITUDE</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach($viewVar["trajetos"] as $trajeto): ?>
                        <tr>
                            <td><?= $trajeto->getDataHora() ?></td>
                            <td><?= $trajeto->getLatitude() ?></td>
                            <td><?= $trajeto->getLongitude() ?></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
<?php endif; ?>
            </div>
        </div>
    </section>
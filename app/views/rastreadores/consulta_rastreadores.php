        <div class="mb-2">
            <form action="<?= $this->route("rastreadores") ?>" method="GET">
                <div class="form-group">
                    <input type="text" name="busca" id="busca" placeholder="Pesquisa" maxlength="64" autofocus value="<?= $dadosUtil::getValorArray($_GET, "busca", "") ?>" />
                </div>
                
                <div class="mt-1">
                    <h3><a href="javascript:void(0);" id="filtro-toggle"><i class="fas fa-filter"></i> Filtros</a></h3>

                    <div id="grupo-filtros" class="mt-1">
                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="data-nasc-inicial">Data de Ativação</label>
                            </div>

                            <?php 
                                $dataAtual = new DateTime();
                                $dataMaxima = $dataAtual->format("Y-m-d") 
                            ?>

                            <div class="form-group-inline-no-break">
                                <label for="data-ativacao-inicial">De:</label>
                                <input type="date" name="data-ativacao-inicial" id="data-ativacao-inicial" max="<?= $dataMaxima  ?>" value="<?= $dadosUtil::getValorArray($_GET, "data-ativacao-inicial", "") ?>"/>
                            </div>
                            <div class="form-group-inline-no-break">
                                <label for="data-ativacao-final">Até: </label>
                                <input type="date" name="data-ativacao-final" id="data-ativacao-final" max="<?= $dataMaxima ?>" value="<?= $dadosUtil::getValorArray($_GET, "data-ativacao-final", "") ?>" />
                            </div>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="ordem">Ordenar Por</label>
                            </div>

                            <?php $ordem = $dadosUtil::getValorArray($_GET, "ordem" ) ?>
                            <select name="ordem" id="ordem">
                                <option <?= $ordem == "cme" ? "selected" : "" ?> value="cme">Código (Menor para Maior)</option>
                                <option <?= $ordem == "cma" ? "selected" : "" ?> value="cma">Código (Maior para Menor)</option>
                                <option <?= $ordem == "paz" ? "selected" : "" ?> value="paz">PET (A-Z)</option>
                                <option <?= $ordem == "pza" ? "selected" : "" ?> value="pza">PET (Z-A)</option>
                            </select>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="limite">Itens por Página</label>
                            </div>

                            <?php $limite = $dadosUtil::getValorArray($_GET, "limite") ?>
                            <select name="limite" id="limite">
                                <option <?= $limite == "15" ? "selected" : ""  ?> value="15">15</option>
                                <option <?= $limite == "30" ? "selected" : ""  ?> value="30">30</option>
                                <option <?= $limite == "45" ? "selected" : ""  ?> value="45">45</option>
                                <option <?= $limite == "60" ? "selected" : ""  ?> value="60">60</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-1">
                    <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Pesquisar</button>
                </div>
            </form>
        </div>
    <div class="resultado-consulta">
        <div class="my-2">
            <?= "{$viewVar['totalItens']} rastreadores foram encontrados" ?>
        </div>
<?php if (!empty($viewVar["rastreadores"])) : ?>
        <div class="tabela-responsiva">
            <table>
                <thead>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>PET</th>
                        <th>DATA DE ATIVAÇÃO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>

                <tbody>
<?php foreach ($viewVar["rastreadores"] as $rastreador) : ?>
                    <tr>
                        <td><?= $rastreador->getCodigo() ?></td>
                        <?php $nomePet = $dadosUtil::getValorVar($rastreador->getNomePet(), "Nenhum")  ?>
                        <td><?= $nomePet  ?></td>
                        <td>
                            <?php 
                                $data = new DateTime($rastreador->getDataAtivacao()); 
                                echo $data->format("d/m/Y");
                            ?>
                        </td>
                        <td>
                            <button class="btn-cancel" onclick="excluirRastreadorModal('<?= $rastreador->getCodigo().'\', \''.$nomePet.'\', \''.$this->route('rastreadores/excluir/'.$rastreador->getCodigo()) ?>')">
                                <i class="fas fa-trash-alt"></i> <span class="texto-botao">Excluir</span>
                            </button>
                        </td>
                    </tr>
<?php endforeach; ?>

                </tbody>
            </table>
            <div class="center mt-3">
                <?= $viewVar["paginacao"] ?>
            </div>
        </div>
<?php endif; ?>
    </div>
    </section>
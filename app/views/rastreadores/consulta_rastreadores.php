    <section class="container">
        <div>
            <h2 class="title">Rastreadores</h2>
        </div>

        <div class="mb-2">
            <form action="<?php echo $this->route("rastreadores") ?>" method="GET">
                <div class="form-group">
                    <input type="text" name="busca" id="busca" placeholder="Pesquisa" maxlength="64" autofocus value="<?php echo !empty($_GET["busca"]) ? $_GET["busca"] : "" ?>" />
                </div>
                
                <div class="mt-1">
                    <h3><a href="javascript:void(0);" id="filtro-toggle" onclick="javascript:mostrarOcultarElemento('div#grupo-filtros')"><i class="fas fa-filter"></i> Filtros</a></h3>

                    <div id="grupo-filtros" class="mt-1">
                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="data-nasc-inicial">Data de Ativação</label>
                            </div>
                            <div class="form-group-inline-no-break">
                                <label for="data-ativacao-inicial">De:</label>
                                <input type="date" name="data-ativacao-inicial" id="data-ativacao-inicial" max="<?php $dataAtual = new DateTime(); echo $dataAtual->format("Y-m-d") ?>" value="<?php echo isset($_GET["data-ativacao-inicial"]) ? $_GET["data-ativacao-inicial"] : "" ?>"/>
                            </div>
                            <div class="form-group-inline-no-break">
                                <label for="data-ativacao-final">Até: </label>
                                <input type="date" name="data-ativacao-final" id="data-ativacao-final" max="<?php $dataAtual = new DateTime(); echo $dataAtual->format("Y-m-d") ?>" value="<?php echo isset($_GET["data-ativacao-final"]) ? $_GET["data-ativacao-final"] : "" ?>" />
                            </div>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="ordem">Ordenar Por</label>
                            </div>
                            <select name="ordem" id="ordem">
                                <option <?php echo !empty($_GET["ordem"]) && $_GET["ordem"] == "cme" ? "selected" : ""  ?> value="cme">Código (Menor para Maior)</option>
                                <option <?php echo !empty($_GET["ordem"]) && $_GET["ordem"] == "cma" ? "selected" : ""  ?> value="cma">Código (Maior para Menor)</option>
                                <option <?php echo !empty($_GET["ordem"]) && $_GET["ordem"] == "paz" ? "selected" : ""  ?> value="paz">PET (A-Z)</option>
                                <option <?php echo !empty($_GET["ordem"]) && $_GET["ordem"] == "pza" ? "selected" : ""  ?> value="pza">PET (Z-A)</option>
                            </select>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="limite">Itens por Página</label>
                            </div>
                            <select name="limite" id="limite">
                                <option <?php echo !empty($_GET["limite"]) && $_GET["limite"] == "15" ? "selected" : ""  ?> value="15">15</option>
                                <option <?php echo !empty($_GET["limite"]) && $_GET["limite"] == "30" ? "selected" : ""  ?> value="30">30</option>
                                <option <?php echo !empty($_GET["limite"]) && $_GET["limite"] == "45" ? "selected" : ""  ?> value="45">45</option>
                                <option <?php echo !empty($_GET["limite"]) && $_GET["limite"] == "60" ? "selected" : ""  ?> value="60">60</option>
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
            <?php echo $viewVar["totalItens"]." rastreadores foram encontrados" ?>
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
                        <td><?php echo $rastreador->getCodigo(); ?></td>
                        <td><?php echo $rastreador->getNomePet() == null ? "Nenhum" : $rastreador->getNomePet(); ?></td>
                        <td>
                            <?php 
                            
                                $data = new DateTime($rastreador->getDataAtivacao()); 
                                echo $data->format("d/m/Y");
                            ?>
                        </td>
                        <td>
                            <button class="btn-cancel" onclick="Modal.mostrar('Excluir', 'Deseja realmente excluir o rastreador <?php echo $rastreador->getCodigo() ?>?', [{nome: 'Sim', classe: 'btn-primary', onclick: function(){window.location='http:\/\/<?php echo APP_HOST ?>/rastreadores/excluir/<?php echo $rastreador->getCodigo() ?>'}}, {nome: 'Não', classe: 'btn-cancel', onclick: function(){}}]);"><i class="fas fa-trash-alt"></i> <span class="texto-botao">Excluir</span></button>
                        </td>
                    </tr>
<?php endforeach; ?>

                </tbody>
            </table>
            <div class="center mt-3">
                <?php echo $viewVar["paginacao"] ?>
            </div>
        </div>
<?php endif; ?>
    </div>
    </section>
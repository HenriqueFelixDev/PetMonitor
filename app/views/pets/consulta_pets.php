    <section class="container">
        <div>
            <h2 class="title">PETs</h2>
        </div>
        <div class="mb-2">
            <a href="<?php echo $this->route("pets/novo") ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Novo Pet</a>
        </div>
        <div>
            <form action="" method="GET">
                <div class="form-group">
                    <input type="search" name="busca" id="busca" placeholder="Pesquisa" maxlength="64" autofocus value="<?php echo !empty($_GET["busca"]) ? $_GET["busca"] : "" ?>" />
                </div>

                <div class="mt-1">
                    <h3><a href="javascript:void(0);" id="filtro-toggle" onclick="javascript:mostrarOcultarElemento('div#grupo-filtros')"><i class="fas fa-filter"></i> Filtros</a></h3>

                    <div id="grupo-filtros">
                        <div class="form-group-inline mt-1">
                            <div class="form-group">
                                <label for="sexo">Sexo</label>
                            </div>
                            <select name="sexo" id="sexo" >
                                <option disabled value="-1">Selecione um sexo:</option>
                                <option <?php echo !empty($_GET["sexo"]) && $_GET["sexo"] == "m" ? "selected" : ""  ?> value="m">Macho</option>
                                <option <?php echo !empty($_GET["sexo"]) && $_GET["sexo"] == "f" ? "selected" : ""  ?> value="f">Fêmea</option>
                                <option <?php echo !empty($_GET["sexo"]) && $_GET["sexo"] == "mc" ? "selected" : ""  ?> value="mc">Macho Castrado</option>
                                <option <?php echo !empty($_GET["sexo"]) && $_GET["sexo"] == "fc" ? "selected" : ""  ?> value="fc">Fêmea Castrada</option>
                            </select>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="data-nasc-inicial">Data de Nascimento</label>
                            </div>
                            <div class="form-group-inline-no-break">
                                <label for="data-nasc-inicial">De:</label>
                                <input type="date" name="data-nasc-inicial" id="data-nasc-inicial" max="<?php $dataAtual = new DateTime(); echo $dataAtual->format("Y-m-d") ?>" value="<?php echo !empty($_GET["data-nasc-inicial"]) ? $_GET["data-nasc-inicial"] : "" ?>"/>
                            </div>
                            <div class="form-group-inline-no-break">
                                <label for="data-nasc-final">Até: </label>
                                <input type="date" name="data-nasc-final" id="data-nasc-final" max="<?php $dataAtual = new DateTime(); echo $dataAtual->format("Y-m-d") ?>" value="<?php echo !empty($_GET["data-nasc-final"]) ? $_GET["data-nasc-final"] : "" ?>" />
                            </div>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="ordem">Ordenar Por</label>
                            </div>
                            <select name="ordem" id="ordem">
                                <option <?php echo !empty($_GET["ordem"]) && $_GET["ordem"] == "cme" ? "selected" : ""  ?> value="cme">Código (Menor para Maior)</option>
                                <option <?php echo !empty($_GET["ordem"]) && $_GET["ordem"] == "cma" ? "selected" : ""  ?> value="cma">Código (Maior para Menor)</option>
                                <option <?php echo !empty($_GET["ordem"]) && $_GET["ordem"] == "naz" ? "selected" : ""  ?> value="naz">Nome (A-Z)</option>
                                <option <?php echo !empty($_GET["ordem"]) && $_GET["ordem"] == "nza" ? "selected" : ""  ?> value="nza">Nome (Z-A)</option>
                            </select>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="limite">Itens por Página</label>
                            </div>
                            <select name="limite" id="limite">
                                <option <?php echo !empty($_GET["limite"]) && $_GET["limite"] == "30" ? "selected" : ""  ?> value="15">30</option>
                                <option <?php echo !empty($_GET["limite"]) && $_GET["limite"] == "60" ? "selected" : ""  ?> value="30">60</option>
                                <option <?php echo !empty($_GET["limite"]) && $_GET["limite"] == "90" ? "selected" : ""  ?> value="45">90</option>
                                <option <?php echo !empty($_GET["limite"]) && $_GET["limite"] == "120" ? "selected" : ""  ?> value="60">120</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-1">
                    <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Pesquisar</button>
                </div>
            </form>
        </div>

        <div class="mt-2 resultado-consulta">
            <?php echo $viewVar["totalItens"]." PETs encontrados" ?>
            <section id="resultados-pets" class="mt-1">
                <!-- Seção onde ficarão os registros dos PETs consultados -->

<?php if (!empty($viewVar["pets"])): foreach($viewVar["pets"] as $pet): ?>

                <table class="tabela-pet" style="width:250px;border:thin solid grey;box-shadow:2px 2px 2px grey;display:inline-block;margin: 5px;border-radius:5px;">
                    <thead>
                        <tr>
                            <th colspan="3">
                                <h2><?php echo $pet->getNome(); ?></h2>
                                <div>
                                    <a class="text-white" href="<?php echo $this->route("rastreadores/vinculo/".$pet->getCodigo()) ?>" title="Vincular Rastreador"><i class="fas fa-link fa-lg"></i></a>
                                    &nbsp;
                                    <a class="text-white" href="<?php echo $this->route("pets/edicao/".$pet->getCodigo()) ?>" title="Editar PET"><i class="fas fa-edit fa-lg"></i></a>
                                    &nbsp;
                                    <button class="btn-sem-borda text-white" title="Excluir PET" onclick="Modal.mostrar('Excluir', 'Todos os dados de trajetos realizados pelo PET e o rastreador ao qual ele está vinculado também serão deletados. <br/><br/>Deseja realmente excluir os dados do PET <?php echo $pet->getNome() ?>?', [{nome: 'Sim', classe: 'btn-primary', onclick: function(){window.location='<?php echo $this->route('pets/excluir/'.$pet->getCodigo()) ?>';}}, {nome: 'Não', classe: 'btn-cancel', onclick: function(){console.log('teste');}}]);"><i class="fas fa-trash fa-lg"></i></button>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3"><img style="border-radius:50%;" src="<?php $foto = $pet->getFoto() == null ? "default.png" : $pet->getFoto();  echo $this->asset("fotos/".$foto) ?>" width="150" height="150" /></td>
                        </tr>
                        <!--
                        <tr><th colspan="3">Código</th></tr>
                        <tr>
                            <td colspan="3"><?php echo $pet->getCodigo(); ?></td>
                        </tr>-->
                        <tr>
                            <th>Espécie</th>
                            <td style="text-align:left;"><?php echo $pet->getEspecie(); ?></td>
                            
                        </tr>
                        <tr>
                            
                            <th>Raça</th>
                            <td style="text-align:left;white-space:nowrap;"><?php echo !empty($pet->getRaca()) ? $pet->getRaca() : "Não Definida"; ?></td>
                            
                        </tr>
                        <tr>
                            <th>Sexo</th>
                            <td style="text-align:left;white-space:nowrap;">
                                <div style="width:115px;text-overflow:clip;"><?php 
                                    switch ($pet->getSexo()) {
                                        case "m":
                                            echo "Macho";
                                            break;
                                            
                                        case "f":
                                            echo "Fêmea";
                                            break;
                                        
                                        case "mc":
                                            echo "Macho Castrado";
                                            break;
                                            
                                        case "fc":
                                            echo "Fêmea Castrada";
                                            break;
                                        
                                        default:
                                            echo "Desconhecido";
                                    } 
                                
                                ?></div>
                            </td>
                        </tr>
                        <tr>
                            
                            <th>Data de Nascimento</th>
                            <td style="text-align:left;">
                                <?php 
                                    $data = new DateTime($pet->getDataNascimento());
                                    echo $data->format("d/m/Y");  
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="<?php echo $this->route("monitoramento/index/".$pet->getCodigo()) ?>" class="btn btn-primary"><i class="fas fa-map-marked-alt"></i> Visualizar Trajeto</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

<?php endforeach; endif; ?>
            </section>
            <section class="center mt-2">
                <div class="btn-group"><?php echo $viewVar["paginacao"] ?></div>
            </section>
        </div>
    </section>
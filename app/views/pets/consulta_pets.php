        <div class="mb-2">
            <a href="<?= $this->route("pets/novo") ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Novo Pet</a>
        </div>
        <div>
            <form action="" method="GET">
                <div class="form-group">
                    <input type="search" name="busca" id="busca" placeholder="Pesquisa" maxlength="64" autofocus value="<?= $dadosUtil::getValorArray($_GET, "busca") ?>" />
                </div>

                <div class="mt-1">
                    <h3><a href="javascript:void(0);" id="filtro-toggle"><i class="fas fa-filter"></i> Filtros</a></h3>

                    <div id="grupo-filtros">
                        <div class="form-group-inline mt-1">
                            <div class="form-group">
                                <label for="sexo">Sexo</label>
                            </div>

                            <?php $sexo = $dadosUtil::getValorArray($_GET, "sexo") ?>
                            <select name="sexo" id="sexo" >
                                <option value="">Selecione um sexo:</option>
                                <option <?= $sexo == "m" ? "selected" : ""  ?> value="m">Macho</option>
                                <option <?= $sexo == "f" ? "selected" : ""  ?> value="f">Fêmea</option>
                                <option <?= $sexo == "mc" ? "selected" : ""  ?> value="mc">Macho Castrado</option>
                                <option <?= $sexo == "fc" ? "selected" : ""  ?> value="fc">Fêmea Castrada</option>
                            </select>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="data-nasc-inicial">Data de Nascimento</label>
                            </div>

                            <?php
                                $dataAtual = new DateTime();
                                $dataMaxima = $dataAtual->format("Y-m-d");
                            ?>
                            <div class="form-group-inline-no-break">
                                <label for="data-nasc-inicial">De:</label>
                                <input type="date" name="data-nasc-inicial" id="data-nasc-inicial" max="<?= $dataMaxima ?>" value="<?= $dadosUtil::getValorArray($_GET, "data-nasc-inicial") ?>"/>
                            </div>
                            <div class="form-group-inline-no-break">
                                <label for="data-nasc-final">Até: </label>
                                <input type="date" name="data-nasc-final" id="data-nasc-final" max="<?= $dataMaxima ?>" value="<?= $dadosUtil::getValorArray($_GET, "data-nasc-final") ?>" />
                            </div>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="ordem">Ordenar Por</label>
                            </div>

                            <?php $ordem = $dadosUtil::getValorArray($_GET, "ordem") ?>
                            <select name="ordem" id="ordem">
                                <option <?= $ordem == "cme" ? "selected" : ""  ?> value="cme">Código (Menor para Maior)</option>
                                <option <?= $ordem == "cma" ? "selected" : ""  ?> value="cma">Código (Maior para Menor)</option>
                                <option <?= $ordem == "naz" ? "selected" : ""  ?> value="naz">Nome (A-Z)</option>
                                <option <?= $ordem == "nza" ? "selected" : ""  ?> value="nza">Nome (Z-A)</option>
                            </select>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="limite">Itens por Página</label>
                            </div>

                            <?php $limite = $dadosUtil::getValorArray($_GET, "limite") ?>
                            <select name="limite" id="limite">
                                <option <?= $limite == "30" ? "selected" : ""  ?> value="30">30</option>
                                <option <?= $limite == "60" ? "selected" : ""  ?> value="60">60</option>
                                <option <?= $limite == "90" ? "selected" : ""  ?> value="90">90</option>
                                <option <?= $limite == "120" ? "selected" : ""  ?> value="120">120</option>
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
            <?= "{$viewVar["totalItens"]} PETs encontrados" ?>
            <section id="resultados-pets" class="mt-1">

<?php if (!empty($viewVar["pets"])): foreach($viewVar["pets"] as $pet): ?>
                <section class="pet-card">
                    <header>
                        <h2><?= $pet->getNome(); ?></h2>
                        <div>
                            <a  href="<?= $this->route("rastreadores/vinculo/{$pet->getCodigo()}") ?>" title="Vincular Rastreador"><i class="fas fa-link fa-lg"></i></a>
                            &nbsp;
                            <a  href="<?= $this->route("pets/edicao/{$pet->getCodigo()}") ?>" title="Editar PET"><i class="fas fa-edit fa-lg"></i></a>
                            &nbsp;
                            <button class="btn-sem-borda" title="Excluir PET" onclick="excluirPetModal('<?= $pet->getNome().'\', \''. $this->route('pets/excluir/'.$pet->getCodigo()) ?>')" >
                                <i class="fas fa-trash fa-lg"></i>
                            </button>
                        </div>
                    </header>

                    <section>
                        <div class="imagem">
                            <?php $foto = $dadosUtil::getValorVar($pet->getFoto(), "default.png") ?>
                            <img style="border-radius:50%;" src="<?= $this->asset("fotos/${foto}") ?>" width="150" height="150" />
                        </div>

                        <div class="dados">
                            <div class="tr">
                                <div class="th">Espécie</div>
                                <div class="td"><?= $pet->getEspecie(); ?></div>
                            </div>

                            <div class="tr">
                                <div class="th">Raça</div>
                                <div class="td"><?= $dadosUtil::getValorVar($pet->getRaca(), "Não Definida") ?></div>
                            </div>

                            <div class="tr">
                                <div class="th">Sexo</div>
                                <div class="td">
                                    <?php 
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
                                    
                                    ?>
                                </div>
                            </div>

                            <div class="tr">
                                <div class="th">Cor</div>
                                <div class="td"><?= $pet->getCor() ?></div>
                            </div>

                            <div class="tr">
                                <div class="th">Data de Nascimento</div>
                                <div class="td">
                                    <?php 
                                        $data = new DateTime($pet->getDataNascimento());
                                        echo $data->format("d/m/Y");  
                                    ?>
                                </div>
                            </div>   
                        </div>                 

                    </section>

                    <footer>
                        <div>
                        <a href="<?= $this->route("monitoramento/trajeto/{$pet->getCodigo()}") ?>" class="btn btn-primary"><i class="fas fa-map-marked-alt"></i> Visualizar Trajeto</a>
                        </div>
                    </footer>
                </section>
<?php endforeach; endif; ?>
            </section>
            
            <section class="center mt-2">
                <div class="btn-group"><?= $viewVar["paginacao"] ?></div>
            </section>
        </div>
    </section>
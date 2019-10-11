    <section class="container">
        <div>
            <h2 class="title">PETs</h2>
        </div>

        <div class="mb-2">
            <a href="http://<?= APP_HOST ?>/pets/novo" class="btn btn-primary"><i class="fas fa-plus"></i> Novo Pet</a>
        </div>

        <div>
            <form action="" method="GET">
                <div class="form-group-inline">
                    <input type="search" name="busca" id="busca" placeholder="Pesquisa" maxlength="64" autofocus />
                </div>

                <div class="form-group-inline">
                    <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Pesquisar</button>
                </div>

                <div class="mt-1">
                    <h3><a href="#" id="filtro-toggle" onclick="javascript:mostrarOcultarElemento('div#grupo-filtros')"><i class="fas fa-filter"></i> Filtros</a></h3>

                    <div id="grupo-filtros">
                        <div class="form-group-inline mt-1">
                            <div class="form-group">
                                <label for="sexo">Sexo</label>
                            </div>
                            <select name="sexo" id="sexo" >
                                <option selected disabled value="-1">Selecione um sexo:</option>
                                <option value="m">Macho</option>
                                <option value="f">Fêmea</option>
                                <option value="mc">Macho Castrado</option>
                                <option value="fc">Fêmea Castrada</option>
                            </select>
                        </div>

                        <div class="form-group-inline mx-2">
                            <div class="form-group">
                                <label for="data-nasc-inicial">Data de Nascimento</label>
                            </div>
                            <div class="form-group-inline">
                                <label for="data-nasc-inicial">De:</label>
                                <input type="date" name="data-nasc-inicial" id="data-nasc-inicial" />
                            </div>
                            <div class="form-group-inline">
                                <label for="data-nasc-final">Até: </label>
                                <input type="date" name="data-nasc-final" id="data-nasc-final" />
                            </div>
                        </div>

                        

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="ordem">Ordenar Por</label>
                            </div>
                            <select name="ordem" id="ordem">
                                <option selected disabled value="-1">Selecione uma opção</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div>
            <section>
                <!-- Seção onde ficarão os registros dos PETs consultados -->
            </section>
        </div>
    </section>
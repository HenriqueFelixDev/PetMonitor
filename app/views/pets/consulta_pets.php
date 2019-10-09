    <section class="container">
        <div>
            <h2 class="title">PETs</h2>
        </div>

        <div class="mb-2">
            <a href="http://<?= APP_HOST ?>/pets/novo" class="btn btn-primary">Novo Pet</a>
        </div>

        <div>
            <form action="" method="GET">
                <div class="form-group-inline">
                    <input type="search" name="busca" id="busca" placeholder="Pesquisa" maxlength="64" autofocus />
                </div>

                <div class="form-group-inline">
                    <button type="submit" class="btn-primary">Pesquisar</button>
                </div>

                <div class="mt-1">
                    <h3><a href="#"><i class="fas fa-filter"></i> Filtros</a></h3>
                    <div class="form-group-inline mt-1">
                        <label for="sexo">Sexo</label>
                        <select name="sexo" id="sexo" >
                            <option selected disabled value="-1">Selecione um sexo:</option>
                            <option value="m">Macho</option>
                            <option value="f">Fêmea</option>
                            <option value="mc">Macho Castrado</option>
                            <option value="fc">Fêmea Castrada</option>
                        </select>
                    </div>

                    <div class="form-group-inline">
                        <label for="data-nasc-inicial">Data de Nascimento</label>
                        <input type="date" name="data-nasc-inicial" id="data-nasc-inicial" />
                    </div>

                    <div class="form-group-inline">
                        <label for="data-nasc-final"></label>
                        <input type="date" name="data-nasc-final" id="data-nasc-final" />
                    </div>

                    <div class="form-group-inline">
                        <label for="ordem">Ordenar Por</label>
                        <select name="ordem" id="ordem">
                            <option selected disabled value="-1">Selecione uma opção</option>
                        </select>
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
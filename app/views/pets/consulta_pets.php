    <section>
        <div>
            <h2>PETs</h2>
        </div>

        <div>
            <form action="" method="GET">
                <div>
                    <input type="search" name="busca" id="busca" placeholder="Pesquisa" maxlength="64" autofocus />
                </div>

                <div>
                    <label for="sexo">Sexo</label>
                    <select name="sexo" id="sexo" >
                        <option selected disabled value="-1">Selecione um sexo:</option>
                        <option value="m">Macho</option>
                        <option value="f">Fêmea</option>
                        <option value="mc">Macho Castrado</option>
                        <option value="fc">Fêmea Castrada</option>
                    </select>
                </div>

                <div>
                    <label for="data-nasc-inicial">Data de Nascimento</label>
                    <input type="date" name="data-nasc-inicial" id="data-nasc-inicial" />
                </div>

                <div>
                    <label for="data-nasc-final"></label>
                    <input type="date" name="data-nasc-final" id="data-nasc-final" />
                </div>

                <div>
                    <label for="ordem">Ordenar Por</label>
                    <select name="ordem" id="ordem">
                        <option selected disabled value="-1">Selecione uma opção</option>
                    </select>
                </div>

                <div>
                    <button type="submit">Pesquisar</button>
                </div>
            </form>
        </div>

        <div>
            <section>
                <!-- Seção onde ficarão os registros dos PETs consultados -->
            </section>
        </div>
    </section>
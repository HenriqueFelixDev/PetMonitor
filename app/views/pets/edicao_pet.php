    <section>
        <div>
            <h2>PETs</h2>
        </div>

        <div>
            <form action="" method="POST" enctype="multipart/form-data">

                <div>
                    <label for="foto">Foto</label>
                    <img src="" />
                    <input type="file" name="foto" id="foto" value="Escolher Foto" />
                </div>

                <div>
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" maxlength="64" required autofocus />
                </div>

                <div>
                    <label for="especie">Espécie</label>
                    <input type="text" name="especie" id="especie" maxlength="32" required />
                </div>

                <div>
                    <label for="raca">Raça<small>(Opcional)</small></label>
                    <input type="text" name="raca" id="raca" maxlength="32" />
                </div>

                <div>
                    <label for="sexo">Sexo</label>
                    <select name="sexo" id="sexo" required>
                        <option>Selecione um sexo</option>
                        <option value="m">Macho</option>
                        <option value="f">Fêmea</option>
                        <option value="mc">Macho Castrado</option>
                        <option value="fc">Fêmea Castrada</option>
                    </select>
                </div>

                <div>
                    <label for="cor">Cor</label>
                    <input type="text" name="cor" id="cor" maxlength="32" required />
                </div>

                <div>
                    <label for="data-nasc">Data de Nascimento</label>
                    <input type="date" name="data-nasc" id="data-nasc" />
                </div>

                <div>
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </section>
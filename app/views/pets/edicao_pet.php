    <section class="container">
        <div>
            <h2 class="title">Novo PET</h2>
        </div>

        <div>
            <form action="http://<?= APP_HOST ?>/pets/salvar" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="foto">Foto</label>
                    <img src="" id="foto-pet" alt="Foto do Pet" />
                    <input type="file" name="foto" id="foto" value="Escolher Foto" />
                </div>

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" maxlength="64" required autofocus />
                </div>

                <div class="form-group">
                    <label for="especie">Espécie</label>
                    <input type="text" name="especie" id="especie" maxlength="32" required />
                </div>

                <div class="form-group">
                    <label for="raca">Raça<small>(Opcional)</small></label>
                    <input type="text" name="raca" id="raca" maxlength="32" />
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" id="sexo" required>
                        <option>Selecione um sexo</option>
                        <option value="m">Macho</option>
                        <option value="f">Fêmea</option>
                        <option value="mc">Macho Castrado</option>
                        <option value="fc">Fêmea Castrada</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cor">Cor</label>
                    <input type="text" name="cor" id="cor" maxlength="32" required />
                </div>

                <div class="form-group">
                    <label for="data-nasc">Data de Nascimento</label>
                    <input type="date" name="data-nasc" id="data-nasc" />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </section>
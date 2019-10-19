    <section class="container">
        <div>
            <h2 class="title">Monitoramento dos PETs</h2>
        </div>

        <div>
            <form action="" method="GET">
                <div class="form-group-inline">
                    <div class="mb-1"><label for="pet">PET</label></div>
                    <input type="text" name="pet" id="pet" maxlength="64" required />
                </div>

                <div class="form-group-inline">
                    <div class="mb-1"><label for="data-inicial">Data Inicial</label></div>
                    <input type="date" name="data-inicial" id="data-inicial" />
                </div>

                <div class="form-group-inline">
                    <div class="mb-1"><label for="data-final">Data Final</label></div>
                    <input type="date" name="data-final" id="data-final" />
                </div>

                <div class="form-group-inline">
                    <button type="submit" class="btn-primary">Visualizar Trajeto</button>
                </div>
            </form>
        </div>

        <div class="mt-1">
            <!-- Seção onde ficará o mapa com o trajeto do pet -->
            <section id="mapa-trajeto">
                <img src=" <?= $viewVar["trajeto"] ?>" />
            </section>
        </div>
    </section>
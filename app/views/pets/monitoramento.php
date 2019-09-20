    <section>
        <div>
            <h2>Monitoramento dos PETs</h2>
        </div>

        <div>
            <form action="" method="GET">
                <div>
                    <label for="pet">PET</label>
                    <input type="text" name="pet" id="pet" maxlength="64" required />
                </div>

                <div>
                    <label for="data-inicial">Data Inicial</label>
                    <input type="date" name="data-inicial" id="data-inicial" />
                </div>

                <div>
                    <label for="data-final">Data Final</label>
                    <input type="date" name="data-final" id="data-final" />
                </div>

                <div>
                    <button type="submit">Visualizar Trajeto</button>
                </div>
            </form>
        </div>

        <div>
            <!-- Seção onde ficará o mapa com o trajeto do pet -->
            <section></section>
        </div>
    </section>
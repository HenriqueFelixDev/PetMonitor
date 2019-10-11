    <section class="container">
        <div>
            <h2 class="title">Rastreadores</h2>
        </div>

        <div class="mb-2">
            <a href="http://<?= APP_HOST ?>/rastreadores/ativacao" class="btn btn-primary">Ativar Rastreador</a>
        </div>

        <div class="mb-2">
            <form action="" method="GET">

                <div class="form-group-inline">
                    <label for="codigo-rastreador">Código</label>
                    <input type="text" name="codigo-rastreador" id="codigo-rastreador" maxlength="16" autofocus />
                </div>

                <div class="form-group-inline">
                    <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Pesquisar</button>
                </div>
            </form>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>PET</th>
                        <th>DATA DE ATIVAÇÃO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn-cancel"><i class="fas fa-trash-alt"></i> Excluir</button>
                            <button class="btn-primary"><i class="fas fa-unlink"></i> Desvincular Pet</button>
                            <button class="btn-primary"><i class="fas fa-link"></i> Vincular Pet</button>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn-cancel"><i class="fas fa-trash-alt"></i> Excluir</button>
                            <button class="btn-primary"><i class="fas fa-unlink"></i> Desvincular Pet</button>
                            <button class="btn-primary"><i class="fas fa-link"></i> Vincular Pet</button>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn-cancel"><i class="fas fa-trash-alt"></i> Excluir</button>
                            <button class="btn-primary"><i class="fas fa-unlink"></i> Desvincular Pet</button>
                            <button class="btn-primary"><i class="fas fa-link"></i> Vincular Pet</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
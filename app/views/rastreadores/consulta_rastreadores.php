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
                    <input type="number" name="codigo-rastreador" id="codigo-rastreador" maxlength="16" autofocus />
                </div>

                <div class="form-group-inline">
                    <button type="submit" class="btn-primary">Pesquisar</button>
                </div>

                <div class="form-group">
                    <label for="situacao">Situação</label>
                    <select name="situacao" id="situacao">
                        <option selected disabled value="-1">Selecione uma situação</option>
                    </select>
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
                        <th>SITUAÇÃO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn-primary">Editar</button>
                            <button class="btn-cancel">Excluir</button>
                            <button class="btn-info">Desvincular Pet</button>
                            <button class="btn-info">Vincular Pet</button>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button>Editar</button>
                            <button>Excluir</button>
                            <button>Desvincular Pet</button>
                            <button>Vincular Pet</button>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button>Editar</button>
                            <button>Excluir</button>
                            <button>Desvincular Pet</button>
                            <button>Vincular Pet</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
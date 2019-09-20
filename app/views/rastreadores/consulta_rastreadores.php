    <section>
        <div>
            <h2>Rastreadores</h2>
        </div>
        <div>
            <form action="" method="GET">

                <div>
                    <label for="codigo-rastreador">Código</label>
                    <input type="number" name="codigo-rastreador" id="codigo-rastreador" maxlength="16" autofocus />
                </div>

                <div>
                    <label for="situacao">Situação</label>
                    <select name="situacao" id="situacao">
                        <option selected disabled value="-1">Selecione uma situação</option>
                    </select>
                </div>

                <div>
                    <button type="submit">Pesquisar</button>
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
<main>

    <div class="row">

        <a href="../../index.php">
            <button style="margin-left: 10px" class="btn btn-danger mt-3">Voltar</button>
        </a>

        <h2 class="mt-3" style="margin-left: 15px">Cadastro de Cliente:</h2>

    </div>

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>E-mail</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <tr v-for="cliente in clientes">
                <td>{{ cliente.id }}</td>
                <td>{{ cliente.nome }}</td>
                <td>{{ cliente.cpf }}</td>
                <td>{{ cliente.email }}</td>
                <td>
                    <button class="btn btn-success" @click="selectCliente(cliente)"><span class="glyphicon glyphicon-edit"></span>Editar</button>
                    <button class="btn btn-danger" @click="deleteCliente(cliente)"><span class="glyphicon glyphicon-trash"></span>Excluir</button>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="col-md-6 offset-md-3">
        <form method="post">
            <div class="row" v-if="!isEditingCL">
                <div class="col-md-12">
                    <label>Nome:</label>
                    <input type="text" class="form-control" v-model="novoCliente.nome" placeholder="Nome do cliente..." maxlength="255">
                </div>

                <div class="col-md-6 mt-3">
                    <label>CPF:</label>
                    <input type="number" class="form-control" v-model="novoCliente.cpf" placeholder="CPF do cliente...">
                </div>

                <div class="col-md-6 mt-3">
                    <label>E-mail:</label>
                    <input type="email" class="form-control" v-model="novoCliente.email" placeholder="Email do cliente..." maxlength="255">
                </div>

            </div>

            <div class="row" v-if="isEditingCL">

                <div class="col-md-12">
                    <label>Nome:</label>
                    <input type="text" class="form-control" v-model="clickCliente.nome" placeholder="Nome do Cliente..." maxlength="255">
                </div>

                <div class="col-md-6 mt-3">
                    <label>CPF:</label>
                    <input type="number" class="form-control" v-model="clickCliente.cpf" placeholder="CPF do cliente...">
                </div>

                <div class="col-md-6 mt-3">
                    <label>E-mail:</label>
                    <input type="email" class="form-control" v-model="clickCliente.email" placeholder="Email do cliente..." maxlength="255">
                </div>

            </div>

            <div class="form-group" style="margin-left: 87%">
                <button type="button" class="btn btn-success mt-3" @click="saveCliente">{{ isEditingCL ? 'Atualizar' : 'Salvar' }}</button>
            </div>

        </form>
    </div>

</main>
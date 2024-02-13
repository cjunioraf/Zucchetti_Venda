<main>

    <div class="row">

        <a href="../../index.php">
            <button style="margin-left: 10px" class="btn btn-danger mt-3">Voltar</button>
        </a>

        <h2 class="mt-3" style="margin-left: 15px">Cadastro de Formas de Pagamento:</h2>

    </div>

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>Parcelas</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <tr v-for="formapagto in forma_pagtos">
                <td>{{ formapagto.id }}</td>
                <td>{{ formapagto.nome }}</td>
                <td>{{ formapagto.parcelas }}</td>
                <td>
                    <button class="btn btn-success" @click="selectFormapagto(formapagto)"><span class="glyphicon glyphicon-edit"></span>Editar</button>
                    <button class="btn btn-danger" @click="deleteFormapagto(formapagto)"><span class="glyphicon glyphicon-trash"></span>Excluir</button>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="col-md-6 offset-md-3">
        <form method="post">
            <div class="row" v-if="!isEditingFP">
                <div class="col-md-12">
                    <label>Forma de Pagamento:</label>
                    <input type="text" class="form-control" placeholder="Nome da Forma de Pagamento" v-model="novoFormapagto.nome" maxlength="255">
                </div>
                <div class="col-md-12 mt-3">
                    <label>Número de Parcelas:</label>
                    <input type="number" class="form-control" v-model="novoFormapagto.parcelas" placeholder="Quantidade de parcelas" nim="1">
                </div>
            </div>

            <div class="row" v-if="isEditingFP">
                <div class="col-md-12">
                    <label>Forma de Pagamento:</label>
                    <input type="text" class="form-control" placeholder="Nome da forma de pagamento..." v-model="clickFormapagto.nome" maxlength="255">
                </div>
                <div class="col-md-12 mt-3">
                    <label>Número de Parcelas:</label>
                    <input type="number" class="form-control" v-model="clickFormapagto.parcelas" placeholder="Qunatidade de parcelas...">
                </div>
            </div>

            <div class="form-group" style="margin-left: 87%">
                <button type="button" class="btn btn-success mt-3" @click="saveFormapagto">{{ isEditingFP ? 'Atualizar' : 'Salvar' }}</button>
            </div>

        </form>
    </div>

</main>
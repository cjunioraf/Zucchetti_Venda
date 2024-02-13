<main>

    <div class="row">

        <a href="../../index.php">
            <button style="margin-left: 10px" class="btn btn-danger mt-3">Voltar</button>
        </a>

        <h2 class="mt-3" style="margin-left: 15px">Cadastro de Produto:</h2>

    </div>

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>Qtd. Estoque</th>
            <th>Valor Unitário</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <tr v-for="produto in produtos">
                <td>{{ produto.id }}</td>
                <td>{{ produto.nome }}</td>
                <td>{{ produto.qtd_estoque }}</td>
                <td>{{ produto.preco_unitario }}</td>
                <td>
                    <button class="btn btn-success" @click="selectProduto(produto)"><span class="glyphicon glyphicon-edit"></span>Editar</button>
                    <button class="btn btn-danger" @click="deleteProduto(produto)"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="col-md-6 offset-md-3">
        <form method="post">
            <div class="row" v-if="!isEditing">
                <div class="col-md-12">
                    <label>Nome Produto:</label>
                    <input type="text" class="form-control" placeholder="Nome do Produto" v-model="novoProduto.nome" maxlength="255">
                </div>
                <div class="col-md-6 mt-3">
                    <label>Qtd. Estoque:</label>
                    <input type="number" class="form-control" v-model="novoProduto.qtd_estoque" placeholder="Quantidade em estoque..." nim="1">
                </div>
                <div class="col-md-6 mt-3">
                    <label>Valor Unitário:</label>
                    <input type="text" class="form-control" v-model="novoProduto.preco_unitario" pattern="[0-9]+([,.][0-9]+)?" placeholder="Preço Unitário...">
                </div>
            </div>

            <div class="row" v-if="isEditing">
                <div class="col-md-12">
                    <label>Nome Produto:</label>
                    <input type="text" class="form-control" placeholder="Nome do Produto" v-model="clickProduto.nome" maxlength="255">
                </div>
                <div class="col-md-6 mt-3">
                    <label>Qtd. Estoque:</label>
                    <input type="number" class="form-control" v-model="clickProduto.qtd_estoque" placeholder="Quantidade em estoque..." nim="1">
                </div>
                <div class="col-md-6 mt-3">
                    <label>Valor Unitário:</label>
                    <input type="text" class="form-control" v-model="clickProduto.preco_unitario" pattern="[0-9]+([,.][0-9]+)?" placeholder="Preço Unitário...">
                </div>
            </div>

            <div class="form-group" style="margin-left: 87%">
                <button type="button" class="btn btn-success mt-3" @click="saveProduto">{{ isEditing ? 'Atualizar' : 'Salvar' }}</button>
            </div>

        </form>
    </div>

</main>
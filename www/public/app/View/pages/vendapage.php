<div id="app" class="container mt-5">

    <div class="d-flex justify-content-between">

        <div class="col-md-6 mt-3" v-if="mostrarCampoPesquisaCli">
            <label for="clientePesquisa">Nome do Cliente:</label>
            <div class="d-flex align-items-center">
                <input v-model="clientePesquisa" name="clientePesquisa" placeholder="Digite o nome do cliente..." class="form-control" />
                <button @click="getClientessel" class="btn btn-primary ml-2">Pesquisar</button>
            </div>
        </div>

        <div class="col-md-6 mt-3" v-if="mostrarSelectCli">
            <label for="cliente_id">Selecione o Cliente:</label>
            <div class="d-flex align-items-center">
                <select v-model="cliente_id" class="form-select form-control" id="cliente_id">
                    <option v-for="clientess in clientessel" :key="clientess.id" :value="clientess.id">{{ clientess.nome }}</option>
                </select>
                <button @click="limparPesquisaCli" class="btn btn-secondary ml-2">Limpar</button>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <label for="form">Forma de Pagamento:</label>
            <select v-model="forma_pagto_id" class="form-select form-control" id="forma_pagto_id">
                <option value="">Selecione a Forma de Pagamento</option>
                <option v-for="formp in forma_pagtos" :key="formp.id" :value="formp.id">{{ formp.nome }}</option>
            </select>
        </div>

    </div>

    <hr class="my-4" style="border-top: 1px solid #ccc;">

    <div class="d-flex justify-content-between">

        <div class="col-md-6" v-if="mostrarCampoPesquisaPro">

            <label for="produtoPesquisa">Nome do Produto:</label>
            <div class="d-flex align-items-center">
                <input v-model="produtoPesquisa" placeholder="Digite o nome do produto..." class="form-control" />
                <button @click="getProdutossel" class="btn btn-primary ml-2">Pesquisar</button>
            </div>

        </div>

        <div class="col-md-6" v-if="mostrarSelectPro">

            <label for="produto_id">Selecione o Produto:</label>

            <div class="d-flex align-items-center">
                <select v-model="produto_id" class="form-select form-control" id="produto_id">
                    <option v-for="produtoss in produtossel" :key="produtoss.id" :value="produtoss.id">{{ produtoss.nome }}</option>
                </select>
                <button @click="limparPesquisaPro" class="btn btn-secondary ml-2">Limpar</button>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="precoUnitarioSelecionado">Preço:</label>
                    <input v-model="precoUnitarioSelecionado" class="form-control" disabled />
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                <label for="quantidade">Quantidade:</label>
                <input v-model="quantidade" type="number" class="form-control" @input="calcularTotal" min="1" />
            </div>

            <div class="col-md-6" style="margin-left: -15px">
                <label for="valor_item">Valor Total Item:</label>
                <input v-model="valor_item" type="number" class="form-control" disabled />
            </div>

            <div class="col-md-6 mt-3">
                <label for="valor_total">Valor Total Venda:</label>
                <input v-model="valor_total" type="number" class="form-control" disabled />
            </div>

        </div>

    </div>

    <div class="d-flex justify-content-between">

        <div class="form-group mt-3">
            <button type="button" class="btn btn-success" @click="finalizarVenda">Finalizar Venda</button>
        </div>

        <div class="form-group mt-3">
            <button type="button" class="btn btn-primary mt-3" @click="gravarVenda">Vender Item</button>
        </div>

    </div>

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <th>ID</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
            <th>Valor Total</th>
        </thead>
        <tbody>
            <tr v-for="vendaitem in vendaitens">
                <td>{{ vendaitem.id }}</td>
                <td>{{ vendaitem.nome }}</td>
                <td>{{ vendaitem.quantidade }}</td>
                <td>{{ vendaitem.valor_unitario }}</td>
                <td>{{ vendaitem.valor_item }}</td>
            </tr>
        </tbody>
    </table>

</div>
<main>

    <div id="app" class="container mt-5">

        <div class="row">

            <a href="../../index.php">
                <button style="margin-left: 10px" class="btn btn-danger mt-3">Voltar</button>
            </a>

            <h2 class="mt-3" style="margin-left: 15px">Consulta Venda:</h2>

        </div>

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

        <div class="row" style="margin-left: 1px">
            <!-- Campo de data de início -->
            <div class="col-md-3 mt-3">
                <label for="dataInicio">Data de Início:</label>
                <input v-model="dataInicio" type="date" class="form-control" id="dataInicio">
            </div>

            <!-- Campo de data de fim -->
            <div class="col-md-3 mt-3">
                <label for="dataFim">Data de Fim:</label>
                <input v-model="dataFim" type="date" class="form-control" id="dataFim">
            </div>

            <div class="form-group mt-3" style="margin-left:40%">
                <button type="button" class="btn btn-success mt-3" @click="buscavendas">Consultar</button>
            </div>

        </div>

        <table class="table table-bordered table-striped mt-3">
            <thead>
                <th>Data Venda</th>
                <th>Cliete</th>
                <th>Forma de Pagamento</th>
                <th>Valor Total</th>
            </thead>
            <tbody>
                <tr v-for="consultavenda in consultavendas">
                    <td>{{ consultavenda.data_venda }}</td>
                    <td>{{ consultavenda.cliente_nome }}</td>
                    <td>{{ consultavenda.formanome }}</td>
                    <td>{{ consultavenda.valor_total }}</td>
                </tr>
            </tbody>
        </table>

    </div>

</main>
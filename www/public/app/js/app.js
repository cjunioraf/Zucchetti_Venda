var app = new Vue({
    el: '#vuejsproduto',
    data: {
        produtos: [],
        forma_pagtos: [],
        clientes: [],
        vendaitens: [],
        consultavendas: [],
        novoProduto: { nome: '', qtd_estoque: '', preco_unitario: '' },
        novoFormapagto: { nome: '', parcelas: '' },
        novoCliente: { nome: '', cpf: '', cep_id: '', email: '' },
        clickProduto: {},
        clickFormapagto: {},
        clickCliente: {},
        clickVendaitem: {},
        isEditing: false,
        isEditingFP: false,
        isEditingCL: false,
        forma_pagto_id: '',
        produtoPesquisa: '',
        clientePesquisa: '',
        quantidade: 1,
        cliente_id: null,
        produto_id: null,
        venda_id_atual: null,
        mostrarSelectCli: false,
        mostrarSelectPro: false,
        mostrarCampoPesquisaCli: true,
        mostrarCampoPesquisaPro: true,
        precoUnitarioSelecionado: null,
        valor_item: 0,
        valor_total: 0,
        dataInicio: '',
        dataFim: ''
    },
    mounted: function () {
        this.getProdutos();
        this.getFormapagtos();
        this.getClientes();
        this.getFormapagtossel();
        this.getClientessel();
        this.getProdutossel();
    },
    methods: {

        buscavendas: function () {
            // Adicione os parâmetros de data à sua solicitação de API
            var consulvenda = {
                params: {
                    cliente_id: this.cliente_id,
                    forma_pagto_id: this.forma_pagto_id,
                    dataInicio: this.dataInicio,
                    dataFim: this.dataFim
                }
            };

            $url = 'http://localhost:4500/public/app/api/api.php?crud=consulvenda';

            axios.get($url, consulvenda)
                .then((response) => {
                    if (response.data.error) {
                        console.error(response.data.message);
                    } else {
                        this.consultavendas = response.data.consultavendas;
                        this.limparCamposFin();
                        this.limparPesquisaCli();
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        finalizarVenda: function () {
            // Certifique-se de que a venda em andamento existe
            if (this.venda_id_atual) {

                var vendaFinData = {
                    venda_id: this.venda_id_atual,
                    valor_total: this.valor_total
                };
                // Enviar a solicitação para a API
                $url = 'http://localhost:4500/public/app/api/api.php?crud=finalizarvenda';
                axios.post($url, vendaFinData)
                    .then((response) => {
                        // console.log($url);
                        if (response.data.error) {
                            console.error(response.data.message);
                        } else {
                            this.venda_id_atual = null;
                            this.limparCampos();
                            this.limparCamposFin();
                            this.limparPesquisaCli();
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                console.error("Nenhuma venda em andamento para finalizar.");
            }
        },

        calcularTotal: function () {
            // Lógica para calcular o total com base na quantidade e preço unitário
            if (!isNaN(this.quantidade) && !isNaN(this.precoUnitarioSelecionado)) {
                this.valor_item = (this.quantidade * this.precoUnitarioSelecionado).toFixed(2);
            }
        },

        calcularTotal: function () {
            console.log('Método calcularTotal chamado');
            console.log('Quantidade:', this.quantidade);
            console.log('Preço Unitário:', this.precoUnitarioSelecionado);

            // Lógica para calcular o total com base na quantidade e preço unitário
            if (!isNaN(this.quantidade) && !isNaN(this.precoUnitarioSelecionado)) {
                this.valor_item = (this.quantidade * this.precoUnitarioSelecionado).toFixed(2);
                console.log('Valor Total:', this.valor_item);
            }
        },

        gravarVenda: function () {

            if (this.venda_id_atual) {
                console.log("AQUI É VENDA CONTINUA - APP.JS");
            } else {
                console.log("AQUI É VENDA NOVA - APP.JS");
            }

            var vendaData = {

                forma_pagto_id: this.forma_pagto_id,
                cliente_id: this.cliente_id,
                venda_id: this.venda_id_atual,
                itens: [
                    {
                        produto_id: this.produto_id,
                        quantidade: this.quantidade,
                        valor_unitario: this.precoUnitarioSelecionado,
                        valor_item: this.valor_item
                    }
                ]
            };

            $url = 'http://localhost:4500/public/app/api/api.php?crud=vendeitemcreate';
            axios.post($url, vendaData)
                .then((response) => {
                    // console.log($url);
                    if (response.data.error) {
                        console.error(response.data.message);
                    } else {

                        this.vendaitens = response.data.venda_itens;
                        this.venda_id_atual = this.vendaitens[0].venda_id;
                        console.log(this.venda_id_atual);
                        this.calcularValorTotalVenda();
                        this.limparCampos();
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        getProdutos: function () {
            axios.get('http://localhost:4500/public/app/api/api.php?crud=prod')
                .then((response) => {
                    // console.log(response);
                    if (response.data.error) {
                        console.error(response.data.message);
                    } else {
                        this.produtos = response.data.produtos;
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        getProdutossel: function () {
            $url = 'http://localhost:4500/public/app/api/api.php?crud=prodselect&nome=' + this.produtoPesquisa;
            axios.get($url)
                .then((response) => {
                    if (response.data.error) {
                        console.error(response.data.message);
                    } else {
                        this.produtossel = response.data.produtossel || [];
                        this.mostrarSelectPro = this.produtossel.length > 0;
                        this.mostrarCampoPesquisaPro = !this.mostrarSelectPro;

                        if (this.produtossel.length > 0) {
                            this.produto_id = this.produtossel[0].id;
                            this.precoUnitarioSelecionado = this.produtossel[0].preco_unitario;
                            this.calcularTotal(); // Adicione esta linha para recalcular o preço total
                        } else {
                            this.precoUnitarioSelecionado = null;
                        }
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        getFormapagtos: function () {
            axios.get('http://localhost:4500/public/app/api/api.php?crud=formp')
                .then((response) => {
                    // console.log(response);
                    if (response.data.error) {
                        console.error(response.data.message);
                    } else {
                        this.forma_pagtos = response.data.forma_pagtos;
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        getFormapagtossel: function () {
            axios.get('http://localhost:4500/public/app/api/api.php?crud=formpselect')
                .then((response) => {
                    if (response.data.error) {
                        console.error(response.data.message);
                    } else {
                        this.forma_pagtos = response.data.forma_pagtos;
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        getClientessel: function () {
            $url = 'http://localhost:4500/public/app/api/api.php?crud=clieselect&nome=' + this.clientePesquisa;
            axios.get($url)
                .then((response) => {
                    // console.log($url)
                    if (response.data.error) {
                        // console.log("erro")
                        console.error(response.data.message);
                    } else {
                        // Verifica se 'clientes' está presente na resposta antes de acessar seu comprimento
                        this.clientessel = response.data.clientessel || [];
                        this.mostrarSelectCli = this.clientessel.length > 0;
                        this.mostrarCampoPesquisaCli = !this.mostrarSelectCli;

                        if (this.clientessel.length > 0) {
                            this.cliente_id = this.clientessel[0].id;
                        }
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        getClientes: function () {
            axios.get('http://localhost:4500/public/app/api/api.php?crud=cliente')
                .then((response) => {
                    // console.log(response);
                    if (response.data.error) {
                        console.error(response.data.message);
                    } else {
                        this.clientes = response.data.clientes;
                        // console.log("this.clientes");
                        // console.log(this.clientes);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        saveProduto: function () {
            // Verificar se há um ID no produto em edição
            if (this.clickProduto.id) {
                // Se há um ID, estamos editando, então chame o método de atualização
                // console.log("TEM ID");
                this.updateProduto();
            } else {
                // Se não há um ID, estamos criando um novo produto, chame o método de criação
                // console.log("NÃO TEM ID");
                this.createProduto();
            }
            // Redefina a variável isEditing e limpe os campos do clickProduto
            this.isEditing = false;
            this.clickProduto = {};
        },

        saveFormapagto: function () {
            // Verificar se há um ID no produto em edição
            if (this.clickFormapagto.id) {
                // Se há um ID, estamos editando, então chame o método de atualização
                this.updateFormapagto();
            } else {
                // Se não há um ID, estamos criando um novo produto, chame o método de criação
                this.createFormapagto();
            }
            // Redefina a variável isEditing e limpe os campos do clickProduto
            this.isEditingFP = false;
            this.clickFormapagto = {};
        },

        saveCliente: function () {
            // Verificar se há um ID no produto em edição
            if (this.clickCliente.id) {
                // Se há um ID, estamos editando, então chame o método de atualização
                this.updateCliente();
            } else {
                // Se não há um ID, estamos criando um novo produto, chame o método de criação
                this.createCliente();
            }
            // Redefina a variável isEditing e limpe os campos do clickProduto
            this.isEditingCL = false;
            this.clickCliente = {};
        },

        createProduto: function () {
            // Lógica para criar um novo produto
            // console.log(this.novoProduto.preco_unitario);
            this.novoProduto.preco_unitario = this.formatarValor(this.novoProduto.preco_unitario);
            var prodForm = this.toFormData(this.novoProduto);
            axios.post('http://localhost:4500/public/app/api/api.php?crud=prodcreate', prodForm)
                .then((response) => {
                    // console.log("AQUI PRODUTO NOVO");
                    this.novoProduto = { nome: '', qtd_estoque: '', preco_unitario: '' };
                    if (response.data.error) {
                        console.error(response.data.message);
                    } else {
                        console.error(response.data.message);
                        this.successMessage = response.data.message;
                        this.getProdutos();
                    }
                })
                .catch((error) => {
                    console.error(error); ''
                });
        },

        updateProduto: function () {
            // console.log(this.clickProduto.preco_unitario);
            this.clickProduto.preco_unitario = this.formatarValor(this.clickProduto.preco_unitario);
            var prodForm = this.toFormData(this.clickProduto);
            axios.post('http://localhost:4500/public/app/api/api.php?crud=produpdate', prodForm)
                .then((response) => {

                    if (response.data.error) {
                        this.errorMessage = response.data.message;
                    }
                    else {
                        // console.log("aqui - saveProduto 3");
                        this.successMessage = response.data.message;
                        this.getProdutos();
                    }
                });
        },

        deleteProduto: function (produto) {

            if (confirm("Tem certeza que deseja excluir o produto '" + produto.nome + "'?")) {
                var prodForm = this.toFormData(produto);
                axios.post('http://localhost:4500/public/app/api/api.php?crud=proddelete', prodForm)
                    .then((response) => {
                        if (response.data.error) {
                            console.error(response.data.message);
                        } else {
                            // console.log(response.data.message);
                            this.successMessage = response.data.message;
                            // Atualize a lista de produtos após a exclusão
                            this.getProdutos();
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },

        createFormapagto: function () {
            // Lógica para criar um novo produto
            var formpForm = this.toFormData(this.novoFormapagto);
            axios.post('http://localhost:4500/public/app/api/api.php?crud=formpcreate', formpForm)
                .then((response) => {
                    this.novoFormapagto = { nome: '', parcelas: '' };
                    if (response.data.error) {
                        console.error(response.data.message);
                    } else {
                        this.successMessage = response.data.message;
                        this.getFormapagtos();
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        updateFormapagto: function () {
            var formpForm = this.toFormData(this.clickFormapagto);
            axios.post('http://localhost:4500/public/app/api/api.php?crud=formpupdate', formpForm)
                .then((response) => {

                    if (response.data.error) {
                        this.errorMessage = response.data.message;
                    }
                    else {
                        this.successMessage = response.data.message;
                        this.getFormapagtos();
                    }
                });
        },

        deleteFormapagto: function (formapagto) {
            if (confirm("Tem certeza que deseja excluir a forma de pagamento '" + formapagto.nome + "'?")) {
                var formpForm = this.toFormData(formapagto);
                axios.post('http://localhost:4500/public/app/api/api.php?crud=formpdelete', formpForm)
                    .then((response) => {
                        if (response.data.error) {
                            console.error(response.data.message);
                        } else {
                            this.successMessage = response.data.message;
                            // Atualize a lista de produtos após a exclusão
                            this.getFormapagtos();
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },

        createCliente: function () {
            var clieForm = this.toFormData(this.novoCliente);
            axios.post('http://localhost:4500/public/app/api/api.php?crud=cliecreate', clieForm)
                .then((response) => {
                    console.log(response);
                    this.novoCliente = { nome: '', cpf: '', cep_id: '', email: '' };
                    if (response.data.error) {
                        console.log("AQUI cliente ERRO");
                        console.error(response.data.message);
                    } else {
                        console.log("AQUI cliente OK");
                        this.successMessage = response.data.message;
                        this.getClientes();
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        updateCliente: function () {
            var clieForm = this.toFormData(this.clickCliente);
            axios.post('http://localhost:4500/public/app/api/api.php?crud=clieupdate', clieForm)
                .then((response) => {

                    if (response.data.error) {
                        this.errorMessage = response.data.message;
                    }
                    else {
                        this.successMessage = response.data.message;
                        this.getClientes();
                    }
                });
        },

        deleteCliente: function (cliente) {
            if (confirm("Tem certeza que deseja excluir o Cliente '" + cliente.nome + "'?")) {
                var clieForm = this.toFormData(cliente);
                axios.post('http://localhost:4500/public/app/api/api.php?crud=cliedelete', clieForm)
                    .then((response) => {
                        if (response.data.error) {
                            console.error(response.data.message);
                        } else {
                            this.successMessage = response.data.message;
                            // Atualize a lista de produtos após a exclusão
                            this.getClientes();
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },

        selectProduto: function (produto) {
            // Preencher os campos de edição com as informações do produto selecionado
            this.clickProduto = { ...produto };
            // Defina a variável como true ao selecionar um produto para edição
            this.isEditing = true;
        },

        selectFormapagto: function (formapagto) {
            // Preencher os campos de edição com as informações do produto selecionado
            this.clickFormapagto = { ...formapagto };
            // Defina a variável como true ao selecionar um produto para edição
            this.isEditingFP = true;
        },

        selectCliente: function (cliente) {
            // Preencher os campos de edição com as informações do produto selecionado
            this.clickCliente = { ...cliente };
            // Defina a variável como true ao selecionar um produto para edição
            this.isEditingCL = true;
        },

        limparPesquisaCli: function () {
            this.clientePesquisa = ''; // Limpar o campo de pesquisa
            this.mostrarCampoPesquisaCli = true; // Mostrar o campo de pesquisa novamente
            this.mostrarSelectCli = false; // Ocultar o select
            this.clientessel = []; // Limpar a lista de clientes
            this.cliente_id = null; // Limpar a seleção
        },

        limparPesquisaPro: function () {
            this.produtoPesquisa = ''; // Limpar o campo de pesquisa
            this.mostrarCampoPesquisaPro = true; // Mostrar o campo de pesquisa novamente
            this.mostrarSelectPro = false; // Ocultar o select
            this.produtossel = []; // Limpar a lista de produtos
            this.produto_id = null; // Limpar a seleção
        },

        calcularValorTotalVenda() {
            let total = 0;
            this.vendaitens.forEach(item => {
                total += parseFloat(item.valor_item);
            });
            this.valor_total = total.toFixed(2); // Arredonda para 2 casas decimais, se necessário            
        },

        limparCampos() {
            this.mostrarCampoPesquisaPro = true;
            this.mostrarSelectPro = false;
            this.produtoPesquisa = '';
            this.produto_id = null;
            this.produtossel = [];
            this.precoUnitarioSelecionado = 0;
            this.quantidade = 1;
            this.valor_item = 0;
        },

        limparCamposFin() {
            this.vendaitens = [];
            this.clientePesquisa = '';
            this.cliente_id = null;
            this.forma_pagto_id = '';
            this.valor_total = 0;
        },

        formatarValor: function (valor) {
            // Substituir vírgulas por pontos
            const valorSemVirgula = valor.replace(',', '.');
            // Extrair apenas dígitos e ponto decimal
            const regex = /[0-9.]+/g;
            const valoresExtraidos = valorSemVirgula.match(regex);
            // Juntar os valores extraídos e converter para número
            const valorNumerico = parseFloat(valoresExtraidos ? valoresExtraidos.join('') : '0');
            return isNaN(valorNumerico) ? 0 : valorNumerico;
        },

        toFormData: function (obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        }
    }
});
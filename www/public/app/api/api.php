<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entity\Cliente;
use App\Entity\Formapagto;
use App\Entity\Produto;
use App\Entity\Venda;
use App\Entity\Vendaitens;

$out = array('error' => false);

$crud = '';

if (isset($_GET['crud'])) {
    $crud = $_GET['crud'];
}
// ---------------------        
// PRODUTO    
// ---------------------
if ($crud == 'prod') {
    $produtos = Produto::getProdutos();
    $out['produtos'] = $produtos;
} elseif ($crud == 'prodselect') {

    $nomePesquisa = !empty($_REQUEST['nome']) ? '%' . $_REQUEST['nome'] . '%' : null;
    $produtossel = null;

    if ($nomePesquisa != null) {
        $where = "nome LIKE '" . $nomePesquisa . "'";
        $fields = 'id, nome, preco_unitario';
        $produtossel = Produto::getProdutos($where, $fields);
    }

    $out['produtossel'] = $produtossel;
} elseif ($crud == 'prodcreate') {

    $novoProduto = new Produto();
    $novoProduto->nome = $_POST['nome'];
    $novoProduto->qtd_estoque = $_POST['qtd_estoque'];
    $novoProduto->preco_unitario = $_POST['preco_unitario'];

    if ($novoProduto->gravar()) {
        $out['message'] = "Produto inserido com sucesso";
        // Log para inserção bem-sucedida
        error_log('Produto inserido com sucesso.');
    } else {
        $out['error'] = true;
        $out['message'] = "Não pode inserir Produto";
        // Log para falha na inserção
        error_log('Falha ao inserir Produto.');
    }
} elseif ($crud == 'produpdate') {

    try {

        $novoProduto = new Produto();
        $novoProduto->id = $_POST['id'];
        $novoProduto->nome = $_POST['nome'];
        $novoProduto->qtd_estoque = $_POST['qtd_estoque'];
        $novoProduto->preco_unitario = $_POST['preco_unitario'];

        if ($novoProduto->atualizar()) {
            $out['message'] = "Produto atualizado com sucesso";
            // Log para atualização bem-sucedida
            error_log('Produto atualizado com sucesso.');
        } else {
            $out['error'] = true;
            $out['message'] = "Não foi possível atualizar o Produto";
            // Log para falha na atualização
            error_log('Falha ao atualizar Produto.');
        }
    } catch (Exception $e) {
        $out['error'] = true;
        $out['message'] = "Erro ao atualizar o Produto: " . $e->getMessage();
        // Log para outros erros
        error_log('Erro ao atualizar Produto: ' . $e->getMessage());
    }
    // ---------------------        
    // FORMA DE PAGAMENTO    
    // ---------------------

} elseif ($crud == 'proddelete') {

    $produto_id = $_POST['id'];

    if ($produto_id) {

        $produto = new Produto();
        $produto->id = $produto_id;
        $result = $produto->excluir();

        if ($result) {
            $out['message'] = 'Produto excluído com sucesso.';
        } else {
            $out['error'] = true;
            $out['message'] = 'Erro ao excluir o produto.';
        }
    } else {
        $out['error'] = true;
        $out['message'] = 'ID do produto não fornecido.';
    }
    echo json_encode($out);
    exit;
} elseif ($crud == 'formp') {
    $fpagtos = Formapagto::getFormapagtos();
    $out['forma_pagtos'] = $fpagtos;
} elseif ($crud == 'formpcreate') {

    $formapagto = new Formapagto();
    $formapagto->nome = $_POST['nome'];
    $formapagto->parcelas = $_POST['parcelas'];

    if ($formapagto->gravar()) {
        $out['message'] = "Forma de pagamento inserida com sucesso.";
        // Log para inserção bem-sucedida
        error_log('Forma de pagamento inserido com sucesso.');
    } else {
        $out['error'] = true;
        $out['message'] = "Não pode inserir forma de pagamento";
        // Log para falha na inserção
        error_log('Falha ao inserir forma de pagamento.');
    }
} elseif ($crud == 'formpselect') {
    $fields = 'id, nome, parcelas';
    $fpagtos = Formapagto::getFormapagtos(null, null);
    $out['forma_pagtos'] = $fpagtos;
} elseif ($crud == 'formpupdate') {

    try {

        $formapagto = new Formapagto();
        $formapagto->id = $_POST['id'];
        $formapagto->nome = $_POST['nome'];
        $formapagto->parcelas = $_POST['parcelas'];

        if ($formapagto->atualizar()) {
            $out['message'] = "Forma de pagamento atualizado com sucesso.";
            // Log para atualização bem-sucedida
            error_log('Forma de pagamento atualizado com sucesso.');
        } else {
            $out['error'] = true;
            $out['message'] = "Não foi possível atualizar o Produto";
            // Log para falha na atualização
            error_log('Falha ao atualizar forma de pagamento.');
        }
    } catch (Exception $e) {
        $out['error'] = true;
        $out['message'] = "Erro ao atualizar a forma de pagamento: " . $e->getMessage();
        // Log para outros erros
        error_log('Erro ao atualizar a forma de pagamento: ' . $e->getMessage());
    }
    // ---------------------        
    // CLIENTE    
    // ---------------------

} elseif ($crud == 'formpdelete') {

    $formp_id = $_POST['id'];

    if ($formp_id) {

        $formapagto = new Formapagto();
        $formapagto->id = $formp_id;

        $result = $formapagto->excluir();

        if ($result) {
            $out['message'] = 'Forma de pagamento excluído com sucesso.';
        } else {
            $out['error'] = true;
            $out['message'] = 'Erro ao excluir a forma de pagamento.';
        }
    } else {
        $out['error'] = true;
        $out['message'] = 'ID da forma de pagamento não fornecido.';
    }
    echo json_encode($out);
    exit;
} elseif ($crud == 'cliente') {
    $clientes = Cliente::getClientes();
    $out['clientes'] = $clientes;
} elseif ($crud == 'clieselect') {

    $nomePesquisa = !empty($_REQUEST['nome']) ? '%' . $_REQUEST['nome'] . '%' : null;
    $clientessel = null;

    if ($nomePesquisa != null) {
        $where = "nome LIKE '" . $nomePesquisa . "'";
        $clientessel = Cliente::getClientes($where);
    }

    $out['clientessel'] = $clientessel;
} elseif ($crud == 'cliecreate') {

    $cliente = new Cliente();
    $cliente->nome = $_POST['nome'];
    $cliente->cpf = $_POST['cpf'];
    $cliente->cep_id = $_POST['cep_id'];
    $cliente->email = $_POST['email'];

    if ($cliente->gravar()) {
        $out['message'] = "Cliente inserida com sucesso.";
        // Log para inserção bem-sucedida
        error_log('Cliente inserido com sucesso.');
    } else {
        $out['error'] = true;
        $out['message'] = "Não pode inserir cliente.";
        // Log para falha na inserção
        error_log('Falha ao inserir Cliente.');
    }
} elseif ($crud == 'clieupdate') {

    try {

        $cliente = new Cliente();
        $cliente->id = $_POST['id'];
        $cliente->nome = $_POST['nome'];
        $cliente->cpf = $_POST['cpf'];
        $cliente->cep_id = $_POST['cep_id'];
        $cliente->email = $_POST['email'];

        if ($cliente->atualizar()) {
            $out['message'] = "Cliente atualizado com sucesso.";
            // Log para atualização bem-sucedida
            error_log('Cliente atualizado com sucesso.');
        } else {
            $out['error'] = true;
            $out['message'] = "Não foi possível atualizar o Cliente";
            // Log para falha na atualização
            error_log('Falha ao atualizar cliente.');
        }
    } catch (Exception $e) {
        $out['error'] = true;
        $out['message'] = "Erro ao atualizar a cliente: " . $e->getMessage();
        // Log para outros erros
        error_log('Erro ao atualizar a cliente: ' . $e->getMessage());
    }
} elseif ($crud == 'cliedelete') {

    $cliente_id = $_POST['id'];

    if ($cliente_id) {

        $cliente = new Cliente();
        $cliente->id = $cliente_id;
        $result = $cliente->excluir();

        if ($result) {
            $out['message'] = 'Cliente excluído com sucesso.';
        } else {
            $out['error'] = true;
            $out['message'] = 'Erro ao excluir o cliente.';
        }
    } else {
        $out['error'] = true;
        $out['message'] = 'ID do cliente não fornecido.';
    }
    echo json_encode($out);
    exit;
} elseif ($crud == 'vendeitemcreate') {
    // Obtenha os dados da venda do corpo da requisição
    $requestData = json_decode(file_get_contents('php://input'), true);

    try {

        $novaVenda = new Venda();

        if (!empty($requestData['venda_id']) && is_numeric($requestData['venda_id'])) {
            //Se existe um venda_id válido, use a venda existente
            $vendaExistente = new Venda();
            $vendaExistente->id = $requestData['venda_id'];
            $novaVenda->status = "0";
            $novaVenda = $vendaExistente;
        } else {
            // Se não existir, crie uma nova venda
            $novaVenda->forma_pagto_id = $requestData['forma_pagto_id'];
            $novaVenda->cliente_id = $requestData['cliente_id'];
            $novaVenda->data_venda = date('Y-m-d H:i:s');
            $novaVenda->status = "0";
            $novaVenda->valor_total = 0;
            $novaVenda->gravar();
        }
        //Crie os itens da venda - nocaso da minha tela sempre será 1, mas como é uma API pode ser usado para inserir vários!
        foreach ($requestData['itens'] as $item) {
            $novoItem = new Vendaitens();
            $novoItem->venda_id = $novaVenda->id;
            $novoItem->produto_id = $item['produto_id'];
            $novoItem->quantidade = $item['quantidade'];
            $novoItem->valor_unitario = $item['valor_unitario'];
            $novoItem->valor_item = $item['valor_item'];
            $novoItem->status = "0";
            $novoItem->gravar();
        }
        // Carregue os itens vendidos
        $tables = ['venda_itens', 'produtos'];
        $fields = 'venda_itens.venda_id, venda_itens.id, produtos.nome, venda_itens.quantidade, venda_itens.valor_unitario, venda_itens.valor_item';
        $joins = ['venda_itens.produto_id = produtos.id'];
        $where = "venda_itens.venda_id = " . $novaVenda->id;
        $vendeitens = Vendaitens::getVendaitens($where, $fields, null, null, $tables, $joins);
        $out['venda_itens'] = $vendeitens;
        // error_log('Venda criada com sucesso.');
    } catch (Exception $e) {
        $out['error'] = true;
        $out['message'] = "Erro ao criar a venda: " . $e->getMessage();
        error_log('Erro ao criar a venda: ' . $e->getMessage());
    }
} elseif ($crud == 'finalizarvenda') {
    // Obtenha os dados da venda do corpo da requisição
    $requestData = json_decode(file_get_contents('php://input'), true);

    try {
        // Certifique-se de que o ID da venda está presente nos dados
        if (!empty($requestData['venda_id']) && is_numeric($requestData['venda_id'])) {

            $where = 'id = ' . $requestData['venda_id'];
            $whereAtu = 'venda_id = ' . $requestData['venda_id'];
            $vendaExistente = Venda::getVenda($where);

            if ($vendaExistente) {

                $vendaitens = Vendaitens::getVendaitens($whereAtu, null);

                if ($vendaitens) {
                    foreach ($vendaitens as $vendaiten) {
                        // Acessar os valores diretamente do objeto $vendaiten
                        $produtoId = $vendaiten->produto_id; // Substitua pelo nome correto do atributo no seu objeto
                        $quantidade = $vendaiten->quantidade; // Substitua pelo nome correto do atributo no seu objeto
                        // Criar instância da classe Produto e definir os valores dinâmicos
                        $atuproduto = new Produto();
                        $atuproduto->id = $produtoId;
                        // Atualizar o estoque com a quantidade dinâmica
                        $atuproduto->atualizarEstoque($quantidade);
                    }
                }
                // Atualize o status e o valor total da venda
                $vendaExistente->status = "1"; // Status 1 para finalizado
                $vendaExistente->valor_total = $requestData['valor_total'];

                // Salve as alterações
                if ($vendaExistente->atualizar()) {
                    $out['message'] = "Venda finalizada com sucesso.";
                } else {
                    $out['error'] = true;
                    $out['message'] = "Falha ao finalizar a venda.";
                }
            } else {
                $out['error'] = true;
                $out['message'] = "Venda não encontrada.";
            }
        } else {
            $out['error'] = true;
            $out['message'] = "ID da venda não fornecido.";
        }
    } catch (Exception $e) {
        $out['error'] = true;
        $out['message'] = "Erro ao finalizar a venda: " . $e->getMessage();
    }
} elseif ($crud == 'vendaitselect') {
    $out['error'] = true;
    $out['message'] = 'Erro ao excluir o item da venda.';
} elseif ($crud == 'consulvenda') {

    $where = "vendas.status = '1'";
    // Obtenha o valor de cliente_id, forma_pagto_id, dataInicio e dataFim da variável $_GET
    $cliente_id = isset($_GET['cliente_id']) ? $_GET['cliente_id'] : null;
    $forma_pagto_id = isset($_GET['forma_pagto_id']) ? $_GET['forma_pagto_id'] : null;
    $dataInicio = isset($_GET['dataInicio']) ? $_GET['dataInicio'] : null;
    $dataFim = isset($_GET['dataFim']) ? $_GET['dataFim'] : null;

    // Adicione as condições dos outros parâmetros ao $where, se presentes
    if ($cliente_id) {
        $where .= " AND vendas.cliente_id = $cliente_id";
    }
    if ($forma_pagto_id) {
        $where .= " AND vendas.forma_pagto_id = $forma_pagto_id";
    }
    if ($dataInicio && $dataFim) {
        $where .= " AND vendas.data_venda BETWEEN '$dataInicio' AND '$dataFim'";
    }

    $tables = ['vendas', 'clientes', 'forma_pagtos'];
    $fields = 'vendas.data_venda, clientes.nome as cliente_nome, forma_pagtos.nome as formanome, vendas.valor_total';
    $joins = [
        'vendas.cliente_id = clientes.id',
        'vendas.forma_pagto_id = forma_pagtos.id'
    ];

    $consultavendas = Venda::getVendas($where, $fields, null, null, $tables, $joins);

    $out['consultavendas'] = $consultavendas;
} else {
    $out['error'] = true;
    $out['message'] = "Chamada da API inválida!";
};

header("Content-type: application/json");
echo json_encode($out);
die();

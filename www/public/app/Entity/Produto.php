<?php

namespace App\Entity;

use App\Db\Database;
use Exception;
use PDO;

class Produto
{
    public $id;
    public $nome;
    public $qtd_estoque;
    public $preco_unitario;

    public function gravar()
    {
        $obDB = new Database('produtos');

        try {

            $this->id = $obDB->insert([
                'nome' => $this->nome,
                'qtd_estoque' => $this->qtd_estoque,
                'preco_unitario' => $this->preco_unitario
            ]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao gravar: " . $e->getMessage());
        }
    }

    public function atualizar()
    {
        return (new Database('produtos'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'qtd_estoque' => $this->qtd_estoque,
            'preco_unitario' => $this->preco_unitario
        ]);
    }

    public function atualizarEstoque($quantidade)
    {
        try {
            // Obter o valor atual do estoque
            $query = (new Database('produtos'))->select('id = ' . $this->id);
            $produto = $query->fetch(PDO::FETCH_OBJ);

            if ($produto) {
                // Atualizar o estoque apenas se o produto for encontrado
                $estoqueAtual = $produto->qtd_estoque;
                $novoEstoque = $estoqueAtual - $quantidade;

                return (new Database('produtos'))->update('id = ' . $this->id, [
                    'qtd_estoque' => $novoEstoque
                ]);
            }

            return false; // Retorna falso se o produto não for encontrado
        } catch (Exception $e) {
            // Registre a exceção para fins de depuração
            error_log('Erro: ' . $e->getMessage());
            return false;
        }
    }

    public function excluir()
    {
        return (new Database('produtos'))->delete('id = ' . $this->id);
    }
    //PEGA OS PRODUTOS DO DB, PEGAR NA API!
    public static function getProdutos($pwhere = null, $pfields = null, $porder = null, $plimit = null)
    {
        return (new Database('produtos'))->select($pwhere, $pfields, $porder, $plimit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    //BUSCA PRODUTO NO EDITAR
    public static function getProduto($pwhere = null, $pfields = null)
    {
        return (new Database('produtos'))->select($pwhere, $pfields)
            ->fetchObject(self::class);
    }
}

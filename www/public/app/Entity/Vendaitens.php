<?php

namespace App\Entity;

use App\Db\Database;
use Exception;
use PDO;

class Vendaitens
{
    public $id;
    public $produto_id;
    public $venda_id;
    public $quantidade;
    public $valor_unitario;
    public $valor_item;
    public $status;

    public function gravar()
    {
        $obDB = new Database('venda_itens');

        try {

            $this->id = $obDB->insert([
                'produto_id' => $this->produto_id,
                'venda_id' => $this->venda_id,
                'quantidade' => $this->quantidade,
                'valor_unitario' => $this->valor_unitario,
                'valor_item' => $this->valor_item,
                'status' => $this->status
            ]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao gravar: " . $e->getMessage());
        }
    }

    public function atualizar()
    {
        return (new Database('venda_itens'))->update('id = ' . $this->id, [
            'produto_id' => $this->produto_id,
            'venda_id' => $this->venda_id,
            'quantidade' => $this->quantidade,
            'valor_unitario' => $this->valor_unitario,
            'valor_item' => $this->valor_item,
            'status' => $this->status
        ]);
    }

    public function excluir()
    {
        return (new Database('venda_itens'))->delete('id = ' . $this->id);
    }

    public static function getVendaitens($pwhere = null, $pfields = null, $porder = null, $plimit = null, $tables = null, $joins = null)
    {
        $db = new Database('venda_itens');
        // Se as tabelas e joins foram fornecidos, use a função de INNER JOIN
        if ($tables && $joins) {
            return $db->selectWithJoin($tables, $joins, $pwhere, $pfields, $porder, $plimit)
                ->fetchAll(PDO::FETCH_CLASS, self::class);
        } else {
            // Caso contrário, use a função de seleção padrão
            return $db->select($pwhere, $pfields, $porder, $plimit)
                ->fetchAll(PDO::FETCH_CLASS, self::class);
        }
    }

    public static function getVendaitem($pwhere = null, $pfields = null)
    {
        return (new Database('venda_itens'))->select($pwhere, $pfields)
            ->fetchObject(self::class);
    }
}

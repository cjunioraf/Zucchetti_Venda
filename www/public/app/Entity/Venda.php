<?php

namespace App\Entity;

use App\Db\Database;
use Exception;
use PDO;

class Venda
{
    public $id;
    public $forma_pagto_id;
    public $cliente_id;
    public $valor_total;
    public $data_venda;
    public $status;

    public function gravar()
    {
        $obDB = new Database('vendas');

        try {

            $this->id = $obDB->insert([
                'forma_pagto_id' => $this->forma_pagto_id,
                'cliente_id' => $this->cliente_id,
                'valor_total' => $this->valor_total,
                'data_venda' => $this->data_venda,
                'status' => $this->status,
            ]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao gravar: " . $e->getMessage());
        }
    }

    public function atualizar()
    {
        return (new Database('vendas'))->update('id = ' . $this->id, [
            'forma_pagto_id' => $this->forma_pagto_id,
            'cliente_id' => $this->cliente_id,
            'valor_total' => $this->valor_total,
            'data_venda' => $this->data_venda,
            'status' => $this->status
        ]);
    }

    public function excluir()
    {
        return (new Database('vendas'))->delete('id = ' . $this->id);
    }

    public static function getVendas($pwhere = null, $pfields = null, $porder = null, $plimit = null, $tables = null, $joins = null)
    {
        $db = new Database('vendas');
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

    public static function getVenda($pwhere = null, $pfields = null)
    {
        return (new Database('vendas'))->select($pwhere, $pfields)
            ->fetchObject(self::class);
    }
}

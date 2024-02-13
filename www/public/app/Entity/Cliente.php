<?php

namespace App\Entity;

use App\Db\Database;
use Exception;
use PDO;

class Cliente
{
    public $id;
    public $nome;
    public $cpf;
    public $cep_id;
    public $email;

    public function gravar()
    {
        $obDB = new Database('clientes');

        try {
            $data = [
                'nome' => $this->nome,
                'cpf' => $this->cpf,
                'email' => $this->email
                //'cep_id' => isset($this->cep_id) ? $this->cep_id : null
            ];

            $this->id = $obDB->insert($data);

            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao gravar: " . $e->getMessage());
        }
    }

    public function atualizar()
    {
        return (new Database('clientes'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'email' => $this->email
            // 'cep_id' => $this->cep_id
        ]);
    }

    public function excluir()
    {
        return (new Database('clientes'))->delete('id = ' . $this->id);
    }
    //PEGA OS PRODUTOS DO DB, PEGAR NA API!
    public static function getClientes($pwhere = null, $pfields = null, $porder = null, $plimit = null)
    {
        return (new Database('clientes'))->select($pwhere, $pfields, $porder, $plimit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    //BUSCA PRODUTO NO EDITAR
    public static function getCliente($pwhere = null, $pfields = null)
    {
        return (new Database('clientes'))->select($pwhere, $pfields)
            ->fetchObject(self::class);
    }
}

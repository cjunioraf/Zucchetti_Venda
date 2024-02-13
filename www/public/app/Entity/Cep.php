<?php

namespace App\Entity;

use App\Db\Database;
use Exception;
use PDO;

class Cep
{
    public $id;
    public $cep;
    public $logradouro;
    public $complemento;
    public $bairro;
    public $localidade;
    public $uf;

    public function gravar()
    {
        $obDB = new Database('ceps');

        try {

            $this->id = $obDB->insert([
                'cep' => $this->cep,
                'logradouro' => $this->logradouro,
                'complemento' => $this->complemento,
                'bairro' => $this->bairro,
                'localidade' => $this->localidade,
                'uf' => $this->uf
            ]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao gravar: " . $e->getMessage());
        }
    }

    public function atualizar()
    {
        return (new Database('ceps'))->update('id = ' . $this->id, [
            'cep' => $this->cep,
            'logradouro' => $this->logradouro,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'localidade' => $this->localidade,
            'uf' => $this->uf
        ]);
    }

    public function excluir()
    {
        return (new Database('ceps'))->delete('id = ' . $this->id);
    }
    //PEGA OS PRODUTOS DO DB, PEGAR NA API!
    public static function getCeps($pwhere = null, $pfields = null, $porder = null, $plimit = null)
    {
        return (new Database('ceps'))->select($pwhere, $pfields, $porder, $plimit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    //BUSCA PRODUTO NO EDITAR
    public static function getCep($pwhere = null, $pfields = null)
    {
        return (new Database('ceps'))->select($pwhere, $pfields)
            ->fetchObject(self::class);
    }
}

<?php

namespace App\Entity;

use App\Db\Database;
use Exception;
use PDO;

class Formapagto
{
    public $id;
    public $nome;
    public $parcelas;

    public function gravar()
    {
        $obDB = new Database('forma_pagtos');

        try {

            $this->id = $obDB->insert([
                'nome' => $this->nome,
                'parcelas' => $this->parcelas
            ]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao gravar: " . $e->getMessage());
        }
    }

    public function atualizar()
    {
        return (new Database('forma_pagtos'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'parcelas' => $this->parcelas
        ]);
    }

    public function excluir()
    {
        return (new Database('forma_pagtos'))->delete('id = ' . $this->id);
    }
    public static function getFormapagtos($pwhere = null, $pfields = null, $porder = null, $plimit = null)
    {
        // Adicione a tabela 'forma_pagtos' como o primeiro argumento para a função select
        $formapagtos = (new Database('forma_pagtos'))->select($pwhere, $pfields, $porder, $plimit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
        return $formapagtos;
    }

    public static function getFormapagto($pwhere = null, $pfields = null)
    {
        return (new Database('forma_pagtos'))->select($pwhere, $pfields)
            ->fetchObject(self::class);
    }
}

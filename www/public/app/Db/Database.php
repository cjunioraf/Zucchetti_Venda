<?php

namespace App\Db;

use InvalidArgumentException;
use PDO;
use PDOException;

class Database
{
    /** MONTANDO A CONEXÃO COM O BANCO DE DADOS*/
    const HOST = 'db';
    const NAMEDB = 'db_zucchetti';
    const USER = 'root';
    const PASSWORD = 'root';
    /** TABELA QUE IREI MANIPULAR*/
    private $table;
    private $connection;

    public function __construct($ptable = null)
    {
        $this->table = $ptable;
        $this->setConn();
    }

    public function execute($query, $params = [])
    {
        try {
            $returnExec = $this->connection->prepare($query);
            $returnExec->execute($params);
            return $returnExec;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }
    // médodo responsável para inserir no db 
    public function insert($pvalues)
    {
        $fields = array_keys($pvalues);
        $values = array_pad([], count($fields), '?');

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')';

        $this->execute($query, array_values($pvalues));

        return $this->connection->lastInsertId();
    }
    public function update($pwhere, $pvalues)
    {
        // Construir a parte SET da consulta SQL
        $fields = array_keys($pvalues);
        $setClause = implode('=?, ', $fields) . '=?';

        // Construir a consulta SQL completa
        $query = 'UPDATE ' . $this->table . ' SET ' . $setClause . ' WHERE ' . $pwhere;
        // Criar array de valores para a execução
        $executeValues = array_values($pvalues);

        $this->execute($query, $executeValues);

        return true;
    }

    public function delete($pwhere)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $pwhere;
        $this->execute($query);
        return true;
    }

    public function select($pwhere = null, $pfields = null, $porder = null, $plimit = null)
    {
        $where = strlen($pwhere) ? ' WHERE ' . $pwhere : '';
        $order = strlen($porder) ? ' ORDER BY ' . $porder : '';
        $limit = strlen($plimit) ? ' LIMIT ' . $plimit : '';
        $fields = is_string($pfields) ? $pfields : '*';

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }

    public function selectWithJoin($tables, $joins, $pwhere = null, $pfields = null, $porder = null, $plimit = null)
    {
        // Verifique se as tabelas e joins têm o mesmo comprimento
        if (count($tables) !== count($joins) + 1) {
            throw new InvalidArgumentException('Número inválido de joins fornecidos.');
        }

        $where = strlen($pwhere) ? ' WHERE ' . $pwhere : '';
        $order = strlen($porder) ? ' ORDER BY ' . $porder : '';
        $limit = strlen($plimit) ? ' LIMIT ' . $plimit : '';
        $fields = is_string($pfields) ? $pfields : '*';
        // Construa a parte da query com os joins
        $joinClause = '';

        foreach ($tables as $index => $table) {
            if ($index > 0 && $index < count($tables)) {
                $joinClause .= ' INNER JOIN ' . $table . ' ON ' . $joins[$index - 1] . ' ';
            }
        }

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . $joinClause . $where . $order . $limit;
        return $this->execute($query);
    }

    private function setConn()
    {
        try {
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAMEDB, self::USER, self::PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Your code for establishing a connection goes here
        } catch (PDOException $e) {
            //AQUI COLOCAR UMA MENSAGEM DE ERRO DE COMUNICAÇÃO.
            die('ERROR: ' . $e->getMessage());
        }
    }
}

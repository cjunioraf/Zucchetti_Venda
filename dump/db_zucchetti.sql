CREATE DATABASE IF NOT EXISTS db_zucchetti;

use db_zucchetti;

set 
    SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
set 
    time_zone = "+03:00";

CREATE TABLE `db_zucchetti`.`produtos` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `qtd_estoque` INT NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `preco_unitario` DECIMAL(10, 2) NOT NULL
);

CREATE TABLE `db_zucchetti`.`forma_pagtos` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `parcelas` INT NOT NULL,
  `nome` VARCHAR(255) NOT NULL
);

CREATE TABLE `db_zucchetti`.`ceps` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `cep` VARCHAR(8) NOT NULL,
    `logradouro` VARCHAR(255) NOT NULL,
    `complemento` VARCHAR(255),
    `bairro` VARCHAR(255) NOT NULL,
    `localidade` VARCHAR(255) NOT NULL,
    `uf` VARCHAR(2) NOT NULL
);

CREATE TABLE `db_zucchetti`.`clientes` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `cpf` VARCHAR(14) NOT NULL,
    `cep_id` INT,
    `email` VARCHAR(255) NOT NULL,
    FOREIGN KEY (cep_id) REFERENCES ceps(id)
);

CREATE TABLE `db_zucchetti`.`vendas` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `forma_pagto_id` INT,
    `cliente_id` INT,
    `valor_total` DECIMAL(10, 2) NOT NULL,
    `data_venda` DATETIME NOT NULL,
    `status` VARCHAR(1),       
    FOREIGN KEY (forma_pagto_id) REFERENCES forma_pagtos(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

CREATE TABLE `db_zucchetti`.`venda_itens` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `produto_id` INT,
    `venda_id` INT,
    `quantidate` INT NOT NULL,
    `valor_unitario` DECIMAL(10, 2) NOT NULL,    
    `valor_item` DECIMAL(10, 2) NOT NULL,    
    `status` VARCHAR(1),       
    FOREIGN KEY (produto_id) REFERENCES produtos(id),    
    FOREIGN KEY (venda_id) REFERENCES vendas(id)
);



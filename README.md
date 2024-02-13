# Docker + Apache + PHP7.2 + Mysql + phpMyAdmin

Ambiente para desenvolvimento com Docker projeto a pasta **www**

**Pré requisitos:** Docker e Docker Compose
```
# Criar e levantar os containers
docker-compose up -d

# Iniciar o container Docker
docker-compose start

# Parar o container Docker
docker-compose stop

```
**Acesso localhost**
```
http://localhost:4500/public

```
**Acesso phpMyAdmin**
```
http://localhost:8080

user: root
senha: root
```
#Pasta DUMP tem as tabelas do sistema que são inicializadas automaticamente quando cria novos containers do docker.

**Clécio 12/02/2024**

SISTEMA TODO USANDO API / PHP E VUE.JS

Não tem mistério a instalação e utilização - na pasta DUMP na raíz do projeto tem a criação do banco de dados e as tabelas de forma automática

após subir os containers do Docker por favor confira se o banco e as tabelas foram criadas de forma correta, caso não esteja pare o docker, delete os containers, 

imagens e volumes pelo docker desktop, o banco de dados é db_zucchetti e as tabelas obrigatórias são:

-> produtos
-> forma_pagtos
-> clientes
-> vendas
-> venda_itens

Depois que criou as tabelas e seus containers estão ON-LINE acesse a aplicação http://localhost:4500/public 

cadastre produtos/formas de pagamentos e Clientes e se divirta, não se esqueça de verificar se está baixando o ESTOQUE na tela de PRODUTO!

Att. Clécio.



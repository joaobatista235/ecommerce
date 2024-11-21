-- Active: 1729355366311@@127.0.0.1@3306@ecommerce
CREATE DATABASE  ecommerce;

USE ecommerce;

-- Criar tabela 'clientes'
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    endereco VARCHAR(255),
    numero VARCHAR(10),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado CHAR(2),
    email VARCHAR(255),
    cpf_cnpj VARCHAR(20),
    rg VARCHAR(20),
    telefone VARCHAR(20),
    celular VARCHAR(20),
    data_nasc DATE,
    salario DECIMAL(15, 2),
    senha VARCHAR(255)
);
 
-- Criar tabela 'vendedor'
CREATE TABLE vendedor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    endereco VARCHAR(255),
    cidade VARCHAR(100),
    estado CHAR(2),
    celular VARCHAR(20),
    email VARCHAR(255),
    perc_comissao DECIMAL(5, 2),
    senha VARCHAR(255)
);
 
-- Criar tabela 'produto'
CREATE TABLE produto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    qtde_estoque INT DEFAULT 0,
    preco DECIMAL(15, 2) CHECK (preco >= 0),
    unidade_medida VARCHAR(10),
    promocao CHAR(1) DEFAULT 'N' CHECK (promocao IN ('Y', 'N'))
);
 
-- Criar tabela 'forma_pagto'
CREATE TABLE forma_pagto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL
);
 
-- Criar tabela 'pedidos'
CREATE TABLE pedidos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data DATE,
    id_cliente INT,
    observacao VARCHAR(255),
    forma_pagto INT,
    prazo_entrega VARCHAR(50),
    id_vendedor INT,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id),
    FOREIGN KEY (forma_pagto) REFERENCES forma_pagto(id),
    FOREIGN KEY (id_vendedor) REFERENCES vendedor(id)
);
 
-- Criar tabela 'itens_pedido'
CREATE TABLE itens_pedido (
    id_pedido INT,
    id_produto INT,
    qtde INT,
    id_item INT PRIMARY KEY AUTO_INCREMENT,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id),
    FOREIGN KEY (id_produto) REFERENCES produto(id)
);

-- Criar tabela 'imagens_produto'
CREATE TABLE imagens_produto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_produto INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    descricao VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produto) REFERENCES produto(id) ON DELETE CASCADE
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- admin login username admin, senha admin123
INSERT INTO admins (username, password) 
VALUES ('admin1@admin.com', '0192023a7bbd73250516f069df18b500');

-- vededor login
INSERT INTO vendedor(nome,email,senha)
VALUES ('teste','vendedor1@email.com', '0192023a7bbd73250516f069df18b500');

-- alimentar a tabela produto
INSERT INTO produto (nome, qtde_estoque, preco, unidade_medida, promocao)
VALUES
  ('Camiseta', 100, 49.90, 'un', 'N'),
  ('Tênis Esportivo', 50, 299.90, 'par', 'Y'),
  ('Calça Jeans', 200, 139.90, 'un', 'N'),
  ('Relógio Digital', 30, 129.90, 'un', 'Y'),
  ('Mochila Escolar', 150, 79.90, 'un', 'N');

-- Active: 1732468426404@@127.0.0.1@3306
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
    salario DECIMAL(15, 2)
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
    data_admissao DATE,
    senha VARCHAR(255)
);
 
-- Criar tabela fornecedores
CREATE TABLE fornecedores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    contato VARCHAR(255)
);

-- Criar tabela 'produto'
CREATE TABLE produto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    qtde_estoque INT DEFAULT 0,
    preco DECIMAL(15, 2) CHECK (preco >= 0),
    unidade_medida VARCHAR(10),
    promocao CHAR(1) DEFAULT 'N' CHECK (promocao IN ('Y', 'N')),
    id_fornecedor INT,
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id)
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

INSERT INTO clientes (nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario) 
VALUES 
('João da Silva', 'Rua das Flores', '123', 'Jardim Paulista', 'São Paulo', 'SP', 'joao.silva@example.com', '123.456.789-00', 'MG-12.345.678', '(11) 9876-5432', '(11) 91234-5678', '1985-03-25', 3500.00);

INSERT INTO clientes (nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario) 
VALUES 
('Maria Oliveira', 'Avenida Brasil', '456', 'Centro', 'Rio de Janeiro', 'RJ', 'maria.oliveira@example.com', '987.654.321-00', 'RJ-98.765.432', '(21) 2233-4455', '(21) 99876-5432', '1990-07-12', 4500.50);

INSERT INTO clientes (nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario) 
VALUES 
('Carlos Andrade', 'Rua das Acácias', '789', 'Bela Vista', 'Belo Horizonte', 'MG', 'carlos.andrade@example.com', '456.789.123-99', 'MG-45.678.123', '(31) 3344-5566', '(31) 98765-4321', '1978-11-05', 5200.75);

INSERT INTO clientes (nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario) 
VALUES 
('Ana Beatriz', 'Travessa das Palmeiras', '101', 'Vila Nova', 'Curitiba', 'PR', 'ana.beatriz@example.com', '112.233.445-55', 'PR-11.223.344', '(41) 5566-7788', '(41) 91234-5678', '1988-05-15', 3100.00);

INSERT INTO clientes (nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario) 
VALUES 
('Pedro Alves', 'Rua do Comércio', '205', 'Santa Maria', 'Porto Alegre', 'RS', 'pedro.alves@example.com', '223.344.556-77', 'RS-22.334.455', '(51) 6677-8899', '(51) 98765-4321', '1995-09-22', 2800.25);


INSERT INTO vendedor (nome, endereco, cidade, estado, celular, email, perc_comissao, senha)
VALUES
    ('Carlos Silva', 'Rua das Flores, 123', 'São Paulo', 'SP', '(11) 98765-4321', 'carlos.silva@email.com', 10.50, 'senha123'),
    ('Mariana Costa', 'Av. Central, 456', 'Rio de Janeiro', 'RJ', '(21) 99887-6543', 'mariana.costa@email.com', 12.00, 'senha456'),
    ('Paulo Souza', 'Rua dos Pinheiros, 789', 'Belo Horizonte', 'MG', '(31) 91234-5678', 'paulo.souza@email.com', 15.00, 'senha789'),
    ('Fernanda Oliveira', 'Rua da Liberdade, 321', 'Curitiba', 'PR', '(41) 91234-0000', 'fernanda.oliveira@email.com', 8.00, 'senha321'),
    ('Lucas Almeida', 'Av. Paulista, 987', 'São Paulo', 'SP', '(11) 91111-2222', 'lucas.almeida@email.com', 10.00, 'senha987');

INSERT INTO produto (nome, qtde_estoque, preco, unidade_medida, promocao)
VALUES
    ('Notebook Dell', 50, 3500.00, 'unidade', 'N'),
    ('Mouse Logitech', 200, 150.00, 'unidade', 'Y'),
    ('Monitor LG', 30, 1200.00, 'unidade', 'N'),
    ('Teclado Mecânico', 100, 300.00, 'unidade', 'Y'),
    ('Headset HyperX', 75, 500.00, 'unidade', 'N');


INSERT INTO forma_pagto (nome)
VALUES
    ('Cartão de Crédito'),
    ('Boleto Bancário'),
    ('PIX'),
    ('Transferência Bancária'),
    ('Dinheiro');


INSERT INTO pedidos (data, id_cliente, observacao, forma_pagto, prazo_entrega, id_vendedor)
VALUES
    ('2024-11-20', 1, 'Entrega urgente', 1, '2 dias úteis', 1),
    ('2024-11-21', 2, 'Embalagem reforçada', 2, '5 dias úteis', 2),
    ('2024-11-22', 3, 'Agendar entrega', 3, '3 dias úteis', 3),
    ('2024-11-23', 4, 'Cliente buscará', 4, 'Retirada no local', 4),
    ('2024-11-24', 5, 'Entrega em horário comercial', 5, '7 dias úteis', 5);


INSERT INTO itens_pedido (id_pedido, id_produto, qtde)
VALUES
    (1, 1, 2),
    (2, 2, 5),
    (3, 3, 1),
    (4, 4, 10),
    (5, 5, 3);

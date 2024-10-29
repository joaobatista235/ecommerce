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
    perc_comissao DECIMAL(5, 2)
);
-- Criar tabela 'produto'
CREATE TABLE produto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    qtde_estoque INT,
    preco DECIMAL(15, 2),
    unidade_medida VARCHAR(10),
    promocao CHAR(1)
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
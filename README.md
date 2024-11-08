# Projeto E-commerce

## Descrição

Este projeto é uma plataforma de e-commerce que permite aos usuários se registrarem como clientes ou vendedores, fazer login, e visualizar o catálogo de produtos. O sistema está sendo desenvolvido com funcionalidades de CRUD (Criar, Ler, Atualizar, Deletar) para clientes, vendedores e produtos, e com navegação dinâmica usando AJAX para carregar conteúdo sem recarregar a página.

## Tecnologias Utilizadas

- **Frontend:**
  - HTML5
  - CSS3
  - JavaScript (AJAX, jQuery)
  - Bootstrap (v5.3)
  
- **Backend:**
  - PHP (para lógica de backend)
  - Banco de Dados MySQL (para armazenar informações de usuários, vendedores e produtos)
  
- **Outros:**
  - Git (controle de versão)
  - jQuery para manipulação de DOM e requisições AJAX

---

## Estrutura de Diretórios

/project-root ├── /assets # Imagens e ícones estáticos ├── /config # Configurações globais (CSS, JS) ├── /controllers # Controladores PHP (lógica de negócio) ├── /models # Modelos PHP para acesso ao banco de dados ├── /views # Visualizações HTML/PHP (telas) ├── /views/base # Cabeçalho e rodapé compartilhados ├── /views/admin # Páginas administrativas ├── /views/user # Páginas para clientes e vendedores ├── /views/products # Páginas de gestão de produtos ├── /views/cart # Páginas de carrinho e pedidos └── /index.php # Página inicial


---

## Funcionalidades

- **Cadastro de Usuário (Cliente ou Vendedor):**
  - Usuários podem se registrar como **clientes** ou **vendedores** através da escolha de um perfil.
  - Cada perfil tem acesso a funcionalidades específicas (clientes visualizam produtos; vendedores gerenciam seus próprios produtos).

- **Login e Autenticação:**
  - Sistema de login para clientes e vendedores, com verificação de credenciais.

- **Perfil do Cliente:**
  - O **cliente** pode visualizar e atualizar suas informações pessoais (como nome, endereço, email).
  - Funcionalidade de **atualizar** e **deletar** informações no perfil do cliente.
  
- **Perfil do Vendedor:**
  - O **vendedor** tem acesso ao CRUD de produtos (criar, editar, excluir e listar produtos).
  - O **vendedor** pode listar seus próprios produtos na página de perfil.
  
- **CRUD de Produtos:**
  - Funcionalidade de CRUD de produtos para **vendedores**.
  - Produtos podem ser adicionados, editados ou removidos.

- **Listagem de Produtos:**
  - Na página principal (home), todos os produtos cadastrados são listados para clientes visualizarem.
  
- **Carrinho de Compras:**
  - Funcionalidade de **carrinho de compras** para clientes.
  - Os clientes podem adicionar produtos ao carrinho, visualizar itens no carrinho e fazer pedidos.

- **Pedido e Itens de Pedido:**
  - Implementação futura de sistema de pedidos, onde o cliente pode realizar uma compra com os itens adicionados ao carrinho.

---

## Pontos Pendentes

Abaixo estão as funcionalidades que ainda precisam ser implementadas ou estão em andamento:

### 1. **Página de Perfil do Cliente:**
   - **Atualizar e Deletar Dados do Cliente:**
     - O cliente pode acessar seu perfil e alterar informações como nome, endereço e senha.
     - Implementação de funcionalidade para **atualizar** ou **deletar** o cliente do sistema.

### 2. **CRUD de Produtos (Página do Vendedor):**
   - **Criar, Editar e Excluir Produtos:**
     - Funcionalidade completa de CRUD de produtos para vendedores.
     - Os vendedores podem criar, editar e excluir produtos diretamente na plataforma.
  
### 3. **Listagem de Produtos (Página do Vendedor):**
   - **Listar Produtos Cadastrados pelo Vendedor:**
     - Na tela de perfil do vendedor, listar todos os produtos cadastrados por ele.
     - Implementação de um layout de exibição de produtos do vendedor com links para editar ou excluir.

### 4. **Página Principal (Home) - Listagem de Produtos:**
   - **Exibir Todos os Produtos para Clientes:**
     - Exibição de uma lista de todos os produtos cadastrados na plataforma, visível na tela principal (`home.php`).
     - Adicionar funcionalidades de filtragem (por preço, categoria, etc.) na tela principal.

### 5. **Carrinho de Compras (Futuro):**
   - **Adicionar Produtos ao Carrinho:**
     - Implementar a funcionalidade de **carrinho de compras** para que os clientes possam adicionar produtos à sua cesta e visualizar o total.
   - **Itens de Pedido:**
     - Implementar o sistema de **itens de pedido** e finalizar compras (processamento de pagamento, envio, etc.).
   
### 6. **Sistema de Pedidos:**
   - **Criar um Sistema de Pedidos:**
     - A plataforma deve permitir que o cliente finalize a compra de produtos que ele adicionou ao carrinho.
     - Implementação de **ordens** e **status de pedidos**.

### 7. **Sistema de Ordenação e Filtros:**
   - **Ordenar Produtos por Preço ou Nome:**
     - Adicionar funcionalidades de ordenação de produtos (por preço, data de cadastro, etc.).
   - **Filtros de Busca:**
     - Filtrar produtos por categoria, preço ou outros parâmetros.

### 8. **Padronização de Controladores:**
   - **Refatoração dos Controladores:**
     - Organizar os controladores para garantir que a lógica de negócios esteja centralizada e reutilizável.
     - Padronizar as funções dos controladores para facilitar a manutenção e o desenvolvimento futuro.

---

## Como Executar

1. **Clone o repositório**:

git clone https://github.com/seu-usuario/projeto-ecommerce.git  

2. **Instale as dependências** (se houver):
- Certifique-se de que você tenha o PHP, MySQL e Apache ou Nginx configurados.
- Para rodar localmente, você pode usar o XAMPP ou MAMP para gerenciar o servidor local.

3. **Configuração do Banco de Dados**:
- Crie um banco de dados MySQL chamado `ecommerce` e configure as tabelas necessárias (usuários, produtos, pedidos, etc.).
- Importe os scripts SQL fornecidos ou crie o banco conforme o modelo de dados.

4. **Acesse o Projeto**:
- Abra seu navegador e acesse o projeto no endereço `http://localhost/projeto-ecommerce` (dependendo da sua configuração).

---

## Contribuições

Contribuições são bem-vindas! Se você deseja contribuir com o projeto, siga os seguintes passos:

1. **Faça um Fork** do repositório.
2. **Crie uma branch** para sua feature (`git checkout -b minha-feature`).
3. **Commit suas mudanças** (`git commit -am 'Adiciona nova funcionalidade'`).
4. **Push para a branch** (`git push origin minha-feature`).
5. **Abra um Pull Request**.

---

## Licença

Este projeto está licenciado sob a MIT License - consulte o arquivo [LICENSE](LICENSE) para mais detalhes.

---

### Observações Finais:

Esse **README.md** oferece uma visão geral do projeto, além de listar as funcionalidades implementadas e as pendentes. As funcionalidades mencionadas estão claramente organizadas para facilitar o acompanhamento do progresso do projeto.


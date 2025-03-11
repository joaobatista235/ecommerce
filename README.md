# Projeto E-commerce 🛒

Este projeto é uma plataforma de e-commerce que permite aos usuários se registrarem como clientes ou vendedores, fazer login, e visualizar o catálogo de produtos. O sistema está sendo desenvolvido com funcionalidades de **CRUD** (Criar, Ler, Atualizar, Deletar) para clientes, vendedores e produtos, e com navegação dinâmica usando **AJAX** para carregar conteúdo sem recarregar a página.

---

## Índice 📚

- [Visão Geral](#visão-geral-)
- [Tecnologias Utilizadas](#tecnologias-utilizadas-)
- [Estrutura de Diretórios](#estrutura-de-diretórios-)
- [Funcionalidades](#funcionalidades-)
- [Pontos Pendentes](#pontos-pendentes-)
- [Como Executar](#como-executar-)
- [Contribuição](#contribuição-)
- [Licença](#licença-)

---

## Visão Geral 🌟

O **Projeto E-commerce** é uma plataforma completa para gerenciamento de clientes, vendedores e produtos. Ele oferece funcionalidades de **CRUD** para clientes e vendedores, além de permitir a gestão de produtos e a realização de pedidos. A navegação dinâmica com **AJAX** proporciona uma experiência de usuário fluida e moderna.

---

## Tecnologias Utilizadas 🛠️

### Frontend
- **HTML5**: Estrutura das páginas.
- **CSS3**: Estilização das páginas.
- **JavaScript**: Interatividade e requisições **AJAX**.
- **Bootstrap (v5.3)**: Framework para design responsivo.
- **jQuery**: Manipulação de DOM e requisições **AJAX**.

### Backend
- **PHP**: Lógica de backend.
- **MySQL**: Banco de dados para armazenar informações de usuários, vendedores e produtos.

### Outros
- **Git**: Controle de versão.

---

## Estrutura de Diretórios 🗂️

```
/project-root
├── /assets                # Imagens e ícones estáticos
├── /config                # Configurações globais (CSS, JS)
├── /controllers           # Controladores PHP (lógica de negócio)
├── /models                # Modelos PHP para acesso ao banco de dados
├── /views                 # Visualizações HTML/PHP (telas)
│   ├── /base              # Cabeçalho e rodapé compartilhados
│   ├── /admin             # Páginas administrativas
│   ├── /user              # Páginas para clientes e vendedores
│   ├── /products          # Páginas de gestão de produtos
│   └── /cart              # Páginas de carrinho e pedidos
└── /index.php             # Página inicial
```

---

## Funcionalidades ✨

### Cadastro de Usuário (Cliente ou Vendedor)
- Usuários podem se registrar como clientes ou vendedores através da escolha de um perfil.
- Cada perfil tem acesso a funcionalidades específicas (clientes visualizam produtos; vendedores gerenciam seus próprios produtos).

### Login e Autenticação
- Sistema de login para clientes e vendedores, com verificação de credenciais.

### Perfil do Cliente
- O cliente pode visualizar e atualizar suas informações pessoais (como nome, endereço, email).
- Funcionalidade de atualizar e deletar informações no perfil do cliente.

### Perfil do Vendedor
- O vendedor tem acesso ao **CRUD** de produtos (criar, editar, excluir e listar produtos).
- O vendedor pode listar seus próprios produtos na página de perfil.

### CRUD de Produtos
- Funcionalidade de **CRUD** de produtos para vendedores.
- Produtos podem ser adicionados, editados ou removidos.

### Listagem de Produtos
- Na página principal (home), todos os produtos cadastrados são listados para clientes visualizarem.

### Carrinho de Compras
- Funcionalidade de carrinho de compras para clientes.
- Os clientes podem adicionar produtos ao carrinho, visualizar itens no carrinho e fazer pedidos.

### Pedido e Itens de Pedido
- Implementação futura de sistema de pedidos, onde o cliente pode realizar uma compra com os itens adicionados ao carrinho.

---

## Pontos Pendentes 📝

1. **Página de Perfil do Cliente**:
   - Atualizar e Deletar Dados do Cliente.
   - Implementação de funcionalidade para atualizar ou deletar o cliente do sistema.

2. **CRUD de Produtos (Página do Vendedor)**:
   - Criar, Editar e Excluir Produtos.
   - Funcionalidade completa de **CRUD** de produtos para vendedores.

3. **Listagem de Produtos (Página do Vendedor)**:
   - Listar Produtos Cadastrados pelo Vendedor.
   - Implementação de um layout de exibição de produtos do vendedor com links para editar ou excluir.

4. **Página Principal (Home) - Listagem de Produtos**:
   - Exibir Todos os Produtos para Clientes.
   - Adicionar funcionalidades de filtragem (por preço, categoria, etc.) na tela principal.

5. **Carrinho de Compras (Futuro)**:
   - Adicionar Produtos ao Carrinho.
   - Implementar o sistema de itens de pedido e finalizar compras (processamento de pagamento, envio, etc.).

6. **Sistema de Pedidos**:
   - Criar um Sistema de Pedidos.
   - Implementação de ordens e status de pedidos.

7. **Sistema de Ordenação e Filtros**:
   - Ordenar Produtos por Preço ou Nome.
   - Filtrar produtos por categoria, preço ou outros parâmetros.

8. **Padronização de Controladores**:
   - Refatoração dos Controladores.
   - Organizar os controladores para garantir que a lógica de negócios esteja centralizada e reutilizável.

---

## Como Executar 🚀

1. **Clone o repositório**:
   ```bash
   git clone https://github.com/seu-usuario/projeto-ecommerce.git
   cd projeto-ecommerce
   ```

2. **Instale as dependências**:
   - Certifique-se de que você tenha o **PHP**, **MySQL** e **Apache** ou **Nginx** configurados.
   - Para rodar localmente, você pode usar o **XAMPP** ou **MAMP** para gerenciar o servidor local.

3. **Configuração do Banco de Dados**:
   - Crie um banco de dados MySQL chamado `ecommerce` e configure as tabelas necessárias (usuários, produtos, pedidos, etc.).
   - Importe os scripts SQL fornecidos ou crie o banco conforme o modelo de dados.

4. **Acesse o Projeto**:
   - Abra seu navegador e acesse o projeto no endereço `http://localhost/projeto-ecommerce` (dependendo da sua configuração).

---

## Licença 📜

Este projeto está licenciado sob a **MIT License** - consulte o arquivo [LICENSE](LICENSE) para mais detalhes.

---

Feito com ❤️ por [João Batista](https://github.com/joaobatista235).

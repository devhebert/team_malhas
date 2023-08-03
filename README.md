# Mercado Têxtil - Team Malhas (V1)

Este projeto consiste em um desafio para testar as habilidades em PHP. O objetivo é desenvolver um sistema que utilize PHP 7.4 ou uma versão superior, em conjunto com PostgreSQL ou MSSQL Server como banco de dados.

## Requisitos do Projeto

- Cadastro de produtos.
- Cadastro de tipos para cada produto.
- Cadastro de valores percentuais de imposto para cada tipo de produto.
- Tela de venda, na qual o usuário informará os produtos e suas quantidades adquiridas.
- Apresentação do valor de cada item multiplicado pela quantidade adquirida, o valor total da compra e o total dos impostos pagos.
- Armazenamento das vendas no sistema.

## Funcionalidades da Versão Atual (V1)

Atendendo a todos esses requisitos, foi desenvolvido o programa Mercado Têxtil - Team Malhas, na versão atual (V1). O sistema foi criado utilizando PHP 8.2 e PostgreSQL.

## Funcionalidades da Próxima Versão (V2)

Para a próxima versão (V2), estão sendo adicionadas as seguintes funcionalidades:

- Edição e exclusão de produtos.
- Criação da tabela "type_product" para permitir que o usuário crie novos tipos de produtos, além dos enumerados anteriormente.
- Criação da tabela "estoque" para manter o controle de entrada e saída de produtos.
- Implementação de uma interface de login com níveis de acesso.

Essas melhorias na próxima versão garantirão maior flexibilidade e controle no gerenciamento de produtos, tipos, estoque e vendas, proporcionando uma experiência aprimorada para os usuários.

## Configuração do Ambiente

Para a inicialização do projeto, é necessário que você tenha o PHP instalado em sua máquina. Caso não tenha, você pode baixá-lo [aqui](https://php.net). Além disso, você precisará do banco de dados PostgreSQL, que pode ser obtido [aqui](https://www.postgresql.org/download/).

## Instruções de Configuração

1. Clone o repositório do projeto.
2. Abra o projeto em sua IDE e localize o arquivo `config.php` que está na raiz do projeto.
3. No início do arquivo `config.php`, você encontrará as variáveis `$servername`, `$username`, `$password` e `$dbname`. Substitua o valor de `$username` e `$password` pelo usuário e senha que você configurou em seu banco de dados PostgreSQL.
4. Após configurar o `config.php`, vá no terminal de sua IDE e execute o comando: `php -S localhost:8080`.
5. Clique no link gerado após a execução do comando acima.
6. Será executado um build que criará o banco de dados e suas respectivas tabelas.
7. Pronto! Agora você já pode brincar com esse programa.

Observação: Certifique-se de que o banco de dados PostgreSQL esteja em execução antes de executar o projeto.


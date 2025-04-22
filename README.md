# Portal Administrativo
Bem-vindo ao repositório do **Portal Administrativo**, uma aplicação desenvolvida para gerenciar clientes de forma eficiente.

## Tecnologias Utilizadas

### Backend:
- **PHP 8.3**
- **MySQL**

### Frontend:
- **TailwindCSS**
- **jQuery**

## Princípios e boas práticas

Este projeto foi desenvolvido seguindo os princípios de **Clean Architecture** e as **boas práticas de desenvolvimento**, com ênfase na manutenção de um código limpo, escalável e de fácil manutenção. Além disso, as diretrizes **SOLID** foram aplicadas para garantir que o código seja bem estruturado, flexível e com baixo acoplamento.

### Testes

A aplicação foi desenvolvida com testes unitários em mente, utilizando  **PHPUnit** para garantir a qualidade e estabilidade do código. Os testes foram estruturados para garantir que os **casos de uso**, camada onde fica concentrado a **lógica de negócio** funcionem de maneira isolada, sem dependências externas.

Acompanhe a última execução dos testes, acesse o [relatório de ações do GitHub](../../actions) do repositório. Lá você encontra o histórico das execuções automáticas e os cenários que foram validados.

<br>

# Configuração Local

## Pré-requisitos

Antes de iniciar as etapas, certifique-se de que você tenha instalado em sua máquina:

1. **Docker** e **Docker Compose**.
3. Este repositório clonado localmente.

## Como subir a aplicação

Siga as etapas abaixo:

### Passo 1: Navegar para o diretório do projeto

Abra um terminal e navegue até o diretório raiz deste projeto, onde o repositório foi clonado.

### Passo 2: Subir os serviços

No terminal, execute o comando abaixo para subir os serviços necessários que compõem a aplicação utilizando docker:

```bash
docker compose up --build
```

O comando acima irá preparar todo o ambiente e instalar as dependências necessárias para a aplicação. Aguarde até o termino para uso, por padrão a aplicação ficará disponível em http://localhost:8080

## Configurações opcionais de portas

Se necessário, você pode alterar as portas padrão utilizadas pela aplicação ou banco de dados. Para isso, basta editar as seguintes variáveis no arquivo `.env` do seu projeto:

- **APP_PORT**: Define a porta que a aplicação web irá utilizar. Se você precisar rodar a aplicação em uma porta diferente, altere este valor.
- **FORWARD_DB_PORT**: Define a porta que o banco de dados MySQL usará. Caso você precise usar uma porta diferente para o banco, altere este valor.

### Como alterar as portas

1. Abra o arquivo `.env` localizado na raiz do seu projeto.
2. Encontre as variáveis correspondentes às portas, por exemplo:
   
   ```
   APP_PORT=8000
   FORWARD_DB_PORT=3306
   ```

3. Alterando as variáveis, por exemplo:
   
   ```
   APP_PORT=8080
   FORWARD_DB_PORT=3307
   ```

4. Salve o arquivo `.env`.

Depois de alterar essas variáveis você pode reiniciar os serviços que os mesmos irão executar nas novas portas configuradas:
```bash
docker compose restart
```

## Como executar os testes unitários

Após os serviços da aplicação estarem disponíveis nos passos anteriores, siga as etapas abaixo para execução dos testes:

### Passo 1: Navegar para o diretório do projeto

Abra um novo terminal e navegue até o diretório raiz deste projeto, onde o repositório foi clonado.

### Passo 2: Execução do comando

No terminal, execute o comando abaixo para executar os testes unitários:

```bash
docker compose exec -it app.portal_adm composer test
```

Acompanhe na saída do terminal os cenários de teste que foram criados para os **casos de uso** desta aplicação.
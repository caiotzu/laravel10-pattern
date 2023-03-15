# Pattern laravel 10
> Projeto construído com laravel 10 - template Enigma v1.0.5

<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" alt="Pattern laravel 10"/>

# :rocket: Tecnologias
> Tecnologias usadas no desenvolvimento
- Laravel
- PHP
- JQuery
- Js
- Vite
- CSS
- PostgreSQL
- Docker
- Redis
- Tailwind

# :link: *Dependências* 
> Dependências para poder executar o projeto.
- NodeJs
- Yarn
- PostgreSQL
- Composer

# :hammer_and_wrench: Instalação
> Download e configuração do projeto.

- Clone o projeto para o seu ambiente de desenvolvimento
```sh
git clone https://github.com/caiotzu/laravel10-pattern.git
```
- Acesse a pasta do repositório clonado
```sh
cd laravel10-pattern/
```
- Copie o arquivo env.example para .env e coloque suas variáveis de ambiente no arquivo .env
```sh
cp .env.example .env
```
- Acesse a pasta public dentro do projeto
```sh
cd public/
```
- Execute o comando, para remover o link simbólico se ele existir
```sh
rm storage
```
- Execute o comando para retornar a raiz do projeto
```sh
cd ..
```
- Execute o comando para instalar as dependências 
```sh
yarn install
```
- Execute o comando para dar o build nos arquivos js
```sh
yarn run dev
```
- Execute o comando dentro da pasta do projeto para inicializar o container do docker
```sh
docker-compose up
```
- Execute o comando em seu terminar para acessar o projeto dentro do docker
```sh
docker exec -it php-laravel10-pattern /bin/bash
```
- Execute o comando para instalar as dependências do projeto
```sh
composer install
```
- Execute o comando para criar um link simbólico para a pasta storage
```sh
php artisan storage:link
```
- Execute o comando para gerar a key do projeto
```sh
php artisan key:generate
```
- Execute o comando para gerar as tabelas e os dados iniciais
```sh
php artisan migrate:fresh --seed
```
# :computer: Inicialização
> Execute os comandos abaixo no repositório clonado, para inicializar o docker.

- Inicializar o docker
```sh
docker-compose up
```

# :earth_americas:	Acesso
> Acesse os links abaixo para ter acesso ao sistema 

### :man_technologist: Acesso a área administrativa: 

- Url: http://127.0.0.1:8989/admin
- E-mail: admin@admin.com
- Senha: administrador

### :raising_hand_man: Acesso a área dos perfis:
- Url: http://127.0.0.1:8989


# :books: Padronização
> Padrões de criação e desenvolvimento do sistema.

### :blue_book: Tables

- Sempre colocar o nome das tabelas no plural, em minúsculo e o nome em inglês. Ex: (users)
- Quando o nome da tabela for composto, o primeiro nome sempre no singular e o segundo no plural. Ex: (company_groups)

### :blue_book: Model

- Os models devem sempre ficar dentro da pasta app/Models
- Colocar sempre no singular, com a primeira letra em maiúsculo e em inglês. Ex: ( User )
- Quando o nome for composto, manter no singular. Ex: (CompanyGroup)

### :blue_book: Services

- Um serviço deve sempre receber o nome do model ao qual está representando, adicionando o sufixo "Service". Ex: (UserService)
### :blue_book: Controllers

- Colocar sempre no singular, com a primeira letra em maiúsculo e o nome em inglês. Ex: ( UserController )
- Quando o nome for composto, manter no singular. Ex: (CompanyGroupController)

### :blue_book: Requests

- Deve ser criada seguindo o padrão (nome da função que irá utilizar o request + nome da subdivisão se tiver + nome do controller + sufixo Request)


#  :desktop_computer: Comandos

> Comandos utilizados para manutenção/instalação do sistema.

- php artisan make:migration create_admin_settings :hash: Cria uma nova migration
- php artisan migrate:fresh --seed :hash: Apaga todo o banco de dados e cria novamente já rodando os seeders
- php artisan migrate :hash: Faz a criação das tabelas que ainda não foram criadas pelas migrations
- php artisan db:seed :hash: Faz a criação dos dados padrões nas tabelas
- php artisan make:model AdminUser :hash: Criar um novo model
- php artisan make:request StoreAdminUserRequest :hash: Cria uma nova request
- php artisan make:service AdminRoleService :hash: Cria um novo service

# :stopwatch:	Sessões do sistema
> Lista de todas as sessões que existem no sistema

- userPermission - Contem todas as permissões de acesso do usuário logado
<hr>

#### :nerd_face: Ser desenvolvedor é uma viagem onde a próxima parada é a solução de um problema. :rocket:

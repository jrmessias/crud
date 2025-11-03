- Executar o comando `composer install` para instalar as dependências do projeto.

- Copiar `.env.example` para `.env`

- Configurar conexão com banco de dados com variáveis DB_

- Alterar chave CSRF_KEY no arquivo .env | [IT-Tools](https://it-tools.tech/token-generator?length=32)

- Testar conexão e migração de dados

| Linux: vendor/bin/phinx migrate --dry-run

| Windows: php vendor/bin/phinx migrate --dry-run

- Rodar servidor embutido do php (utilizar url APP_URL do .env)

| php -S localhost:8001 -t public

- Executar migração de dados

| Linux: vendor/bin/phinx migrate

| Windows: php vendor/bin/phinx migrate

- Criar primeiro usuário

Acesse: localhost:8001/auth/create
- E-mail: teste@teste.com
- Senha: teste123

------

1. Routes (routes.php)
2. Controller (ProductController > CategoryController)
3. Migrations (db/migrations)
4. Repository (ProductRepository > CategoryRepository)
5. Model (Product > Category)
6. Service (ProductService > CategoryService)
7. Views (duplicar - views/admin/products > categories)
8. Controller (views)
9. Views (alterar)

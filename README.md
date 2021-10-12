# Home Budgeting
Project made during internship. 

Stack:
* Vue 3 (Vue Router, Vuex)
* Symfony (Doctrine)
* API Platform
* PostgreSQL
* Docker (docker-compose)


## Run app
1. `docker-compose up -d --build`
2. `docker-compose exec php /bin/bash`
3. `composer install`
4. Create database:
   `symfony console doctrine:database:create`
5. Migrate:
   `symfony console doctrine:migrations:migrate`
6. Load data fixtures for dev:
   `symfony console doctrine:fixtures:load`
7. `cd` to `\app`
8. `yarn` or `npm install`
9. `yarn dev-server` or `npm run dev-server`
10. Go to http://localhost:8000

## Testing
1. `cd` to `\app`
2. `docker-compose exec php /bin/bash`
3. Create database for tests: `symfony console doctrine:database:create --env=test`
4. Migrate: `symfony console doctrine:migrations:migrate --env=test`
5. Load data fixtures for test database: `symfony console hautelook:fixtures:load --env=test` 
6. Run tests:  
   `bin/phpunit`

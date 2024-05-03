install:
	docker compose exec php composer install

db:
	docker compose exec php bin/console doctrine:migrations:migrate

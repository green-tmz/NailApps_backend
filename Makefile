.PHONY: setup test lint

setup-local:
	./bin/setup-local.sh

setup:
	docker-compose up -d
	docker-compose exec app composer install
	docker-compose exec app npm install
	docker-compose exec app cp .env.local .env
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate --seed

test:
	docker-compose exec app php artisan test

lint:
	docker-compose exec app composer lint
	docker-compose exec app npm run lint

down:
	docker-compose down

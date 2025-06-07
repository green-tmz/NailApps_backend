setup-local:
	./bin/setup-local.sh

lint:
	docker compose exec -e PHP_CS_FIXER_IGNORE_ENV=1 app vendor/bin/php-cs-fixer fix --using-cache=no --allow-risky=yes

analyze:
	docker compose exec app vendor/bin/phpstan analyse app --memory-limit=-1

rector:
	docker compose exec app vendor/bin/rector process --clear-cache

lint-fix:
	docker compose exec app ./vendor/bin/phpcbf --standard=PSR12 app tests

test:
	docker compose exec app php artisan test

prepare-commit:
	docker compose exec app  sh -c "./vendor/bin/phpcbf --standard=PSR12 app tests && ./vendor/bin/phpcs --standard=PSR12 app tests && php artisan test --parallel --processes=12"

cc: ## Clear cache
	php bin/console  c:c --env=dev
	php bin/console  c:c --env=prod
	php bin/console  c:c --env=test

run-app: ## install all dependencies
	composer install
	make reload
	bin/console lexik:jwt:generate-keypair

help: ## display command lists
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

up:  ## build and run docker containers
	docker-compose up -d --build

down:  ## stop and remove docker containers
	docker-compose down

php:  ## ssh of php container
	 docker-compose exec php bash

test:  ## lunch all functional tests with migrations
	php bin/console doctrine:schema:drop --force --env=test \
    	&& php bin/console doctrine:schema:update --force --env=test \
    	&& php bin/console doctrine:fixtures:load -n --env=test \
		&& vendor/bin/phpunit

reload:  ## reload database(delete,create and fixtures)
	php bin/console doctrine:schema:drop --force \
	&& php bin/console doctrine:schema:update --force \
	&& php bin/console doctrine:fixtures:load -n

php-cs-fixer: ## fix php cs
	php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix src
	php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix tests

phpstan:  ## check php stan
	vendor/bin/phpstan analyse phpstan.neon --level=6 src
	vendor/bin/phpstan analyse phpstan.neon --level=6 tests

quality: ## check quality of code
	make php-cs-fixer
	make phpstan

write-and-read:
	bin/console lexik:jwt:generate-token admin

read:
	bin/console lexik:jwt:generate-token user
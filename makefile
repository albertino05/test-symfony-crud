APP_ENV=dev

# internal
COMPOSE_PROJECT_NAME=demo_test
compose=docker-compose -f docker-compose.yml

export compose COMPOSE_PROJECT_NAME APP_ENV

.PHONY: start
start: down up composer-install## Start dev

.PHONY: up
up: ## spin up environment
	$(compose) up -d --build

.PHONY: stop
stop: ## stop environment
	$(compose) stop $(s)
		
.PHONY: down
down: ## down environment
	$(compose) down

.PHONY: sh
sh: ## gets inside a container, use 's' variable to select a service. make s=php sh
	$(compose) exec $(s) sh -l

.PHONY: logs
logs: ## look for 's' service logs, make s=php logs
	$(compose) logs -f $(s)

.PHONY: composer-install
composer-install: ## composer install
	$(compose) exec -T php sh -lc 'composer install --no-interaction'

# tests: ## tests
.PHONY: tests
tests: APP_ENV = test
tests: db ## tests
	$(compose) exec -T php sh -lc 'bin/phpunit'

.PHONY: db
db: ## reset db
	-$(compose) exec -T php sh -lc 'bin/console doctrine:database:drop -f -e $(APP_ENV)'
	$(compose) exec -T php sh -lc 'bin/console doctrine:database:create --quiet -e $(APP_ENV)'
	$(compose) exec -T php sh -lc 'bin/console doctrine:migrations:migrate --no-interaction --quiet -e $(APP_ENV)'

.PHONY: help
help: ## Display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'



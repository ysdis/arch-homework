UID=$(shell id -u)

include .env

privilege: ## add user to docker group. After run "exec su -l $USER"
	sudo gpasswd -a ${USER} docker

permissions: ## Fixing permissions for project files
	@echo '\033[0;35m[LOCAL FILES UID]\033[0m'; \

	cd ../$$s && sudo chmod 775 -R ./ && sudo chown ${UID}:www-data -R ./; \

run: ## run projects
	@echo '\033[0;35m[RUN]\033[0m'; \

	docker-compose -p ${PROJECT_NAME} up -d

build: ## build all services
	@echo '\033[0;35m[BUILD]\033[0m'; \

	docker-compose -p ${PROJECT_NAME} build

stop: ## stop projects
	@echo '\033[0;35m[STOP]\033[0m'; \

	docker-compose -p ${PROJECT_NAME} stop

to-php: ## enter to the php container
	@docker-compose -p ${PROJECT_NAME} exec php bash

rebuild: stop build run

gen-openapi: ## Generate OpenAPI specifications from project annotations
	@echo '\033[0;35m[GENERATING OPENAPI SPECS]\033[0m'; \

	sudo ../vendor/bin/openapi -o ../ ../app

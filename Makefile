default: install

DOCKER :=
ifeq ($(isContainerRunning), 1)
	user := $(shell id -u)
    group := $(shell id -g)
    DOCKER := @docker exec -t -u $(user):$(group) test_app
endif

CONSOLE := $(DOCKER) php bin/console
COMPOSER = $(DOCKER) composer
NPM = $(DOCKER) npm

continue:
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Would you like to continue ? [y/n]: " CONTINUE; \
	done ; \
	[ $$CONTINUE = "y" ] || [ $$CONTINUE = "Y" ] || (echo "End of make program"; exit 1;)
	@echo "...continue..."

configured:
ifneq ($(wildcard .env),)
include .env
else
	@echo "!Please create .env file. You need to configure all variables that mentioned in .env.example"
endif

help:
	@echo "---------------------------------------------------------"
	@echo "make install    => Install project and dependencies      "
	@echo "make restart    => Restart containers and dependencies   "
	@echo "---------------------------------------------------------"


warning:
	@echo "-------------------------------------------------------------------------------"
	@echo "-------------------------------WARNING ---------------------------------------"
	@echo "-------------------------------------------------------------------------------"
	@echo ""

prune_warning:
	@echo "Remove all containers for $(COMPOSE_PROJECT_NAME) project, purge all volumes and network ?"
	@echo ""

install: configured prune continue
	docker-compose up -d --build
	@sleep 2
	@docker-compose ps
	@sleep 2
	$(COMPOSER) install -n
	$(NPM) install
	$(NPM) run build

prune: warning prune_warning continue
	@docker-compose down --remove-orphans
	@docker-compose down --volumes
	@docker-compose rm -f

restart:
	@docker-compose down
	@docker-compose up -d
	@docker-compose ps

install_dependencies:
	$(COMPOSER) install -n


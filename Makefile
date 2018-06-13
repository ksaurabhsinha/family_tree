include .env

export PROJECT_NAME
export MEMORY_SIZE
export DISK_SIZE

.PHONY: all build

SHELL := /bin/bash

#Define Colors to be used
LIGHT_GREEN := $(shell echo -e "\033[1;32m")
RED := $(shell echo -e "\033[0;31m")
CYN := $(shell echo -e "\033[0;36m")
NC := $(shell echo -e "\033[0m") # No Color

include build/makefiles/*.mk

create_machine:
	@source build/shell/machine && machine create

destroy_machine:
	@docker-machine stop ${PROJECT_NAME}
	@docker-machine rm ${PROJECT_NAME}

containers_up:
	$(call message, Building the Docker Containers)
	@eval $$(docker-machine env ${PROJECT_NAME}) && docker-compose up -d --build --force-recreate

remove_containers:
	$(call message, Removing the Docker Containers)
	@eval $$(docker-machine env ${PROJECT_NAME}) && docker-compose down

project_init: 
	$(call message, Initializing the project)
	@eval $$(docker-machine env ${PROJECT_NAME}) && docker exec -it ${PROJECT_NAME}_php cp -n .env.example .env

project_deps:
	$(call message, Taking care of the dependencies)
	@eval $$(docker-machine env ${PROJECT_NAME}) && docker exec -it ${PROJECT_NAME}_php composer install
	@eval $$(docker-machine env ${PROJECT_NAME}) && docker exec -it ${PROJECT_NAME}_php chmod +x artisan

migration:
	$(call message, Running the migrations)
	@eval $$(docker-machine env ${PROJECT_NAME}) && docker exec -it ${PROJECT_NAME}_php php artisan migrate

seed_db:
	$(call message, Seeding data)
	@eval $$(docker-machine env ${PROJECT_NAME}) && docker exec -it ${PROJECT_NAME}_php php artisan db:seed --class=CategoryTableSeeder

run_tests:
	$(call message, Running Tests)
	@eval $$(docker-machine env ${PROJECT_NAME}) && docker exec -it ${PROJECT_NAME}_php vendor/bin/phpunit

build_coverage:
	$(call message, Building Coverage)
	@eval $$(docker-machine env ${PROJECT_NAME}) && docker exec -it ${PROJECT_NAME}_php vendor/bin/phpunit --coverage-html coverage

success:
	@echo "${CYN} ****************************************************************"
	@echo "${CYN} *                                                              *"
	@echo "${CYN} *             Setup is complete. We are good to go.            *"
	@echo "${CYN} *                                                              *"
	@echo "${CYN} ****************************************************************"

project_config:
	@echo -e "\n \n"
	@echo -e "${LIGHT_GREEN} --------------------- Project configuration details ---------------------"
	@echo "${CYN} Machine IP Address:  ----- ${LIGHT_GREEN} $$(docker-machine ip ${PROJECT_NAME})"
	@echo "${CYN} Machine Name:        ----- ${LIGHT_GREEN} ${PROJECT_NAME}"
	@echo "${CYN} Web Url:             ----- ${LIGHT_GREEN} http://$$(docker-machine ip ${PROJECT_NAME})"
	@echo "${CYN} MySQL Host:          ----- ${LIGHT_GREEN} mysql (when connecting from inside the application)"
	@echo "${CYN}                      ----- ${LIGHT_GREEN} $$(docker-machine ip ${PROJECT_NAME}) (when connecting from outside the application)"
	@echo "${CYN} MySQL User:          ----- ${LIGHT_GREEN} ${DB_USERNAME}"
	@echo "${CYN} MySQL Password:      ----- ${LIGHT_GREEN} ${DB_PASSWORD}"
	@echo "${CYN} MySQL Root User:     ----- ${LIGHT_GREEN} root"
	@echo "${CYN} MySQL Root Password: ----- ${LIGHT_GREEN} ${DB_ROOT_PASSWORD}"
	@echo -e "\n"
	@echo -e "${LIGHT_GREEN} --------------------- Add the following to your bashrc or zshrc ---------------------"
	@echo -e "${CYN} eval $$(docker-machine env ${PROJECT_NAME})"

install: intro_text create_machine containers_up project_init project_deps migration seed_db build_coverage success project_config

project_setup: containers_up project_init project_deps migration seed_db build_coverage success project_config

ifneq (,$(wildcard ./.env))
    include .env
    export
else
    include .env.example
    export
endif

help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Commands:"
	@echo "  clean               Clean directories for reset"
	@echo "  init                Cleanup data files and re-init project"
	@echo "  docker-start        Create and start containers"
	@echo "  docker-stop         Stop all services"
	@echo "  build               Build frontend"

init:
	make clean
	make init-env
	docker-compose up -d
	docker-compose exec php composer install
	docker-compose exec php php artisan key:generate
	docker-compose exec php php artisan migrate:install
	docker-compose exec php php artisan migrate
	docker-compose exec php php artisan db:seed --class=BoosterPackSeeder
	docker-compose exec php npm i
	docker-compose exec php npm run prod
	docker-compose exec php php artisan ide-helper:generate
	make docker-info

clean:
	make docker-stop
	docker-compose rm --force
	rm -rf ./storage/docker/data/mysql/*

docker-start:
	docker-compose up -d
	make docker-info

docker-stop:
	docker-compose stop

build:
	docker-compose exec php npm run prod

init-env:
ifeq (,$(wildcard .env))
	cp .env.example .env
endif

docker-info:
	@echo "Web is available here: $(APP_URL):$(APP_PORT)"
	@echo "PMA is available here: $(APP_URL):$(PMA_PORT)"

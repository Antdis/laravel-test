help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Commands:"
	@echo "  clean               Clean directories for reset"
	@echo "  init                Cleanup data files and re-init project"
	@echo "  docker-start        Create and start containers"
	@echo "  docker-stop         Stop all services"

init:
	@make clean
	@make docker-start
	@docker-compose exec php composer install
	cp .env.example .env
	@docker-compose exec php php artisan key:generate
	@docker-compose exec php php artisan migrate:install
	@docker-compose exec php php artisan migrate
	@docker-compose exec php php artisan db:seed --class=BoosterPackSeeder
	@docker-compose exec php npm i
	@docker-compose exec php npm run prod
	@docker-compose exec php php artisan ide-helper:generate

clean:
	make docker-stop
	docker-compose rm --force
	rm -rf ./storage/docker/data/mysql/*

docker-start:
	docker-compose up -d

docker-stop:
	docker-compose stop

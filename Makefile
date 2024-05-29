setup:
	@make build
	@make up
	@make composer-update
build:
	docker compose build
stop:
	docker compose stop
up:
	docker compose up -d
composer-update:
	docker exec  taic-reg-api bash -c "composer update"
data:
	docker exec  taic-reg-api bash -c "php artisan migrate:fresh --seed"
bash:
	docker exec -it  taic-reg-api bash
start:
	docker compose restart
boost:
	docker exec  taic-reg-api bash -c "php artisan optimize"
	docker exec  taic-reg-api bash -c "composer dump-autoload"
	docker exec  taic-reg-api bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  taic-reg-api bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
rmi:
	docker image rm -f taic-reg-api-taic-reg-api
logs:
	docker logs -f taic-reg-api
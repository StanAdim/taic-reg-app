setup:
	@make build
	@make up
	@make composer-update
	@yarn

build:
	docker compose build 
stop:
	docker compose stop
up:
	docker compose up -d
composer-update:
	docker exec  ems-stage-reg bash -c "composer update"
data:
	docker exec  ems-stage-reg bash -c "php artisan migrate:fresh --seed"
bash:
	docker exec -it  ems-stage-reg bash
start:
	docker compose restart
boost:
	docker exec  ems-stage-reg bash -c "php artisan optimize"
	docker exec  ems-stage-reg bash -c "composer dump-autoload"
	docker exec  ems-stage-reg bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  ems-stage-reg bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
rmi:
	docker image rm -f ems-stage-reg-ems-stage-reg
logs:
	docker logs -f ems-stage-reg
update: 
	 git pull && cd mgt-app &&  yarn ; yarn build && pm2 restart taic-reg-app &&  cd  ../ && make start
	 @boost
# Define the directory and the command
DIR1 := ./mgt-app 
DIR2 := ./site-app 
CMD := yarn && yarn build
CMD1 := pm2 start ecosystem.config.cjs


# Target to change to the specified directory and execute the command
yarn:
	@cd $(DIR1) && $(CMD) && $(CMD1)
	@cd $(DIR2) && $(CMD) && $(CMD1)
	@echo "Command executed in $(DIR1) and $(DIR2)"

#================
#=== Production
#================

setup.p:
	@make build-prod
	@make up-prod
	@make composer-update-prod
	@yarn

build.p:
	docker compose -f docker-compose.prod.yml build 
stop.p:
	docker compose -f docker-compose.prod.yml stop
up.p:
	docker compose -f docker-compose.prod.yml up -d
composer-update.p:
	docker exec  events-api bash -c "composer update"
data.p:
	docker exec  events-api bash -c "php artisan migrate:fresh --seed"
bash.p:
	docker exec -it  events-api bash
start.p:
	docker compose -f docker-compose.prod.yml restart
boost.p:
	docker exec  events-api bash -c "php artisan optimize"
	docker exec  events-api bash -c "composer dump-autoload"
	docker exec  events-api bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  events-api bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
rmi.p:
	docker image rm -f events-api-events-api
logs.p:
	docker logs -f events-api
update.p: 
	 git pull && cd mgt-app &&  yarn ; yarn build && pm2 restart taic-reg-app &&  cd  ../ && make start
	 @boost
# Define the directory and the command
DIR1 := ./mgt-app 
DIR2 := ./site-app 
CMD := yarn && yarn build
CMD1 := pm2 start ecosystem.config.cjs


# Target to change to the specified directory and execute the command
yarn.p:
	@cd $(DIR1) && $(CMD) && $(CMD1)
	@cd $(DIR2) && $(CMD) && $(CMD1)
	@echo "Command executed in $(DIR1) and $(DIR2)"

setup:
	@make build
	@make up
	@make composer-update
	# @yarn

build:
	docker compose build 

stop:
	docker compose stop
up:
	docker compose up -d

composer-update:
	docker exec  events-test bash -c "composer update"
data:
	docker exec  events-test bash -c "php artisan migrate:fresh --seed"
bash:
	docker exec -it  events-test bash
start:
	docker compose restart
	# cd  mgt-app/ && pm2 restart ecosystem.config.cjs
boost:
	docker exec  events-test bash -c "php artisan optimize"
	docker exec  events-test bash -c "composer dump-autoload"
	docker exec  events-test bash -c "php artisan key:generate"
	docker exec  events-test bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  events-test bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
rmi:
	docker image rm -f events-test-events-test
logs:
	docker logs -f events-test
update: 
	 git pull && cd mgt-app &&  yarn ; yarn build && pm2 restart ecosystem.config.cjs &&  cd  ../ && make start
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

setup.production:
	@make build.production
	@make up.production
	@make composer-update.production
	@yarn

build.production:
	docker compose -f docker-compose.productionrod.yml build 

stop.production:
	docker compose -f docker-compose.productionrod.yml stop

up.production:
	docker compose -f docker-compose.productionrod.yml up -d

composer-update.production:
	docker exec  events-app bash -c "composer update"

data.production:
	docker exec  events-app bash -c "php artisan migrate:fresh --seed"
bash.production:
	docker exec -it  events-app bash
start.production:
	docker compose -f docker-compose.productionrod.yml restart

boost.production:
	docker exec  events-app bash -c "php artisan optimize"
	docker exec  events-app bash -c "composer dump-autoload"
	docker exec  events-app bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  events-app bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
rmi.production:
	docker image rm -f events-app-events-app
logs.production:
	docker logs -f events-app
update.production: 
	 git pull && cd mgt-app &&  yarn ; yarn build && pm2 restart production.config.cjs &&  cd  ../ && make start

# Define the directory and the command
DIR1 := ./mgt-app 
DIR2 := ./site-app 
CMD := yarn && yarn build
CMD1 := pm2 start ecosystem.config.cjs


# Target to change to the specified directory and execute the command
yarn.production:
	@cd $(DIR1) && $(CMD) && $(CMD1)
	@cd $(DIR2) && $(CMD) && $(CMD1)
	@echo "Command executed in $(DIR1) and $(DIR2)"

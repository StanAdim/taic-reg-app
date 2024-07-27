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
	docker exec  events-finalized bash -c "composer update"
data:
	docker exec  events-finalized bash -c "php artisan migrate:fresh --seed"
bash:
	docker exec -it  events-finalized bash
start:
	docker compose restart
	cd  mgt-app/ && pm2 restart ecosystem.config.cjs
boost:
	docker exec  events-finalized bash -c "php artisan optimize"
	docker exec  events-finalized bash -c "composer dump-autoload"
	docker exec  events-finalized bash -c "php artisan key:generate"
	docker exec  events-finalized bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  events-finalized bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
rmi:
	docker image rm -f events-finalized-events-finalized
logs:
	docker logs -f events-finalized
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

setup.p:
	@make build.p
	@make up.p
	@make composer-update.p
	@yarn

build.p:
	docker compose -f docker-compose.prod.yml build 
	cd  mgt-app/ && yarn build

stop.p:
	docker compose -f docker-compose.prod.yml stop
	cd  mgt-app/ && pm2 stop ecosystem.config.cjs

up.p:
	docker compose -f docker-compose.prod.yml up -d
		cd  mgt-app/ && pm2 start ecosystem.config.cjs

composer-update.p:
	docker exec  events-app bash -c "composer update"
data.p:
	docker exec  events-app bash -c "php artisan migrate:fresh --seed"
bash.p:
	docker exec -it  events-app bash
start.p:
	docker compose -f docker-compose.prod.yml restart
	cd  mgt-app/ && pm2 restart ecosystem.config.cjs

boost.p:
	docker exec  events-app bash -c "php artisan optimize"
	docker exec  events-app bash -c "composer dump-autoload"
	docker exec  events-app bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  events-app bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
rmi.p:
	docker image rm -f events-app-events-app
logs.p:
	docker logs -f events-app
update.p: 
	 git pull && cd mgt-app &&  yarn ; yarn build && pm2 restart production.config.cjs &&  cd  ../ && make start

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

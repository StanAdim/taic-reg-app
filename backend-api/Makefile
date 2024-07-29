staging.setup:
	@make staging.build
	@make staging.up
	@make staging.composer-update
	# @yarn

staging.build:
	docker compose build 

staging.stop:
	docker compose stop
staging.up:
	docker compose up -d

staging.composer-update:
	docker exec  test-ems-api bash -c "composer update"
staging.data:
	docker exec  test-ems-api bash -c "php artisan migrate:fresh --seed"
staging.bash:
	docker exec -it  test-ems-api bash
staging.start:
	docker compose restart
staging.boost:
	docker exec  test-ems-api bash -c "php artisan optimize"
	docker exec  test-ems-api bash -c "composer dump-autoload"
	docker exec  test-ems-api bash -c "php artisan key:generate"
	docker exec  test-ems-api bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  test-ems-api bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
staging.rmi:
	docker image rm -f test-ems-api-test-ems-api
staging.logs:
	docker logs -f test-ems-api
staging.update: 
	 git pull && cd mgt-app &&  yarn ; yarn build && pm2 restart ecosystem.config.cjs &&  cd  ../ && make start
# Define the directory and the command
DIR1 := ../frontend-app 
DIR2 := ./site-app 
CMD := yarn && yarn build
CMD1 := pm2 start ecosystem.config.cjs


# Target to change to the specified directory and execute the command
staging.yarn:
	@cd $(DIR1) && $(CMD) && $(CMD1)
	@cd $(DIR2) && $(CMD) && $(CMD1)
	@echo "Command executed in $(DIR1) and $(DIR2)"

#================
#=== Production
#================

production.setup:
	@make production.build
	@make production.up
	@make production.composer-update
	@make production.boost
	@make production.yarn

production.reload:
	git pull origin production
	@make production.stop
	@make build.production
	@make production.up
	@make production.boost

production.build:
	docker compose -f docker-compose.prod.yml build 

production.stop:
	docker compose -f docker-compose.prod.yml stop

production.up:
	docker compose -f docker-compose.prod.yml up -d

production.composer-update:
	docker exec  events-app-api bash -c "composer update"

production.data:
	docker exec  events-app-api bash -c "php artisan migrate:fresh --seed"
	
production.bash:
	docker exec -it  events-app-api bash
production.start:
	docker compose -f docker-compose.prod.yml restart

production.boost:
	docker exec  events-app-api bash -c "php artisan optimize"
	docker exec  events-app-api bash -c "composer dump-autoload"
	docker exec  events-app-api bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  events-app-api bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
production.rmi:
	docker image rm -f events-app-api-events-app-api
production.logs:
	docker logs -f events-app-api
production.update: 
	 git pull && cd ../frontend-app &&  yarn ; yarn build && pm2 restart production.config.cjs &&  cd  ../backend-api && make start

# Define the directory and the command
DIR1 := ../frontend-app 
DIR2 := ./site-app 
CMD := yarn && yarn build
CMD1 := pm2 restart production.config.cjs


# Target to change to the specified directory and execute the command
production.yarn:
	@cd $(DIR1) && $(CMD) && $(CMD1)
	@echo "Command executed in $(DIR1)"

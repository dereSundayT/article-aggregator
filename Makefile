# Makefile

setup:
	./wait-for-it.sh db:3306 -- php artisan migrate:refresh --seed
	php artisan optimize:clear
	composer dump-autoload


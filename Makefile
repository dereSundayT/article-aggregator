# Makefile

setup:
	php artisan migrate:refresh --seed
	php artisan optimize:clear
	composer dump-autoload


start:
	php -S localhost:3000 public/index.php

test:
	./vendor/bin/phpunit tests
	# composer exec --verbose phpunit tests

make setup:
	composer install

# lint:
# 	composer run-script phpcs -- --standard=PSR12 app tests
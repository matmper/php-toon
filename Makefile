composer-install:
	composer install --dev --prefer-dist --no-progress --no-interaction

composer-update:
	composer update

composer-tests:
	composer tests

composer-check:
	composer check

composer-phpcbf:
	composer phpcbf

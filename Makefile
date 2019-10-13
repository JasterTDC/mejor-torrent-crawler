stan:
	./vendor/bin/phpstan analyze ./src -l 7
test:
	./vendor/bin/phpunit -c phpunit.xml --no-coverage
coverage:
	./vendor/bin/phpunit -c phpunit.xml

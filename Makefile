stan:
	./vendor/bin/phpstan analyze ./src -l 7
sniffer:
	./vendor/bin/phpcs --standard=PSR2 ./src ./tests
test:
	./vendor/bin/phpunit -c phpunit.xml --no-coverage
coverage:
	./vendor/bin/phpunit -c phpunit.xml
crawl:
	time php index_hex.php

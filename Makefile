stan:
	docker run --rm \
	--volume=${PWD}/code:/code \
	mejor-torrent-crawler_crawler:latest \
	php /code/vendor/bin/phpstan analyze /code/src -l 8
sniffer:
	docker run --rm \
    --volume=${PWD}/code:/code \
    mejor-torrent-crawler_crawler:latest \
	php /code/vendor/bin/phpcs --standard=PSR12 /code/src /code/tests
test:
	docker run --rm \
    --volume=${PWD}/code:/code \
    --network='crawler_network' \
    mejor-torrent-crawler_crawler:latest \
	php /code/vendor/bin/phpunit -c /code/phpunit.xml --no-coverage
coverage:
	docker run --rm \
    --volume=${PWD}/code:/code \
    --network='crawler_network' \
    mejor-torrent-crawler_crawler:latest \
	php /code/vendor/bin/phpunit -c /code/phpunit.xml
command:
	docker run --rm \
    --volume=${PWD}/code:/code \
    --volume=${PWD}/scrap-json:/scrap/json:rw \
    --volume=${PWD}/scrap-torrent:/scrap/torrent:rw \
    mejor-torrent-crawler_crawler:latest \
	time php /code/public/index_hex_crawler.php ${page}
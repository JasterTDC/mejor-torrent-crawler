FROM "richarvey/nginx-php-fpm"

WORKDIR /code

ADD script/commandExecute.sh /crawler/command/execute.sh

RUN docker-php-ext-enable xdebug

RUN chmod +x /crawler/command/execute.sh

ADD ./conf/crawler.conf /etc/nginx/sites-available/crawler.conf
ADD ./conf/crawler-static.conf /etc/nginx/sites-available/crawler-static.conf
ADD ./passwd/.htpasswd /etc/general/.htpasswd

RUN mkdir /srv/www/
RUN mkdir /LOGS/

RUN mv /usr/local/etc/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf.back
ADD ./conf/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN ln -s /etc/nginx/sites-available/crawler.conf /etc/nginx/sites-enabled/crawler.conf
RUN ln -s /etc/nginx/sites-available/crawler-static.conf /etc/nginx/sites-enabled/crawler-static.conf
RUN rm /etc/nginx/sites-enabled/default.conf

CMD ["/start.sh"]

FROM "richarvey/nginx-php-fpm"

ADD script/commandExecute.sh /crawler/command/execute.sh

RUN chmod +x /crawler/command/execute.sh

CMD ["/start.sh"]

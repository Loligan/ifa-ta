FROM ifata_php7:latest

RUN apt-get install -y supervisor

## Set TZ
RUN cat /usr/share/zoneinfo/Europe/Moscow > /etc/localtime

COPY ./supervisord.conf /etc/supervisord.conf

WORKDIR /var/www

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
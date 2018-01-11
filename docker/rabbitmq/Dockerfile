FROM rabbitmq:latest

## Set TZ
RUN cat /usr/share/zoneinfo/Europe/Moscow > /etc/localtime

RUN rabbitmq-plugins enable --offline rabbitmq_management

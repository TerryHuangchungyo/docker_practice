FROM ubuntu:18.04

COPY ./src /data
WORKDIR /data
RUN chmod +x init.sh

RUN apt update -y && apt upgrade -y && apt dist-upgrade -y
RUN apt-get install -yqq inetutils-ping
RUN apt-get install -y vim
RUN apt-get install -y apache2
RUN ln -fs /usr/share/zoneinfo/Asia/Taipei /etc/localtime
RUN apt-get install -y tzdata
RUN dpkg-reconfigure --frontend noninteractive tzdata
RUN apt-get install -y php php-mysql libapache2-mod-php

WORKDIR /var/www/html
CMD ["/data/init.sh"]
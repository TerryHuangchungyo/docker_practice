FROM httpd:2.4
RUN apt update -y && apt upgrade -y && apt dist-upgrade -y
RUN apt-get install -y apache2 php libapache2-mod-php php-mysql
RUN service apache2 restart
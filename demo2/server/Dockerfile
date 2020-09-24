# 以ubuntu:18.04做為基底
FROM ubuntu:18.04

# 將src目錄底下的東西複製到容器的/data底下
COPY ./src /data

# 將工作目錄設在/data
WORKDIR /data

# 將shell script檔案權限改成可執行
RUN chmod +x init.sh

# 更新套件清單
RUN apt update -y && apt upgrade -y && apt dist-upgrade -y
# 安裝ping指令
RUN apt-get install -yqq inetutils-ping
# 安裝vim編輯器
RUN apt-get install -y vim
# 安裝Apache伺服器
RUN apt-get install -y apache2

# 時區設定
RUN ln -fs /usr/share/zoneinfo/Asia/Taipei /etc/localtime
RUN apt-get install -y tzdata

# 安裝套件時如果詢問時區設定自動套用
RUN dpkg-reconfigure --frontend noninteractive tzdata

# 安裝php
RUN apt-get install -y php php-mysql libapache2-mod-php

# 轉移容器工作目錄
WORKDIR /var/www/html

# 啟動容器後執行/data/init.sh腳本
CMD ["/data/init.sh"]
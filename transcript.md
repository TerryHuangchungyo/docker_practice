# 容器化技術與版本控制

## 虛擬化是什麼
這句話你去問不同背景的人可能會有不同的答案。

問編譯器背景的人他們可能會說JVM(Java virtual machine)、LLVM(Low level virtual machine)、V8 Engine.....  
問作業系統背景的人他們可能會說是一種在作業系統模擬出硬體環境運行另一套作業系統的技術，像是VM ware、Virtual Box、Hypervisor.....  
問網頁開發背景的人他們可能會說容器化技術，像是Docker、LXC(Linux Containers)  

所以虛擬化到底是什麼？  
虛擬化技術就是一種模擬出虛擬環境供目標實體(程式語言、作業系統、應用程式)運行的技術。  
目的就是為了解決不同環境下也可以運行目標實體

## Docker介紹
Docker是一種幫你管理容器的工具，他可以將應用程式所需的環境打包，建立資源管控機制隔離各個容器，分配容器有效使用實體機器上作業系統的資源。
透過容器，應用程式不需要再另外安裝作業系統（Guest OS）也可以執行。

## Docker三元素
映象檔、容器、倉庫

映像檔 Image
Docker 映像檔是一個模板，紀錄容器的設定，用來重複產生容器實體。例如：一個映像檔裡可以包含一個完整的 MySQL 服務、一個 Golang 的編譯環境、或是一個 Ubuntu 作業系統。透過 Docker 映像檔，我們可以快速的產生可以執行應用程式的容器。而 Docker 映像檔可以透過撰寫由命令行構成的 Dockerfile 輕鬆建立，或甚至可以從公開的地方下載已經做好的映像檔來使用，也可以由當前的容器製作。

容器 Container
就像是用蛋糕模具烤出來的蛋糕本體，容器是用映像檔建立出來的執行實例。它可以被啟動、開始、停止、刪除。每個容器都是相互隔離、保證安全的平台。
可以把容器看做是一個執行的應用程式加上執行它的簡易版 Linux 環境（包括 root 使用者權限、程式空間、使用者空間和網路空間等）。
另外要注意的是，Docker 映像檔是唯讀（read-only）的，而容器在啟動的時候會建立一層可以被修改的可寫層作為最上層，讓容器的功能可以再擴充。

## 倉庫 Repository
倉庫（Repository）是集中存放映像檔檔案的場所，也可以想像成存放蛋糕模具的大本營。倉庫註冊伺服器（Registry）上則存放著多個倉庫。
最大的公開倉庫註冊伺服器是上面提到過的 Docker Hub，存放了數量龐大的映像檔供使用者下載，我們可以輕鬆在上面找到各式各樣現成實用的映像檔。
而 Docker 倉庫註冊伺服器的概念就跟 Github 類似，你可以在上面建立多個倉庫，然後透過 push、pull 的方式上傳、存取。

## Docker的工作流程

## 簡易實作
demo 1 在容器中架設簡易apache伺服器環境
git clone demo_1
cd demo_1
docker build -t my-docker1 .
docker images 觀察映象檔
docker run -dit --name my-running-docker1 -p 3000:80 my-docker1
docker ps -a 觀察運行中得容器
docker stop my-running-docker1 終止運行中的容器
docker rm my-runnin-docker1 刪除容器
docker rmi my-docker1 刪除映象檔

demo 2 在容器中架設LAMP環境
docker pull mysql 5.7.31

- 容器堆疊

- 指令
查看docker版本
docker --version

# 建立映象檔
從網路上取得映象檔
docker pull <domain>:<port>/<image tag>

列出docker映象檔
docker images

查詢被修改的Container
docker ps -l

提交被修改的Container成為映象檔
docker commit -m "<message>" -a "<auther name>" <container id> <repository name>/<tag>

關掉Container
docker stop <contatiner id>

Docker容器設定檔: Dockerfile

FROM: 指令告訴 Docker 使用哪個映像檔作為基底
MAINTAINER: 維護者的信息
RUN:  
忽略不想要的檔案: .dockerignore

打包成映像黨
docker build . -t <repository>:<tag>
*注意一個映像檔不能超過 127 層

匯出:
docker image save --output=myapp.tar myapp
匯入:
docker import myapp.tar myapp:imported

執行成Container
docker run -p <host port>:<container port> -i -t <images id>|<repository>:<tag>
-t 在容器中建立了一個終端機
-i 建立與容器標準輸入（STDIN）的互動連結

e.g.:
docker run -t -i ubuntu:12.04 /bin/bash (找不到映象檔的話會直接從網路上pull)

查詢執行中的Container
docker ps

- Docker-compose
- laradock實作

列出所有的容器 ID
docker ps -aq

停止所有的容器
docker stop $(docker ps -aq)

删除所有的容器
docker rm $(docker ps -aq)
## 什麼是Docker-compose


啟動所有的 Docker Container 指令
docker-compose up -d
用 Docker-Compose 提供的指令查看 Docker Container 的執行狀態
docker-compose ps
如果要看執行的 log 可以使用以下的指令
docker-compose logs
如果要停止 docker-compose 執行的所有 Container 可以使用以下的指令
docker-compose stop
如果要刪除 docker-compose 的所有 Container 可以使用以下的指令
docker-compose rm
## git版本控制系統

## 參考資料
https://medium.com/unorthodox-paranoid/docker-tutorial-101-c3808b899ac6
https://philipzheng.gitbook.io/docker_practice/
https://www.itread01.com/xxell.html
https://blog.techbridge.cc/2018/09/07/docker-compose-tutorial-intro/
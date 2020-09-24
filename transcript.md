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
Git 的出現，來自於 Linux 之父 "Linus Torvalds" 開發 Linux kernel 的時候，因為早期的版本控制方法非常沒有效率，屬集中式控管，當 Linux kernel 這類複雜又龐大的專案在進行版本控管時，出現了許多問題，特別是效能不佳。最早期 Linux kernel 採用 BitKeeper 進行版本控管，但後來 Linus Torvalds 基於 BitKeeper 與 Monotone 的使用經驗，設計出更棒的 Git 版控系統。原先 Git 只被設計成一個低階的版控工具，用來當做其他版控系統(SCM)的操作工具，後來才漸漸演變成一套完整的版本控制系統

有趣的是，Linus Torvalds 改採 Git 進行版本控管初期，由於 Git 太過複雜，許多版控觀念跟以往差異太大，也受到世界各地開放原始碼社群的反對，但經過幾年的努力與發展，操作 Git 的相關工具也越來越成熟，才漸漸平撫反對的壓力，從 2013 年的市場調查看來，全世界已有 30% 的開放原始碼專案改採 Git 進行版本控管，這是個非常驚人的市占率，意謂著 Git 絕對有其驚豔之處，不好好研究一番還不行呢！

### 集中化的版本控制系統
接下來人們又遇到了重大問題，就是如何和其他電腦上的開發者協同合作？ 為了解決這個問題，於是集中化的版本控制系統應運而生。 這類系統（如：CVS、Subversion 和 Perforce），都有一個伺服器來管理所有版本的檔案，而許多用戶端會連到這台伺服器取出檔案來使用。 多年以來，這儼然成為版本控制系統的標準做法。

相對於本機版本控制系統，這種做法帶來了許多好處。 舉例來說，每個人都可以一定程度的知道專案中的其他人正在做些什麼。 管理員也可以輕鬆掌控每個開發者的權限；而且比每個用戶端只用本機的版本控制系統好管理很多。

然而，集中化的版本控制系統也有一些嚴重的缺點。 最嚴重的當然是中央伺服器如果發生故障的時候。 如果當機一小時，那麼這個小時之中，沒有人可以提交更新，也就無法協同合作。 如果中心版本庫的硬碟發生損壞，又沒有做適當的備份，那麼你就絕對會遺失所有資料——包括專案的全部變更歷史，只會剩下用戶端各自機器上保留的單獨快照。 本機版本控制系統也存在類似的問題——只要你的專案歷史都放在同一個地方，就有遺失所有資料的風險。
### 分散式的版本控制系統
於是分散式版本控制系統（Distributed Version Control Systems，簡稱 DVCSs）就此登上舞台。 在 DVCS 系統（如 Git、Mercurial、Bazaar 和 Darcs）中，用戶端並不只取出最新的檔案快照；還把整個倉儲做個鏡像。 假設有任何一個協同合作的伺服器故障，事後都可以用任何一個用戶端的鏡像來還原。 因為每個地方都有完整的資料備份。

除此之外，許多這類的系統都可以很好的和許多遠端倉儲互動，所以你可以和不同群組的人使用不同的方式，在同一個專案內協同合作。 你可以根據需要設定許多工作流程（如：階層式模型），這是在集中式的版本控制系統中是無法實現的。

由於每個人都有一份儲存庫，所以在分散式系統中處理分支與合併是很常見的事。

### Git的特點
* 快速

* 簡潔的設計

* 完整支援非線性的開發（上千個同時進行的分支）
Git 擁有快速的分支與合併機制，還包括圖形化的工具顯示版本變更的歷史路徑。
Git 非常強調分支與合併，所以版本控管的過程中，你會不斷的在執行分支與合併動作。
Git 的分支機制非常輕量，沒有負擔，每一次的分支只是某個 commit 的參考指標而已。

* 完全的分散式系統
參與 Git 開發的每個人，都將擁有完整的開發歷史紀錄。
當開發人員第一次將 Git 版本庫複製(clone)下來後，完全等同於這份 Git 版本庫的「完整備份」。
整個版本庫中所有變更過的檔案與歷史紀錄，通通都會儲存在本機儲存庫(local repository)。

* 有效率的處理大型專案
由於完整的版本庫會複製(clone)一份在本機，該版本庫包含完整的檔案與版本變更紀錄，所以針對版本控管中的各種檔案操作速度，將會比直接從遠端存取來的快上百倍之多。
這也代表著，Git 版本控管不會因為專案越來越大、檔案越來越多，而導致速度變慢。
## 參考資料
https://medium.com/unorthodox-paranoid/docker-tutorial-101-c3808b899ac6
https://philipzheng.gitbook.io/docker_practice/
https://www.itread01.com/xxell.html
https://blog.techbridge.cc/2018/09/07/docker-compose-tutorial-intro/
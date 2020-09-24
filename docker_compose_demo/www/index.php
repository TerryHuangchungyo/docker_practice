<?php
    //因為使用了links，所以在apache這個容器中可以直接用"mysql"字元連線資料庫，
    //使用links後其實就是在apache這個容器的hosts檔案中添加了"mymysql"字元到mysql容器的ip的對映
    $link = mysql_connect("mysql", "root", "root");
    if(!$link)
        die('Could not connect: ' . mysql_error());
    else
        echo "Successfully connect to the mysql.";
    mysql_close($link);
?>

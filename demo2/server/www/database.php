<?php
    $link = mysqli_connect("db", "root", "root");
    if(!$link)
        die('連接失敗' . mysqli_error());
    else
        echo "成功連上了我好興奮啊!!";
    mysqli_close($link);
?>
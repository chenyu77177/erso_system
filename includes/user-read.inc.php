<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/user.classes.php";
        include "../classes/user-contr.classes.php";

    }
    //取得使用者資料
    if(isset($_POST["getUser"])){

        $prod = new UserContr();

        echo $prod->getUser();
    }else{
        echo "get_error";
    }
?>
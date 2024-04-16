<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/user.classes.php";
        include "../classes/user-contr.classes.php";

    }
    //更新使用者身分
    if(isset($_POST["updateUserPermission"])){
        //取得資料
        $user_id = $_POST["user_id"];
        $permission = $_POST["permission"];

        $prod = new UserContr();

        echo $prod->updatePermission($user_id, $permission);
    }else{
        echo "get_error";
    }
?>
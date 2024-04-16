<?php
    session_start();
    if(isset($_SESSION["useremail"])){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            //取得資料
            $email = $_SESSION["useremail"];
            $newName = $_POST["name"];
        
            //實例化類別
            include "../classes/dbh.classes.php";
            include "../classes/personal-Info.classes.php";
            include "../classes/personal-Info-contr.classes.php";
            $info = new PersonalInfoContr($email);
        
            //執行 錯誤處理程序 和 使用者註冊
            $info->updateInfo($newName);
            
            //回首頁
            header("location:personal-Info.inc.php");
        }
        
    
    }
?>
<?php
    session_start();
    if(isset($_SESSION["useremail"])){
    
        //取得資料
        $email = $_SESSION["useremail"];
    
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/personal-Info.classes.php";
        include "../classes/personal-Info-contr.classes.php";
        $info = new PersonalInfoContr($email);
    
        //執行 錯誤處理程序 和 使用者註冊
        $info->personalInfo();
        
        //回首頁
        header("location: ../personal-Info.php?error=none");
    
    }
?>
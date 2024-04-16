<?php
    session_start();

    if(isset($_GET["email"]) && isset($_GET["key"])){
        //取得資料
        //$email = $_SESSION["useremail"];
        $email = $_GET["email"];
        $key = $_GET["key"];
    
        //實例化 EmailVerifyContr 類別
        include "../classes/dbh.classes.php";
        include "../classes/verify.classes.php";
        include "../classes/verify-contr.classes.php";
        $verify = new EmailVerifyContr($email);
    

        //執行 錯誤處理程序 和 使用者註冊
        //$verify->sendLetter("4A890103@stust.edu.tw");
        $msg = $verify->setVerifyState($email, $key);
        $_SESSION["verifyMSG"] = $msg;
        //phpinfo();
        
        //回首頁
        header("location: ../email-verify.php?email=" . $email . "&key=" . $key . "&msg=" . $msg);
    }else if(isset($_POST["resendEmail"])){
        //取得資料
        $email = $_POST["resendEmail"];
    
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/verify.classes.php";
        include "../classes/verify-contr.classes.php";
        $verify = new EmailVerifyContr($email);
    
        //執行 錯誤處理程序 和 使用者註冊
        $result = $verify->resendEmail($email);
        $_SESSION["system_msg"] = $result;
        
        //回首頁
        header("location: ../email-verify.php?email=" . $email);

    }else if($_SERVER["REQUEST_METHOD"] == "POST"){
        //取得資料
        //$email = $_SESSION["useremail"];
        $email = $_POST["email"];
        $key = $_POST["key"];
    
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/verify.classes.php";
        include "../classes/verify-contr.classes.php";
        $verify = new EmailVerifyContr($email);
    

        //執行 錯誤處理程序 和 使用者註冊
        //$verify->sendLetter("4A890103@stust.edu.tw");
        $msg = $verify->setVerifyState($email, $key);
        $_SESSION["verifyMSG"] = $msg;
        //phpinfo();
        
        //回首頁
        header("location: ../email-verify.php?email=" . $email . "&key=" . $key . "&msg=" . $msg);
    }
?>
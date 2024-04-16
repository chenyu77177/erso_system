<?php
session_start();
if(isset($_POST["submit"])){

    //取得資料
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    //實例化 LoginContr 類別
    include "../classes/dbh.classes.php";
    include "../classes/login.classes.php";
    include "../classes/login-contr.classes.php";
    //實例化 verifyContr 類別
    include "../classes/verify.classes.php";
    include "../classes/verify-contr.classes.php";

    $login = new LoginContr($email, $pwd);

    //執行 錯誤處理程序 和 使用者註冊
    $verify = new EmailVerifyContr($email);
    $result = $verify->getVerifyState();
    if($result[0]["verify_state"] == "0"){
        $_SESSION["system_msg"] = "您的電子信箱尚未驗證，請進行驗證";
        header("location: ../email-verify.php?email=" . $email);
        exit();
    }else{
        $login->loginUser();
    }

    //回首頁
    header("location: ../index.php?error=none");
    exit();
}
?>
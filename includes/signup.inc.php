<?php

if(isset($_POST["submit"])){

    //取得資料
    $name= $_POST["name"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];

    //實例化類別
    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup-contr.classes.php";
    $signup = new SignupContr($name, $email, $pwd, $pwdrepeat);

    //執行 錯誤處理程序 和 使用者註冊
    $signup->signupUser();

    //實例化 EmailVerifyContr 類別
    include "../classes/verify.classes.php";
    include "../classes/verify-contr.classes.php";
    $verify = new EmailVerifyContr($email);

    //執行 錯誤處理程序 和 設定驗證資料
    $verify->setVerifyKey();
    $verify->sendEmail($email);

    //回首頁
    header("location: ../signup-thankyou.php?error=none");

}

?>
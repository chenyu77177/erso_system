<?php
session_start();

?>

<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/bootstrap.bundle.min.js"></script>
      <title>註冊感謝信 - erso租借交易平台</title>
    </head>
    <body>
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-3"></div>
                <div class="col-6 p-5 shadow-sm bg-body rounded border">
                    <h3 >感謝您的註冊</h3>
                    <br>
                    <p>系統已將驗證信件寄至您所填寫的信箱，麻煩再進行驗證動作，謝謝!</p>
                    <br>
                    <div class="d-grid gap-2 py-1">
                        <a class="btn btn-primary" href="email-verify.php">進行信箱驗證</a>
                    </div>
                    <div class="d-grid gap-2 py-1">
                        <a class="btn btn-secondary" href="login.php">登入</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
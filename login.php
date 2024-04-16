<?php
session_start();
if(isset($_SESSION["userid"])){
    header("Location: index.php");
    exit();
}
//系統訊息顯示
if(isset($_SESSION["system_msg"])){
    $msg = $_SESSION["system_msg"];
    echo "<script>alert('" . $msg . "');</script>";
    unset($_SESSION["system_msg"]);
}
?>

<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/bootstrap.bundle.min.js"></script>
      <title>登入 - erso租借交易平台</title>
      <link rel="icon" href="assets/img/erso_icon_72.ico" type="image/x-icon">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row align-items-center min-vh-100">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <img src="./assets/img/erso_logo.png" class="w-25">
                            <h4 class="my-4" ><strong></strong></h4>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-5">
                            <form action="includes/login.inc.php" method="POST">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingEmail" name="email" placeholder="電子信箱" required>
                                    <label for="floatingEmail">電子信箱</label>
                                </div>
                                <br>
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="floatingPwd" name="pwd" placeholder="密碼" required>
                                    <label for="floatingPwd">密碼</label>
                                </div>
                                <br>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary" name="submit">登入</button>
                                </div>
                                <br>
                            </form>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <p class="text-center">沒有帳號? <a href="signup.php">開始註冊</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
    </body>
</html>
<?php 
session_start();
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
      <title>註冊 - erso租借交易平台</title>
    </head>
    <body>
        <div style="height: 100px;"></div>
        <div class="container align-items-center">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h4 >註冊</h4>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-5">
                    <form action="includes/signup.inc.php" method="POST">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingName" name="name" placeholder="姓名" required>
                            <label for="floatingName">姓名</label>
                        </div>
                        <br>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingEmail" name="email" placeholder="使用者名稱" required>
                            <label for="floatingEmail">電子信箱</label>
                        </div>
                        <br>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPwd" name="pwd" placeholder="密碼" required>
                            <label for="floatingPwd">密碼</label>
                        </div>
                        <br>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPwdRepeat" name="pwdrepeat" placeholder="密碼" required>
                            <label for="floatingPwdRepeat">重覆密碼</label>
                        </div>
                        <br>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" name="submit">註冊</button>
                        </div>
                        <br>
                    </form>
                </div>
                <div class="row justify-content-center">
                <div class="col-3">
                    <p class="text-center">已有帳號? <a href="login.php">登入</a></p>
                </div>
            </div>
            </div>
        </div>
    </body>
</html>
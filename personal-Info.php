<?php
session_start();
// if(!isset($_SESSION["userid"])){
//     header("Location: login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/bootstrap.bundle.min.js"></script>
      <title>個人資料 - erso租借交易平台</title>
    </head>
    <body>
        <?php 
            include("header.php");
        ?>
        <section>
            <div class="container my-3">
                <div class="row">
                    <div class="col-3">
                        <div class="shadow-sm p-3 mb-5 bg-body rounded border">
                            <p class="border_btm">功能列</p>
                            <?php 
                                include("function-bar.php");
                            ?>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="shadow-sm p-5 mb-5 bg-body rounded border">
                            <h4>個人資料</h4>
                            <hr>
                            <?php 
                                // if(isset($_SESSION["username"]) && isset($_SESSION["useremail"])){
                                //     echo $_SESSION["username"] . "<br>" . $_SESSION["useremail"];
                                // }else{
                                //     echo "123";
                                // }
                            ?>
                            <form action="includes/personal-UpdateInfo.inc.php" method="POST">
                                <div class="row my-3 align-items-center">
                                    <div class="col-2">
                                        <p>姓名</p>
                                    </div>
                                    <div class="col-5">
                                        <input type="text" class="form-control" name="name" value="<?php if(isset($_SESSION["username"])){echo $_SESSION["username"];}else{echo "";} ?>">
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-2">
                                        <p>電子信箱</p>
                                    </div>
                                    <div class="col-5">
                                        <input type="text" class="form-control" value="<?php if(isset($_SESSION["useremail"])){echo $_SESSION["useremail"];}else{echo "";} ?>" disabled>
                                    </div>
                                    <div class="col-1">
                                        <!-- <p>變更</p> -->
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-2">
                                        <button class="btn btn-danger" type="submit">儲存</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>

    </body>
</html>
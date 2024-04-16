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
    </head>
    <body>
        <?php 
            include("header.php");
        ?>
        <section>
            <div class="container my-3">
                <div class="row">
                    <div class="col-3">
                        <div class="bg1">
                            <p class="border_btm">功能列</p>
                            <ul>
                                <li><a href="includes/personal-Info.inc.php">個人資料</a></li>
                                <li><a href="">個人資料</a></li>
                                <li><a href="">個人資料</a></li>
                                <li><a href="">個人資料</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="bg1">
                            123
                        </div>
                    </div>
                </div>
                
            </div>
        </section>

    </body>
</html>
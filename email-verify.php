<?php
session_start();

//判斷連結是否有帶入資料
if(isset($_GET["email"]) && isset($_GET["key"]) && !isset($_GET["msg"])){
    header('location: includes/verify.inc.php?email=' . $_GET["email"] . '&key=' . $_GET["key"]);
}

// if(!isset($_SESSION["useremail"])){
//     header("location: login.php");
//     exit();
// }

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
      <title>信箱認證 - erso租借交易平台</title>
    </head>
    <body>
        <div style="height: 150px;"></div>
            <div class="container align-items-center">
                <?php
                if(!isset($_SESSION["verifyMSG"])){
                ?>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <h4 >信箱驗證</h4><br>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5">
                        <form action="includes/verify.inc.php" method="POST">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" id="floatingKey" name="email" placeholder="電子信箱" value="<?php if(isset($_GET["email"])){echo $_GET["email"];} ?>" required>
                                <label for="floatingKey">電子郵件</label>
                            </div>
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" id="floatingKey" name="key" placeholder="驗證碼" required>
                                <label for="floatingKey">驗證碼</label>
                            </div>
                            <br>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" name="submit">驗證</button>
                            </div>
                            <br>
                        </form>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3 text-center">
                            <p class="text-center d-inline mx-2"><a href="index.php">回首頁</a></p>
                            <p class="text-center d-inline mx-2"><a class="text-link" data-bs-toggle="modal" data-bs-target="#staticBackdrop">重寄驗證碼</a></p>
                        </div>
                    </div>
                <?php
                }else{
                ?>
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <?php
                            if(strpos($_SESSION["verifyMSG"],"成功")){
                            ?>
                                <svg class="bi text-success" width="32" height="32" fill="currentColor">
                                    <use xlink:href="assets/icons/bootstrap-icons.svg#check-circle"/>
                                </svg>
                            <?php
                            }else if(strpos($_SESSION["verifyMSG"],"失敗")){
                            ?>
                                <svg class="bi text-danger" width="32" height="32" fill="currentColor">
                                    <use xlink:href="assets/icons/bootstrap-icons.svg#x-circle"/>
                                </svg>
                            <?php
                            }else{
                            ?>
                                <svg class="bi text-primary" width="32" height="32" fill="currentColor">
                                    <use xlink:href="assets/icons/bootstrap-icons.svg#info-circle"/>
                                </svg>
                            <?php
                            }
                            ?>
                            <br><br>
                            <h4 > <?php echo $_SESSION["verifyMSG"] ?></h4><br>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <div class="d-grid gap-2">
                                <a class="btn btn-primary" href="email-verify.php">重新驗證</a>
                            </div>
                            <br>
                            <div class="d-grid gap-2">
                                <a class="btn btn-secondary" href="index.php">回首頁</a>
                            </div>
                        </div>
                    </div>
                <?php
                    unset($_SESSION["verifyMSG"]);
                }
                ?>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">重新寄送驗證信件</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <form action="includes/verify.inc.php" method="POST">
                        <div class="modal-body">
                                <input type="text" class="form-control text-center" id="resendEmail" name="resendEmail" placeholder="請輸入電子郵件" value="<?php if(isset($_GET["email"])){echo $_GET["email"];} ?>" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="resendLetterBtn" name="resendLetter" class="btn btn-secondary" onclick="resendEmailLoading();">重新寄送</button>
                            <div id="loading"></div>
                        </div>
                    </form>
                </div>
                
            </div>
            </div>
        </div>
    </body>
</html>
<script>
    function resendEmailLoading(){
        let loading_tag = document.getElementById("loading");
        let loading_list = '<div class="spinner-border text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>';
        loading_tag.innerHTML = loading_list;
    }
</script>
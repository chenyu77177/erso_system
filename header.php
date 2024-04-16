<?php

if(!isset($_SESSION["useremail"])){
    //設定登入後跳轉網址
    $_SESSION["nextUrl"] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit();
}

if(isset($_SESSION["nextUrl"])){
    $url = $_SESSION["nextUrl"];
    unset($_SESSION["nextUrl"]);
    header("Location: " . $url);
    exit();
}

//系統訊息顯示
if(isset($_SESSION["system_msg"])){
    $msg = $_SESSION["system_msg"];
    echo "<script>alert('" . $msg . "');</script>";
    unset($_SESSION["system_msg"]);
}
//echo "導入成功";
?>
<script>
    //讀取購物車數量
    function cart_quantity(){
        let fdata = new FormData();
        fdata.append('submit',"quantity");
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fetch('includes/read_cart.inc.php',
        {
            method: 'post',
            body: fdata
        })
        .then(function(response) {
        return response.text();
        })
        .then(function(data) {
            console.log("購物車商品數量：" + data);
            let cart_quantity_tag = document.getElementById("cart_quantity");
            cart_quantity_tag.innerText = data;
        });
    }
    cart_quantity();
</script>
<header>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" data-bs-toggle="offcanvas" href="#offcanvas" role="button" aria-controls="offcanvasExample">
            <svg class="bi text-muted" width="32" height="32" fill="currentColor">
                <use xlink:href="assets/icons/bootstrap-icons.svg#list"/>
            </svg>
            </a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
            <!-- <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">首頁</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">熱門商品</a>
                </li>
            </ul> -->
            <ul class="navbar-nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php"><img src="assets/img/erso_logo_2.png" style="height: 70px;"></a>
                </li>
            </ul>
            <ul class="navbar-nav d-flex">
                <?php
                    if(isset($_SESSION["userid"])){
                ?>
                <li class="nav-item">
                    <a class="nav-link d-inline" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <svg class="bi text-muted" width="32" height="32" fill="currentColor">
                            <use xlink:href="assets/icons/bootstrap-icons.svg#search"/>
                        </svg>
                    </a>
                    <a class="nav-link d-inline" href="includes/personal-Info.inc.php">
                        <svg class="bi text-muted" width="32" height="32" fill="currentColor">
                            <use xlink:href="assets/icons/bootstrap-icons.svg#person-fill"/>
                        </svg>
                    </a>
                    <a class="nav-link d-inline" href="my-cart.php">
                        <div class="d-inline" style="position: relative;">
                            <span class="w-100 h-100 pt-2 text-center align-items-center link-secondary user-select-none" id="cart_quantity" style="position: absolute;"><?php if(isset($_SESSION["cart_quantity"])){echo $_SESSION["cart_quantity"];}else{echo "0";} ?></span>
                            <svg class="bi text-muted" width="32" height="32" fill="currentColor">
                                <use xlink:href="assets/icons/bootstrap-icons.svg#bag"/>
                            </svg>
                        </div>
                        
                    </a>
                    
                </li>
                <!-- <li class="nav-item"><a class="nav-link" href="includes/personal-Info.inc.php"><?php //echo $_SESSION["username"] ?></a></li> -->
                <!-- <li class="nav-item"><a class="nav-link" href="includes/logout.inc.php">登出</a></li> -->
                <?php
                    } else {
                ?>
                <li class="nav-item"><a class="nav-link" href="signup.php">註冊</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">登入</a></li>
                <?php
                    }
                ?>
            </ul>
            <!-- </div> -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
                <div class="offcanvas-header justify-content-center" style="background-color: #C1DBDE;">
                    <h5 class="offcanvas-title" id="offcanvasLabel"><img src="assets/img/erso_logo_2.png" style="width: 200px;"></h5>
                    <!-- <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button> -->
                </div>
                <div class="offcanvas-body">
                    <p>您的身分：<?php if(isset($_SESSION["permission"])){echo $_SESSION["permission"];}else{echo "";} ?></p>
                    <?php 
                        if(isset($_SESSION["permission"])){
                            if($_SESSION["permission"] == "webmaster"){
                                echo '<a class="btn btn-primary w-100 mb-2" href="user-show.php" >後端管理</a>';
                            }
                            if($_SESSION["permission"] == "admin"){
                                echo '<a class="btn btn-primary w-100 mb-2" href="user-update.php" >後端管理</a>';
                            }
                        }
                    ?>
                    <a class="btn btn-secondary w-100 align-item-end" href="includes/logout.inc.php">登出</a>
                </div>
            </div>
            <!-- 購物車 -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCar" aria-labelledby="offcanvasLabel">
                <div class="offcanvas-header justify-content-center" style="background-color: #C1DBDE;">
                    <h5 class="offcanvas-title" id="offcanvasLabel"><img src="assets/img/erso_logo_2.png" style="width: 200px;"></h5>
                    <!-- <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button> -->
                </div>
                <div class="offcanvas-body">
                    <?php
                        include("./includes/shopping_cart.inc.php");
                    ?>
                    <a href="includes/logout.inc.php">登出</a>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">搜尋</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <form action="includes/product-search.inc.php" method="POST">
                        <div class="modal-body">
                                <input type="text" class="form-control text-center" id="keyword" name="keyword" placeholder="請輸入商品名稱" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="search" class="btn btn-secondary">搜尋</button>
                        </div>
                    </form>
                </div>
                
            </div>
            </div>
        </div>
    </nav>
</header>

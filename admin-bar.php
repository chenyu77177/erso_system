<h5><?php if($_SESSION["permission"] == "admin"){echo "系統管理員"; }else{echo "網站管理員"; } ?></h5>
<ul>
    <li><a href="<?php if($_SESSION["permission"] == "admin"){echo "user-update.php"; }else{echo "user-show.php"; } ?>">使用者管理</a></li>
    <!-- <li><a href="delivery-update.php">配送資訊管理</a></li>
    <li><a href="payment-update.php">支付方式管理</a></li>
    <li><a href="trade-state-update.php">交易狀態管理</a></li> -->
    <li><a href="banner-update.php">首頁橫幅管理</a></li>
</ul>
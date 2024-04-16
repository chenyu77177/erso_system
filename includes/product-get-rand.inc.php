<?php
    session_start();
    //echo $_SESSION["productId"];
    if(isset($_POST["quantity"])){
        //取得資料
        $quantity = $_POST["quantity"];
    
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/product.classes.php";
        include "../classes/product-contr.classes.php";

        $prod = new ProductContr(null, null);

        //到資料庫搜索程式找資料
        $result = $prod->getRandProductAll($quantity);
        
        //回首頁
        echo $result;
        //die($_SESSION["productId"]);
    
    }
    else{
        echo "session_not";
    }
?>
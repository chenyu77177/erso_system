<?php
    session_start();
    //echo $_SESSION["productId"];
    if(isset($_POST["productId"])){
        //取得資料
        $productId = $_POST["productId"];
        $salesCategory = $_POST["salesCategory"];
        //unset($_SESSION["productId"]);
    
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/product.classes.php";
        include "../classes/product-contr.classes.php";

        $prod = new ProductContr($productId, $salesCategory);

        if(isset($_POST["type"]) && $_POST["type"] == "data"){
            $result = $prod->getProduct();
        }else if(isset($_POST["type"]) && $_POST["type"] == "photo"){
            $result = $prod->getPhoto();
        }
        
        //執行 錯誤處理程序 和 使用者註冊
        //$result = $prod->getProduct();
        // $result = $productId;
        
        //回首頁
        echo $result;
        //die($_SESSION["productId"]);
    
    }elseif(isset($_POST["productCategory"])){
        //實例化 SignupContr 類別
        include "../classes/dbh.classes.php";
        include "../classes/product.classes.php";
        include "../classes/product-contr.classes.php";

        $prod = new ProductContr("", "");

        $result = $prod->getProductCategory();
        
        //回首頁
        echo $result;
    }elseif(isset($_POST["sellerId"])){
        //取得資料
        $sellerId = $_POST["sellerId"];

        //實例化 SignupContr 類別
        include "../classes/dbh.classes.php";
        include "../classes/product.classes.php";
        include "../classes/product-contr.classes.php";

        $prod = new ProductContr(null, null);

        echo $prod->getSellerRentAll($sellerId);
    }
    else{
        echo "session_not";
    }
?>
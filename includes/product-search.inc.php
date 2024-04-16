<?php
    session_start();
    //關鍵字搜尋
    if(isset($_POST["keyword"])){
        //取得資料
        $keyword = $_POST["keyword"];
    
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/product.classes.php";
        include "../classes/product-contr.classes.php";

        $prod = new ProductContr(null, null);
        
        //執行 錯誤處理程序 和 使用者註冊
        $result = $prod->searchSpecifyProduct($keyword);
        
        //回首頁
        $_SESSION["keyword"] = $keyword;
        if($result != "nullData"){
            $_SESSION["product_data"] = $result;
        }

        $next_link = "../search.php";
        header("Location: " . $next_link);
        exit();
        //echo $result;
    
    }else if(isset($_POST["categoryId"])){  //商品類別搜尋
        //取得資料
        $category_id = $_POST["categoryId"];
    
        //實例化 SignupContr 類別
        include "../classes/dbh.classes.php";
        include "../classes/product.classes.php";
        include "../classes/product-contr.classes.php";

        $prod = new ProductContr(null, null);
        
        //執行 錯誤處理程序 和 使用者註冊
        $result = $prod->searchCategoryProduct($category_id);
        
        //回首頁
       // $_SESSION["category"] = $category_id;
        // if($result != "nullData"){
        //     $_SESSION["product_data"] = $result;
        // }

        // $next_link = "../search.php?category=" . $keyword;
        // header("Location: " . $next_link);
        // exit();

        echo $result;
    
    }else{
        echo "post_not";
    }
?>
<?php
    session_start();
    //echo $_SESSION["productId"];
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        //取得資料
        $productId = $_POST["productId"];
        $productName = $_POST["productName"];
        $productIntro = $_POST["productIntro"];
        $productCategory = $_POST["productCategory"];
        // echo $productName . "<br>";
        // echo $productIntro . "<br>";
        // echo $productCategory . "<br>";
        $before_item_length = $_POST["before_product_size_length"];
        $current_item_length = $_POST["product_size_length"];
        $item_id = $_POST["product_item_id"];
        $size = $_POST["size"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $salesCategory = $_POST["salesCategory"];
        $length = count($size);
        // for($i = 0; $i < $length; $i++){
        //     echo "產品細項：" . $size[$i] . "<br>";
        //     echo "產品價格：" . $price[$i] . "<br>";
        //     echo "產品數量：" . $quantity[$i] . "<br>";
        // }
        
        
    
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/product.classes.php";
        include "../classes/product-contr.classes.php";
        
        if(isset($_POST["product_online_send"])){
            $sendCategory = 1;
            // echo "架上儲存";
        }
        if(isset($_POST["product_offline_send"])){
            $sendCategory = 0;
            // echo "架下儲存";
        }

        $prod = new ProductContr(null,null);

        switch ($_POST["salesCategory"]){
            case 1: 
                $productData = array("productId"=>$productId, "productName"=>$productName, "productIntro"=>$productIntro, "productCategory"=>$productCategory, 
                "size"=>$size, "price"=>$price, "quantity"=>$quantity, "salesCategory"=>$salesCategory, "sendCategory"=>$sendCategory,
                "before_item_length"=>$before_item_length, "current_item_length"=>$current_item_length, "item_id"=>$item_id);
                // echo "陣列：" . $productData["productName"] . "<br>";
                // echo "銷售類別：" . $productData["salesCategory"] . "<br>";
                
                //執行 錯誤處理程序 和 使用者註冊
                $prod->updateRent($productData);
                
                // $result = $productId;
            break;
            case 2:
                // $productData = array("productName"=>$productName, "productIntro"=>$productIntro, "productCategory"=>$productCategory, 
                // "size"=>$size, "price"=>$price, "quantity"=>$quantity, "salesCategory"=>$salesCategory, "sendCategory"=>$sendCategory);
                // echo "陣列：" . $productData["productName"] . "<br>";
                // echo "銷售類別：" . $productData["salesCategory"] . "<br>";
                
                //執行 錯誤處理程序 和 使用者註冊
                // $result = $prod->addProduct($productData);
                // $result = $productId;
            break;
        }
        
        //回首頁
        if($result = true){
            $sendCategory_msg;
            if($sendCategory == 1){
                $sendCategory_msg = "架上";
            }else{
                $sendCategory_msg = "架下";
            }
            $_SESSION["system_msg"] = "資料已更新成功，商品儲存狀態：" . $sendCategory_msg;
        }else{
            $_SESSION["system_msg"] = "資料更新失敗...";
        }

        $next_link = "../rent-update.php?productId=" . strval($productId);
        header("Location: " . $next_link);
        exit();
        
    
    }else{
        echo "post_not";
    }
?>
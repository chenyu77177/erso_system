<?php
    session_start();
    //echo $_SESSION["productId"];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //取得資料
        //將cookie內的資料以 逗號 分割成陣列
        
        if($_POST["submit"] == "my-cart"){
            $seller_id_array = explode(",", $_COOKIE["seller_id_list"]);
            $sale_category_array = explode(",", $_COOKIE["sale_category_list"]);
            $product_id_array = explode(",", $_COOKIE["product_id_list"]);
            $item_id_array = explode(",", $_COOKIE["item_id_list"]);
            $quantity_array = explode(",", $_COOKIE["quantity_list"]);
        }
        if($_POST["submit"] == "order"){
            $seller_id_array = explode(",", $_COOKIE["order_seller_id_list"]);
            $sale_category_array = explode(",", $_COOKIE["order_sale_category_list"]);
            $product_id_array = explode(",", $_COOKIE["order_product_id_list"]);
            $item_id_array = explode(",", $_COOKIE["order_item_id_list"]);
            $quantity_array = explode(",", $_COOKIE["order_quantity_list"]);
        }
        //取得購物車商品數量並回傳
        if($_POST["submit"] == "quantity"){
            if(!isset($_COOKIE["product_id_list"])){
                echo 0;
                return;
            }
            $product_id_array = explode(",", $_COOKIE["product_id_list"]);
            $quantity = count($product_id_array);
            $_SESSION["cart_quantity"] = $quantity;
            echo $quantity;
            return;
        }
    
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/product.classes.php";
        include "../classes/product-contr.classes.php";

        $prod = new ProductContr($product_id_array, null);
        $result = $prod->getSpecifyProductAll($seller_id_array, $item_id_array);
        // if(isset($_POST["type"]) && $_POST["type"] == "data"){
        //     $result = $prod->getProduct();
        // }else if(isset($_POST["type"]) && $_POST["type"] == "photo"){
        //     $result = $prod->getPhoto();
        // }
        
        // echo $result;
        echo $result;
    
    }else{
        echo "session_not";
    }
?>
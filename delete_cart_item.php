<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //取得資料  
        $delete_item_id = $_POST["item_id"];

        //將cookie內的資料以 逗號 分割成陣列
        $seller_id_array = explode(",", $_COOKIE["seller_id_list"]);
        $sale_category_array = explode(",", $_COOKIE["sale_category_list"]);
        $product_id_array = explode(",", $_COOKIE["product_id_list"]);
        $item_id_array = explode(",", $_COOKIE["item_id_list"]);
        $quantity_array = explode(",", $_COOKIE["quantity_list"]);

        $key = array_search($delete_item_id, $item_id_array);

        array_splice($seller_id_array, $key, 1);
        array_splice($sale_category_array, $key, 1);
        array_splice($product_id_array, $key, 1);
        array_splice($item_id_array, $key, 1);
        array_splice($quantity_array, $key, 1);

        //儲存資料至購物車(cookie)
        setcookie("seller_id_list", implode(",", $seller_id_array));
        setcookie("sale_category_list", implode(",", $sale_category_array));
        setcookie("product_id_list", implode(",", $product_id_array));
        setcookie("item_id_list", implode(",", $item_id_array));
        setcookie("quantity_list", implode(",", $quantity_array));      

        echo $_COOKIE["item_id_list"];
    }
    if(isset($_SESSION["del_cart_item"])){
        
        //取得資料  
        $del_item_id = explode(",", $_SESSION["item_id"]);

        //將cookie內的資料以 逗號 分割成陣列
        $seller_id_array = explode(",", $_COOKIE["seller_id_list"]);
        $sale_category_array = explode(",", $_COOKIE["sale_category_list"]);
        $product_id_array = explode(",", $_COOKIE["product_id_list"]);
        $item_id_array = explode(",", $_COOKIE["item_id_list"]);
        $quantity_array = explode(",", $_COOKIE["quantity_list"]);

        for($i = 0; $i < count($del_item_id); $i++){
            $key = array_search($del_item_id[$i], $seller_id_array);
            
            //刪除(有找到才刪)
            if(!$key){
                array_splice($seller_id_array, $key, 1);
                array_splice($sale_category_array, $key, 1);
                array_splice($product_id_array, $key, 1);
                array_splice($item_id_array, $key, 1);
                array_splice($quantity_array, $key, 1);
            }
        }
        //儲存資料至購物車(cookie)
        setcookie("seller_id_list", implode(",", $seller_id_array));
        setcookie("sale_category_list", implode(",", $sale_category_array));
        setcookie("product_id_list", implode(",", $product_id_array));
        setcookie("item_id_list", implode(",", $item_id_array));
        setcookie("quantity_list", implode(",", $quantity_array));
        
        unset($_SESSION["del_cart_item"]);
        unset($_SESSION["item_id"]);

        $next_link = "order-show.php?orderId=" . $_SESSION["new_order_id"]; //跳轉至租借單畫面
        unset($_SESSION["new_order_id"]);
        header("Location: " . $next_link);
        exit();
    }
    
?>
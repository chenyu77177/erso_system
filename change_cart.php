<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //取得資料  
        $change_item_id = $_POST[""];
        $change_quantity = $_POST[""];
        
        $seller_id = $_POST["seller_id"];        //賣家編號
        $sale_category = $_POST["sale_category"];   //銷售類別
        $product_id = $_POST["product_id"];      //產品編號
        $item_id = $_POST["item_id"];         //項目編號
        $quantity = $_POST["quantity"];        //數量

        //將cookie內的資料以 逗號 分割成陣列
        $seller_id_array = explode(",", $_COOKIE["seller_id_list"]);
        $sale_category_array = explode(",", $_COOKIE["sale_category_list"]);
        $product_id_array = explode(",", $_COOKIE["product_id_list"]);
        $item_id_array = explode(",", $_COOKIE["item_id_list"]);
        $quantity_array = explode(",", $_COOKIE["quantity_list"]);

        $key = array_search($change_item_id, $item_id_array);

        //若商品項目數量等於0，就將該商品移除購物車
        if($change_quantity == 0 || empty($change_quantity)){
            unset($seller_id_array);
            unset($sale_category_array);
            unset($product_id_array);
            unset($item_id_array);
            unset($quantity_array);
        }else{
            //否則更新商品數量
            $quantity_array[$key] = $change_quantity;
        }
        
        //儲存資料至購物車(cookie)
        setcookie("seller_id_list", implode(",", $seller_id_array));
        setcookie("sale_category_list", implode(",", $sale_category_array));
        setcookie("product_id_list", implode(",", $product_id_array));
        setcookie("item_id_list", implode(",", $item_id_array));
        setcookie("quantity_list", implode(",", $quantity_array));
        
        echo "seller:" . $seller_id . "/sale_category: " . $sale_category . "/product_id:" . $product_id . "/item_id:" . $item_id . "/quantity:" . $quantity;
        
        
    }
?>
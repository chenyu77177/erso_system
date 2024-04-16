<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //取得資料  
        $change_item_id = $_POST[""];
        $change_quantity = $_POST[""];
              
        //儲存資料至購物車(cookie)
        setcookie("seller_id_list", "");
        setcookie("sale_category_list", "");
        setcookie("product_id_list", "");
        setcookie("item_id_list", "");
        setcookie("quantity_list", "");
        
        echo "seller:" . $seller_id . "/sale_category: " . $sale_category . "/product_id:" . $product_id . "/item_id:" . $item_id . "/quantity:" . $quantity;
        
        
    }
?>
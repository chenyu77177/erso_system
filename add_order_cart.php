<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //取得資料        
        $seller_id = $_POST["seller_id"];        //賣家編號
        $sale_category = $_POST["sale_category"];   //銷售類別
        $product_id = $_POST["product_id"];      //產品編號
        $item_id = $_POST["item_id"];         //項目編號
        $quantity = $_POST["quantity"];        //數量
        
        setcookie("order_seller_id_list", $seller_id);
        setcookie("order_sale_category_list", $sale_category);
        setcookie("order_product_id_list", $product_id);
        setcookie("order_item_id_list", $item_id);
        setcookie("order_quantity_list", $quantity);

        //echo "seller:" . $seller_id . "/sale_category: " . $sale_category . "/product_id:" . $product_id . "/item_id:" . $item_id . "/quantity:" . $quantity;
        echo true;
        
    }
?>
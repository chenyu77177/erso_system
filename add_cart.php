<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //取得資料        
        $seller_id = $_POST["seller_id"];        //賣家編號
        $sale_category = $_POST["sale_category"];   //銷售類別
        $product_id = $_POST["product_id"];      //產品編號
        $item_id = $_POST["item_id"];         //項目編號
        $quantity = $_POST["quantity"];        //數量
        
        //若購物車內沒有資料，就新增到購物車
        if(empty($_COOKIE["product_id_list"])){
            setcookie("seller_id_list", $seller_id);
            setcookie("sale_category_list", $sale_category);
            setcookie("product_id_list", $product_id);
            setcookie("item_id_list", $item_id);
            setcookie("quantity_list", $quantity);
        }else{
            //將cookie內的資料以 逗號 分割成陣列
            $seller_id_array = explode(",", $_COOKIE["seller_id_list"]);
            $sale_category_array = explode(",", $_COOKIE["sale_category_list"]);
            $product_id_array = explode(",", $_COOKIE["product_id_list"]);
            $item_id_array = explode(",", $_COOKIE["item_id_list"]);
            $quantity_array = explode(",", $_COOKIE["quantity_list"]);

            //若加入的商品已在購物車內，則變更數量(以項目編號來判斷)
            if(in_array($item_id, $item_id_array)){
                $key = array_search($item_id, $item_id_array);
                $quantity_array[$key] += $quantity;
            }
            //否則將商品加入購物車
            else{
                array_push($seller_id_array, $seller_id);
                array_push($sale_category_array, $sale_category);
                array_push($product_id_array, $product_id);
                array_push($item_id_array, $item_id);
                array_push($quantity_array, $quantity);
            }

            //儲存資料至購物車(cookie)
            setcookie("seller_id_list", implode(",", $seller_id_array));
            setcookie("sale_category_list", implode(",", $sale_category_array));
            setcookie("product_id_list", implode(",", $product_id_array));
            setcookie("item_id_list", implode(",", $item_id_array));
            setcookie("quantity_list", implode(",", $quantity_array));
        }
        echo "seller:" . $seller_id . "/sale_category: " . $sale_category . "/product_id:" . $product_id . "/item_id:" . $item_id . "/quantity:" . $quantity;
        
        
    }
?>
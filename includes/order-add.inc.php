<?php
    session_start();
    //echo $_SESSION["productId"];
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        //前端商品資料
        $title_array = $_POST["title"];
        $item_name_array = $_POST["item"];
        $price_array = $_POST["price"];
        $item_id_array = $_POST["item_id"];

        //後端商品資料
        $seller_id_array = explode(",", $_COOKIE["order_seller_id_list"]);
        $rent_id_array = explode(",", $_COOKIE["order_product_id_list"]);
        $quantity_array = explode(",", $_COOKIE["order_quantity_list"]);

        //租借人資訊
        $user_id = $_SESSION["userid"];
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        
        

        //配送資訊
        $delivery = $_POST["delivery_method"];
        $delivery_fee = $_POST["delivery_fee"];
        $addr = null;
        $store_name = null;

        if(isset($_POST["store_name"])){
            $store_name = $_POST["store_name"];
        }
        //判別資配送方式 --面交=1 門市=2 宅配=3
        switch ($delivery){
            case 1:
            case 3:
                $addr = $_POST["addr"];
                break;
            case 2:
                $store_name = $_POST["store_name"];
                break;
        }
        
        //支付資訊
        $payment = $_POST["payment_method"];
        //--信用卡--
        $credit_card_number = null;
        $expiry_date = null;
        $check_code = null;
        $credit_card_name = null;
        //--轉帳--
        $transfer_end_code = null;
        //判別資支付方式 --信用卡=2 轉帳=3
        switch ($payment){
            case 2:
                $credit_card_number = $_POST["credit_card_number"];
                $expiry_date = $_POST["expiry_date"];
                $check_code = $_POST["check_code"];
                $credit_card_name = $_POST["credit_card_name"];
                break;
            case 3:
                $transfer_end_code = $_POST["transfer_end_code"];
                break;
        }
        

        $item_id_list = implode(",", $item_id_array);
        //測試接收的資料
        // echo "===== 租借人資訊 =====<br>";
        // echo "使用者id：{$user_id}<br>";
        // echo "姓名：{$name}<br>";
        // echo "電話：{$phone}<br>";
        
        // echo "信箱：{$email}<br>";
        // echo "===== 商品資訊 =====<br>";
        // for($i = 0; $i < count($title_array); $i++){
        //     echo "-----第 {$i} 筆-----<br>";
        //     echo "賣家id：{$seller_id_array["0"]}<br>";
        //     echo "商品id：{$rent_id_array[$i]}<br>";
        //     echo "商品名稱：{$title_array[$i]}<br>";
        //     echo "項目名稱：{$item_name_array[$i]}<br>";
        //     echo "單價：{$price_array[$i]}<br>";
        //     echo "天數：{$quantity_array[$i]}<br>";
        // }
        // echo "===== 配送資訊 =====<br>";
        // echo "配送方式：{$delivery}<br>";
        // echo "運費：{$delivery_fee}<br>";
        // echo "地址：{$addr}<br>";
        // echo "門市：{$store_name}<br>";
        // echo "===== 支付資訊 =====<br>";
        // echo "---信用卡---<br>";
        // echo "支付方式：{$payment}<br>";
        // echo "信用卡號{$credit_card_number}<br>";
        // echo "有效期限{$expiry_date}<br>";
        // echo "檢查碼{$check_code}<br>";
        // echo "持卡人姓名：{$card_name}<br>";
        // echo "---轉帳---<br>";
        // echo "轉帳帳號末五碼：{$transfer_end_code}<br>";        
    
        //實例化 OrderContr 類別
        include "../classes/dbh.classes.php";
        include "../classes/order.classes.php";
        include "../classes/order-contr.classes.php";

        $prod = new OrderContr();

        //資料打包
        $orderData = array("user_id"=>$user_id, "name"=>$name, "phone"=> $phone, "addr"=>$addr, "email"=> $email, "seller_id"=>$seller_id_array["0"], 
                "rent_id_array"=>$rent_id_array, "title_array"=>$title_array, "item_name_array"=>$item_name_array, "price_array"=>$price_array, "quantity_array"=>$quantity_array, 
                "payment"=> $payment, "delivery"=> $delivery, "delivery_fee"=>$delivery_fee, "store_name"=>$store_name, "transfer_end_code"=>$transfer_end_code,
                "credit_card_number"=>$credit_card_number, "expiry_date"=>$expiry_date, "check_code"=>$check_code, "credit_card_name"=>$credit_card_name);
        
        //執行 錯誤處理程序 和 使用者註冊
        $result = $prod->addOrder($orderData);
        
        //回傳判斷
        if($result){
            $_SESSION["system_msg"] = "租借成功!!!";
            $_SESSION["del_cart_item"] = true;
            $_SESSION["item_id"] = $item_id_list;
        }else{
            $_SESSION["system_msg"] = "租借失敗... [" . $result . "]";
            $next_link = "../order-add.php";
            header("Location: " . $next_link);
            exit();
        }
        $next_link = "../delete_cart_item.php";
        header("Location: " . $next_link);
        exit();
    
    }else{
        echo "post_not";
    }
?>
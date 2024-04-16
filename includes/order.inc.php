<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //實例化 SignupContr 類別
        include "../classes/dbh.classes.php";
        include "../classes/order.classes.php";
        include "../classes/order-contr.classes.php";

    }
    if(isset($_POST["getSellerAllOrder"])){
        //取得資料
        $userId = $_POST["userId"];

        $prod = new OrderContr();

        echo $prod->getSellerAllOrder($userId);
    }else if(isset($_POST["getSpecifyOrder"])){
        //取得資料
        $order_id = $_POST["orderId"];

        $prod = new OrderContr();

        echo $prod->getSpecifyOrder($order_id);
    }else if(isset($_POST["getTradeCategory"])){
        $prod = new OrderContr();

        echo $prod->getTradeCategory();
    }else if(isset($_POST["sendTradeState"])){

        $prod = new OrderContr();

        $result = $prod->updateTradeState($_POST["orderId"], $_POST["tradeCategory"]);

        if($result){
            $_SESSION["system_msg"] = "租借單狀態已更新成功!!!";
        }else{
            $_SESSION["system_msg"] = "租借單狀態更新失敗... [" . $result ."]";
        }

        $next_link = "../order-process.php?orderId=" . $_POST["orderId"];
        header("Location: " . $next_link);
        exit();
    }else if(isset($_POST["btn"])){

        $prod = new OrderContr();

        $result = $prod->updateTradeState($_POST["orderId"], $_POST["btn"]);

        if($result){
            $_SESSION["system_msg"] = "租借單狀態已更新成功!!!";
        }else{
            $_SESSION["system_msg"] = "租借單狀態更新失敗... [" . $result ."]";
        }

        $next_link = "../order-process.php?orderId=" . $_POST["orderId"];
        header("Location: " . $next_link);
        exit();
    }else if(isset($_POST["getUserAllOrder"])){
        //取得資料
        $userId = $_POST["userId"];

        $prod = new OrderContr();

        echo $prod->getUserAllOrder($userId);
    }else if(isset($_POST["getPaymentCategory"])){
        //取得支付方式名稱
        $prod = new OrderContr();

        echo $prod->getPaymentCategory();
    }else if(isset($_POST["getDeliveryCategory"])){
        //取得配送方式名稱
        $prod = new OrderContr();

        echo $prod->getDeliveryCategory();
    }else if(isset($_POST["updatePaymentCategory"])){
        //更新支付方式名稱

        //取得資料
        $pyament_id = $_POST["payment_id"];
        $payment_name = $_POST["payment_name"];

        $prod = new OrderContr();

        echo $prod->updatePaymentCategory($pyament_id, $payment_name);
    }else if(isset($_POST["updateDeliveryCategory"])){
        //更新配送方式名稱

        //取得資料
        $delivery_id = $_POST["delivery_id"];
        $delivery_name = $_POST["delivery_name"];

        $prod = new OrderContr();

        echo $prod->updateDeliveryCategory($delivery_id, $delivery_name);
    }else if(isset($_POST["updateTradeCategory"])){
        //更新配送方式名稱

        //取得資料
        $trade_id = $_POST["trade_id"];
        $category_name = $_POST["category_name"];
        $user_show_name = $_POST["user_show_name"];
        $btn_name = $_POST["btn_name"];
        $color = $_POST["color"];
        
        $data = array("id"=>$trade_id, "category_name"=>$category_name, "user_show_name"=>$user_show_name, "btn_name"=>$btn_name, "color"=>$color);

        $prod = new OrderContr();

        echo $prod->updateTradeCategory($data);
    }else{
        echo "session_not";
    }
?>
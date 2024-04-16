<?php
    class Order extends Dbh{

        //新增租借資料至資料庫
        protected function addOrderData($data){
            $connect = $this->connect();
            $stmt = $connect->prepare(
                'INSERT INTO
                orders(user_id, seller_id, name, phone, address, email, payment, delivery, create_date, trade_state, delivery_fee, store_name, transfer_end_code, credit_card_number, expiry_date, check_code, credit_card_name)
                values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            
            $timeNow = date("Y-m-d H:i:s");
            if(!$stmt->execute(array($data["user_id"], $data["seller_id"], $data["name"], $data["phone"], $data["addr"], $data["email"], $data["payment"], $data["delivery"], $timeNow, 1, $data["delivery_fee"], $data["store_name"], $data["transfer_end_code"], $data["credit_card_number"], $data["expiry_date"], $data["check_code"], $data["credit_card_name"]))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                //新資料成功時，取得新增資料時自動產生的id
                $new_id = $connect->lastInsertId();
                $detailResult = $this->addOrderDetailData($data, $new_id);
                if(!$detailResult){
                    return "detailUploadError";
                }
                $_SESSION["new_order_id"] = $new_id;
                return true;
            }
            return "insertNullInProducts";
        }

        //新增租借資料(細項)至資料庫
        protected function addOrderDetailData(array $data, $orderId){
            $stmt = $this->connect()->prepare(
                'INSERT INTO
                orders_details(order_id, rent_id, rent_name, rent_item_name, quantity, price)
                values(?,?,?,?,?,?)');

            for($i = 0; $i < count($data["title_array"]); $i++){
                if(!$stmt->execute(array($orderId, $data["rent_id_array"][$i], $data["title_array"][$i], $data["item_name_array"][$i], $data["quantity_array"][$i], $data["price_array"][$i]))){
                    $stmt = null;
                    return "stmtNull";
                }
            }
            if($stmt->rowCount() > 0){
                return true;
            }

            return false;
            
        }

        //取得賣家所有訂單資料
        protected function getSellerAllOrderData($sellerId){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM orders 
                -- INNER JOIN rents_details 
                -- ON rents.rent_id = rents_details.rent_id 
                LEFT JOIN orders_details
                ON orders.order_id = orders_details.order_id
                WHERE orders.seller_id = ?;');

            if(!$stmt->execute(array($sellerId))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $orderData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $orderData;
        }

        //取得使用者所有訂單資料
        protected function getUserAllOrderData($userId){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM orders 
                -- INNER JOIN rents_details 
                -- ON rents.rent_id = rents_details.rent_id 
                LEFT JOIN orders_details
                ON orders.order_id = orders_details.order_id
                WHERE orders.user_id = ?;');

            if(!$stmt->execute(array($userId))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $orderData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $orderData;
        }

        //取得指定訂單資料
        protected function getSpecifyOrderData($orderId){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM orders 
                LEFT JOIN orders_details
                ON orders.order_id = orders_details.order_id
                inner JOIN rents_photos 
                ON orders_details.rent_id = rents_photos.rent_id 
                WHERE orders.order_id = ?;');

            if(!$stmt->execute(array($orderId))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $orderData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $orderData;
        }

        //讀取訂單處理狀態類別資訊
        protected function getTradeCategoryData(){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM trade_category ');

            if(!$stmt->execute(array())){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $tradeData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $tradeData;
        }

        //讀取支付方式類別資訊
        protected function getPaymentCategoryData(){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM payment_category ');

            if(!$stmt->execute(array())){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $paymentData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $paymentData;
        }

        //讀取配送方式類別資訊
        protected function getDeliveryCategoryData(){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM delivery_category ');

            if(!$stmt->execute(array())){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $deliveryData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $deliveryData;
        }

        //更新商品處理狀態
        protected function updateTradeStateData($order_id, $state_id){
            $connect = $this->connect();
            $stmt = $connect->prepare(
                'UPDATE orders 
                SET trade_state=?, update_date=? 
                WHERE order_id = ?');
            
            $timeNow = date("Y-m-d H:i:s");
            if(!$stmt->execute(array($state_id, $timeNow, $order_id))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                return true;
            }

            return "updateError";
        }

        //更新配送方式資訊
        protected function updatePaymentCategoryData($payment_id, $payment_name){
            $connect = $this->connect();
            $stmt = $connect->prepare(
                'UPDATE payment_category 
                SET payment_name=? 
                WHERE payment_id = ?');
            
            if(!$stmt->execute(array($payment_name, $payment_id))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                return true;
            }

            return false;
        }

        //更新支付方式資訊
        protected function updateDeliveryCategoryData($delivery_id, $delivery_name){
            $connect = $this->connect();
            $stmt = $connect->prepare(
                'UPDATE delivery_category 
                SET delivery_name=? 
                WHERE delivery_id = ?');
            
            if(!$stmt->execute(array($delivery_name, $delivery_id))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                return true;
            }

            return false;
        }

        //更新交易狀態資訊
        protected function updateTradeCategoryData($data){
            $connect = $this->connect();
            $stmt = $connect->prepare(
                'UPDATE trade_category 
                SET category_name = ?, user_show_name = ?, btn_name = ?, color = ?  
                WHERE trade_state_id = ?');
            
            if(!$stmt->execute(array($data["category_name"], $data["user_show_name"], $data["btn_name"], $data["color"], $data["id"]))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                return true;
            }

            return false;
        }
    }

?>
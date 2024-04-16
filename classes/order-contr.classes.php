<?php
    class OrderContr extends Order{

        public function __construct()
        {

        }

        //取得商品資料
        public function addOrder($orderData) {
            return $this->addOrderData($orderData);
        }

        //取得賣家所有訂單資料
        public function getSellerAllOrder($seller_id){
            return $this->getSellerAllOrderData($seller_id);
        }

        //取得使用者所有訂單資料
        public function getUserAllOrder($user_id){
            return $this->getUserAllOrderData($user_id);
        }

        //取得指定訂單資料
        public function getSpecifyOrder($order_id){
            return $this->getSpecifyOrderData($order_id);
        }

        //讀取處理狀態資訊
        public function getTradeCategory(){
            return $this->getTradeCategoryData();
        }

        //讀取支付方式資訊
        public function getPaymentCategory(){
            return $this->getPaymentCategoryData();
        }

        //讀取配送方式資訊
        public function getDeliveryCategory(){
            return $this->getDeliveryCategoryData();
        }

        //更新商品處理狀態
        public function updateTradeState($order_id, $state_id){
            return $this->updateTradeStateData($order_id, $state_id);
        }

        //更新配送方式資訊
        public function updatePaymentCategory($payment_id, $payment_name){
            return $this->updatePaymentCategoryData($payment_id, $payment_name);
        }

        //更新支付方式資訊
        public function updateDeliveryCategory($delivery_id, $delivery_name){
            return $this->updateDeliveryCategoryData($delivery_id, $delivery_name);
        }

        //更新交易狀態資訊
        public function updateTradeCategory($data){
            return $this->updateTradeCategoryData($data);
        }

    }

?>
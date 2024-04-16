<?php
    class ProductContr extends Product{
        private $productId;
        private $salesCategory;

        public function __construct($productId, $salesCategory)
        {
            $this->productId = $productId;
            $this->salesCategory = $salesCategory;
        }

        //取得商品資料
        public function getProduct() {
            if(!empty($this->productId)){
                return $this->getProductData($this->productId, $this->salesCategory);
            }else
                return "nullProductId(data)";
        }

        //取得商品資料(多筆)
        public function getProducts() {
            $data  = array();
            for($i = 0; $i < count($this->productId); $i++){
                if(!empty($this->productId[$i])){
                    $salesCategory = "";
                    switch ($this->salesCategory[$i]){
                        case 1:
                            $salesCategory = "rent";
                            break;
                        case 2 :
                            $salesCategory = "product";
                            break;
                    }
                    $return_data = $this->getProductData($this->productId[$i], $salesCategory);
                    array_push($data, json_decode($return_data));
                    
                }else
                    return "nullProductId(data)";
            }
            return Json_encode($data);            
        }

        //取得商品圖片
        public function getPhoto(){
            if(!empty($this->productId)){
                return $this->getProductPhoto($this->productId, $this->salesCategory);
            }else
                return "nullProductId(photos)";
        }

        //取得商品類別資料
        public function getProductCategory() {
            return $this->getProductCategoryData();
        }

        //取得指定項目所有商品資料
        public function getSpecifyProductAll($seller_id, $item_id){
            $data  = array();
            for($i = 0; $i < count($this->productId); $i++){
                if(!empty($this->productId[$i])){
                    $return_data = $this->getSpecifyProductAllData($this->productId[$i], $seller_id[$i], $item_id[$i]);
                    array_push($data, json_decode($return_data));
                    
                }else
                    return "nullProductId(data)";
            }
            return Json_encode($data);
            // return $this->getSpecifyProductAllData($seller_id, $item_id);
        }

        //取得指定數量之隨機商品詳細資料
        public function getRandProductAll($quantity){
            return $this->getRandProductAllData($quantity);
        }

        //取得商品資料及圖片資料
        public function getSellerRentAll($sellerId){
            return $this->getSellerRentAllData($sellerId);
        }

        //新增商品資料
        public function addProduct($data){
            return $this->addProductData($data);
        }

        //新增租借商品資料
        public function addRent($data){
            return $this->addRentData($data);
        }

        //更新租借商品資料
        public function updateRent($data){
            return $this->updateRentData($data);
        }

        //刪除租借商品圖片
        public function removePhoto($photo_id){
            return $this->removePhotoData($photo_id);
        }

        //上傳新租借商品圖片
        public function uploadPhoto($product_id){
            return $this->addRentPhotoData($product_id);
        }

        //搜尋商品
        public function searchSpecifyProduct($keyword){
            return $this->searchSpecifyProductData($keyword);
        }

        //搜尋指定類別商品
        public function searchCategoryProduct($category_id){
            return $this->searchCategoryProductData($category_id);
        }

    }


?>
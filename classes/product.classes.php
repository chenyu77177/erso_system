<?php
    class Product extends Dbh{

        protected function getProductData($productId, $salesCategory){
            //讀取資料選擇
            switch ($salesCategory) {
                case "sale":
                    $stmt = $this->connect()->prepare(
                        'SELECT * FROM products 
                        INNER JOIN products_details 
                        ON products.product_id = products_details.product_id 
                        WHERE products.product_id = ?;');
                    break;
                case "rent":
                    $stmt = $this->connect()->prepare(
                        'SELECT * FROM rents 
                        INNER JOIN rents_details 
                        ON rents.rent_id = rents_details.rent_id 
                        WHERE rents.rent_id = ?;');
                    break;
            }

            if(!$stmt->execute(array($productId))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            // $productData = ;
            $productData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $productData;
        }

        //取得商品圖片
        protected function getProductPhoto($productId, $salesCategory){
            switch ($salesCategory) {
                case "sale":
                    $stmt = $this->connect()->prepare(
                        'SELECT * FROM products_photos
                        WHERE product_id = ?;');
                    break;
                case "rent":
                    $stmt = $this->connect()->prepare(
                        'SELECT * FROM rents_photos
                        WHERE rent_id = ?;');
                    break;
            }
            
            if(!$stmt->execute(array($productId))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $productPhoto = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $productPhoto;
        }

        //取得指定項目所有商品資料
        protected function getSpecifyProductAllData($procuct_id, $seller_id, $item_id){
            //讀取資料選擇
            $stmt = $this->connect()->prepare(
                'SELECT * FROM rents 
                LEFT JOIN rents_details 
                ON rents.rent_id = rents_details.rent_id
                LEFT JOIN rents_photos 
                ON rents.rent_id = rents_photos.rent_id
                LEFT JOIN users 
                ON rents.seller = users.user_id
                WHERE rents.rent_id = ? AND users.user_id = ? AND rent_detail_id = ?;');

            if(!$stmt->execute(array($procuct_id,$seller_id, $item_id))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            // $productData = ;
            $productData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $productData;
        }

        //取得指定數量之所有商品資料
        protected function getRandProductAllData($quantity){
            //讀取資料選擇
            $stmt = $this->connect()->prepare(
                'SELECT * FROM rents 
                LEFT JOIN rents_details 
                ON rents.rent_id = rents_details.rent_id
                LEFT JOIN rents_photos 
                ON rents.rent_id = rents_photos.rent_id
                LEFT JOIN users 
                ON rents.seller = users.user_id
                WHERE rents.save_category = ?
                ORDER BY rand()
                LIMIT ' . $quantity . ';');

            if(!$stmt->execute(Array(1))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            // $productData = ;
            $productData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $productData;
        }

        //取得賣家所有商品資料
        protected function getSellerRentAllData($sellerId){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM rents 
                -- INNER JOIN rents_details 
                -- ON rents.rent_id = rents_details.rent_id 
                LEFT JOIN rents_photos
                ON rents.rent_id = rents_photos.rent_id
                WHERE rents.seller = ?;');

            if(!$stmt->execute(array($sellerId))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            // $productData = ;
            $productData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $productData;
        }

        //取得商品名名稱
        protected function getProductCategoryData(){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM product_category');
            
            if(!$stmt->execute()){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $productCategoryData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $productCategoryData;
        }

        //新增商品資料至資料庫
        protected function addProductData($data){
            $connect = $this->connect();
            $stmt = $connect->prepare(
                'INSERT INTO
                products(title, intro, seller, category, date, product_category, save_category)
                values(?,?,?,?,?,?,?)');
            
            $timeNow = date("Y-m-d H:i:s");
            if(!$stmt->execute(array($data["productName"], $data["productIntro"], $data["seller"], $data["salesCategory"], $timeNow, $data["productCategory"], $data["sendCategory"]))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                //新資料成功時，取得新增資料時自動產生的id
                $new_id = $connect->lastInsertId();
                $detailResult = $this->addProductDetailData($data, $new_id);
                $photoResult = $this->addProductPhotos($new_id);
                if($detailResult != "success"){
                    return "detailUploadError";
                }
                if($photoResult != "success"){
                    return "photoUploadErroe";
                }
                return "success";
            }
            return "insertNullInProducts";
        }

        //新增商品資料(細項)至資料庫
        protected function addProductDetailData(array $data, $productId){
            $stmt = $this->connect()->prepare(
                'INSERT INTO
                products_details(product_id, size, price, quantity, state, edit_date)
                values(?,?,?,?,?,?)');

            $timeNow = date("Y-m-d H:i:s");
            for($i = 0; $i < count($data["size"]); $i++){
                if(!$stmt->execute(array($productId, $data["size"][$i], $data["price"][$i], $data["quantity"][$i], "1", $timeNow))){
                    $stmt = null;
                    return "stmtNull";
                }
            }
            if($stmt->rowCount() > 0){
                return "success";
            }

            return "error";
            
        }

        //新增商品資料及圖片至資料庫和資料夾(多筆)
        protected function addProductPhotos($new_id){
            $path = "../assets/products/" . $new_id;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            
            $upload_dir = $path."/";

            //將圖片檔名暫時存起來，以便後續存入資料庫
            $fileNameArray = array();
            for($i = 0; $i < 5; $i++){
                //若檔案名稱不是空字串，表示上傳成功，將暫存檔案移至指定資料夾
                $timeNow = date("YmdHis");
                $newFileName = "img" . $timeNow . "_" . ($i + 1) .".jpg";
                if($_FILES["img"]["name"][$i] != ""){
                    array_push($fileNameArray, $newFileName);
                    $upload_file = $upload_dir . $newFileName;
                    move_uploaded_file($_FILES["img"]["tmp_name"][$i], $upload_file);
                }
            }
            
            
            $stmt = $this->connect()->prepare(
                'INSERT INTO
                products_photos(product_id, path, photo_name, sequence)
                values(?,?,?,?)');

            $file_dir = "assets/products/" . $new_id . "/";
            for($i = 0; $i < count($fileNameArray); $i++){
                if(!$stmt->execute(array($new_id, $file_dir, $fileNameArray[$i], $i+1))){
                    $stmt = null;
                    return "stmtNull";
                }
            }

            if($stmt->rowCount() > 0){
                unset($fileNameArray);
                return "success";
            }

            return "error";
        }

        //新增商品圖片至資料庫和資料夾
        protected function addRentPhotoData($product_id){
            $path = "../assets/rents/" . $product_id;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            
            $upload_dir = $path."/";

            //將圖片檔名暫時存起來，以便後續存入資料庫
            
            $timeNow = date("YmdHis");
            $newFileName = "img" . $timeNow . "_" . 1 .".jpg";
            //若檔案名稱不是空字串，表示上傳成功，將暫存檔案移至指定資料夾
            if($_FILES["img"]["name"] != ""){
                $upload_file = $upload_dir . $newFileName;
                move_uploaded_file($_FILES["img"]["tmp_name"], $upload_file);
            }
            
            
            $stmt = $this->connect()->prepare(
                'INSERT INTO
                rents_photos(rent_id, path, photo_name, sequence)
                values(?,?,?,?)');

            $file_dir = "assets/rents/" . $product_id . "/";
            if(!$stmt->execute(array($product_id, $file_dir, $newFileName, 2))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                unset($fileNameArray);
                return true;
            }

            return "圖片上傳失敗";
        }

        //新增租借資料至資料庫
        protected function addRentData($data){
            $connect = $this->connect();
            $stmt = $connect->prepare(
                'INSERT INTO
                rents(title, intro, seller, category, date, rent_category, save_category)
                values(?,?,?,?,?,?,?)');
            
            $timeNow = date("Y-m-d H:i:s");
            if(!$stmt->execute(array($data["productName"], $data["productIntro"], $data["seller"], $data["salesCategory"], $timeNow, $data["productCategory"], $data["sendCategory"]))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                //新資料成功時，取得新增資料時自動產生的id
                $new_id = $connect->lastInsertId();
                $detailResult = $this->addRentDetailData($data, $new_id);
                $photoResult = $this->addRentPhotos($new_id);
                if($detailResult != "success"){
                    return "detailUploadError";
                }
                if($photoResult != "success"){
                    return "photoUploadErroe";
                }
                return "success";
            }
            return "insertNullInProducts";
        }

        //新增租借資料(細項)至資料庫
        protected function addRentDetailData(array $data, $productId){
            $stmt = $this->connect()->prepare(
                'INSERT INTO
                rents_details(rent_id, size, price, quantity, state, edit_date)
                values(?,?,?,?,?,?)');

            $timeNow = date("Y-m-d H:i:s");
            for($i = 0; $i < count($data["size"]); $i++){
                if(!$stmt->execute(array($productId, $data["size"][$i], $data["price"][$i], $data["quantity"][$i], "1", $timeNow))){
                    $stmt = null;
                    return "stmtNull";
                }
            }
            if($stmt->rowCount() > 0){
                return true;
            }

            return "error";
            
        }

        //新增租借資料及圖片至資料庫和資料夾(多筆)
        protected function addRentPhotos($new_id){
            $path = "../assets/rents/" . $new_id;
            //資料夾不存在就新增資料夾
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            
            $upload_dir = $path."/";

            //將圖片檔名暫時存起來，以便後續存入資料庫
            $fileNameArray = array();
            for($i = 0; $i < 5; $i++){
                //若檔案名稱不是空字串，表示上傳成功，將暫存檔案移至指定資料夾
                $timeNow = date("YmdHis");
                $newFileName = "img" . $timeNow . "_" . ($i + 1) .".jpg";
                if($_FILES["img"]["name"][$i] != ""){
                    array_push($fileNameArray, $newFileName);
                    $upload_file = $upload_dir . $newFileName;
                    move_uploaded_file($_FILES["img"]["tmp_name"][$i], $upload_file);
                }
            }
            
            
            $stmt = $this->connect()->prepare(
                'INSERT INTO
                rents_photos(rent_id, path, photo_name, sequence)
                values(?,?,?,?)');

            $file_dir = "assets/rents/" . $new_id . "/";
            for($i = 0; $i < count($fileNameArray); $i++){
                if(!$stmt->execute(array($new_id, $file_dir, $fileNameArray[$i], $i+1))){
                    $stmt = null;
                    return "stmtNull";
                }
            }

            if($stmt->rowCount() > 0){
                unset($fileNameArray);
                return "success";
            }

            return "error";
        }

        //更新租借商品資料
        protected function updateRentData($data){
            $connect = $this->connect();
            $stmt = $connect->prepare(
                'UPDATE rents 
                SET title=?, intro=?, update_date=?, rent_category=?, save_category=? 
                WHERE rent_id = ?');
            
            $timeNow = date("Y-m-d H:i:s");
            if(!$stmt->execute(array($data["productName"], $data["productIntro"], $timeNow, $data["productCategory"], $data["sendCategory"], $data["productId"]))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                //新資料成功時，取得新增資料時自動產生的id
                $detailResult = $this->updateRentDetailData($data);
                // $photoResult = $this->UpdateRentPhotos($new_id);
                if(!$detailResult){
                    return "detailUploadError";
                }
                // if($photoResult != "success"){
                //     return "photoUploadErroe";
                // }
                return true;
            }
            return "insertNullInProducts";
        }

        //更新租借資料(細項)至資料庫
        protected function updateRentDetailData(array $data){
            $timeNow = date("Y-m-d H:i:s");

            $stmt = $this->connect()->prepare(
                'UPDATE rents_details 
                SET size=?, price=?, quantity=?, state=?, edit_date=? 
                WHERE rent_detail_id = ?');

            if($data["before_item_length"] < $data["current_item_length"]){
                //原本項目數量 < 目前項目數量，則新增項目資料至租借細項資料表
                for($i = 0; $i < number_format($data["before_item_length"]); $i++){
                    if(!$stmt->execute(array($data["size"][$i], $data["price"][$i], $data["quantity"][$i], "1", $timeNow, $data["item_id"][$i]))){
                        $stmt = null;
                        return "stmtNull";
                    }
                }
                $add_item_id_start = number_format($data["before_item_length"]);    //索引直起始為0
                $add_item_id_end = number_format($data["current_item_length"]);
                $size = array();
                $price = array();
                $quantity = array();
                for($i = $add_item_id_start; $i < $add_item_id_end; $i++){
                    array_push($size, $data["size"][$i]);
                    array_push($price, $data["price"][$i]);
                    array_push($quantity, $data["quantity"][$i]);
                }
                $insert_item_data = array("size"=>$size, "price"=>$price, "quantity"=>$quantity);
                if(!$this->addRentDetailData($insert_item_data, $data["productId"])){
                    return "insert item error.";
                }
            }elseif($data["before_item_length"] > $data["current_item_length"]){
                //原本項目數量 > 目前項目數量，則刪除多餘資料
                for($i = 0; $i < number_format($data["current_item_length"]); $i++){
                    if(!$stmt->execute(array($data["size"][$i], $data["price"][$i], $data["quantity"][$i], "1", $timeNow, $data["item_id"][$i]))){
                        $stmt = null;
                        return "stmtNull";
                    }
                }
                $remove_item_id_quantity = number_format($data["before_item_length"]) - number_format($data["current_item_length"]);
                $remove_item_id_data = array();
                for($i = 0; $i < $remove_item_id_quantity; $i++){
                    array_push($remove_item_id_data, $data["item_id"][$i]);
                }
                if(!$this->removeRentDetailData($remove_item_id_data)){
                    return "remove item error.";
                }

            }elseif($data["before_item_length"] == $data["current_item_length"]){
                //原本項目數量 = 目前項目數量，則修改現有資料
                for($i = 0; $i < number_format($data["before_item_length"]); $i++){
                    if(!$stmt->execute(array($data["size"][$i], $data["price"][$i], $data["quantity"][$i], "1", $timeNow, $data["item_id"][$i]))){
                        $stmt = null;
                        return "stmtNull";
                    }
                }
            }
            
            if($stmt->rowCount() > 0){
                return true;
            }

            return "error";
            
        }

        //移除指定id租借資料(細項)
        protected function removeRentDetailData(array $remove_id){
            $stmt = $this->connect()->prepare(
                'DELETE FROM rents_details 
                WHERE rent_detail_id = ?');

            $timeNow = date("Y-m-d H:i:s");
            for($i = 0; $i < count($remove_id); $i++){
                if(!$stmt->execute(array($remove_id[$i]))){
                    $stmt = null;
                    return "stmtNull";
                }
            }
            if($stmt->rowCount() > 0){
                return true;
            }

            return "error";
        }

        //移除租借商品指定之id圖片
        protected function removePhotoData($photoId){
            $stmt = $this->connect()->prepare(
                'DELETE FROM rents_photos 
                WHERE rent_photo_id = ?');
                
            if(!$stmt->execute(array($photoId))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                return true;
            }

            return "error";
        }

        //搜尋商品
        protected function searchSpecifyProductData($keyword){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM rents 
                LEFT JOIN rents_details 
                ON rents.rent_id = rents_details.rent_id 
                LEFT JOIN rents_photos
                ON rents.rent_id = rents_photos.rent_id
                WHERE rents.save_category = ? AND (rents.title LIKE ? OR rents.intro LIKE ?);');
            $keyword = '%'.$keyword.'%';
            if(!$stmt->execute(array(true , $keyword, $keyword))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            // $productData = ;
            $productData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $productData;
        }

        //搜尋指定類別商品
        protected function searchCategoryProductData($category_id){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM rents 
                LEFT JOIN rents_details 
                ON rents.rent_id = rents_details.rent_id 
                LEFT JOIN rents_photos
                ON rents.rent_id = rents_photos.rent_id
                WHERE rents.rent_category = ? AND rents.save_category = ?;');
            if(!$stmt->execute(array($category_id, true))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            // $productData = ;
            $productData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $productData;
        }
    }


?>
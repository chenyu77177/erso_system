<?php
    class Banner extends Dbh{

        //取得橫幅圖片資料
        protected function getBannerData(){
            $stmt = $this->connect()->prepare(
                'SELECT * FROM banner ;');

            if(!$stmt->execute(array())){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $bannerData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $bannerData;
        }

        //新增橫幅圖片至資料庫和資料夾
        protected function addBannerPhotoData(){
            $path = "../assets/banner";
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            
            $upload_dir = $path."/";

            //將圖片檔名暫時存起來，以便後續存入資料庫
            
            $timeNow = date("YmdHis");
            $newFileName = "banner_" . $timeNow . "_" . 1 .".jpg";
            //若檔案名稱不是空字串，表示上傳成功，將暫存檔案移至指定資料夾
            if($_FILES["img"]["name"] != ""){
                $upload_file = $upload_dir . $newFileName;
                move_uploaded_file($_FILES["img"]["tmp_name"], $upload_file);
            }
            
            
            $stmt = $this->connect()->prepare(
                'INSERT INTO
                banner(photo_name, show_state)
                values(?,?)');

            if(!$stmt->execute(array($newFileName, 1))){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() > 0){
                unset($fileNameArray);
                return true;
            }

            return false;
        }

        //移除指定之id橫幅
        protected function removePhotoData($banner_id){
            $stmt = $this->connect()->prepare(
                'DELETE FROM banner 
                WHERE banner_id = ?');
                
            if(!$stmt->execute(array($banner_id))){
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
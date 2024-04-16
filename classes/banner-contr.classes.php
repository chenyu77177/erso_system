<?php
    class BannerContr extends Banner{

        public function __construct()
        {

        }

        //取得橫幅圖片資料
        public function getBanner() {
            return $this->getBannerData();
        }

        //上傳新橫幅圖片
        public function uploadPhoto(){
            return $this->addBannerPhotoData();
        }

        //刪除橫幅圖片
        public function removeBanner($banner_id){
            return $this->removePhotoData($banner_id);
        }


    }

?>
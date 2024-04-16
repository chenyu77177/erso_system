<?php
    class UserContr extends User{

        public function __construct()
        {

        }

        //取得user資料
        public function getUser() {
            return $this->getUserData();
        }

        //更新user身分資料
        public function updatePermission($user_id, $permission){
            return $this->updatePermissionData($user_id, $permission);
        }

    }


?>
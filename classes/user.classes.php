<?php
    class User extends Dbh{
        //取得所有使用者資料
        protected function getUserData(){
            $stmt = $this->connect()->prepare(
                'SELECT user_id, user_name, user_email, permission FROM users 
                -- INNER JOIN rents_details 
                -- ON rents.rent_id = rents_details.rent_id 
                -- LEFT JOIN orders_details
                -- ON orders.order_id = orders_details.order_id
                -- WHERE orders.seller_id = ?
                ;');

            if(!$stmt->execute(array())){
                $stmt = null;
                return "stmtNull";
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                return "nullData";
            }

            $userData = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $userData;
        }

        //更新使用者身分
        protected function updatePermissionData($user_id, $permission){
            $connect = $this->connect();
            $stmt = $connect->prepare(
                'UPDATE users 
                SET permission=? 
                WHERE user_id = ?');
            
            if(!$stmt->execute(array($permission, $user_id))){
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
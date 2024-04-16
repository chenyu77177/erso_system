<?php
    //session_start();
    class PersonalInfo extends Dbh{
        protected function getUserInfo($email) {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_email = ?;');

            if(!$stmt->execute(array($email))){
                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                header("location: ../login.php?error=usernotfound");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["userid"] = $user[0]["user_id"];
            $_SESSION["username"] = $user[0]["user_name"];
            $_SESSION["useremail"] = $user[0]["user_email"];
        }

        protected function updateUserInfo($email,$newName){
            $stmt = $this->connect()->prepare('UPDATE users SET user_name = ? WHERE user_email = ?');

            if(!$stmt->execute(array($newName,$email))){
                $stmt = null;

                $_SESSION["error"] = "stmtfailed 資料庫執行失敗";
                header("location: ../personal-Info.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                $_SESSION["error"] = "usernotfound 找不到該使用者";
                header("location: ../personal-Info.php?error=usernotfound");
                exit();
            }

            $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["error"] = "none";
        }
    }
?>
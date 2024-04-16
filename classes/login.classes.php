<?php
class Login extends Dbh{

    protected function getUser($email, $pwd) {
        $stmt = $this->connect()->prepare('SELECT user_pwd FROM users WHERE user_email = ?;');

        if(!$stmt->execute(array($email))){
            $stmt = null;
            $_SESSION["system_msg"] = "OOPS! 發生了一些錯誤";
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0){
            $stmt = null;
            $_SESSION["system_msg"] = "帳號或密碼錯誤";
            header("location: ../login.php?error=usernotfound");
            exit();
        }

        // $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $checkPwd = password_verify($pwd, $pwdHashed[0]["user_pwd"]);
        $getPwd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = false;
        if($pwd == $getPwd[0]["user_pwd"]){
            $checkPwd = true;
        }else{
            $checkPwd = false;
        }

        if($checkPwd == false){
            $stmt = null;
            $_SESSION["system_msg"] = "帳號或密碼錯誤";
            header("location: ../login.php?error=usernotfound");
            exit();
        } elseif($checkPwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_email = ? AND user_pwd = ?;');

            if(!$stmt->execute(array($email, $pwd))){
                $stmt = null;
                $_SESSION["system_msg"] = "OOPS! 發生了一些錯誤";
                header("location: ../login.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                $_SESSION["system_msg"] = "帳號或密碼錯誤";
                header("location: ../login.php?error=usernotfound");
                exit();
            }
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["userid"] = $user[0]["user_id"];
            $_SESSION["username"] = $user[0]["user_name"];
            $_SESSION["useremail"] = $user[0]["user_email"];
            $_SESSION["permission"] = $user[0]["permission"];

            $stmt = null;
        }
        $stmt = null;
    }
}

?>
<?php

class Signup extends Dbh{

    protected function setUser($name, $email, $pwd) {
        $stmt = $this->connect()->prepare('INSERT INTO users (user_name, user_email, user_pwd, permission) VALUES (?, ?, ?, ?);');

        //加密密碼
        //$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        $permission = "user";

        if(!$stmt->execute(array($name, $email, $pwd, $permission))){
            $stmt = null;
            $_SESSION["system_msg"] = "系統異常，請重新嘗試 [stmtfailed]";
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function checkUser($email) {
        $stmt = $this->connect()->prepare('SELECT user_email FROM users WHERE user_email = ?;');

        if(!$stmt->execute(array($email))){
            $stmt = null;
            $_SESSION["system_msg"] = "系統異常，請重新嘗試 [stmtfailed]";
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }

        $resultCheck = false;
        if($stmt->rowCount() > 0){
            $resultCheck = false;
        }else{
            $resultCheck = true;
        }
        return $resultCheck;

    }

}

?>
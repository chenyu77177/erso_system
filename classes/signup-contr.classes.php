<?php
session_start();
class SignupContr extends Signup{

    private $name;
    private $email;
    private $pwd;
    private $pwdRepeat;

    public function __construct($name, $email, $pwd, $pwdRepeat)
    {
        $this->name = $name;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        
    }

    public function signupUser() {
        if($this->emptyInput() == false){
            // echo "Empty input!";
            $_SESSION["system_msg"] = "欄位不能空白";
            header("location: ../signup.php?error=emptyinput");
            exit();
        }
        // if($this->invalidUid() == false){
        //     // echo "invalid username!";
        //     header("location: ../signup.php?error=username");
        //     exit();
        // }
        if($this->invalidEmail() == false){
            // echo "invalid email!";
            $_SESSION["system_msg"] = "欄位不能空白 [Email]";
            header("location: ../signup.php?error=emptyinput");
            exit();
        }
        if($this->pwdMatch() == false){
            // echo "Passwords don't match!";
            $_SESSION["system_msg"] = "密碼與重複密碼不符";
            header("location: ../signup.php?error=passwordmatch");
            exit();
        }
        if($this->uidTakenCheck() == false){
            // echo "Username or email taken!";
            $_SESSION["system_msg"] = "該Email已註冊過";
            header("location: ../signup.php?error=usernameoremailtaken");
            exit();
        }

        $this->setUser($this->name, $this->email, $this->pwd);
    }

    private function emptyInput(){
        $result = false;
        if(empty($this->name) || empty($this->email || empty($this->pwd) || empty($this->pwdRepeat))){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }

    private function invalidUid(){
        $result = false;
        if(!preg_match("/^[a-zA-Z0-9]*$/", $this->uid)){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }

    private function invalidEmail(){
        $result = false;
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }

    private function pwdMatch(){
        $result = false;
        if($this->pwd !== $this->pwdRepeat){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }

    private function uidTakenCheck(){
        $result = false;
        if(!$this->checkUser($this->email)){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }
}

?>
<?php
    class EmailVerifyContr extends EmailVerify{
        private $email;

        public function __construct($email)
        {
            $this->email = $email;
        }

        //取得驗證狀態
        public function getVerifyState(){
            if($this->emptyUser() == false){
                header("location: ../login.php?error=emptyUser");
                exit();
            }
            return $this->verifyState($this->email);
        }

        //設定驗證資料
        public function setVerifyKey(){
            if($this->emptyUser() == false){
                header("location: ../login.php?error=emptyUser");
                exit();
            }
            $this->insertKey($this->email);
        }

        //設定驗證狀態
        public function setVerifyState($email, $key){
            if(isset($email) == false || isset($key) == false){
                header("location: ../index.php?error=emptyEmailAndKey");
                exit();
            }
            return $this->verifyEmail($email, $key);
        }

        //寄信
        public function sendEmail(){
            if($this->emptyUser() == false){
                header("location: ../login.php?error=emptyUser");
                exit();
            }
            $this->sendLetter($this->email);
        }

        //重新寄信
        public function resendEmail(){
            if($this->emptyUser() == false){
                header("location: ../login.php?error=emptyUser");
                exit();
            }
            return $this->resendLetter($this->email);
        }

        //空值檢查
        private function emptyUser(){
            $result = false;
            if(!isset($this->email)){
                $result = false;
            }else{
                $result = true;
            }
            return $result;
        }
    }
?>

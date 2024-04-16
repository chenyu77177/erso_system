<?php
    //session_start();
    class PersonalInfoContr extends PersonalInfo{
        private $email;

        public function __construct($email)
        {
            $this->email = $email;
        }

        public function personalInfo(){
            if($this->emptyUser() == false){
                header("location: ../login.php?error=emptyUser");
                exit();
            }
            $this->getUserInfo($this->email);
        }

        public function updateInfo($newName){
            if($this->emptyUser() == false){
                header("location: ../login.php?error=emptyUser");
                exit();
            }

            if($this->emptyInput($newName)){
                header("location: ../personal-Info.php?error=emptyName");
                exit();
            }

            $this->updateUserInfo($this->email,$newName);
        }

        private function emptyUser(){
            $result = false;
            if(!isset($_SESSION["useremail"])){
                $result = false;
            }else{
                $result = true;
            }
            return $result;
        }

        private function emptyInput($value){
            $result = true;
            if(empty($value)){
                $result = true;
            }else{
                $result = false;
            }
            return $result;
        }
    }
?>
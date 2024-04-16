<?php
    //將PHPMailer類導入全局命名空間
    //這些必須在腳本的頂部，而不是在函數內部
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class EmailVerify extends Dbh{

        //取得驗證狀態
        protected function verifyState($email) {
            $stmt = $this->connect()->prepare('SELECT verify_state FROM email_verify WHERE user_email = ?;');

            if(!$stmt->execute(array($email))){
                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() ==0){
                $stmt = null;
                $_SESSION["system_msg"] = "尚未註冊";
                header("location: ../login.php?error=usernotfound");
                exit();
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

            //$_SESSION["verifyState"] = $user[0]["verify_state"];
        }

        //驗證email
        protected function verifyEmail($email, $key) {
            $resultMSG = "";
            if($this->checkUserVerify($email)){
                if(!$this->checkEmailVerifyState($email)){
                    $stmt = $this->connect()->prepare('UPDATE email_verify SET verify_state = ? WHERE user_email = ? AND verify_key = ?');
                    $stmt->execute(array(true, $email, $key));
                    if($stmt->rowCount() > 0 ){
                        $resultMSG =  "驗證成功";
                    }else{
                        $resultMSG =  "驗證失敗";
                    }
                }else{
                    $resultMSG =  "該帳號已驗證過";
                }
                
            }else{
                $resultMSG =  "無資料";
            }
            return $resultMSG;
        }

        //新增驗證資料並產生驗證碼
        protected function insertKey($email) {
            if($this->checkUserSignup($email)){
                $stmt = $this->connect()->prepare('INSERT INTO email_verify(user_email, verify_key, verify_state, verify_startTime) VALUES(?, ?, ?, ?)');

                $key = $this->generateRandomString();
                $timeNow = date("Y-m-d H:i:s");
                echo $timeNow . "<br>";
                echo $key;

                if(!$stmt->execute(array($email, $key, false, $timeNow))){
                    $stmt = null;
                    header("location: ../signup.php?error=stmtfailed");
                    exit();
                }
        
                $stmt = null;
            }
        }

        //產生隨機字串
        private function generateRandomString($length = 15) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        //檢查使用者是否註冊
        private function checkUserSignup($email) {
            $stmt = $this->connect()->prepare('SELECT user_email FROM users where user_email = ?');

            $stmt->execute(array($email));
            $resultCheck = false;
            if($stmt->rowCount() > 0){
                $resultCheck = true;
            }else{
                $resultCheck = false;
            }
            return $resultCheck;
        }

        //檢查使用者驗證資料是否存在
        private function checkUserVerify($email) {
            $stmt = $this->connect()->prepare('SELECT user_email FROM email_verify where user_email = ?');

            $stmt->execute(array($email));
            $resultCheck = false;
            if($stmt->rowCount() > 0){
                $resultCheck = true;
            }else{
                $resultCheck = false;
            }
            return $resultCheck;
        }

        //檢查使用者是否已驗證
        private function checkEmailVerifyState($email) {
            $stmt = $this->connect()->prepare('SELECT verify_state FROM email_verify where user_email = ?');

            $stmt->execute(array($email));
            $state = $stmt->fetchAll();
            $resultCheck = $state[0]["verify_state"];
            // if($state["verify_state"]){
            //     $resultCheck = true;
            // }else{
            //     $resultCheck = false;
            // }
            // $stmt = null;
            return $resultCheck;
        }

        //取得使用者已產生的驗證碼
        private function getUserVerifyKey($email) {
            $stmt = $this->connect()->prepare('SELECT verify_key FROM email_verify where user_email = ?');

            $stmt->execute(array($email));
            $fdata = $stmt->fetchAll();
            
            if($stmt->rowCount() > 0){
                $resultKey = $fdata[0]["verify_key"];
            }else{
                $resultKey = null;
            }
            return $resultKey;
        }

        //取得使用者名字
        private function getUserName($email) {
            $stmt = $this->connect()->prepare('SELECT user_name FROM users where user_email = ?');

            $stmt->execute(array($email));
            $fdata = $stmt->fetchAll();
            
            if($stmt->rowCount() > 0){
                $resultName = $fdata[0]["user_name"];
            }else{
                $resultName = null;
            }
            return $resultName;
        }
        
        //寄信
        protected function sendLetter($userEmail){

            if(!$this->checkUserSignup($userEmail)){
                header("location: ../signup.php?error=userNotSignup");
                exit();
            }
            if(!$this->checkUserVerify($userEmail)){
                header("location: ../signup.php?error=userVerifyDataNull");
                exit();
            }

            $username = $this->getUserName($userEmail);
            $key = $this->getUserVerifyKey($userEmail);
            $server_ip = $_SERVER['SERVER_ADDR'];
            $link = 'http://' . $server_ip . '/erso_System/email-verify.php?email=' . $userEmail . '&key=' . $key;
            $link2 = 'http://localhost/erso_System/email-verify.php?email=' . $userEmail . '&key=' . $key;
            $verifyPage = 'http://' . $server_ip . '/erso_System/email-verify.php?email=' . $userEmail;
            $verifyPage2 = 'http://localhost/erso_System/email-verify.php?email=' . $userEmail;

            //echo '<h3>' . $username . ' 您好!</h3><br><p>感謝您加入成為 erso 的會員，麻煩您點擊下方連結進行信箱驗證：</p><br>' . $link . '<br><p>或，至驗證頁面輸入驗證碼「' . $key .'」進行驗證</p><p>驗證頁面：</p>' . $verifyPage;
            

            //Load Composer 的自動加載器
            require '../vendor/autoload.php';

            //創建一個實例； 傳遞 `true` 啟用異常
            $mail = new PHPMailer(true);
            //解決中文亂碼
            $mail->CharSet = 'utf-8';

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //啟用詳細調試輸出
                $mail->isSMTP();                                            //使用 SMTP 發送
                $mail->Host       = 'smtp.gmail.com';                     //設置要通過的 SMTP 服務器發送
                $mail->SMTPAuth   = true;                                   //啟用 SMTP 身份驗證
                $mail->Username   = 'erso.system@gmail.com';                     //SMTP 用戶名
                $mail->Password   = 'fmtostmxzprqwzcy';                               //SMTP 密碼
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //啟用隱式 TLS 加密
                $mail->Port       = 465;                                    //要連接的 TCP 端口； 如果您設置了 `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`，請使用 587

                //加載中文版本
                $mail -> setLanguage ( 'zh' , '../vendor/phpmailer/phpmailer/language/' );

                //收件人
                $mail->setFrom("erso.system@gmail.com", '系統'); //寄件人
                $mail->addAddress($userEmail);     //收件人
                //$mail->addAddress('ellen@example.com');               //名稱是可選的
                $mail->addReplyTo('erso.system@gmail.com', '客服'); //回覆的信箱
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //附件
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //添加附件
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //可選名稱

                //內容
                $mail->isHTML(true);                                  //將電子郵件格式設置為 HTML
                $mail->Subject = 'erso 租借交易平台 信箱驗證';  //主題
                
                $mail->Body = '<h3>' . $username . ' 您好!</h3><br><p>感謝您加入成為 erso 的會員，麻煩您點擊下方連結進行信箱驗證：</p><br>' . $link . '<br><p>備用連結：</p>' . $link2 . '<p>或，至驗證頁面輸入驗證碼「' . $key .'」進行驗證</p><p>驗證頁面：</p>' . $verifyPage . '<p>備用連結：</p>' . $verifyPage2;  //內容(HTML)
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';  //內容(純文字)

                $mail->send();
                echo '信件已發送';
            } catch (Exception $e) {
                echo "無法發送消息。 郵件錯誤: {$mail->ErrorInfo}";
            }
        }

        //重新寄信
        protected function resendLetter($userEmail){

            if(!$this->checkUserSignup($userEmail)){
                $_SESSION["system_msg"] = "該使用者尚未註冊";
                header("location: ../email-verify.php?error=userNotSignup");
                exit();
            }
            if(!$this->checkUserVerify($userEmail)){
                $_SESSION["system_msg"] = "該使用者的驗證資料不存在";
                header("location: ../email-verify.php?error=userVerifyDataNull");
                exit();
            }

            $username = $this->getUserName($userEmail);
            $key = $this->getUserVerifyKey($userEmail);
            $server_ip = $_SERVER["SERVER_ADDR"];
            $link = 'http://' . $server_ip . '/erso_System/email-verify.php?email=' . $userEmail . '&key=' . $key;
            $link2 = 'http://localhost/erso_System/email-verify.php?email=' . $userEmail . '&key=' . $key;
            $verifyPage = 'http://' . $server_ip . '/erso_System/email-verify.php?email=' . $userEmail;
            $verifyPage2 = 'http://localhost/erso_System/email-verify.php?email=' . $userEmail;

            //echo '<h3>' . $username . ' 您好!</h3><br><p>感謝您加入成為 erso 的會員，麻煩您點擊下方連結進行信箱驗證：</p><br>' . $link . '<br><p>或，至驗證頁面輸入驗證碼「' . $key .'」進行驗證</p><p>驗證頁面：</p>' . $verifyPage;
            

            //Load Composer 的自動加載器
            require '../vendor/autoload.php';

            //創建一個實例； 傳遞 `true` 啟用異常
            $mail = new PHPMailer(true);
            //解決中文亂碼
            $mail->CharSet = 'utf-8';

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //啟用詳細調試輸出
                $mail->isSMTP();                                            //使用 SMTP 發送
                $mail->Host       = 'smtp.gmail.com';                     //設置要通過的 SMTP 服務器發送
                $mail->SMTPAuth   = true;                                   //啟用 SMTP 身份驗證
                $mail->Username   = 'erso.system@gmail.com';                     //SMTP 用戶名
                $mail->Password   = 'fmtostmxzprqwzcy';                               //SMTP 密碼
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //啟用隱式 TLS 加密
                $mail->Port       = 465;                                    //要連接的 TCP 端口； 如果您設置了 `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`，請使用 587

                //加載中文版本
                $mail -> setLanguage ( 'zh' , '../vendor/phpmailer/phpmailer/language/' );

                //收件人
                $mail->setFrom("erso.system@gmail.com", '系統'); //寄件人
                $mail->addAddress($userEmail);     //收件人
                //$mail->addAddress('ellen@example.com');               //名稱是可選的
                $mail->addReplyTo('erso.system@gmail.com', '客服'); //回覆的信箱
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //附件
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //添加附件
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //可選名稱

                //內容
                $mail->isHTML(true);                                  //將電子郵件格式設置為 HTML
                $mail->Subject = 'erso 租借交易平台 信箱驗證';  //主題
                
                $mail->Body = '<h3>' . $username . ' 您好!</h3><br><p>感謝您加入成為 erso 的會員，麻煩您點擊下方連結進行信箱驗證：</p><br>' . $link . '<br><p>備用連結：</p>' . $link2 . '<p>或，至驗證頁面輸入驗證碼「' . $key .'」進行驗證</p><p>驗證頁面：</p>' . $verifyPage . '<p>備用連結：</p>' . $verifyPage2;  //內容(HTML)
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';  //內容(純文字)

                $mail->send();
                return "驗證信件已寄出，收件信箱：{$userEmail}";
            } catch (Exception $e) {
                return "無法發送消息。 郵件錯誤: {$mail->ErrorInfo}";
            }
        }
        
    }
?>
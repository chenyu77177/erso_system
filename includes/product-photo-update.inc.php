<?php
    session_start();
    //echo $_SESSION["productId"];
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        //實例化類別
        include "../classes/dbh.classes.php";
        include "../classes/product.classes.php";
        include "../classes/product-contr.classes.php";

        $prod = new ProductContr(null,null);

        $product_id = $_POST["productId"];

        //photo_remove存在，表示要刪除圖片
        if(isset($_POST["photo_remove"])){
            //取得資料
            $photo_id = $_POST["photo_id"];
            $photo_path = "../" . $_POST["photo_path"];
            //執行相片刪除方法
            if($prod->removePhoto($photo_id)){
                //實體檔案刪除
                if(file_exists($photo_path)){
                    unlink($photo_path);
                    $_SESSION["system_msg"] = "相片已刪除成功!";
                }else{
                    $_SESSION["system_msg"] = "相片刪除失敗!";
                }
            }else{
                $_SESSION["system_msg"] = "相片刪除失敗!";
            }
        }

        //photo_upload存在，表示要新增圖片
        if(isset($_POST["photo_upload"])){
            if($prod->uploadPhoto($product_id)){
                $_SESSION["system_msg"] = "相片上傳成功!";
            }else{
                $_SESSION["system_msg"] = "相片上傳失敗!";
            }
        }
  
        $next_link = "../rent-update.php?productId=" . strval($product_id);
        header("Location: " . $next_link);
        exit();
        //回首頁
        // echo $result;
        //die($_SESSION["productId"]);
    
    }else{
        echo "post_not";
    }
?>
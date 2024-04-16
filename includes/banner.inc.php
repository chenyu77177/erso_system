<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //實例化 BannerContr 類別
        include "../classes/dbh.classes.php";
        include "../classes/banner.classes.php";
        include "../classes/banner-contr.classes.php";

    }
    if(isset($_POST["getBanner"])){

        $prod = new BannerContr();

        echo $prod->getBanner();
    }else if(isset($_POST["photo_upload"])){
        //上傳新橫幅

        $prod = new BannerContr();

        if($prod->uploadPhoto()){
            $_SESSION["system_msg"] = "相片上傳成功!";
        }else{
            $_SESSION["system_msg"] = "相片上傳失敗!";
        }
  
        $next_link = "../banner-update.php";
        header("Location: " . $next_link);
        exit();

    }else if(isset($_POST["photo_remove"])){
        //刪除橫幅圖片

        $prod = new BannerContr();
        //取得資料
        $banner_id = $_POST["banner_id"];
        $photo_path = "../assets/banner/" . $_POST["photo_name"];
        //執行相片刪除方法
        if($prod->removeBanner($banner_id)){
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
        $next_link = "../banner-update.php";
        header("Location: " . $next_link);
        exit();
    }else{
        echo "post_error";
    }
?>
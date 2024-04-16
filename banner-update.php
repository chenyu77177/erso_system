<?php
session_start();
// if(!isset($_GET["productId"])){
//     header("location: index.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/bootstrap.bundle.min.js"></script>
      <title>首頁橫幅管理 - erso租借交易平台</title>
    </head>
    <body>
        <?php 
            include("header.php");
        ?>
        <section>
            <div class="my-3">
                <div class="container">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">首頁橫幅廣告管理</li>
                        </ol>
                    </nav>
                    <div id="start">
                        <?php
                        // if(!isset($_GET["productId"]) || empty($_GET["productId"])){
                        //     echo "<div class='container border rounded text-center py-3'>OOPS!!找不到資料</div>";
                        //     exit();
                        // }
                        ?>
                        <!-- <form action="includes/product-update.inc.php" method="POST" enctype="multipart/form-data"> -->
                        <div class="p-4 border border-1 rounded">
                            <h3 class="pb-3">橫幅廣告</h3>
                            <div class="row">
                                <!-- <div class="col-2">
                                    <p>商品圖片<span class="text-danger">*</span></p>
                                </div> -->
                                <div class="col-12">
                                    <div class="row" id="img_list">
                                        Loading...
                                    </div>
                                    <!-- 上傳新圖片 -->
                                    <!-- <div class="col-12 border bg-light rounded p-2 mb-3">
                                            <p>新增圖片</p>
                                            <img src="" alt="圖片" id="product_img_add" height="150px"/>
                                            <form action="includes/product-photo-update.inc.php" method="POST" enctype="multipart/form-data">
                                                <p><input type="file" class="form-control my-3" id="img_add" name="img" onchange="upload_preview_file(event,'_add')"/></p>
                                                <button class="btn btn-success d-block" id="photo_upload" type="submit" name="photo_upload" disabled>上傳</button>
                                            </form>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

    </body>
    <script>
        let photo = "";
        let img_list_tag = document.getElementById("img_list");
        

        function getPhoto(){
            var fdata = new FormData();
            fdata.append('getBanner', true);
            //透過表單送出資料(非同步傳輸)至後端處理程式
            fetch('includes/banner.inc.php',
            {
                method: 'post',
                body: fdata
            })
            .then(function(response) {
            return response.text();
            })
            .then(function(data) {
                let print_img_list = '';
                console.log(data);
                if(data == "nullData"){
                    print_img_list += '<div class="col bg-light rounded p-2 m-1">';
                    print_img_list += '<p>新增圖片</p>'
                    print_img_list += '<img src="" alt="新圖片" id="new_banner" height="150px"/>';
                    print_img_list += '<form action="includes/banner.inc.php" method="POST" enctype="multipart/form-data">';
                    print_img_list += '    <p><input type="file" class="form-control my-3" id="img_add" name="img" onchange="upload_preview_file(event)"/></p>';
                    print_img_list += '    <button class="btn btn-success d-block" id="photo_upload" type="submit" name="photo_upload" disabled>上傳</button>';
                    print_img_list += '</form>';
                    print_img_list += '</div>';
                    img_list_tag.innerHTML = print_img_list;
                    return;
                }

                photo = JSON.parse(data);
                console.log(photo);
                
                
                for(i = 0; i < photo.length; i++){
                    // let id = i+1;
                    // //取得圖片標籤
                    // let img = document.getElementById("product_img" + id);
                    // //設定圖片路徑
                    // img.src = photo[i]["path"] + photo[i]["photo_name"];
                    // //取得圖片id標籤
                    // let photo_id_tag = document.getElementById("photo_id" + id);
                    // //設定圖片id資料
                    // photo_id_tag.value = photo[i]["rent_photo_id"];
                    // //取得圖片路徑標籤
                    // let photo_path_tag = document.getElementById("photo_name" + id);
                    // //設定圖片路徑資料
                    // photo_path_tag.value = photo[i]["path"] + photo[i]["photo_name"];
                    print_img_list += '<div class="col bg-light rounded p-2 m-1">';
                    // if(i == 0){
                    //     print_img_list += '<p>圖片<span class="text-danger">*</span></p>';
                    // }else{
                    //     print_img_list += '<p>圖片</p>';
                    // }
                    print_img_list += '<img src="assets/banner/' + photo[i]["photo_name"] + '" alt="圖片" id="banner_' + photo[i]["banner_id"] + '" height="150px" />';
                    print_img_list += '<form action="includes/banner.inc.php" method="POST" enctype="multipart/form-data">';
                    print_img_list += '<input type="hidden" name="banner_id" value="' + photo[i]["banner_id"] + '">';
                    print_img_list += '<input type="hidden" name="photo_name" value="' + photo[i]["photo_name"] + '">';
                    print_img_list += '<button class="btn btn-danger m-2" type="submit" name="photo_remove">刪除</button>';
                    print_img_list += '</form>';
                    print_img_list += '</div>';
                }

                //新增圖片
                let id = "_add";
                print_img_list += '<div class="col bg-light rounded p-2 m-1">';
                print_img_list += '<p>新增圖片</p>'
                print_img_list += '<img src="" alt="新圖片" id="new_banner" height="150px"/>';
                print_img_list += '<form action="includes/banner.inc.php" method="POST" enctype="multipart/form-data">';
                print_img_list += '    <p><input type="file" class="form-control my-3" id="img_add" name="img" onchange="upload_preview_file(event)"/></p>';
                print_img_list += '    <button class="btn btn-success d-block" id="photo_upload" type="submit" name="photo_upload" disabled>上傳</button>';
                print_img_list += '</form>';
                print_img_list += '</div>';
                
                console.log(data);
                img_list_tag.innerHTML = print_img_list;
                
                // console.log(photos);
                // var photo_print = document.getElementById("product_photo");
                // photo_print.innerHTML = photos;
                // var photo_ctrl_print = document.getElementById("photo_ctrl");
                // photo_ctrl_print.innerHTML = photo_ctrl;
            });
        }

        getPhoto();

        function upload_preview_file(event, id) {
            var selected_file = event.target.files[0];
            var reader = new FileReader(); 
            var img_tag = document.getElementById("new_banner");
            //上傳圖片按鈕標籤
            let photo_upload_tag = document.getElementById("photo_upload");
        
            reader.onload = function(event) {
            img_tag.src = event.target.result;
            //設定上傳圖片按鈕為可點選
            photo_upload_tag.removeAttribute("disabled");
            };
        
            reader.readAsDataURL(selected_file);
        }

    </script>

</html>
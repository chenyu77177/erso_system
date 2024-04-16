<?php
session_start();
// if(!isset($_SESSION["userid"])){
//     header("Location: login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/bootstrap.bundle.min.js"></script>
      <title>首頁 - erso租借交易平台</title>
    </head>
    <body>
        <?php 
            include("header.php");
        ?>
        <section>
            <p><br/></p>
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-12">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators" id="banner_btn">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                </div>
                                <div class="carousel-inner rounded" id="banner_list">
                                    <div class="carousel-item active">
                                    <img src="assets/img/loading.gif" class="d-block w-100" style="height: 440px; object-fit:cover;" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                    <img src="assets/img/loading.gif" class="d-block w-100" style="height: 440px; object-fit:cover;" alt="...">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="p-4 col-md-4 col-12 bg-light rounded">
                            <div class="text-center"><h3>商品分類</h3></div>
                            <div class="row" id="category_btn">
                                <!-- <div class="col-4 w-100 m-1 text-cente">
                                    <a class="btn btn-secondary d-block">工具</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p><br/></p>

            <div class="container">
            <h3>商品展示</h3>
                <div class="row mb-3" id="card_list">
                    <div class="col-md-3 col-6">
                        <div class="card" style="width: 18rem;">
                            <img src="assets/img/loading.gif" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Loading...</span></h5>
                                <p class="card-text"></p>
                                <!-- <a href="#" class="btn btn-primary">...</a> -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="card" style="width: 18rem;">
                            <img src="assets/img/loading.gif" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Loading...</span></h5>
                                <p class="card-text"></p>
                                <!-- <a href="#" class="btn btn-primary">...</a> -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="card" style="width: 18rem;">
                            <img src="assets/img/loading.gif" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Loading...</span></h5>
                                <p class="card-text"></p>
                                <!-- <a href="#" class="btn btn-primary">...</a> -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="card" style="width: 18rem;">
                            <img src="assets/img/loading.gif" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Loading...</span></h5>
                                <p class="card-text"></p>
                                <!-- <a href="#" class="btn btn-primary">...</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </body>
</html>

<script>
    function getProduct(){
        let fdata = new FormData();
        let quantity = 12;
        fdata.append('quantity', quantity);
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fetch('includes/product-get-rand.inc.php',
        {
            method: 'post',
            body: fdata
        })
        .then(function(response) {
        return response.text();
        })
        .then(function(data) {
            console.log(JSON.parse(data));
            let card_list_tag = document.getElementById("card_list");
            let card_list = '';
            let product = JSON.parse(data);
            // let msg_tag = document.getElementById("msg");
            
            // let previou = "";

            // console.log(data);
            // if(data == "nullData"){
            //     rent_table.innerHTML = "";
            //     msg_tag.innerHTML = "您尚未建立商品";
            //     return;
            // }else{
            //     product = JSON.parse(data); //全域變數
            // }
            
            // console.log(product);
            let print_rent_id_array = Array();
            for(i = 0; i < product.length; i++){
                if(print_rent_id_array.includes(product[i]["rent_id"])){
                    continue;
                }
                print_rent_id_array.push(product[i]["rent_id"])
                let card_data = '';
                let path = product[i]["path"] + product[i]["photo_name"];
                let title = product[i]["title"];
                if(title.length >= 20){
                    title = title.substr(0,20) + " ...";
                }
                let intro = product[i]["intro"];
                if(intro.length >= 50){
                    intro = intro.substr(0,50) + " ...";
                }
                let productId = product[i]["rent_id"];
                card_data += '<div class="mb-3 col-xl-3 col-lg-4 justify-content-center">';
                card_data += '    <div class="card" style="width: 18rem;">';
                card_data += '        <img src="' + path + '" class="card-img-top" style="height:200px; object-fit:cover;" alt="...">';
                card_data += '        <div class="card-body">';
                card_data += '            <h5 class="card-title" style="height:50px;">' + title + '</h5>';
                card_data += '            <p class="card-text" style="height:80px;">' + intro + '</p>';
                card_data += '            <a href="rent.php?productId=' + productId + '" class="btn btn-primary stretched-link">檢視商品</a>';
                card_data += '        </div>';
                card_data += '    </div>';
                card_data += '</div>';
                card_list += card_data;
            }
            // if(product.length = 0){
            //     rent_table.innerHTML = '無資料';
            // }else{
            //     rent_table.innerHTML = rent_data;
            // }
            card_list_tag.innerHTML = card_list;
        });
    }

    function getProductCategory(){
        var fdata = new FormData();
        fdata.append('productCategory', "");
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fetch('includes/product.inc.php',
        {
            method: 'post',
            body: fdata
        })
        .then(function(response) {
        return response.text();
        })
        .then(function(data) {
            console.log(data);
            var product_category = JSON.parse(data);
            console.log(product_category);
            let category_btn_tag = document.getElementById("category_btn");
            let btn_print = '';
            for(i = 0; i < product_category.length; i++){
                id = i + 1;
                btn_print += '<div class="col-4 w-100 m-1 text-cente">';
                btn_print += '    <a class="btn btn-secondary d-block" href="search.php?category=' + product_category[i]["product_category_id"] + '">' + product_category[i]["category_name"] + '</a>';
                btn_print += '</div>';
            }
            category_btn_tag.innerHTML = btn_print;
        });
        
    }

    function getBanner(){
        let banner_list_tag = document.getElementById("banner_list");
        let banner_btn_tag = document.getElementById("banner_btn");
        let fdata = new FormData();
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
            let banner_list = '';
            let banner_btn_list = '';
            console.log(data);
            if(data == "nullData"){
                //相片
                banner_list += '<div class="carousel-item active">';
                banner_list += '<img src="assets/img/loading.jpg" class="d-block w-100" style="height: 440px; object-fit:cover;" alt="...">';
                banner_list += '</div>';
                banner_list += '<div class="carousel-item">';
                banner_list += '<img src="assets/img/loading.jpg" class="d-block w-100" style="height: 440px; object-fit:cover;" alt="...">';
                banner_list += '</div>';

                //按鈕
                banner_btn_list += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                banner_btn_list += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>';

                banner_list_tag.innerHTML = banner_list;
                banner_btn_tag.innerHTML = banner_btn_list;
                return;
            }

            photo = JSON.parse(data);
            console.log(photo);
            
            
            for(i = 0; i < photo.length; i++){
                if(i == 0){
                    //相片
                    banner_list += '<div class="carousel-item active">';
                    banner_list += '<img src="assets/banner/' + photo[i]["photo_name"] + '" class="d-block w-100" style="height: 440px; object-fit:cover;" alt="...">';
                    banner_list += '</div>';

                    //按鈕
                    banner_btn_list += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label=""></button>';
                    
                    continue;
                }
                //相片
                banner_list += '<div class="carousel-item">';
                banner_list += '<img src="assets/banner/' + photo[i]["photo_name"] + '" class="d-block w-100" style="height: 440px; object-fit:cover;" alt="...">';
                banner_list += '</div>';

                //按鈕
                banner_btn_list += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' + i + '" aria-label=""></button>';
            }
            
            banner_list_tag.innerHTML = banner_list;
            banner_btn_tag.innerHTML = banner_btn_list;
        });
    }

    getProductCategory();
    getProduct();
    getBanner();
</script>
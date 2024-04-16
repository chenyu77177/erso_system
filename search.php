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
      <title>搜尋 - erso租借交易平台</title>
    </head>
    <body>
        <?php 
            include("header.php");
        ?>
        <section>
            <p><br/></p>
            <div class="container">
            <div class="shadow-sm border rounded text-center p-4 my-3">
                <form action="includes/product-search.inc.php" method="POST" class='row'>
                    <h4 class="text-start">關鍵字搜尋</h4>
                    <div class="col-11">
                        <input type="text" class="form-control text-center" id="key" name="keyword" value="" placeholder="請輸入商品名稱" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" name="search" class="btn btn-secondary">搜尋</button>
                    </div>
                </form>
                <hr>
                <h4 class="text-start">分類搜尋</h4>
                <div class="row">
                    <div class="col-11">
                        <select id="product_category" class="form-select" aria-label="Default select example" name="productCategory" onchange="category_search();" required>
                            <option disabled>請選擇分類</option>
                            <option value="1" selected>--</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <!-- <button type="submit" name="search" onclick="category_search();" class="btn btn-secondary">搜尋</button> -->
                    </div>
                </div>
            </div>
            

            <hr class="my-4">
            <h4>搜尋結果</h4>
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
    function checkGET(){
        let category_id = <?php if(isset($_GET["category"])){echo $_GET["category"];}else{echo "null";} ?>;
        return category_id;
    }

    function getSearchProduct(){
        let product_data = <?php if(isset($_SESSION["product_data"])){echo $_SESSION["product_data"];}else{echo "null";} ?>;
        <?php unset($_SESSION["product_data"]); ?>
        return product_data;
    }

    function getKeyword(){
        let keyword = "<?php if(isset($_SESSION["keyword"])){echo $_SESSION["keyword"];}else{echo "null";} ?>";
        <?php unset($_SESSION["keyword"]); ?>   
        return keyword;
    }

    function category_search(){
        let category_select_tag = document.getElementById("product_category");
        category_select = category_select_tag.value;
        getCategoryProduct(category_select);
    }

    //取得指定分類之商品
    function getCategoryProduct(category_id){
        let fdata = new FormData();
        fdata.append('categoryId', category_id);
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fetch('includes/product-search.inc.php',
        {
            method: 'post',
            body: fdata
        })
        .then(function(response) {
        return response.text();
        })
        .then(function(data) {
            if(data == "nullData"){
                show_card(null);
            }else{
                show_card(JSON.parse(data));
            }

        });
    }

    //取得所有分類之資訊
    function getCategoryInfo(){
        let fdata = new FormData();
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
            if(data == "nullData"){
                return;
            }
            let product_category = JSON.parse(data);
            // console.log(product_category);
            let product_category_tag = document.getElementById("product_category");
            let option_print = '';
            let current_category_id = checkGET();
            if(current_category_id == "null"){
                option_print += '<option value="0" selected >請選擇商品分類...</option>';
            }else{
                option_print += '<option value="0" >請選擇商品分類...</option>';
            }
            for(i = 0; i < product_category.length; i++){
                if(current_category_id == "null"){
                    // option_print += '<option value="' + product_category[i]["product_category_id"] + '" >' + product_category[i]["category_name"] + '</option>';
                }
                if(current_category_id == i + 1){
                    option_print += '<option value="' + product_category[i]["product_category_id"] + '" selected >' + product_category[i]["category_name"] + '</option>';
                    continue;
                }
                let category_name = product_category[i]["category_name"];
                option_print += '<option value="' + product_category[i]["product_category_id"] + '" >' + category_name + '</option>';
            }
            product_category_tag.innerHTML = option_print;
        });

        
    }

    function show_card(data){
        let card_list_tag = document.getElementById("card_list");
        let card_list = '';
        let product = data;
        if(product == null){
            card_list_tag.innerHTML = "<div class='container border rounded text-center py-3 mt-3'>沒有符合的商品</div>";
        }else{
            console.log(product);
            let rent_id_array = Array();
            for(i = 0; i < product.length; i++){
                let card_data = '';
                if(!rent_id_array.includes(product[i]["rent_id"])){
                    rent_id_array.push(product[i]["rent_id"]);
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
                    card_data += '<div class="mb-3 col-xxl-3 col-xl-4 col-md-6 justify-content-center">';
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
            }
            card_list_tag.innerHTML = card_list;
        }

    }

    let keyword_tag = document.getElementById("key");
    let keyword = getKeyword();
    if(keyword != "null"){
        console.log(keyword);
        keyword_tag.value = keyword;
        show_card(getSearchProduct());
    }else{
        show_card(null);
    }

    let category = checkGET();
    if(category != null){
        getCategoryInfo();
        getCategoryProduct(category);
    }else{
        getCategoryInfo();
    }
    
    
</script>
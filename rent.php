<?php
session_start();
// if(!isset($_SESSION["userid"])){
//     header("Location: login.php");
//     exit();
// }

//判斷連結是否有帶入資料
if(isset($_GET["productId"])){

}
?>

<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/bootstrap.bundle.min.js"></script>
      <title>商品 - erso租借交易平台</title>
    </head>
    <body>
        <?php 
            include("header.php");
        ?>
        <section>
            <div>
                <div class="container">
                    <div class="row" id="content">
                        <?php
                        if(!isset($_GET["productId"]) || empty($_GET["productId"])){
                            echo "<div class='container border rounded text-center py-3 mt-3'>OOPS!!找不到資料</div>";
                            exit();
                        }
                        ?>
                        <div class="col-lg-6 col-12 my-4">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators" id="photo_ctrl">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                </div>
                                <div class="carousel-inner" id="product_photo">
                                    <div class="carousel-item active">
                                    <img src="assets/img/loading.jpg" class="d-block w-100" style="height: 440px; object-fit:cover;" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                    <img src="assets/background/background1.jpg" class="d-block w-100" style="height: 440px;" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                    <img src="assets/background/background1.jpg" class="d-block w-100" style="height: 440px;" alt="...">
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
                        <!-- --- -->
                        <div class="col-lg-6 col-12 my-4">
                            <div class="container">
                                <h3 id="title">載入中...</h3>
                                <p>分類：<span class="badge bg-warning text-dark" id="category">租借</span></p>
                                <!-- <p>評價：<span class="text-warning">★★★★★</span></p> -->
                                <p>租借費用：<span class="fs-4" id="price" style="color:red;">0</span> / 天</p>

                                <div class="row justify-content-start">
                                    <div class="col-6">
                                        <div class="d-inline">天數：</div>
                                        <div class="d-inline"><button class="btn btn-outline-secondary btn-sm" onclick="reduceQuantity();">-</button></div>
                                        <div class="d-inline mx-2" id="itemQuantity">1</div>
                                        <div class="d-inline"><button class="btn btn-outline-secondary btn-sm" onclick="addQuantity();">+</button></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-inline">最大天數：</div>
                                        <div class="d-inline fs-5" id="quantity">0</div>
                                    </div>
                                </div>
                                <div class="my-3" id="size">
                                    <button class="btn btn-outline-secondary btn-sm" disabled>...</button>
                                </div>
                                <div class="my-5">
                                    <div class="d-inline"><button class="btn btn-secondary" onclick="addShoppingCart();">加入購物車</button></div>
                                    <div class="d-inline"><button class="btn btn-danger" id="rent_btn" onclick="addOrderCart();">直接租借</button></div>
                                </div>
                            </div>
                        </div>
                        <div><hr/></div>
                        <h3>商品資訊</h3>
                        <p id="intro">...</p>
                        <!-- <div><hr/></div>
                        <h3>評論</h3>
                        <div>
                            <p class="d-inline">abc123</p>
                            <p class="d-inline">　　</p>
                            <p class="d-inline text-warning">★★★</p>
                            <p>這款衛生紙超讚的啦!!</p>
                            <br/>
                        </div>
                        <div>
                            <p class="d-inline">abc123</p>
                            <p class="d-inline">　　</p>
                            <p class="d-inline text-warning">★★★</p>
                            <p>這款衛生紙超讚的啦!!</p>
                            <br/>
                        </div> -->
                    </div>
                </div>
            </div>
            <p><br/></p>
        </section>

    </body>

    <script>
        var product = "";
        var product_photo = "";
        function getProduct(){
            var fdata = new FormData();
            var product_id = <?php echo $_GET["productId"]; ?>;
            fdata.append('productId', product_id);
            fdata.append('salesCategory', "rent");
            fdata.append('type',"data");
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
                let content_tag = document.getElementById("content");
                if(data == "nullData"){
                    
                    content_tag.innerHTML = "<div class='container border rounded text-center py-3 mt-3'>OOPS!!此筆資料不存在</div>";
                    return;
                }
                product = JSON.parse(data); //全域變數
                if(!product["0"]["save_category"]){
                    content_tag.innerHTML = "<div class='container border rounded text-center py-3 mt-3'>OOPS!!此商品不在架上</div>";
                    return;
                }
                console.log(product);
                console.log(product["0"]["title"]);
                var tit = document.getElementById("title");
                tit.textContent = product["0"]["title"];
                var price = document.getElementById("price");
                price.textContent = product["0"]["price"];
                var qua = document.getElementById("quantity");
                qua.textContent = product["0"]["quantity"];
                var intro = document.getElementById("intro");
                intro.innerText = product["0"]["intro"];
                var category = document.getElementById("category");
                let rent_btn_tag = document.getElementById("rent_btn");
                rent_btn_tag.setAttribute("onclick", "addOrderCart(" + product["0"]["seller"] + ")");
                var category_name = ""
                switch(product["0"]["category"]){
                    case 1 :
                        category_name = "租借";
                        category.setAttribute("class","badge bg-warning text-dark");
                        break;
                    case 2 :
                        category_name = "二手販售";
                        category.setAttribute("class","badge bg-success text-light");
                        break;
                }
                category.textContent = category_name;
                var size = document.getElementById("size");
                var size_item = "";
                for(i = 0; i< product.length; i++){
                    if(i == 0){
                        size_item += '<button class="btn btn-secondary btn-sm" id="btn_category' + i + '" name="size_id_' + product[i]["product_detail_id"] + '" onclick="updateSizeData(' + i + ')">' + product[i]["size"] +'</button>\n';
                    }else{
                        size_item += '<button class="btn btn-outline-secondary btn-sm" id="btn_category' + i + '" name="size_id_' + product[i]["product_detail_id"] + '" onclick="updateSizeData(' + i + ')">' + product[i]["size"] +'</button>\n';
                    }
                }
                size.innerHTML = size_item;
            });
        }

        function getPhoto(){
            var fdata = new FormData();
            fdata.append('productId',<?php echo $_GET["productId"]; ?>);
            fdata.append('salesCategory', "rent");
            fdata.append('type',"photo");
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
                if(data == "nullData"){
                    return;
                }
                var product_photo = JSON.parse(data);
                console.log(product_photo);
                var photos = "";
                var photo_ctrl = "";
                for(i = 0; i < product_photo.length; i++){
                    // if(product_photo[i]["sequence"] == "1"){
                    if(i == 0){
                        photos += '<div class="carousel-item active"><img src="'+ product_photo[i]["path"] + product_photo[i]["photo_name"] +'" class="d-block w-100" style="height: 440px; object-fit:cover;" alt="..."></div>';
                    }else{
                        photos += '<div class="carousel-item"><img src="'+ product_photo[i]["path"] + product_photo[i]["photo_name"] +'" class="d-block w-100" style="height: 440px; object-fit:cover;" alt="..."></div>';
                    }
                    if(i == 0){
                        photo_ctrl += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide 1"></button>';
                    }else{
                        photo_ctrl += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide 1"></button>';
                    }
                }
                console.log(photos);
                var photo_print = document.getElementById("product_photo");
                photo_print.innerHTML = photos;
                var photo_ctrl_print = document.getElementById("photo_ctrl");
                photo_ctrl_print.innerHTML = photo_ctrl;
            });
        }

        getProduct();
        getPhoto();

        // 購買項目數量增加
        function addQuantity(){
            var item_qua_id = document.getElementById("itemQuantity");
            var current_qua = item_qua_id.innerText;
            var qua = Number(current_qua);
            let maxDay = Number(document.getElementById("quantity").innerText);
            if(qua < maxDay){
                qua = qua + 1;
            }
            console.log("目前" + qua);
            item_qua_id.textContent = qua;
        }

        // 購買項目數量減少
        function reduceQuantity(){
            var item_qua_id = document.getElementById("itemQuantity");
            var current_qua = item_qua_id.innerText;
            var qua = Number(current_qua);
            // 限制數量一定要 > 1
            if(qua > 1){
                qua = qua - 1;
                item_qua_id.textContent = qua;
            }
        }

        var current_choose = "btn_category0";    //目前選中的商品類別
        var current_choose_id = 0;    //目前選中的商品編號
        //更改不同size產品價錢、數量
        function updateSizeData(id){
            var price = document.getElementById("price");
            price.textContent = product[id]["price"];
            var qua = document.getElementById("quantity");
            qua.textContent = product[id]["quantity"];
            //將前一個選中商品類別按鈕還原
            var before_btn_category = document.getElementById(current_choose);
            before_btn_category.setAttribute("class", "btn btn-outline-secondary btn-sm")
            var btn_category = document.getElementById("btn_category" + id);
            //新選中商品類別按鈕
            btn_category.setAttribute("class", "btn btn-secondary btn-sm")
            current_choose = "btn_category" + id;
            current_choose_id = id;
            //目前選擇數量歸1
            let maxDay = document.getElementById("itemQuantity");
            maxDay.innerText = "1";
        }

        //購物車
        function addShoppingCart(){

            let seller_id = (product['0']['seller']).toString();
            let sale_category = (product['0']['category']).toString();
            let product_id = (product['0']['rent_id']).toString();
            let item_id = (product[current_choose_id]['rent_detail_id']).toString();
            let quantity = (document.getElementById("itemQuantity").innerText).toString();
            // let rentDataJson = {
            //     "seller": seller,
            //     "saleCategory": saleCategory,
            //     "productId": productId,
            //     "itemId": itemId,
            //     "count": count
            // };
            // console.log(JSON.stringify(rentDataJson));
            let fdata = new FormData();
            fdata.append('seller_id', seller_id);
            fdata.append('sale_category', sale_category);
            fdata.append('product_id', product_id);
            fdata.append('item_id', item_id);
            fdata.append('quantity', quantity);
            fetch('add_cart.php',
            {
            method:'post',
            body:fdata
            }).then(function(response) {
            return response.text();
            })
            .then(function(data) {
                console.log(data);
                read_cart_quantity();
                alert("已加入購物車");
            });
        }

        //讀取購物車數量
        function read_cart_quantity(){
            let fdata = new FormData();
            fdata.append('submit',"quantity");
            //透過表單送出資料(非同步傳輸)至後端處理程式
            fetch('includes/read_cart.inc.php',
            {
                method: 'post',
                body: fdata
            })
            .then(function(response) {
            return response.text();
            })
            .then(function(data) {
                console.log("購物車商品數量：" + data);
                let cart_quantity_tag = document.getElementById("cart_quantity");
                cart_quantity_tag.innerText = data;
            });
        }

        //讀取購物車資料
        function read_cart(){
            let step = 0;
            let fdata = new FormData();
            fetch('includes/read_cart.inc.php',
            {
            method:'post',
            body:fdata
            }).then(function(response) {
            return response.text();
            })
            .then(function(data) {
                if(data == "cart_null"){
                    console.log("購物車是空的");
                }else{
                    $cookie_cart_json = JSON.parse(data)
                    console.log($cookie_cart_json);
                    let print_cart;
                    let product;
                    for(i = 0; i < $cookie_cart_json["item_id"].length; i++){
                        var fdata = new FormData();
                        var product_id = $cookie_cart_json["product_id"];
                        fdata.append('productId', product_id);
                        fdata.append('salesCategory', "rent");
                        fdata.append('type',"data");
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
                            product = JSON.parse(data); //全域變數
                            print_cart += "-----\n";
                            print_cart += "產品名稱：" + product["0"]["title"] + "\n";
                            print_cart += "數量：" + [$cookie_cart_json["quantity"][i]] + "　　";
                            print_cart += "價格：" + product[$cookie_cart_json["item_id"][i]] + "　　";
                            console.log(print_cart);
                        });
                    }
                    
                }
            });
        }

        function addOrderCart(seller_id){
            //帶入表單資料
            let seller_id_list = Array();
            let sale_category_list = Array();
            let product_id_list = Array();
            let item_id_list = Array();
            let quantity_list = Array();
            let quantity_tag = document.getElementById("itemQuantity");

            //資料塞入陣列
            seller_id_list.push(seller_id);
            sale_category_list.push(product[0]["category"]);
            product_id_list.push(product[0]["rent_id"]);
            item_id_list.push(product[current_choose_id]["rent_detail_id"]);
            quantity_list.push(quantity_tag.innerText);

            //轉字串
            seller_id_list = seller_id_list.toString();
            sale_category_list = sale_category_list.toString();
            product_id_list = product_id_list.toString();
            item_id_list = item_id_list.toString();
            quantity_list = quantity_list.toString();
            console.log(seller_id_list);
            console.log(sale_category_list);
            console.log(product_id_list);
            console.log(item_id_list);
            console.log(quantity_list);

            let fdata = new FormData();
            fdata.append('seller_id', seller_id_list);
            fdata.append('sale_category', sale_category_list);
            fdata.append('product_id', product_id_list);
            fdata.append('item_id', item_id_list);
            fdata.append('quantity',quantity_list);
            fdata.append('submit', 'rent_page');
            //透過表單送出資料(非同步傳輸)至後端處理程式
            fetch('add_order_cart.php',
            {
                method: 'post',
                body: fdata
            })
            .then(function(response) {
            return response.text();
            })
            .then(function(data) {
                console.log(data);
                if(data){
                    document.location.href="order-add.php";
                }
            });
        }

    </script>

</html>
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
      <title>商品管理 - erso租借交易平台</title>
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
                            <li class="breadcrumb-item active" aria-current="page">編輯租借商品</li>
                        </ol>
                    </nav>
                    <div id="start">
                        <?php
                        if(!isset($_GET["productId"]) || empty($_GET["productId"])){
                            echo "<div class='container border rounded text-center py-3'>OOPS!!找不到資料</div>";
                            exit();
                        }
                        ?>
                        <!-- <form action="includes/product-update.inc.php" method="POST" enctype="multipart/form-data"> -->
                        <div class="p-4 border border-1 rounded">
                            <h3 class="pb-3">商品圖片</h3>
                            <div class="row">
                                <!-- <div class="col-2">
                                    <p>商品圖片<span class="text-danger">*</span></p>
                                </div> -->
                                <div class="col-12">
                                    <div class="row" id="img_list">
                                        <div class="col bg-light rounded p-2 m-1">
                                            <p>封面<span class="text-danger">*</span></p>
                                            <img src="assets/img/loading.gif" alt="封面" id="product_img1" height="150px"/>
                                            <form action="includes/product-photo-update.inc.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" id="photo_id1" name="photo_id" value="">
                                                <input type="hidden" id="photo_name1" name="photo_path" value="">
                                                <button class="btn btn-danger m-2" type="submit" name="photo_remove" disabled>刪除</button>
                                            </form>
                                        </div>
                                        <div class="col bg-light rounded p-2 m-1">
                                            <p>圖一</p>
                                            <img src="assets/img/loading.gif" alt="圖片一" id="product_img2" height="150px"/>
                                            <input type="hidden" id="photo_id2" name="photo_id" value="">
                                            <input type="hidden" id="photo_name2" name="photo_path" value="">
                                            <a class="btn btn-danger d-block">刪除</a>
                                        </div>
                                    </div>
                                    <!-- 上傳新圖片 -->
                                    <!-- <div class="col-12 border bg-light rounded p-2 mb-3">
                                            <p>新增圖片</p>
                                            <img src="" alt="圖片" id="product_img_add" height="150px"/>
                                            <form action="includes/product-photo-update.inc.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="productId" value="<?php echo $_GET["productId"]; ?>">
                                                <p><input type="file" class="form-control my-3" id="img_add" name="img" onchange="upload_preview_file(event,'_add')"/></p>
                                                <button class="btn btn-success d-block" id="photo_upload" type="submit" name="photo_upload" disabled>上傳</button>
                                            </form>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <form action="includes/product-update.inc.php" method="POST">
                        <div class="p-4 mt-3 border border-1 rounded">
                            <h3 class="pb-3">基本資料</h3>
                            <!-- <form action="includes/product-update.inc.php" method="POST"> -->
                            <div class="row mt-2">
                                <input type="hidden" name="productId" value="<?php echo $_GET["productId"]; ?>">
                                <div class="col-2">
                                    <p>商品名稱<span class="text-danger">*</span></p>
                                </div>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="productName" name="productName" placeholder="商品名稱" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <p>商品描述<span class="text-danger">*</span></p>
                                </div>
                                <div class="col-10">
                                    <textarea class="form-control" aria-label="With textarea" id="productIntro" name="productIntro" placeholder="商品描述" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <p>商品類型<span class="text-danger">*</span></p>
                                </div>
                                <div class="col-10">
                                    <select id="product_category" class="form-select" aria-label="Default select example" name="productCategory" required>
                                        <option disabled>請選擇符合該商品的類型</option>
                                        <option value="1" selected >--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 mt-3 border border-1 rounded">
                            <h3 class="pb-3">租借資訊</h3>
                            <input type="hidden" value="" id="product_item_id_data" name="product_item_id_data">
                            <input type="hidden" value="1" id="product_size_length" name="product_size_length">
                            <input type="hidden" value="1" id="before_product_size_length" name="before_product_size_length">
                            <div class="row mt-2" id="product_size1">
                                <div class="col-1 text-end">
                                    <p>商品項目<span class="text-danger" required="required">*</span></p>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="item1" name="size[]" placeholder="項目" required>
                                </div>
                                <div class="col-1 text-end">
                                    <p>每日租金<span class="text-danger">*</span></p>
                                </div>
                                <div class="col-3">
                                    <input type="number" class="form-control" id="price1" name="price[]]" placeholder="請輸入每一天的租金" required>
                                </div>
                                <div class="col-1 text-end">
                                    <p>最大天數<span class="text-danger">*</span></p>
                                </div>
                                <div class="col-3">
                                    <input type="number" class="form-control" id="quantity1" name="quantity[]]" placeholder="最大天數" required>
                                </div>
                            </div>
                            <div class="row mt-2" id="product_size2">
                            </div>
                            <div class="row mt-2" id="product_size3">
                            </div>
                            <div class="row mt-2" id="product_size4">
                            </div>
                            <div class="row mt-2" id="product_size5">
                            </div>
                            <a class="btn btn-secondary" id="btn_product_add" onclick="add_product_size();">增加項目</a>
                            <a class="btn btn-danger" id="btn_product_reduce" onclick="reduce_product_size();">減少項目</a>
                            <hr>
                            <!-- <div class="row mt-2">
                                <div class="col-1 text-end">
                                    <p>運送方式<span class="text-danger">*</span></p>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="quantity1" name="quantity1" placeholder="運送方式">
                                </div>
                                <div class="col-1 text-end">
                                    <p>運費<span class="text-danger">*</span></p>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="quantity1" name="quantity1" placeholder="運費">
                                </div>
                            </div> -->
                        </div>

                        <!-- 銷售類別(1=租借；2=二手販售) -->
                        <input type="hidden" name="salesCategory" value="1">

                        <div class="mt-3 text-end">
                            <button class="btn btn-success" type="submit" name="product_online_send">架上儲存</button>
                            <button class="btn btn-danger" type="submit" name="product_offline_send">架下儲存</button>                        
                            <a class="btn btn-secondary" href="">取消</a>                        
                        </div>
                        </form>
                    </div>
                </div>
            </div>
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
                getCategory();
                console.log(data);
                if(data == "nullData"){
                    let start_tag = document.getElementById("start");
                    start_tag.innerHTML = "<div class='container border rounded text-center py-3'>OOPS!!此筆資料不存在</div>";
                }
                product = JSON.parse(data); //全域變數
                console.log(product);
                var tit = document.getElementById("productName");
                tit.value = product["0"]["title"];
                var intro = document.getElementById("productIntro");
                intro.value = product["0"]["intro"];

                // let size_length_tag = document.getElementById("product_size_length");
                // let size_length = size_length_tag.getAttribute("value");
                let length = product.length;
                for(i = 0; i < length; i++){

                    let id = i+1;
                    //取得要建立的id名稱
                    let next_product_item = document.getElementById("product_size" + id);
                    next_product_item.innerHTML = 
                            '<div class="col-1 text-end">'+
                            '    <input type="hidden" value="' + product[i]["rent_detail_id"] + '" name="product_item_id[]">'+
                            '    <p>商品項目<span class="text-danger" required="required">*</span></p>'+
                            '</div>'+
                            '<div class="col-3">'+
                            '    <input type="text" class="form-control" id="item' + id + '" name="size[]]" placeholder="項目" value="' + product[i]["size"] + '" required>'+
                            '</div>'+
                            '<div class="col-1 text-end">'+
                            '    <p>每日租金<span class="text-danger">*</span></p>'+
                            '</div>'+
                            '<div class="col-3">'+
                            '    <input type="number" class="form-control" id="price' + id + '" name="price[]]" placeholder="請輸入每一天的租金" value="' + product[i]["price"] + '" required>'+
                            '</div>'+
                            '<div class="col-1 text-end">'+
                            '    <p>最大天數<span class="text-danger">*</span></p>'+
                            '</div>'+
                            '<div class="col-3">'+
                            '    <input type="number" class="form-control" id="quantity' + id + '" name="quantity[]" placeholder="最大天數" value="' + product[i]["quantity"] + '" required>'+
                            '</div>';
                }
                let size_length = document.getElementById("product_size_length");
                size_length.setAttribute("value", length);
                let before_size_length = document.getElementById("before_product_size_length");
                before_size_length.setAttribute("value", length);
                let item_id_data_tag = document.getElementById("product_item_id_data");
                

                // var price = document.getElementById("price");
                // price.textContent = product["0"]["price"];
                // var qua = document.getElementById("quantity");
                // qua.textContent = product["0"]["quantity"];
                // category.textContent = category_name;
                // var size = document.getElementById("size");
                // var size_item = "";
                // for(i = 0; i< product.length; i++){
                //     if(i == 0){
                //         size_item += '<button class="btn btn-secondary btn-sm" id="btn_category' + i + '" name="size_id_' + product[i]["product_detail_id"] + '" onclick="updateSizeData(' + i + ')">' + product[i]["size"] +'</button>\n';
                //     }else{
                //         size_item += '<button class="btn btn-outline-secondary btn-sm" id="btn_category' + i + '" name="size_id_' + product[i]["product_detail_id"] + '" onclick="updateSizeData(' + i + ')">' + product[i]["size"] +'</button>\n';
                //     }
                // }
                // size.innerHTML = size_item;
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
                var product_photo = JSON.parse(data);
                console.log(product_photo);
                var photos = "";
                var photo_ctrl = "";
                let photo_amount = product_photo.length;
                let print_img_list = '';
                let img_list_tag = document.getElementById("img_list");
                for(i = 0; i < product_photo.length; i++){
                    let id = i+1;
                    // //取得圖片標籤
                    // let img = document.getElementById("product_img" + id);
                    // //設定圖片路徑
                    // img.src = product_photo[i]["path"] + product_photo[i]["photo_name"];
                    // //取得圖片id標籤
                    // let photo_id_tag = document.getElementById("photo_id" + id);
                    // //設定圖片id資料
                    // photo_id_tag.value = product_photo[i]["rent_photo_id"];
                    // //取得圖片路徑標籤
                    // let photo_path_tag = document.getElementById("photo_name" + id);
                    // //設定圖片路徑資料
                    // photo_path_tag.value = product_photo[i]["path"] + product_photo[i]["photo_name"];
                    print_img_list += '<div class="col bg-light rounded p-2 m-1">';
                    if(i == 0){
                        print_img_list += '<p>圖片<span class="text-danger">*</span></p>';
                    }else{
                        print_img_list += '<p>圖片</p>';
                    }
                    print_img_list += '<img src="' + product_photo[i]["path"] + product_photo[i]["photo_name"] + '" alt="圖片" id="product_img' + (i + 1) + '" height="150px" />';
                    print_img_list += '<form action="includes/product-photo-update.inc.php" method="POST" enctype="multipart/form-data">';
                    print_img_list += '<input type="hidden" name="productId" value="' + <?php echo $_GET["productId"]; ?> + '">';
                    print_img_list += '<input type="hidden" id="photo_id' + id + '" name="photo_id" value="' + product_photo[i]["rent_photo_id"] + '">';
                    print_img_list += '<input type="hidden" id="photo_name' + id + '" name="photo_path" value="' + product_photo[i]["path"] + product_photo[i]["photo_name"] + '">';
                    if(product_photo.length > 1 ){
                        print_img_list += '<button class="btn btn-danger m-2" type="submit" name="photo_remove">刪除</button>';
                    }
                    print_img_list += '</form>';
                    print_img_list += '</div>';
                }
                //圖片超過>=5張則不能再上傳新圖片
                if(product_photo.length < 5){
                    let id = "_add";
                    print_img_list += '<div class="col bg-light rounded p-2 m-1">';
                    print_img_list += '<p>新增圖片</p>'
                    print_img_list += '<img src="" alt="新圖片" id="product_img_add" height="150px"/>';
                    print_img_list += '<form action="includes/product-photo-update.inc.php" method="POST" enctype="multipart/form-data">';
                    print_img_list += '    <input type="hidden" name="productId" value="' + <?php echo $_GET["productId"]; ?> + '">';
                    print_img_list += '    <p><input type="file" class="form-control my-3" id="img_add" name="img" onchange="upload_preview_file(event)"/></p>';
                    print_img_list += '    <button class="btn btn-success d-block" id="photo_upload" type="submit" name="photo_upload" disabled>上傳</button>';
                    print_img_list += '</form>';
                    print_img_list += '</div>';
                }
                
                console.log(data);
                img_list_tag.innerHTML = print_img_list;
                // console.log(photos);
                // var photo_print = document.getElementById("product_photo");
                // photo_print.innerHTML = photos;
                // var photo_ctrl_print = document.getElementById("photo_ctrl");
                // photo_ctrl_print.innerHTML = photo_ctrl;
            });
        }

        function getCategory(){
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
                let product_category_tag = document.getElementById("product_category");
                let print_category = '<option disabled>請選擇符合該商品的類型</option>';
                for(i = 0; i < product_category.length; i++){
                    id = i + 1;
                    if(product[0]["rent_category"] == id){
                        print_category += '<option value="' + id + '" selected >' + product_category[i]["category_name"] + '</option>';
                    }else{
                        print_category += '<option value="' + id + '" >' + product_category[i]["category_name"] + '</option>';
                    }
                }
                product_category_tag.innerHTML = print_category;
            });
        }

        getProduct();
        getPhoto();

        function upload_preview_file(event, id) {
            var selected_file = event.target.files[0];
            var reader = new FileReader(); 
            var img_tag = document.getElementById("product_img_add");
            //上傳圖片按鈕標籤
            let photo_upload_tag = document.getElementById("photo_upload");
        
            reader.onload = function(event) {
            img_tag.src = event.target.result;
            //設定上傳圖片按鈕為可點選
            photo_upload_tag.removeAttribute("disabled");
            };
        
            reader.readAsDataURL(selected_file);
        }

        function add_product_size(){
            let size_length_tag = document.getElementById("product_size_length");
            
            let size_length = size_length_tag.getAttribute("value");
            let length = Number(size_length);

            if(length <= 4){
                length += 1;
                let next_product_item = document.getElementById("product_size" + length);
                size_length_tag.setAttribute("value", length);
                
                let btn_product_reduce_tag = document.getElementById("btn_product_reduce");
                btn_product_reduce_tag.removeAttribute("disabled");
                next_product_item.innerHTML = 
                            '<div class="col-1 text-end">'+
                            '    <p>商品項目<span class="text-danger" required="required">*</span></p>'+
                            '</div>'+
                            '<div class="col-3">'+
                            '    <input type="text" class="form-control" id="item' + length + '" name="size[]]" placeholder="項目" required>'+
                            '</div>'+
                            '<div class="col-1 text-end">'+
                            '    <p>租金<span class="text-danger">*</span></p>'+
                            '</div>'+
                            '<div class="col-3">'+
                            '    <input type="number" class="form-control" id="price' + length + '" name="price[]]" placeholder="請輸入每一天的租金" required>'+
                            '</div>'+
                            '<div class="col-1 text-end">'+
                            '    <p>最大天數<span class="text-danger">*</span></p>'+
                            '</div>'+
                            '<div class="col-3">'+
                            '    <input type="number" class="form-control" id="quantity' + length + '" name="quantity[]" placeholder="最大天數" required>'+
                            '</div>';
            }else{
                let btn_product_add_tag = document.getElementById("btn_product_add");
                btn_product_add_tag.setAttribute("disabled",true);
            }
            console.log(size_length);
            
        }
        function reduce_product_size(){
            let size_length_tag = document.getElementById("product_size_length");
            
            let size_length = size_length_tag.getAttribute("value");
            let length = Number(size_length);
            let next_product_item = document.getElementById("product_size" + length);
            let last_item_tag = document.getElementById("item" + length);
            let last_price_tag = document.getElementById("price" + length);
            let last_quantity_tag = document.getElementById("quantity" + length);
            last_item = last_item_tag.getAttribute("value");
            last_price = last_price_tag.getAttribute("value");
            last_quantity = last_quantity_tag.getAttribute("value");
            if(last_item === null && last_price === null && last_quantity === null){
                if(length <= 1){
                    let btn_product_reduce_tag = document.getElementById("btn_product_reduce");
                    btn_product_reduce_tag.setAttribute("disabled",true);
                }else{
                    let btn_product_add_tag = document.getElementById("btn_product_add");
                    btn_product_add_tag.removeAttribute("disabled");
                    length -= 1;
                    size_length_tag.setAttribute("value", length);
                    next_product_item.innerHTML = "";
                }
            }
            console.log(size_length);
        }

    </script>

</html>
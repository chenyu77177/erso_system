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
      <title>新增商品 - erso租借交易平台</title>
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
                            <li class="breadcrumb-item active" aria-current="page">新增租借商品</li>
                        </ol>
                    </nav>
                    <form action="includes/product-add.inc.php" method="POST" enctype="multipart/form-data">
                    <div class="p-4 border border-1 rounded">
                        <h3 class="pb-3">基本資料</h3>
                        <div class="row">
                            <div class="col-2">
                                <p>商品圖片<span class="text-danger">*</span></p>
                            </div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col bg-light rounded p-2 m-1">
                                        <p>封面<span class="text-danger">*</span></p>
                                        <img src="" alt="封面" id="product_img1" height="150px"/>
                                        <p><input type="file" class="form-control my-3" id="img1" name="img[]" onchange="upload_preview_file(event,'1')" required/></span></p>
                                    </div>
                                    <div class="col bg-light rounded p-2 m-1">
                                        <p>圖一</p>
                                        <img src="" alt="圖片一" id="product_img2" height="150px"/>
                                        <p><input type="file" class="form-control my-3" id="img1" name="img[]" onchange="upload_preview_file(event,'2')"/></p>
                                    </div>
                                    <div class="col bg-light rounded p-2 m-1">
                                        <p>圖二</p>
                                        <img src="" alt="圖片二" id="product_img3" height="150px"/>
                                        <p><input type="file" class="form-control my-3" id="img1" name="img[]" onchange="upload_preview_file(event,'3')"/></p>
                                        
                                    </div>
                                    <div class="col bg-light rounded p-2 m-1">
                                        <p>圖三</p>
                                        <img src="" alt="圖片三" id="product_img4" height="150px"/>
                                        <p><input type="file" class="form-control my-3" id="img1" name="img[]" onchange="upload_preview_file(event,'4')"/></p>                                
                                    </div>
                                    <div class="col bg-light rounded p-2 m-1">
                                        <p>圖四</p>
                                        <img src="" alt="圖片四" id="product_img5" height="150px"/>
                                        <p><input type="file" class="form-control my-3" id="img1" name="img[]" onchange="upload_preview_file(event,'5')"/></p>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
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
                        <input type="hidden" value="1" id="product_size_length">
                        <div class="row mt-2" id="product_size1">
                            <div class="col-1 text-end">
                                <p>商品項目<span class="text-danger" required="required">*</span></p>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="price1" name="size[]" placeholder="項目" required>
                            </div>
                            <div class="col-1 text-end">
                                <p>租金<span class="text-danger">*</span></p>
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
                    <!-- <div class="p-4 mt-3 border border-1 rounded">
                        <h3 class="pb-3">商品屬性</h3>
                        <div class="row mt-2">
                            <div class="col-1 text-end">
                                <p>--<span class="text-danger">*</span></p>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="price1" name="price1" placeholder="價格">
                            </div>
                            <div class="col-1 text-end">
                                <p>--<span class="text-danger">*</span></p>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="quantity1" name="quantity1" placeholder="數量">
                            </div>
                            <div class="col-1 text-end">
                                <p>--<span class="text-danger">*</span></p>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="price1" name="price1" placeholder="優惠">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-1 text-end">
                                <p>--<span class="text-danger">*</span></p>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="quantity1" name="quantity1" placeholder="運送方式">
                            </div>
                            <div class="col-1 text-end">
                                <p>--<span class="text-danger">*</span></p>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="quantity1" name="quantity1" placeholder="運費">
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="p-4 mt-3 border border-1 rounded">
                        <h3 class="pb-3">其他資訊</h3>
                        <div class="row mt-2">
                            <div class="col-1 text-end">
                                <p>販售方式<span class="text-danger">*</span></p>
                            </div>
                            <div class="col-4">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group" aria-required="">
                                <input type="radio" class="btn-check" name="salesCategory" id="btnradio3" autocomplete="off" value="1" checked>
                                    <label class="btn btn-outline-primary" for="btnradio3">租借</label>

                                    <input type="radio" class="btn-check" name="salesCategory" id="btnradio2" autocomplete="off" value="2">
                                    <label class="btn btn-outline-primary" for="btnradio2">二手販售</label>
                                    
                                </div>
                                <input type="hidden" name="salesCategory" value="1">
                            </div>
                        </div>
                    </div> -->

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
        </section>

    </body>
    <script>
        function upload_preview_file(event, id) {
            var selected_file = event.target.files[0];
            var reader = new FileReader(); 
            var img_tag = document.getElementById("product_img" + id);
        
            reader.onload = function(event) {
            img_tag.src = event.target.result;
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
                console.log(size_length);
                let btn_product_reduce_tag = document.getElementById("btn_product_reduce");
                btn_product_reduce_tag.removeAttribute("disabled");
                next_product_item.innerHTML = 
                            '<div class="col-1 text-end">'+
                            '    <p>商品項目<span class="text-danger" required="required">*</span></p>'+
                            '</div>'+
                            '<div class="col-3">'+
                            '    <input type="text" class="form-control" id="price1" name="size[]]" placeholder="項目" required>'+
                            '</div>'+
                            '<div class="col-1 text-end">'+
                            '    <p>租金<span class="text-danger">*</span></p>'+
                            '</div>'+
                            '<div class="col-3">'+
                            '    <input type="number" class="form-control" id="price1" name="price[]]" placeholder="請輸入每一天的租金" required>'+
                            '</div>'+
                            '<div class="col-1 text-end">'+
                            '    <p>最大天數<span class="text-danger">*</span></p>'+
                            '</div>'+
                            '<div class="col-3">'+
                            '    <input type="number" class="form-control" id="quantity1" name="quantity[]" placeholder="最大天數" required>'+
                            '</div>';
            }else{
                let btn_product_add_tag = document.getElementById("btn_product_add");
                btn_product_add_tag.setAttribute("disabled",true);
            }
            
            
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
                    if(i == 0){
                        print_category += '<option value="' + id + '" selected >' + product_category[i]["category_name"] + '</option>';
                    }else{
                        print_category += '<option value="' + id + '" >' + product_category[i]["category_name"] + '</option>';
                    }
                }
                product_category_tag.innerHTML = print_category;
            });
        }

        getCategory();

        function reduce_product_size(){
            let size_length_tag = document.getElementById("product_size_length");
            
            let size_length = size_length_tag.getAttribute("value");
            let length = Number(size_length);
            let next_product_item = document.getElementById("product_size" + length);
            
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
            
            console.log(size_length);
        }

    </script>

</html>
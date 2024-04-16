<?php
session_start();

//取得資料，檢查購物車有無資料
if(empty($_COOKIE["product_id_list"])){
    $result = "cart_null";
}else{
    //將cookie內的資料以 逗號 分割成陣列
    $seller_id_array = explode(",", $_COOKIE["seller_id_list"]);
    $sale_category_array = explode(",", $_COOKIE["sale_category_list"]);
    $product_id_array = explode(",", $_COOKIE["product_id_list"]);
    $item_id_array = explode(",", $_COOKIE["item_id_list"]);
    $quantity_array = explode(",", $_COOKIE["quantity_list"]);
    //合併陣列
    $cookie_data = array("seller_id"=>$seller_id_array, "sale_category"=>$sale_category_array, "product_id"=>$product_id_array, 
    "item_id"=>$item_id_array, "quantity"=>$quantity_array);
}

?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <?php 
            include("header.php");
        ?>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card my-3">
                            <div class="card-header">
                                租借商品
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" id="product_list">
                                    <div class="text-center">載入中...</div>
                                    <!-- <div class="card my-2">
                                        <div class="card-header">
                                            XXX的賣場
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-1">
                                                    </div>
                                                    <div class="col-1">
                                                    </div>
                                                    <div class="col-3">
                                                        <p><strong>商品</strong></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p><strong>項目</strong></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p><strong>單價/天</strong></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p><strong>天數</strong></p>
                                                    </div>
                                                    <div class="col-1">
                                                        
                                                    </div>
                                                </div>
                                                <div class="row mb-2 justify-content-end align-items-center">
                                                    <div class="col-1">
                                                        <div class="text-center">
                                                            <input class="form-check-input" type="checkbox" id="checkboxNoLabel" name="chk_item[]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-1">
                                                        <img class="border" style="width: 100%;" src="./assets/img/loading.gif">
                                                    </div>
                                                    <div class="col-3">
                                                        <p>清新果凍</p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>葡萄</p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>5</p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>30</p>
                                                    </div>
                                                    <div class="col-1">
                                                        <a class="btn btn-danger btn-sm">✕</a>
                                                    </div>
                                                </div>
                                                <div class="row mb-2 align-items-center">
                                                    <div class="col-1">
                                                        <div  class="text-center">
                                                            <input class="form-check-input" type="checkbox" id="checkboxNoLabel" name="chk_item[]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-1">
                                                        <img class="border" style="width: 100%" src="./assets/img/loading.gif">
                                                    </div>
                                                    <div class="col-3">
                                                        <p>清新果凍</p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>葡萄</p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>5</p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>30</p>
                                                    </div>
                                                    <div class="col-1">
                                                        <a class="btn btn-danger btn-sm">✕</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <button class="btn btn-secondary">租借所選</button>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div> -->
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </body>
    <script>
        function checkCart(){
            let cart_state = "<?php if(!isset($_COOKIE["seller_id_list"])){ echo "nullCart"; }else{ echo "true";} ?>";
            let product_list = document.getElementById("product_list");
            if(cart_state == "nullCart"){
                product_list.innerHTML = '<div class="text-center">購物車是空的</div>';
                return;
            }else{
                get_cart();
            }
        }
        checkCart();

        function get_cart(){
            let product_list = document.getElementById("product_list");
            
            //賣家_id
            let cookie_seller_id_array = <?php if(isset($_COOKIE["seller_id_list"])){echo '"' . $_COOKIE["seller_id_list"] . '"';}else{ echo '""';} ?>;
            cookie_seller_id_array = cookie_seller_id_array.split(",");
            //銷售類別_id
            let cookie_sale_category_array = <?php if(isset($_COOKIE["sale_category_list"])){echo '"' . $_COOKIE["sale_category_list"] . '"';}else{ echo '""';} ?>;
            cookie_sale_category_array = cookie_sale_category_array.split(",");
            //商品_id
            let cookie_product_id_array = <?php if(isset($_COOKIE["product_id_list"])){echo '"' . $_COOKIE["product_id_list"] . '"';}else{ echo '""';} ?>;
            cookie_product_id_array = cookie_product_id_array.split(",");
            //項目_id
            let cookie_item_id_array = <?php if(isset($_COOKIE["item_id_list"])){echo '"' . $_COOKIE["item_id_list"] . '"';}else{ echo '""';} ?>;
            cookie_item_id_array = cookie_item_id_array.split(",");
            //數量
            let cookie_quantity_array = <?php if(isset($_COOKIE["quantity_list"])){echo '"' . $_COOKIE["quantity_list"] . '"';}else{ echo '""';} ?>;
            cookie_quantity_array = cookie_quantity_array.split(",");
            console.log(cookie_seller_id_array);
                

            let fdata = new FormData();
            let product_id = cookie_product_id_array;
            // fdata.append('productId', product_id);
            // fdata.append('salesCategory', "rent");
            fdata.append('submit',"my-cart");
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
                console.log(data);
                if(data == "nullProductId(data)"){
                    product_list.innerHTML = '<div class="text-center">購物車無資料...[null data]</div>';
                    return;
                }
                console.log(JSON.parse(data));
                product_data = JSON.parse(data);
                print_cart = "";
                
                uncategory_data = Array();
                seller_data = Array();
                seller_id = Array();
                for(i = 0; i < cookie_item_id_array.length; i++){
                    price = 0;
                    size = "";
                    card = "";

                    //以儲存在cookie的項目id取得商品項目之價格
                    for(j = 0; j < product_data[i].length; j++){
                        if(product_data[i][j]["rent_detail_id"] == cookie_item_id_array[i]){
                            price = product_data[i][j]["price"];
                            size = product_data[i][j]["size"];
                        }
                    }
                    
                    // print_cart += "產品名稱：" + product_data[i][i]["title"] + "\n";
                    // print_cart += "數量：" + cookie_quantity_array[i] + "　　";
                    // print_cart += "價格：" + price + "　　";
                    // print_cart += "----------\n";
                    if(i == 0){
                        card += '<div class="row mb-2"><div class="col-2">';
                        card += '<img class="border" style="width:75%; object-fit:cover;" src="' + product_data[i][0]["path"] + product_data[i][0]["photo_name"] + '">';
                        card += '</div><div class="col-3">';
                        card += '<p>' + product_data[i][0]["title"] + '</p>';
                        card += '</div><div class="col-2">';
                        card += '<p>' + size + '</p>';
                        card += '</div><div class="col-2">';
                        card += '<p>' + price + '</p>';
                        card += '</div><div class="col-2">';
                        card += '<p>' + cookie_quantity_array[i] + '</p>';
                        card += '</div><div class="col-1">';
                        card += '<a class="btn btn-danger btn-sm" onClick="del_cart_item(' + cookie_item_id_array[i] + ')">✕</a>';
                        card += '</div></div>';
                        uncategory_data.push(card);
                        seller_data.push(product_data[i][0]["user_name"]);
                        seller_id.push(product_data[i][0]["user_id"]);
                    }else{
                        //賣場歸類
                        set = false;
                        for(k = 0; k < seller_data.length; k++){
                            if(product_data[i][0]["user_name"] == seller_data[k]){
                                card += '<div class="row mb-2"><div class="col-2">';
                                card += '<img class="border" style="width:75%; object-fit:cover;" src="' + product_data[i][0]["path"] + product_data[i][0]["photo_name"] + '">';
                                card += '</div><div class="col-3">';
                                card += '<p>' + product_data[i][0]["title"] + '</p>';
                                card += '</div><div class="col-2">';
                                card += '<p>' + size + '</p>';
                                card += '</div><div class="col-2">';
                                card += '<p>' + price + '</p>';
                                card += '</div><div class="col-2">';
                                card += '<p>' + cookie_quantity_array[i] + '</p>';
                                card += '</div><div class="col-1">';
                                card += '<a class="btn btn-danger btn-sm" onClick="del_cart_item(' + cookie_item_id_array[i] + ')">✕</a>';
                                card += '</div></div>';
                                uncategory_data[k] += card;
                                set = true;
                            }
                        }
                        if(!set){
                            card += '<div class="row mb-2"><div class="col-2">';
                            card += '<img class="border" style="width:75%; object-fit:cover;" src="' + product_data[i][0]["path"] + product_data[i][0]["photo_name"] + '">';
                            card += '</div><div class="col-3">';
                            card += '<p>' + product_data[i][0]["title"] + '</p>';
                            card += '</div><div class="col-2">';
                            card += '<p>' + size + '</p>';
                            card += '</div><div class="col-2">';
                            card += '<p>' + price + '</p>';
                            card += '</div><div class="col-2">';
                            card += '<p>' + cookie_quantity_array[i] + '</p>';
                            card += '</div><div class="col-1">';
                            card += '<a class="btn btn-danger btn-sm" onClick="del_cart_item(' + cookie_item_id_array[i] + ')">✕</a>';
                            card += '</div></div>';
                            uncategory_data.push(card);
                            seller_data.push(product_data[i][0]["user_name"]);
                            seller_id.push(product_data[i][0]["user_id"]);
                        }
                    }
                    
                }
                card = "";
                for(i = 0; i < seller_data.length; i++){
                    
                    //抬頭
                    card += '<div class="card my-2"><div class="card-header">';
                    card += '<div>' + seller_data[i] + ' 的商店</div></div>';
                    card += '<ul class="list-group list-group-flush"><li class="list-group-item"><div class="row"><div class="col-2"></div><div class="col-3"><p><strong>商品</strong></p></div><div class="col-2"><p><strong>項目</strong></p></div><div class="col-2"><p><strong>單價/天</strong></p></div><div class="col-2"><p><strong>天數</strong></p></div><div class="col-2"></div></div>';
                    
                    card += uncategory_data[i];

                    //結尾
                    card += '</li><li class="list-group-item text-center"><a class="btn btn-secondary" onClick="addOrderCart(' + seller_id[i] + ')">租借</a></li></ul></div>';
                }
                
                console.log(card);
                product_list.innerHTML = card;
            });
            
        }
        // get_cart();

        function del_cart_item(item_id){
            let fdata = new FormData();
            let cart_item_id = item_id;
            // fdata.append('productId', product_id);
            // fdata.append('salesCategory', "rent");
            fdata.append('item_id', cart_item_id);
            //透過表單送出資料(非同步傳輸)至後端處理程式
            fetch('delete_cart_item.php',
            {
                method: 'post',
                body: fdata
            })
            .then(function(response) {
            return response.text();
            })
            .then(function(data) {
                console.log(data);
                read_cart_quantity();
                parent.location.reload();
                // console.log(JSON.parse(data));
                
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
            });
        }

        function addOrderCart(seller_id){
            //賣家_id
            let cookie_seller_id_array = <?php if(isset($_COOKIE["seller_id_list"])){echo '"' . $_COOKIE["seller_id_list"] . '"';}else{ echo '""';} ?>;
            cookie_seller_id_array = cookie_seller_id_array.split(",");
            //銷售類別_id
            let cookie_sale_category_array = <?php if(isset($_COOKIE["sale_category_list"])){echo '"' . $_COOKIE["sale_category_list"] . '"';}else{ echo '""';} ?>;
            cookie_sale_category_array = cookie_sale_category_array.split(",");
            //商品_id
            let cookie_product_id_array = <?php if(isset($_COOKIE["product_id_list"])){echo '"' . $_COOKIE["product_id_list"] . '"';}else{ echo '""';} ?>;
            cookie_product_id_array = cookie_product_id_array.split(",");
            //項目_id
            let cookie_item_id_array = <?php if(isset($_COOKIE["item_id_list"])){echo '"' . $_COOKIE["item_id_list"] . '"';}else{ echo '""';} ?>;
            cookie_item_id_array = cookie_item_id_array.split(",");
            //數量
            let cookie_quantity_array = <?php if(isset($_COOKIE["quantity_list"])){echo '"' . $_COOKIE["quantity_list"] . '"';}else{ echo '""';} ?>;
            cookie_quantity_array = cookie_quantity_array.split(",");
            console.log(cookie_seller_id_array);

            //帶入表單資料
            let seller_id_list = Array();
            let sale_category_list = Array();
            let product_id_list = Array();
            let item_id_list = Array();
            let quantity_list = Array();
            for(i = 0; i < cookie_item_id_array.length; i++){
                if(cookie_seller_id_array[i] == seller_id){
                    seller_id_list.push(cookie_seller_id_array[i]);
                    sale_category_list.push(cookie_sale_category_array[i]);
                    product_id_list.push(cookie_product_id_array[i]);
                    item_id_list.push(cookie_item_id_array[i]);
                    quantity_list.push(cookie_quantity_array[i]);
                }
            }
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
            fdata.append('submit', 'cart');
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
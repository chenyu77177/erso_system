<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>下單</title>
</head>
<body>
    <?php 
        include("header.php");
    ?>
    <div class="container">
        <form action="includes/order-add.inc.php" method="POST">
            <div class="card my-2">
                <div class="card-header">
                    租借清單
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-2">
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
                                <p><strong>金額</strong></p>
                            </div>
                        </div>
                        <div id="order_list">
                            <p class="text-center">資料讀取中...</p>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-9">
                                
                            </div>
                            <div class="col-2">
                                <p>總金額：</p>
                            </div>
                            <div class="col-1" id="total_sum">
                                <p>$-</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="p-4 mt-3 border border-1 rounded">
                <h3 class="pb-3">租借人資訊</h3>

                <div class="row mt-2">
                    <div class="col-1 text-end">
                        <p>姓名<span class="text-danger" required="required">*</span></p>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="item1" name="name" placeholder="姓名" required value="<?php if(isset($_SESSION["username"])){ echo $_SESSION["username"];} ?>">
                    </div>
                    <div class="col-1 text-end">
                        <p>連絡電話<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="price1" name="phone" placeholder="聯絡電話" required>
                    </div>
                    <div class="col-1 text-end">
                        <p>信箱<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="quantity1" name="email" placeholder="信箱" required value="<?php if(isset($_SESSION["useremail"])){ echo $_SESSION["useremail"];} ?>">
                    </div>
                </div>
                <!-- <div class="row mt-2" id="">
                    <div class="col-1 text-end">
                        <p>地址<span class="text-danger" required="required">*</span></p>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="item1" name="addr" placeholder="地址" required>
                    </div>
                </div> -->
            </div>
            <div class="p-4 mt-3 border border-1 rounded">
                <h3 class="pb-3">配送資訊</h3>
                <div class="row mt-2">
                    <div class="col-1 text-end">
                        <p>運送方式<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="delivery_method" id="delivery1" value="1" onchange="changeDelivery(1)" checked>
                            <label class="form-check-label" for="delivery1">面交</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="delivery_method" id="delivery2" value="2" onchange="changeDelivery(2)">
                            <label class="form-check-label" for="delivery2">超商取貨</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="delivery_method" id="delivery3" value="3" onchange="changeDelivery(3)">
                            <label class="form-check-label" for="delivery3">宅配</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" id="delivery_input">
                <div class="col-1 text-end">
                        <p>運費<span class="text-danger" required="required">*</span></p>
                    </div>
                    <div class="col-1">
                        <input type="hidden" id="delivery_fee" name="delivery_fee" value="0">
                        <span>0</span>
                    </div>
                    <div class="col-1 text-end">
                        <p>地址<span class="text-danger" required="required">*</span></p>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="addr" name="addr" placeholder="地址" required>
                    </div>
                </div>
            </div>
            <div class="p-4 mt-3 border border-1 rounded">
                <h3 class="pb-3">支付資訊</h3>
                <div class="row mt-2">
                    <div class="col-1 text-end">
                        <p>支付方式<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment1" value="1" onchange="changePayment(1)" checked>
                            <label class="form-check-label" for="payment1">取貨付款</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment2" value="2" onchange="changePayment(2)">
                            <label class="form-check-label" for="payment2">信用卡</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment3" value="3" onchange="changePayment(3)">
                            <label class="form-check-label" for="payment3">轉帳</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" id="payment_input">

                </div>
            </div>
        
            <div class="my-3 text-end">
                <button class="btn btn-success" type="submit" name="rent">租借</button>                      
                <a class="btn btn-danger" href="">捨棄</a>                        
            </div>
        </form>
    </div>
</body>
</html>

<script>
    function get_cart(){
        let order_list = document.getElementById("order_list");
        let total_sum_tag = document.getElementById("total_sum");
        
        //賣家_id
        let cookie_seller_id_array = <?php if(isset($_COOKIE["order_seller_id_list"])){echo '"' . $_COOKIE["order_seller_id_list"] . '"';}else{ echo '""';} ?>;
        cookie_seller_id_array = cookie_seller_id_array.split(",");
        //銷售類別_id
        let cookie_sale_category_array = <?php if(isset($_COOKIE["order_sale_category_list"])){echo '"' . $_COOKIE["order_sale_category_list"] . '"';}else{ echo '""';} ?>;
        cookie_sale_category_array = cookie_sale_category_array.split(",");
        //商品_id
        let cookie_product_id_array = <?php if(isset($_COOKIE["order_product_id_list"])){echo '"' . $_COOKIE["order_product_id_list"] . '"';}else{ echo '""';} ?>;
        cookie_product_id_array = cookie_product_id_array.split(",");
        //項目_id
        let cookie_item_id_array = <?php if(isset($_COOKIE["order_item_id_list"])){echo '"' . $_COOKIE["order_item_id_list"] . '"';}else{ echo '""';} ?>;
        cookie_item_id_array = cookie_item_id_array.split(",");
        //數量
        let cookie_quantity_array = <?php if(isset($_COOKIE["order_quantity_list"])){echo '"' . $_COOKIE["order_quantity_list"] . '"';}else{ echo '""';} ?>;
        cookie_quantity_array = cookie_quantity_array.split(",");
        console.log(cookie_item_id_array);
            

        let fdata = new FormData();
        let product_id = cookie_product_id_array;
        // fdata.append('productId', product_id);
        // fdata.append('salesCategory', "rent");
        fdata.append('submit',"order");
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
            
            let total_sum = 0;
            let card_list = "";
            for(i = 0; i < cookie_item_id_array.length; i++){
                let card = "";
                let price = 0;
                let size = "...";
                let item_id = 0;
                
                //以儲存在cookie的項目id取得商品項目之價格
                for(j = 0; j < product_data[i].length; j++){
                    if(product_data[i][j]["rent_detail_id"] == cookie_item_id_array[i]){
                        price = product_data[i][j]["price"];
                        size = product_data[i][j]["size"];
                        item_id = product_data[i][j]["rent_detail_id"];
                    }
                }
                let sum = Number(price) * Number(cookie_quantity_array[i]);
                card += '<div class="row mb-2"><div class="col-2">';
                card += '<img class="border" style="width:75%; object-fit:cover;" src="' + product_data[i][0]["path"] + product_data[i][0]["photo_name"] + '">';
                card += '</div><div class="col-3">';
                card += '<p>' + product_data[i][0]["title"] + '</p>';
                card += '<input type="hidden" name="title[]" value="' + product_data[i][0]["title"] + '">';
                card += '</div><div class="col-2">';
                card += '<p>' + size + '</p>';
                card += '<input type="hidden" name="item[]" value="' + size + '">';
                card += '<input type="hidden" name="item_id[]" value="' + item_id + '">';
                card += '</div><div class="col-2">';
                card += '<p>' + price + '</p>';
                card += '<input type="hidden" name="price[]" value="' + price + '">';
                card += '</div><div class="col-2">';
                card += '<p>' + cookie_quantity_array[i] + '</p>';
                card += '</div><div class="col-1">';
                card += '<p>' + sum + '</p>';
                card += '</div></div>';
                card_list += card;
                total_sum += sum;
                
            }
            
            console.log(card_list);
            order_list.innerHTML = card_list;
            total_sum_tag.innerText = '$ ' + total_sum;
        });
            
    }
    get_cart();

    function changeDelivery(id){
        let delivery_input_tag = document.getElementById("delivery_input");
        let input_list = '';
        switch (id){
            case 1:
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>運費<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-1">';
                input_list += '<input type="hidden" id="delivery_fee" name="delivery_fee" value="0">';
                input_list += '<span>0</span>';
                input_list += '</div>';
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>地址<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-3">';
                input_list += '<input type="text" class="form-control" id="addr" name="addr" placeholder="地址" required>';
                input_list += '</div>';
                break;
            case 2:
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>運費<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-1">';
                input_list += '<input type="hidden" id="delivery_fee" name="delivery_fee" value="60">';
                input_list += '<span>60</span>';
                input_list += '</div>';
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>門市名稱<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-3">';
                input_list += '<input type="text" class="form-control" id="addr" name="store_name" placeholder="門市名稱" required>';
                input_list += '</div>';
                break;
            case 3:
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>運費<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-1">';
                input_list += '<input type="hidden" id="delivery_fee" name="delivery_fee" value="100">';
                input_list += '<span>100</span>';
                input_list += '</div>';
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>地址<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-3">';
                input_list += '<input type="text" class="form-control" id="addr" name="addr" placeholder="地址" required>';
                input_list += '</div>';
                break;
        }
        delivery_input_tag.innerHTML = input_list;
    }

    function changePayment(id){
        let payment_input_tag = document.getElementById("payment_input");
        let input_list = '';
        let date = new Date();
        let today = date.getFullYear() + '-' + (date.getMonth()+1);
        console.log(today);
        switch (id){
            case 2:
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>卡片號碼<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-3">';
                input_list += '<input type="number" class="form-control" id="item1" name="credit_card_number" placeholder="信用卡號碼" required>';
                input_list += '</div>';
                input_list += '<div class="col-2 text-end">';
                input_list += '<p>有效期限(YY/MM)<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-2">';
                input_list += '<input type="text" class="form-control" id="item1" name="expiry_date" placeholder="有效日期(YY/MM)" required>';
                input_list += '</div>';
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>檢查碼<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-3">';
                input_list += '<input type="number" class="form-control" id="item1" name="check_code" placeholder="檢查碼" required>';
                input_list += '</div>';
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>持卡人姓名<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-3">';
                input_list += '<input type="text" class="form-control" id="item1" name="credit_card_name" placeholder="持卡人姓名" required>';
                input_list += '</div>';
                break;
            case 3:
                input_list += '<div class="col-1 text-end">';
                input_list += '<p>銀行帳號末5碼<span class="text-danger" required="required">*</span></p>';
                input_list += '</div>';
                input_list += '<div class="col-3">';
                input_list += '<input type="text" class="form-control" id="item1" name="transfer_end_code" maxlength="5" placeholder="銀行帳號末5碼" required>';
                input_list += '</div>';
                break;
        }
        payment_input_tag.innerHTML = input_list;
    }
</script>
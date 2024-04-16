<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>顧客租借明細</title>
</head>
<body>
    <?php 
        include("header.php");
    ?>
    <div class="container">
        <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="index.php">首頁</a></li>
                <li class="breadcrumb-item"><a class="link-secondary" href="my-order.php">顧客租借單</a></li>
                <li class="breadcrumb-item active" aria-current="page">租借明細</li>
            </ol>
        </nav>
        <div class="p-4 mt-3 border border-1 rounded" id="view">
            <h3 class="pb-3">商品資訊</h3>
            <table class="table table table-hover align-middle">
                <thead>
                    <tr>
                        <!-- <th scope="col">編號</th> -->
                        <th scope="col">商品相片</th>
                        <th scope="col">商品名稱</th>
                        <th scope="col">項目</th>
                    </tr>
                </thead>
                <tbody id="order_table">
                    <tr>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                    </tr>
                </tbody>
            </table>
            <div id="order_info" class="mb-5"></div>
            <div id="msg" class="text-center"></div>

            <div class="row mt-2" id="info">
                <div class="col-xl-6 col-12">
                    <h3 class="pb-3">租借人資訊</h3>
                    <p>姓名：<span></span></p>
                    <p>聯絡電話：<span></span></p>
                    <p>Email：<span></span></p>
                </div>
                <div class="col-xl-6 col-12">
                    <h3 class="pb-3">支付資訊</h3>
                    <p>支付方式：<span></span></p>
                    <h3 class="pb-3">配送資訊</h3>
                    <p>配送方式：<span></span></p>
                </div>
            </div>
        </div>

        <div class="p-4 my-3 border border-1 rounded" id="control">
            <h3 class="pb-3">商家操作</h3>
            <form action="includes/order.inc.php" method="POST">
                <div id="trade_state" class="row my-3">
                    <div class="col-auto">
                        <span>快捷操作：</span>
                    </div>
                    <!-- <div class="col-auto">
                        <button class="btn btn-success" type="submit" id="btn2" name="btn" value="2">接受租借</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-danger" type="submit" id="btn5" name="btn" value="5">拒絕租借</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-warning" type="submit" id="btn3" name="btn" value="3">出貨</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-danger" type="submit" id="btn4" name="btn" value="4">歸還</button>
                    </div> 
                    <div class="col-auto">
                        <button class="btn btn-danger" type="submit" id="btn6" name="btn" value="6">取消</button>
                    </div>                 -->
                </div>
                <div id="trade_state_btn" class="row my-3">
                    <div class="col-auto">
                        <span>快捷操作：</span>
                    </div>
                    <!-- <div class="col-auto">
                        <button class="btn btn-success" type="submit" id="btn2" name="btn" value="2">接受租借</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-danger" type="submit" id="btn5" name="btn" value="5">拒絕租借</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-warning" type="submit" id="btn3" name="btn" value="3">出貨</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-danger" type="submit" id="btn4" name="btn" value="4">歸還</button>
                    </div> 
                    <div class="col-auto">
                        <button class="btn btn-danger" type="submit" id="btn6" name="btn" value="6">取消</button>
                    </div>                 -->
                </div>
                <!-- <div class="row mt-3">
                    <div class="col-auto">
                        <span>狀態修改：</span>
                    </div>
                    <div class="col-auto">
                    <select id="trade_category" class="form-select" aria-label="Default select example" name="tradeCategory" required>
                        <option disabled>租借狀態</option>
                        <option value="1" selected >--</option>
                    </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-secondary btn-sm" type="submit" name="sendTradeState">修改狀態</button>
                    </div>
                </div> -->
                <input type="hidden" name="orderId" value="<?php echo $_GET["orderId"]; ?>">
            </form>
        </div>
    </div>
</body>
</html>

<script>
    var order = "";
    async function getSpecifyOrder(){
        let order_table = document.getElementById("order_table");
        let msg_tag = document.getElementById("msg");
        let view_tag = document.getElementById("view");
        let control_tag = document.getElementById("control");
        let order_info_tag = document.getElementById("order_info");
        let info_tag = document.getElementById("info");
        let fdata = new FormData();
        let order_id = <?php if(isset($_GET["orderId"])){echo $_GET["orderId"];}else{echo "false";} ?>;
        if(!order_id){
            control_tag.innerHTML = '';
            view_tag.innerHTML = '<div class="text-center">無資料</div>';
            return;
        }
        let payment_category = await getPayment();
        // console.log(payment_category);
        let delivery_category = await getDelivery();
        // console.log(delivery_category);
        payment_category = JSON.parse(payment_category);
        delivery_category = JSON.parse(delivery_category);
        fdata.append('orderId', order_id);
        fdata.append('getSpecifyOrder', true);
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fetch('includes/order.inc.php',
        {
            method: 'post',
            body: fdata
        })
        .then(function(response) {
        return response.text();
        })
        .then(function(data) {
            
            let order_data = '';
            //let previou = 0;

            console.log(data);
            if(data == "nullData"){
                control_tag.innerHTML = '';
                view_tag.innerHTML = '<div class="text-center">該筆訂單不存在<br><a class="btn btn-secondary btn-sm mt-3" href="index.php">回首頁</a></div>';
                return;
            }else{
                order = JSON.parse(data); //全域變數
            }
            
            console.log(JSON.parse(data));
            
            //因每筆租借回傳回該商品圖片筆數，所以要排除重複的項目
            let order_datail_id_array = Array();
            for(i = 0; i < order.length; i++){
                let trade = "";                
                let rent_name_list = "";
                // console.log(current_order_id);
                // console.log(previous_order_id);
                order_data += '<tr>';
                // order_data += '    <td>' + order[i]["order_id"] + '</td>';
                if(!order_datail_id_array.includes(order[i]["order_detail_id"])){
                    order_datail_id_array.push(order[i]["order_detail_id"]);
                    
                    order_data += '    <td>' + '<img style="width:100px; height:100px; object-fit:cover;" src="'+ order[i]["path"] + order[i]["photo_name"] + '">' + '</td>';
                    order_data += '    <td>' + order[i]["rent_name"] + '</td>';
                    order_data += '    <td>' + order[i]["rent_item_name"] + '</td>';
                }
                order_data += '</tr>'
                
            }
            let order_info_data = '<p class="text-black-50">建立日期：' + order[0]["create_date"] + '</p>';
            let update_date = order[0]["update_date"];
            if(order[0]["update_date"] == null){
                update_date = '';
            }
            order_info_data += '<p class="text-black-50">修改日期：' + update_date + '</p>';
            let payment_name = '';
            let delivery_name = '';
            
            console.log("長度：" + payment_category.length);
            for(i = 0; i < payment_category.length; i++){
                if(order[0]["payment"] == payment_category[i]["payment_id"]){
                    payment_name = payment_category[i]["payment_name"];
                }
            }
            for(i = 0; i < delivery_category.length; i++){
                if(order[0]["delivery"] == delivery_category[i]["delivery_id"]){
                    delivery_name = delivery_category[i]["delivery_name"];
                }
            }

            let info_data = '';
            info_data += '<div class="col-xl-6 col-12">';
            info_data += '    <h3 class="pb-3">租借人資訊</h3>';
            info_data += '    <p>姓名：<span>' + order[0]["name"] + '</span></p>';
            info_data += '    <p>聯絡電話：<span>' + order[0]["phone"] + '</span></p>';
            info_data += '    <p>Email：<span>' + order[0]["email"] + '</span></p>';
            info_data += '</div>';
            info_data += '<div class="col-xl-6 col-12">';
            info_data += '    <h3 class="pb-3">支付資訊</h3>';
            info_data += '    <p>支付方式：<span>' + payment_name + '</span></p>';
            switch (order[0]["payment"]){
                case 3:
                    info_data += '    <p>帳號末5碼：<span>' + order[0]["transfer_end_code"] + '</span></p>';
                    break;
            }
            info_data += '    <h3 class="pb-3">配送資訊</h3>';
            info_data += '    <p>配送方式：<span>' + delivery_name + '</span></p>';
            info_data += '    <p>運費：<span>' + order[0]["delivery_fee"] + '</span></p>';
            switch (order[0]["delivery"]){
                case 1:
                case 3:
                    info_data += '    <p>地址：<span>' + order[0]["address"] + '</span></p>';
                    break;
                case 2:
                    info_data += '    <p>門市名稱：<span>' + order[0]["store_name"] + '</span></p>';
                    break;
            }
            info_data += '</div>';
            if(order.length == 0){
                order_table.innerHTML = '無資料';
            }else{
                order_table.innerHTML = order_data;
                order_info_tag.innerHTML = order_info_data;
                info_tag.innerHTML = info_data;
            }

            //按鈕規則            
            let trade_btn_tag = document.getElementById("trade_state_btn");
            let trade_list = '';
            
            trade_list += '<div class="col-auto"><span>快捷操作：</span></div>';
            switch(order[0]["trade_state"]){
                case 1:
                    trade_list += '<div class="col-auto"><button class="btn btn-success" type="submit" id="btn2" name="btn" value="2" >接受租借</button></div>';
                    trade_list += '<div class="col-auto"><button class="btn btn-danger" type="submit" id="btn5" name="btn" value="5" >拒絕租借</button></div>';
                    trade_list += '<div class="col-auto"><button class="btn btn-danger" type="submit" id="btn6" name="btn" value="6" >取消</button></div>';
                    break;
                case 2:
                    trade_list += '<div class="col-auto"><button class="btn btn-warning" type="submit" id="btn3" name="btn" value="3" >出貨</button></div>';
                    trade_list += '<div class="col-auto"><button class="btn btn-danger" type="submit" id="btn6" name="btn" value="6" >取消</button></div>';
                    break;
                case 3:
                    trade_list += '<div class="col-auto"><button class="btn btn-danger" type="submit" id="btn4" name="btn" value="4" >歸還</button></div> ';
                    break;
                default:
                    break;
            }
            trade_btn_tag.innerHTML = trade_list;
            
            
            
            // 暫時關閉改租單狀態功能
            getTrade(order[0]["trade_state"]);
        });
    }

    function getTrade(trade_id){
        var fdata = new FormData();
        fdata.append('getTradeCategory', "");
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fetch('includes/order.inc.php',
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
                console.log("處理狀態資料讀取失敗...");
                return;
            }
            let trade_category = JSON.parse(data);
            console.log(trade_category);
            // let trade_category_tag = document.getElementById("trade_category");
            // let print_category = '<option disabled>租借狀態</option>';
            // for(i = 0; i < trade_category.length; i++){
            //     id = i + 1;
                
            //     if(id == order[0]["trade_state"]){
            //         print_category += '<option value="' + id + '" selected >' + trade_category[i]["btn_name"] + '</option>';
            //     }else{
            //         print_category += '<option value="' + id + '" >' + trade_category[i]["btn_name"] + '</option>';
            //     }
            // }
            // trade_category_tag.innerHTML = print_category;
            let trade_state_tag = document.getElementById("trade_state");
            let current_trade_list = '';
            let trade_name = '';
            for(i = 0; i < trade_category.length; i++){
                if(trade_id == trade_category[i]["trade_state_id"]){
                    trade_name = trade_category[i]["category_name"];
                    break;
                }
            }
            current_trade_list += '<div class="col-auto"><span>租借狀態：</span></div>';
            current_trade_list += '<div class="col-auto"><span>' + trade_name + '</span></div>';
            trade_state_tag.innerHTML = current_trade_list;
        });
    }

    async function getPayment(){
        let payment = "";
        var fdata = new FormData();
        fdata.append('getPaymentCategory', "");
        //透過表單送出資料(非同步傳輸)至後端處理程式
        await fetch('includes/order.inc.php',
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
                console.log("處理狀態資料讀取失敗...");
                return;
            }
            // let payment_category = JSON.parse(data);
            //console.log(payment_category);
            //return JSON.parse(data);
            payment = data;
        });
        return payment;
    }

    async function getDelivery(){
        let delivery = "";
        var fdata = new FormData();
        fdata.append('getDeliveryCategory', "");
        //透過表單送出資料(非同步傳輸)至後端處理程式
        await fetch('includes/order.inc.php',
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
                console.log("處理狀態資料讀取失敗...");
                return;
            }
            //let payment_category = JSON.parse(data);
            //console.log(payment_category);
            delivery = data;
        });
        return delivery;
    }
    getSpecifyOrder();
    
</script>
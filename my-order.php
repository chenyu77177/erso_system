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
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/bootstrap.bundle.min.js"></script>
      <title>顧客租借單管理 - erso租借交易平台</title>
    </head>
    <body>
        <?php 
            include("header.php");
        ?>
        <section>
            <div class="container my-3">
                <div class="row">
                    <div class="col-3">
                        <div class="shadow-sm p-3 mb-5 bg-body rounded border">
                            <p class="border_btm">功能列</p>
                            <?php 
                                include("function-bar.php");
                            ?>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="shadow-sm p-5 mb-5 bg-body rounded border">
                            <h4>顧客租借單管理</h4>
                            <hr>
                            <table class="table table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">訂單日期</th>
                                        <th scope="col">商品</th>
                                        <th scope="col">租借人</th>
                                        <th scope="col">處理狀態</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody id="order_table">
                                    <tr>
                                        <td>...</td>
                                        <td>...</td>
                                        <td>...</td>
                                        <td>...</td>
                                        <td>...</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div id="msg" class="text-center"></div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </section>

    </body>
</html>

<script>
    let order = "";
    function getOrder(){
        var fdata = new FormData();
        var user_id = <?php echo $_SESSION["userid"]; ?>;
        fdata.append('userId', user_id);
        fdata.append('getSellerAllOrder', true);
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
            let order_table = document.getElementById("order_table");
            let msg_tag = document.getElementById("msg");
            let order_data = '';
            let previou = 0;

            console.log(data);
            if(data == "nullData"){
                order_table.innerHTML = "";
                msg_tag.innerHTML = "尚無訂單";
                return;
            }else{
                order = JSON.parse(data); //全域變數
            }
            
            console.log(JSON.parse(data));
            
            for(i = 0; i < order.length; i++){
                if(previou != order[i]["order_id"]){
                    let trade = "";
                    let trade_color = "";
                    let current_order_id = order[i]["order_id"];
                    let rent_name_list = "";
                    for(j = 0; j < trade_category.length; j++){
                        if(order[i]["trade_state"] == trade_category[j]["trade_state_id"]){
                            trade = trade_category[j]["category_name"];
                            trade_color = trade_category[j]["color"];
                            break;
                        }
                    }
                    order_data += '<tr>';
                    order_data += '    <td>' + order[i]["order_id"] + '</td>';
                    order_data += '    <td>' + order[i]["create_date"] + '</td>';
                    for(j = i ; j < order.length; j++){
                        if(current_order_id == order[j]["order_id"]){
                            let name = order[j]["rent_name"];
                            if(name.length >= 15){
                                rent_name_list += name.substr(0,15) + "...<br>";
                            }else{
                                rent_name_list += name + "<br>";
                            }
                            
                        }
                    }
                    order_data += '    <td>' + rent_name_list + '</td>';
                    order_data += '    <td>' + order[i]["name"] + '</td>';
                    order_data += '    <td><span class="badge rounded-pill bg-' + trade_color + '">' + trade + '</span></td>';
                    order_data += '    <td><a class="btn btn-primary" href="order-process.php?orderId=' + order[i]["order_id"] + '">檢視</a></td>';
                    order_data += '</tr>';
                }
                previou = order[i]["order_id"];
                
            }
            if(order.length = 0){
                order_table.innerHTML = '無資料';
            }else{
                order_table.innerHTML = order_data;
            }
            
        });
    }

    let trade_category = "";
    function getTrade(){
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
            trade_category = JSON.parse(data);
            console.log(trade_category);
            getOrder();
        });
    }
    getTrade();

</script>
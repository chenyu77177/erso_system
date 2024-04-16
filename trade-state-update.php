<?php
session_start();
if($_SESSION["permission"] == "user"){
    header("Location: index.php");
    exit();
}
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
      <title>交易狀態管理介面 - erso租借交易平台</title>
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
                                include("admin-bar.php");
                            ?>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="shadow-sm p-5 mb-5 bg-body rounded border">
                            <h4>交易狀態管理介面</h4>
                            <hr>
                            <table class="table table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">名稱</th>
                                        <th scope="col">使用者端顯示</th>
                                        <th scope="col">店家端按鈕顯示</th>
                                        <th scope="col">顏色</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody id="trade_table">
                                    <tr>
                                        <td>...</td>
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
    
    function getTradeState(){
        let fdata = new FormData();
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fdata.append("getTradeCategory", true);
        fetch('includes/order.inc.php',
        {
            method: 'post',
            body: fdata
        })
        .then(function(response) {
        return response.text();
        })
        .then(function(data) {
            let trade_table = document.getElementById("trade_table");
            let msg_tag = document.getElementById("msg");
            let trade_data = "";
            let trade_list = "";

            //console.log(data);
            //回傳資料判斷
            if(trade_data == "nullData"){
                trade_table.innerHTML = "";
                msg_tag.innerHTML = "尚無交易狀態類別";
                return;
            }else{
                trade_data = JSON.parse(data);
            }

            //bootstrap 顏色
            let color = ["primary", "secondary", "success", "danger", "warning", "info", "light", "dark"];
            let color_name = ["藍色", "灰色", "綠色", "紅色", "黃色", "青色", "亮色", "深色"];
            //資料整理
            for(i = 0; i < trade_data.length; i++){
                let color_list = "";
                trade_list += '<tr>';
                trade_list += '    <td>' + trade_data[i]["trade_state_id"] + '</td>';
                trade_list += '    <td><input type="text" class="form-control" id="category_name_' + trade_data[i]["trade_state_id"] + '" value="' + trade_data[i]["category_name"] + '" requirde></td>';
                trade_list += '    <td><input type="text" class="form-control" id="user_show_name_' + trade_data[i]["trade_state_id"] + '" value="' + trade_data[i]["user_show_name"] + '" requirde></td>';
                trade_list += '    <td><input type="text" class="form-control" id="btn_name_' + trade_data[i]["trade_state_id"] + '" value="' + trade_data[i]["btn_name"] + '" requirde></td>';
                color_list += '    <td><select id="trade_color_' + trade_data[i]["trade_state_id"] + '" class="form-select" aria-label="Default select example" required>';
                for(j = 0; j < color.length; j++){
                    
                    if(trade_data[i]["color"] == color[j]){
                        color_list += '<option value="' + color[j] + '" selected >' + color_name[j] + '</option>';
                    }else{
                        color_list += '<option value="' + color[j] + '" >' + color_name[j] + '</option>';
                    }
                }
                color_list += '</select></td>';
                trade_list += color_list;
                trade_list += '    <td><a class="btn btn-success" onclick="update_trade(' + trade_data[i]["trade_state_id"] + ')" >修改</a></td>';
                
            }
            trade_table.innerHTML = trade_list;
            
        });
    }

    getTradeState();

    function update_trade(trade_id){
        //取得標籤
        let category_name = document.getElementById("category_name_" + trade_id);
        let user_show_name = document.getElementById("user_show_name_" + trade_id);
        let btn_name = document.getElementById("btn_name_" + trade_id);
        let color = document.getElementById("trade_color_" + trade_id);

        let fdata = new FormData();
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fdata.append("trade_id", trade_id);
        fdata.append("category_name", category_name.value);
        fdata.append("user_show_name", user_show_name.value);
        fdata.append("btn_name", btn_name.value);
        fdata.append("color", color.value);
        fdata.append("updateTradeCategory", true);
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

            //回傳資料判斷
            if(data == true){
                alert("更新成功");
            }else if(data == false){
                alert("無資料被更新");
            }else{
                alert("更新錯誤 [" + data + "]");
            }
            
        });
    }

</script>
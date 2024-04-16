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
      <title>配送方式管理介面 - erso租借交易平台</title>
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
                            <h4>配送方式管理介面</h4>
                            <hr>
                            <table class="table table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">名稱</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody id="delivery_table">
                                    <tr>
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
    
    function getDelivery(){
        let fdata = new FormData();
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fdata.append("getDeliveryCategory", true);
        fetch('includes/order.inc.php',
        {
            method: 'post',
            body: fdata
        })
        .then(function(response) {
        return response.text();
        })
        .then(function(data) {
            let delivery_table = document.getElementById("delivery_table");
            let msg_tag = document.getElementById("msg");
            let delivery_data = "";
            let delivery_list = "";

            //console.log(data);
            //回傳資料判斷
            if(delivery_data == "nullData"){
                delivery_table.innerHTML = "";
                msg_tag.innerHTML = "尚無使用者";
                return;
            }else{
                delivery_data = JSON.parse(data);
            }

            //資料整理
            for(i = 0; i < delivery_data.length; i++){
                delivery_list += '<tr>';
                delivery_list += '    <td>' + delivery_data[i]["delivery_id"] + '</td>';
                delivery_list += '    <td><input type="text" class="form-control" id="delivery_name_' + delivery_data[i]["delivery_id"] + '" value="' + delivery_data[i]["delivery_name"] + '" requirde></td>';
                delivery_list += '    <td><a class="btn btn-success" onclick="update_delivery_name(' + delivery_data[i]["delivery_id"] + ')" >修改</a></td>';
                delivery_list += '</tr>';
            }
            delivery_table.innerHTML = delivery_list;
            
        });
    }

    getDelivery();

    function update_delivery_name(delivery_id){
        //取得標籤
        let delivery_name = document.getElementById("delivery_name_" + delivery_id);
        
        let fdata = new FormData();
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fdata.append("delivery_id", delivery_id);
        fdata.append("delivery_name", delivery_name.value);
        fdata.append("updateDeliveryCategory", true);
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
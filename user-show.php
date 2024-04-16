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
      <title>使用者管理介面 - erso租借交易平台</title>
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
                            <h4>使用者管理介面</h4>
                            <hr>
                            <table class="table table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">名稱</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">身分</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody id="user_table">
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
    
    function getUser(){
        var fdata = new FormData();
        //透過表單送出資料(非同步傳輸)至後端處理程式
        fdata.append("getUser", true);
        fetch('includes/user-read.inc.php',
        {
            method: 'post',
            body: fdata
        })
        .then(function(response) {
        return response.text();
        })
        .then(function(data) {
            let user_table = document.getElementById("user_table");
            let msg_tag = document.getElementById("msg");
            let user_data = "";
            let user_list = "";

            // console.log(data);
            //回傳資料判斷
            if(user_data == "nullData"){
                user_table.innerHTML = "";
                msg_tag.innerHTML = "尚無使用者";
                return;
            }else{
                user_data = JSON.parse(data);
            }

            let permission = ["admin", "webmaster", "user"];
            let permission_name = ["系統管理員", "網站管理員", "使用者"];
            //資料整理
            for(i = 0; i < user_data.length; i++){
                let permission_list = '';
                user_list += '<tr>';
                user_list += '    <td>' + user_data[i]["user_id"] + '</td>';
                user_list += '    <td>' + user_data[i]["user_name"] + '</td>';
                user_list += '    <td>' + user_data[i]["user_email"] + '</td>';

                permission_list += '    <td><select id="permission_' + user_data[i]["user_id"] + '" class="form-select" aria-label="Default select example" required disabled>';
                for(j = 0; j < permission.length; j++){
                    
                    if(user_data[i]["permission"] == permission[j]){
                        permission_list += '<option value="' + permission[j] + '" selected >' + permission_name[j] + '</option>';
                    }else{
                        permission_list += '<option value="' + permission[j] + '" >' + permission_name[j] + '</option>';
                    }
                }
                permission_list += '</select></td>';

                user_list += permission_list;
                //user_list += '    <td>' + user_data[i]["permission"] + '</td>';
                //user_list += '    <td><a class="btn btn-success" onclick="update_permission(' + user_data[i]["user_id"] + ')" >修改</a></td>';
                user_list += '<td></td>';
                user_list += '</tr>';
            }
            user_table.innerHTML = user_list;
            
        });
    }

    getUser();

</script>
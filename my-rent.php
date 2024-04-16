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
      <title>店家商品管理 - erso租借交易平台</title>
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
                            <h4>個人商品管理</h4>
                            <hr>
                            <table class="table table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">商品相片</th>
                                        <th scope="col">商品名稱</th>
                                        <th scope="col">儲存狀態</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody id="rent_table">
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
    var product = "";
    var product_photo = "";
    function getProduct(){
        var fdata = new FormData();
        var seller_id = <?php echo $_SESSION["userid"]; ?>;
        fdata.append('sellerId', seller_id);
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
            let rent_table = document.getElementById("rent_table");
            let msg_tag = document.getElementById("msg");
            let rent_data = '';
            let previou = "";

            console.log(data);
            if(data == "nullData"){
                rent_table.innerHTML = "";
                msg_tag.innerHTML = "您尚未建立商品";
                return;
            }else{
                product = JSON.parse(data); //全域變數
            }
            
            console.log(product);
            
            for(i = 0; i < product.length; i++){
                let send_category = ""
                if(product[i]["save_category"]){
                    send_category = "架上";
                }else{
                    send_category = "架下";
                }
                
                if(previou != product[i]["rent_id"]){
                    rent_data += '<tr>';
                    rent_data += '    <td>' + product[i]["rent_id"] + '</td>';
                    rent_data += '    <td><img width="100px" src="' + product[i]["path"] + product[i]["photo_name"] + '"></td>';
                    rent_data += '    <td>' + product[i]["title"] + '</td>';
                    rent_data += '    <td>' + send_category + '</td>';
                    rent_data += '    <td><a class="btn btn-primary" href="rent-update.php?productId=' + product[i]["rent_id"] + '">修改</a></td>';
                    rent_data += '</tr>';
                }
                previou = product[i]["rent_id"];
                
            }
            if(product.length = 0){
                rent_table.innerHTML = '無資料';
            }else{
                rent_table.innerHTML = rent_data;
            }
            
        });
    }

    // function getPhoto(){
    //     var fdata = new FormData();
    //     fdata.append('productId',<?php //echo $_GET["productId"]; ?>);
    //     fdata.append('salesCategory', "rent");
    //     fdata.append('type',"photo");
    //     //透過表單送出資料(非同步傳輸)至後端處理程式
    //     fetch('includes/product.inc.php',
    //     {
    //         method: 'post',
    //         body: fdata
    //     })
    //     .then(function(response) {
    //     return response.text();
    //     })
    //     .then(function(data) {
    //         console.log(data);
    //         var product_photo = JSON.parse(data);
    //         console.log(product_photo);
    //     });
    // }

    getProduct();
    // getPhoto();

</script>
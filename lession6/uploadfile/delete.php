<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Xóa ảnh</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>
            .box-content{
                margin: 0 auto;
                width: 800px;
                border: 1px solid #ccc;
                text-align: center;
                padding: 20px;
            }
            #create_user form{
                width: 200px;
                margin: 40px auto;
            }
            #create_user form input{
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <?php
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            $url = $_GET['url'];
            unlink($url);
            ?>
            <div id="success-notify" class="box-content">
                <h1>Xóa ảnh thành công</h1>
                <a href="./index.php">Danh sách ảnh</a>
            </div>
        <?php } ?>
    </body>
</html>

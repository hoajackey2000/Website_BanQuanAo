<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Đăng xuất tài khoản</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/login_register.css">
    </head>
    <body>
        <?php
        session_start();
        unset($_SESSION['current_user']);
        unset($_SESSION['access_token']);
        unset($_SESSION['cart']);
        ?>
        <div id="user_logout" class="box-content">
            <h1>Đăng xuất tài khoản thành công</h1>
            <a href="./login.php">Đăng nhập lại</a>
            <br></br>
            <a href="./index.php">Quay lại trang chủ</a>
        </div>
    </body>
</html>

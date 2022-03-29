<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Trang Quản Trị</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css" >
        <script src="../resources/ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <?php
        session_start();



        if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
                $result = mysqli_query($con, "Select `id`,`username`,`fullname`,`birthday` from `user` WHERE (`username` ='" . $_POST['username'] . "' AND `password` = md5('" . $_POST['password'] . "'))");
                if (!$result) {
                    $error = mysqli_error($con);
                }
                if ($error !== false || $result->num_rows == 0) {
                    ?>
                    <div id="login-notify" class="box-content">
                        <h1>Thông báo</h1>
                        <h4><?= !empty($error) ? $error : "Thông tin đăng nhập không chính xác" ?></h4>
                        <a href="./login.php">Quay lại</a>
                    </div>
                    <?php
                    exit;
                }else {
                    $user = mysqli_fetch_assoc($result);
                    $_SESSION['current_user'] = $user;
                }
                mysqli_close($con);
                
                ?>
            <?php } 


    $param = "";
    $sortParam = "";
    $orderConditon = "";
        include '../../config/connect_db.php';
        include '../../function/function.php';
        $regexResult = checkPrivilege(); //Kiểm tra quyền thành viên
        if (!$regexResult) {
            echo "Bạn không có quyền truy cập chức năng này";
            exit;
        }
        
        if (!empty($_SESSION['current_user'])) { //Kiểm tra xem đã đăng nhập chưa?
            ?>
            <?php if (!empty($_SESSION['current_user'])) {
            $currentUser = $_SESSION['current_user'];
            ?>
            <div id="admin-heading-panel">
                    <div class="right-panel">
                        <img height="24" src="../images/home.png">
                        <a href="../index.php">Trang chủ</a>
                        <img height="24" src="../images/logout.png">
                        <a href="logout.php">Ðăng Xuất</a>
                        <a href="register.php">Ðăng Ký</a>
                    </div>

                    <div id="container" class="left-panel">
                    Xin chào <span> <?= $currentUser['fullname'] ?></span><br/>                        
                    </div>
                </div>
            </div>

            <?php
    }  ?>
    
            <div id="content-wrapper">
                <div class="container">
                    <div class="left-menu">
                        <div class="menu-heading">Admin Menu</div>
                        <div class="menu-items">
                            <ul>
                                <li><a href="dashboard.php">Thông tin hệ thống</a></li>
                                <?php if (checkPrivilege('menu_listing.php')) { ?>
                                    <li><a href="menu_listing.php">Danh mục</a></li>
                                <?php } ?>
                                <?php if (checkPrivilege('news_listing.php')) { ?>
                                    <li><a href="#">Tin tức</a></li>
                                <?php } ?>
                                <?php if (checkPrivilege('product_listing.php')) { ?>
                                    <li><a href="product_listing.php">Sản phẩm</a></li>
                                <?php } ?>
                                <?php if (checkPrivilege('order_listing.php')) { ?>
                                    <li><a href="order_listing.php">Đơn hàng</a></li>
                                <?php } ?>
                                <?php if (checkPrivilege('member_listing.php')) { ?>
                                    <li><a href="member_listing.php">Quản lý thành viên</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
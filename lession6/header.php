<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>WEB BÁN HÀNG</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/carouseller.css">
        <link rel="stylesheet" href="libs/fancybox/jquery.fancybox.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/fonts.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/category.css">
    </head>
    <body>
<?php
    include "../config/connect_db.php";
    session_start();

    $error = false;
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
    $error = false;

    include '../config/connect_db.php';
    include '../function/function.php';

    //Tìm kiếm
    $search = isset($_GET['name']) ? $_GET['name'] : "";
    if ($search) {
        $where = "WHERE `name` LIKE '%" . $search . "%'";
        $param .= "name=".$search."&";
        $sortParam =  "name=".$search."&";
    }
    
    //Sắp xếp
    $orderField = isset($_GET['field']) ? $_GET['field'] : "";
    $orderSort = isset($_GET['sort']) ? $_GET['sort'] : "";
    if(!empty($orderField)
        && !empty($orderSort)){
        $orderConditon = "ORDER BY `product`.`".$orderField."` ".$orderSort;
        $param .= "field=".$orderField."&sort=".$orderSort."&";
    }

    include '../config/connect_db.php';
    $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 8; 
    // kiểm tra xem có !empty($_GET['per_page']), nếu đúng thì thực hiện sau dấu ? và ngược lại thực hiện sau dấu :
        $current_page = !empty($_GET['page']) ? $_GET['page'] : 1; //Trang hiện tại
        $offset = ($current_page - 1) * $item_per_page;
        if ($search) {
            $products = mysqli_query($con, "SELECT * FROM `product` WHERE `name` LIKE '%" . $search . "%' ".$orderConditon."  LIMIT " . $item_per_page . " OFFSET " . $offset);
            $totalRecords = mysqli_query($con, "SELECT * FROM `product` WHERE `name` LIKE '%" . $search . "%'");
        } else {
            $products = mysqli_query($con, "SELECT * FROM `product` ".$orderConditon." LIMIT " . $item_per_page . " OFFSET " . $offset);
            $totalRecords = mysqli_query($con, "SELECT * FROM `product`");
        }
        $totalRecords = $totalRecords->num_rows;
        $totalPages = ceil($totalRecords / $item_per_page);


        if (!empty($_SESSION["cart"])) {
            $product = mysqli_query($con, "SELECT * FROM `product` WHERE `id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
        }

?>
         <div id="cart-icon">


        <span>
         
            <?php
            if (!empty($product)) {
                $total = 0;
                $num = 1;
                while ($row = mysqli_fetch_array($product)) {
                    ?>
                    <?php
                    $total += $_SESSION["cart"][$row['id']] ;
                    $num++;
                }
                ?>
                <!-- <tr id="row-total"> -->
                     <td class="product-quantity"><?= $total, "" ?></td>
                     
                <!-- </tr> -->
                <?php
            }
            ?>
    </span>

    

        





            <!-- <span>10</span> -->


            <a data-fancybox data-type="ajax" data-src="ajax-cart.php" href="javascript:;">
                <img width="100" src="images/cart-icon.png" alt="alt"/>
            </a>
        </div>

        <header>
       

        <section class="container">
            <div id="header-top">
                <span><img src="images/phone.png" />090 - 725 39 10</span>
                <span><img src="images/email.png" />fchuynhhoa2000@gmail.com</span>
            </div>
            <div id="header-bottom">
                <section id="header-left">
                    <img src="images/logo.png" />
        </section>

    <?php
        if (!empty($_SESSION['current_user'])) { //Kiểm tra xem đã đăng nhập chưa?
        ?> 
        <?php if (!empty($_SESSION['current_user'])) {
            $currentUser = $_SESSION['current_user'];
            ?>

        <div class="dropdown" style="float:right;">
                <button class="dropbtn">
                    Xin chào <span> <?= $currentUser['fullname'] ?></span><br/>                        
                </button>

                <div class="dropdown-content">
                    <a href="./logout.php">Đăng xuất</a>
                    </div>
        </div>
        <?php } ?>
        <?php }else { ?>
            <section id="header-right">
                        <section id="header-link">
                            <a id="cart-link" href="cart.php"><img src="images/cart.png" /></a>
                            <a id="login-link" href="./login.php">Đăng nhập</a>
                            <a id="register-link" href="register.php"><img src="images/register.png" /></a>
                        </section>
            </section>
        <?php }?>
  

    
        <section class="clear-both"></section>
                </div>
            </section>
            <section id="menu">
                <section class="container">
                    <ul>
                        <li><a href="./index.php">Trang chủ</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="./category.php">Sản phẩm</a></li>
                        <li><a href="#">Chúng tôi</a></li>
                        <li><a href="#">Liên hệ</a></li>
                        <li class="clear-both"></li>
                    </ul>
                    <div id="filter-box">
                        <form id="product-search" method="GET">
                            <input type="submit" value="" />
                            <input type="text" value="<?=isset($_GET['name']) ? $_GET['name'] : ""?>" name="name" placeholder="Tìm kiếm" />
                        </form>
                        <div style="clear: both;" ></div>
                    </div>
                    
                    
                </section>
            </section>

        </header>


 
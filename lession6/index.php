<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
    session_start();

    include '../config/connect_db.php';
    $error = false;
    if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
        $result = mysqli_query($con, "Select `id`,`username`,`email`,`fullname`,`birthday` from `user` WHERE (`username` ='" . $_POST['username'] . "' AND `password` = md5('" . $_POST['password'] . "'))");
        if (!$result) {
            $error = mysqli_error($con);
        } else {
            $user = mysqli_fetch_assoc($result);
            $userPrivileges = mysqli_query($con, "SELECT * FROM `user_privilege` INNER JOIN `privilege` ON user_privilege.privilege_id = privilege.id WHERE user_privilege.user_id = ".$user['id']);
            $userPrivileges = mysqli_fetch_all($userPrivileges, MYSQLI_ASSOC);
            if(!empty($userPrivileges)){
                $user['privileges'] = array();
                foreach($userPrivileges as $privilege){
                    $user['privileges'][] = $privilege['url_match'];
                }
            }
            $_SESSION['current_user'] = $user;
            // header('Location: dashboard.php');
        }
        mysqli_close($con);
        if ($error !== false || $result->num_rows == 0) {
            ?>
            <div id="login-notify" class="box-content">
                <h1>Thông báo</h1>
                <h4><?= !empty($error) ? $error : "Thông tin đăng nhập không chính xác" ?></h4>
                <a href="./login.php">Quay lại</a>
            </div>
            <?php
            exit;
        }
        ?>
        <?php } 
    $param = "";
    $sortParam = "";
    $orderConditon = "";
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
    $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 4;
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
        ?>


        <?php if (!empty($_SESSION['current_user'])) {
            $currentUser = $_SESSION['current_user'];
            ?>
            <div id="admin-heading-panel">
                    <div class="right-panel">
                        <img height="24" src="./images/home.png">
                        <a href="index.php">Trang chủ</a>
                        <img height="24" src="./images/logout.png">
                        <a href="./logout.php">Đăng xuất</a>
                        <a href="./register.php">Đăng Ký</a>
                    </div>

                    <div id="container-index" class="left-panel">
                    Xin chào <span> <?= $currentUser['fullname'] ?></span><br/>                        
                    </div>
                </div>
            </div>
            <?php
        


        }  ?>

            

        <div id="wrapper-product" class="container">
            <h1>Danh sách sản phẩm</h1>
            <div id="filter-box">
                <form id="product-search" method="GET">
                    <label>Tìm kiếm sản phẩm</label>
                    <input type="text" value="<?=isset($_GET['name']) ? $_GET['name'] : ""?>" name="name" />
                    <input type="submit" value="Tìm kiếm" />
                </form>
                <select id="sort-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="">Sắp xếp giá</option>
                    <option <?php if(isset($_GET['sort']) && $_GET['sort'] == "desc") { ?> selected <?php } ?> value="?<?=$sortParam?>field=price&sort=desc">Cao đến thấp</option>
                    <option <?php if(isset($_GET['sort']) && $_GET['sort'] == "asc") { ?> selected <?php } ?> value="?<?=$sortParam?>field=price&sort=asc">Thấp đến cao</option>
                </select>
                <div style="clear: both;" ></div>
            </div>
            <div class="product-items">
        
                <?php
                while ($row = mysqli_fetch_array($products)) {
                    ?>
                    <div class="product-item">
                        <div class="product-img">
                            <a href="detail.php?id=<?= $row['id'] ?>"><img src="./<?= $row['image'] ?>" title="<?= $row['name'] ?>" /></a>
                        </div>

                        <div id="product-info-index">
                            <strong><a href="detail.php?id=<?= $row['id'] ?>"><?= $row['name'] ?></a></strong><br/>
                            <label>Giá: </label><span class="product-price"><?= number_format($row['price'], 0, ",", ".") ?> VNĐ</span><br/>
                            <!-- <p><?= $row['content'] ?></p> -->
                            <form id="add-to-cart-form" action="cart.php?action=add" method="POST">
                                <input type="text" value="1" name="quantity[<?=$row['id']?>]" size="2" /><br/>
                                <input type="submit" value="Thêm Vào Giỏ Hàng" />
                            </form>
                            <?php if(!empty($product['images'])){ ?>
                            <div id="gallery">
                                <ul>
                                    <?php foreach($product['images'] as $img) { ?>
                                        <li><img src="./<?=$img['path']?>" /></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="clear-both"></div>
                <?php
                include '../function/pagination.php';
                ?>
            </div>
        </div>
</body>
</html>
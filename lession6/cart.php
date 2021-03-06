<?php include 'header.php';?>
<!DOCTYPE html>

<html>
    <head>
        <title>Giỏ Hàng</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/style.css" >
    </head>
    <body>
    <?php
        include '../config/connect_db.php';
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
        $GLOBALS['changed_cart'] = false;
        $error = false;
        $success = false;
        if (isset($_GET['action'])) {

            function update_cart($con, $add = false) {
                foreach ($_POST['quantity'] as $id => $quantity) {
                    if ($quantity == 0) {
                        unset($_SESSION["cart"][$id]);
                    } else {
                        if (!isset($_SESSION["cart"][$id])) {
                            $_SESSION["cart"][$id] = 0;
                        }
                        // var_dump($_SESSION["cart"][$id]);
                        if ($add) {
                            $_SESSION["cart"][$id] += $quantity;
                        } else {
                            $_SESSION["cart"][$id] = $quantity;
                        }
                        //Kiểm tra số lượng sản phẩm tồn kho
                        $addProduct = mysqli_query($con, "SELECT `quantity` FROM `product` WHERE `id` = " . $id);
                        $addProduct = mysqli_fetch_assoc($addProduct);
                        if ($_SESSION["cart"][$id] > $addProduct['quantity']) {
                            $_SESSION["cart"][$id] = $addProduct['quantity'];
                            $GLOBALS['changed_cart'] = true;
                        }
                    }
                }
            }

            switch ($_GET['action']) {
                case "add":
                    update_cart($con, true);
                    if ($GLOBALS['changed_cart'] == false) {
                        header('Location: ./cart.php');
                    }
                    break;
                case "delete":
                    if (isset($_GET['id'])) {
                        unset($_SESSION["cart"][$_GET['id']]);
                    }
                    header('Location: ./cart.php');
                    break;
                case "submit":
                    if (isset($_POST['update_click'])) { //Cập nhật số lượng sản phẩm
                        update_cart($con);
                        header('Location: ./cart.php');
                    } elseif ($_POST['order_click']) { //Đặt hàng sản phẩm
                        if (empty($_POST['name'])) {
                            $error = "Bạn chưa nhập tên của người nhận";
                        } elseif (empty($_POST['phone'])) {
                            $error = "Bạn chưa nhập số điện thoại người nhận";
                        } elseif (empty($_POST['address'])) {
                            $error = "Bạn chưa nhập địa chỉ người nhận";
                        } elseif (empty($_POST['quantity'])) {
                            $error = "Giỏ hàng rỗng";
                        }
                        if ($error == false && !empty($_POST['quantity'])) { //Xử lý lưu giỏ hàng vào db
                            $product = mysqli_query($con, "SELECT * FROM `product` WHERE `id` IN (" . implode(",", array_keys($_POST['quantity'])) . ")");
                            $total = 0;
                            $orderProducts = array();
                            $updateString = "";
                            while ($row = mysqli_fetch_array($product)) {
                                $orderProducts[] = $row;
                                if ($_POST['quantity'][$row['id']] > $row['quantity']) {
                                    $_POST['quantity'][$row['id']] = $row['quantity'];
                                    $GLOBALS['changed_cart'] = true;
                                } else {
                                    $total += $row['price'] * $_POST['quantity'][$row['id']];
                                    $updateString .= " when id = ".$row['id']." then quantity - ".$_POST['quantity'][$row['id']];
                                }
                            }
                            if ($GLOBALS['changed_cart'] == false) {
                                $updateQuantity = mysqli_query($con, "update `product` set quantity = CASE".$updateString." END where id in (".implode(",", array_keys($_POST['quantity'])).")");
                                $insertOrder = mysqli_query($con, "INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `note`, `total`, `created_time`, `last_updated`) VALUES (NULL, '" . $_POST['name'] . "', '" . $_POST['phone'] . "', '" . $_POST['address'] . "', '" . $_POST['note'] . "', '" . $total . "', '" . time() . "', '" . time() . "');");
                                $orderID = $con->insert_id;
                                $insertString = "";
                                foreach ($orderProducts as $key => $product) {
                                    $insertString .= "(NULL, '" . $orderID . "', '" . $product['id'] . "', '" . $_POST['quantity'][$product['id']] . "', '" . $product['price'] . "', '" . time() . "', '" . time() . "')";
                                    if ($key != count($orderProducts) - 1) {
                                        $insertString .= ",";
                                    }
                                }
                                $insertOrder = mysqli_query($con, "INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_time`, `last_updated`) VALUES " . $insertString . ";");
                                $success = "Đặt hàng thành công";
                                unset($_SESSION['cart']);
                            }
                        }
                    }
                    break;
            }
        }
        if (!empty($_SESSION["cart"])) {
            $product = mysqli_query($con, "SELECT * FROM `product` WHERE `id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
        }

    ?>
        <div class="container_cart">
            <?php if (!empty($error)) { ?> 
                <div id="notify-msg">
                    <?= $error ?>. <a href="javascript:history.back()">Quay lại</a>
                </div>
            <?php } elseif (!empty($success)) { ?>
                <div id="notify-msg">
                    <?= $success ?>. <a href="index.php">Tiếp tục mua hàng</a>
                </div>
            <?php } else { ?>
                <a href="index.php">Trang chủ</a>
                <h1>Giỏ hàng</h1>
                <?php if ($GLOBALS['changed_cart']) { ?>
                    <h3>Số lượng sản phẩm trong giỏ hàng đã thay đổi, do lượng sản phẩm tồn kho không đủ. Vui lòng <a href="cart.php">tải lại</a> giỏ hàng</h3>
                <?php } else { ?>
                    <form id="cart-form" action="cart.php?action=submit" method="POST">
                        <table class="cart_table">
                            <tr>
                                <th class="product-number">STT</th>
                                <th class="product-name">Tên sản phẩm</th>
                                <th class="product-img">Ảnh sản phẩm</th>
                                <th class="product-price">Đơn giá</th>
                                <th class="product-quantity">Số lượng</th>
                                <th class="total-money">Thành tiền</th>
                                <th class="product-delete">Xóa</th>
                            </tr>
                            <?php
                            if (!empty($product)) {
                                $total = 0;
                                $total1 = 0;
                                $num = 1;
                                while ($row = mysqli_fetch_array($product)) {
                                    ?>
                                    <tr>
                                        <td class="product-number"><?= $num++; ?></td>
                                        <td class="product-name"><?= $row['name'] ?></td>
                                        <td class="product-img"><a href="detail.php?id=<?= $row['id'] ?>"><img src="./<?= $row['image'] ?>" /></a></td>
                                        <td class="product-price"><?= number_format($row['price'], 0, ",", ".") ?></td>
                                        <td class="product-quantity"><input type="text" value="<?= $_SESSION["cart"][$row['id']] ?>" name="quantity[<?= $row['id'] ?>]" /></td>
                                        <td class="total-money"><?= number_format($row['price'] * $_SESSION["cart"][$row['id']], 0, ",", ".") ?></td>
                                        <td class="product-delete"><a href="cart.php?action=delete&id=<?= $row['id'] ?>">Xóa</a></td>
                                    </tr>
                                    <?php
                                    $total += $row['price'] * $_SESSION["cart"][$row['id']];
                                    $total1 += $_SESSION["cart"][$row['id']] ;
                                    $num++;
                                }
                                ?>
                                <tr id="row-total">
                                    <td class="product-number">&nbsp;</td>
                                    <td class="product-name">Tổng tiền</td>
                                    <td class="product-img">&nbsp;</td>
                                    <td class="product-price">&nbsp;</td>
                                    <td class="product-quantity"><?= $total1, " " ?></td>
                                    <td class="total-money"><?= number_format($total, 0, ",", ".") ?></td>
                                    <td class="product-delete">Xóa</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>

                        
                        <div id="form-button">
                            <input type="submit" name="update_click" value="Cập nhật" />
                        </div>
                        <hr>
                        <div><label>Người nhận: </label><input type="text" value="" name="name" /></div>
                        <div><label>Điện thoại: </label><input type="text" value="" name="phone" /></div>
                        <div><label>Địa chỉ: </label><input type="text" value="" name="address" /></div>
                        <div><label>Ghi chú: </label><textarea name="note" cols="50" rows="7" ></textarea></div>
                        <input type="submit" name="order_click" value="Đặt hàng" />
                        

                    </form>
                <?php } ?>
            <?php } ?>
        </div>
    </body>
</html>
<?php include 'footer.php';?>
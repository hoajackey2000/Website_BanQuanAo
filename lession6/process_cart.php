<?php
session_start();
include '../config/connect_db.php';
switch ($_GET['action']) {
    case "add":
        $result = update_cart(true);
        echo json_encode(array(
            'status'=>$result,
            'message'=>"Thêm sản phẩm thành công"
        ));
        break;
    default:
        break;
}

function update_cart($add = false) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if ($quantity == 0) {
            unset($_SESSION["cart"][$id]);
        } else {
            if (!isset($_SESSION["cart"][$id])) {
                $_SESSION["cart"][$id] = 0;
            }
            if ($add) {
                $_SESSION["cart"][$id] += $quantity;
            } else {
                $_SESSION["cart"][$id] = $quantity;
            }
            //Kiểm tra số lượng sản phẩm tồn kho
//            $addProduct = mysqli_query($con, "SELECT `quantity` FROM `product` WHERE `id` = " . $id);
//            $addProduct = mysqli_fetch_assoc($addProduct);
//            if ($_SESSION["cart"][$id] > $addProduct['quantity']) {
//                $_SESSION["cart"][$id] = $addProduct['quantity'];
//                $GLOBALS['changed_cart'] = true;
//            }
        }
    }
    return true;
}

<?php
include 'header.php';
if (!empty($_SESSION['current_user'])) {
    ?>
    <div class="main-content">
        <h1>Xóa Đơn Hàng</h1>
        <div id="content-box">
            <?php
            $error = false;
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                include '../../config/connect_db.php';
                $result = mysqli_query($con, "DELETE FROM `orders` WHERE `id` = " . $_GET['id']);
                if (!$result) {
                    $error = "Không thể xóa đơn hàng.";
                }
                mysqli_close($con);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h2>Thông báo</h2>
                        <h4><?= $error ?></h4>
                        <a href="./order_listing.php">Danh sách đơn hàng</a>
                    </div>
        <?php } else { ?>
                    <div id="success-notify" class="box-content">
                        <h2>Xóa đơn hàng thành công</h2>
                        <a href="./order_listing.php">Danh sách đơn hàng</a>
                    </div>
                <?php } ?>
    <?php } ?>
        </div>
    </div>
    <?php
}
include 'footer.php';
?>
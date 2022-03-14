<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa Tài Khoản</title>
</head>
    <body>
        <?php
            $error = false;
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                include '../config/connect_db.php';
                $result = mysqli_query($con, "DELETE FROM `user` WHERE `id` = " . $_GET['id']);
                if (!$result) {
                    $error = "Không thể xóa tài khoản.";
                }
                mysqli_close($con);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h1>Thông báo</h1>
                        <h4><?= $error ?></h4>
                        <a href="./index.php">Danh sách tài khoản</a>
                    </div>
                <?php } else { ?>
                    <div id="success-notify" class="box-content">
                        <h1>Xóa tài khoản thành công</h1>
                        <a href="./index.php">Danh sách tài khoản</a>
                    </div>
                <?php } ?>
            <?php } ?>
    </body>
</html>

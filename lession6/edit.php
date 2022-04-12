<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Đổi thông tin thành viên</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../css/login_register.css">
    </head>
    <body>
        <?php
        include '../config/connect_db.php';
        $error = false;
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            if (isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['old_password']) && !empty($_POST['old_password']) && isset($_POST['new_password']) && !empty($_POST['new_password'])
            ) {
                $userResult = mysqli_query($con, "Select * from `user` WHERE (`id` = " . $_POST['user_id'] . " AND `password` = '" . md5($_POST['old_password']) . "')");
                if ($userResult->num_rows > 0) {
                    $result = mysqli_query($con, "UPDATE `user` SET `password` = MD5('" . $_POST['new_password'] . "'), `last_updated`=" . time() . " WHERE (`id` = " . $_POST['user_id'] . " AND `password` = '" . md5($_POST['old_password']) . "')");
                    if (!$result) {
                        $error = "Không thể cập nhật tài khoản";
                    }
                } else {
                    $error = "Mật khẩu cũ không đúng.";
                }
                mysqli_close($con);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h1>Thông báo</h1>
                        <h4><?= $error ?></h4>
                        <a href="./edit.php">Đổi lại mật khẩu</a>
                    </div>
                <?php } else { ?>
                    <div id="edit-notify" class="box-content">
                        <h1><?= ($error !== false) ? $error : "Sửa tài khoản thành công" ?></h1>
                        <a href="./index.php">Quay lại tài khoản</a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div id="edit-notify" class="box-content">
                    <h1>Vui lòng nhập đủ thông tin để sửa tài khoản</h1>
                    <a href="./edit.php">Quay lại sửa tài khoản</a>
                </div>
                <?php
            }
        } else {
            session_start();
            $user = $_SESSION['current_user'];
            if (!empty($user)) {
                ?>
                <div id="edit_user" class="box-content">
                    <h1>Xin chào "<span><?= $user['fullname'] ?></span>". Bạn đang thay đổi mật khẩu</h1>
                    <form action="./edit.php?action=edit" method="Post" autocomplete="off">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <div class="form-control">
                            <input type="password" name="old_password" value="" placeholder="Nhập Password cũ">
                            <span></span>
                            <small></small>
                        </div>
                        <div class="form-control">
                            <input type="password" name="new_password" value="" placeholder="Nhập Password mới">
                            <span></span>
                            <small></small>
                        </div>


                        <br><br>
                        <input type="submit" value="Edit" />
                        <a   href="./index.php">Quay lại</a>
                    </form>
                </div>
                <?php
            }
        }
        ?>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="../css/login_register.css">
</head>
<body>
<?php
        include '../config/connect_db.php';
        include '../function/function.php';
        $error = false;
        if (isset($_GET['action']) && $_GET['action'] == 'reg') {
            if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
                $fullname = $_POST['fullname'];
                $birthday = $_POST['birthday'];
                $check = validateDateTime($birthday);
                if ($check) {
                    $birthday = strtotime($birthday);
                    $result = mysqli_query($con, "INSERT INTO `user` (`username`, `password`, `fullname`, `birthday`, `status`, `created_time`, `last_updated`) VALUES ( '" . $_POST['username'] . "', MD5('" . $_POST['password'] . "'), '" . $_POST['fullname'] . "', '" . $birthday . "', 0, " . time() . ", '" . time() . "');");
                    if (!$result) {
                        if (strpos(mysqli_error($con), "Duplicate entry") !== FALSE) {
                            $error = "Tài khoản đã tồn tại. Bạn vui lòng chọn tài khoản khác.";
                        }
                    }
                    mysqli_close($con);
                } else {
                    $error = "Ngày tháng nhập chưa chính xác";
                }
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h1>Thông báo</h1>
                        <h4><?= $error ?></h4>
                        <a href="./register.php">Quay lại</a>
                    </div>
                <?php } else { ?>
                    <div id="edit-notify" class="box-content">
                        <h1><?= ($error !== false) ? $error : "Đăng ký tài khoản thành công" ?></h1>
                        <a href="./login.php">Mời bạn đăng nhập</a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div id="edit-notify" class="box-content">
                    <h1>Vui lòng nhập đủ thông tin để đăng ký tài khoản</h1>
                    <a href="./register.php">Quay lại đăng ký</a>
                </div>
                <?php
            }
        } else {
            ?>
            <div id="user_register" class="box-content">
                <h1>Đăng ký tài khoản</h1>
                <form action="./register.php?action=reg" method="Post" autocomplete="off">
				<div class="form-control">
					<input type="text" name="username" value="" placeholder="Username">
					<span></span>
					<small></small>
				</div>
				<div class="form-control">
					<input type="password" name="password" value="" placeholder="Password">
					<span></span>
					<small></small>
				</div>
				<div class="form-control">
					<input type="text" name="fullname" value="" placeholder="Fullname">
					<span></span>
					<small></small>
				</div>
                <div class="form-control">
					<input type="text" name="birthday" value="" placeholder="Ngày sinh (DD-MM-YYYY)">
					<span></span>
					<small></small>
				</div>
                    </br>
                    <input type="submit" value="Đăng ký"/>

                    <div class="signup_link">Không phải là thành viên? <a href="login.php">Đăng nhập</a></div>

                </form>
            </div>
            <?php
        }
        ?>
</body>
</html>
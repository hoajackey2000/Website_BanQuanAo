<!DOCTYPE html>
<html>
    <head>
        <title>Trang Quản Trị</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/admin_style.css">
    </head>
    <body>
    <?php
        session_start();
        include '../../config/connect_db.php';
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
                    <a href="./index.php">Quay lại</a>
                </div>
                <?php
                exit;
            }else {
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
                header('Location: product_listing.php');
            }
            mysqli_close($con);

            ?>
        <?php } ?>
        <?php if (empty($_SESSION['current_user'])) { ?>
            <div id="user_login" class="box-content">
                <h1>ĐĂNG NHẬP TÀI KHOẢN ADMIN</h1>
                <form action="./index.php" method="Post" autocomplete="off">
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
                    <br>
                    <input type="submit" value="Đăng nhập" />
                </form>
            </div>
            <?php
        } else {
            $currentUser = $_SESSION['current_user'];
            ?>
            <div id="login-notify" class="box-content">

            </div>
        <?php } ?>
    </body>
</html>
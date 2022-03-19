<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Đăng nhập với facebook và google</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
        <?php
        session_start();

        include '../config/connect_db.php';
        $error = false;

       if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $result = mysqli_query($con, "Select `id`,`username`,`fullname`,`birthday` from `user` WHERE (`username` ='" . $_POST['username'] . "' AND `password` = md5('" . $_POST['password'] . "'))");
            if (!$result) {
                $error = mysqli_error($con);
            } else {
                $user = mysqli_fetch_assoc($result);
                $_SESSION['current_user'] = $user;
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

        ?>

        <?php if (!empty($_SESSION['current_user'])) {
            $currentUser = $_SESSION['current_user'];
            ?>
            <div id="admin-heading-panel">
                    <div class="right-panel">
                        <img height="24" src="./images/home.png">
                        <a href="./index.php">Trang chủ</a>
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
        
        }else {
            include './facebook_source.php';
            include './google_source.php';
              ?>

            <div id="user_login" class="box-content">
                <h1>Đăng nhập tài khoản</h1>
                <form action="./index.php" method="Post" autocomplete="off">
                    <label>Username</label></br>
                    <input type="text" name="username" value="" /><br/>
                    <label>Password</label></br>
                    <input type="password" name="password" value="" /></br>
                    <br>
                    <input type="submit" value="Đăng nhập" /><br/>
                    <a href="./register.php">Click vào đây để đăng ký</a>
                </form>
                <h2>Hoặc đăng nhập với mạng xã hội</h2>
                <div id="login-with-social">
                    <a href="<?= $loginUrl ?>"><img src="./images/facebook.png" alt='facebook login' title="Facebook Login" height="50" width="280" /></a>
                    <?php if(isset($authUrl)){ ?>
                    <a href="<?= $authUrl ?>"><img src="./images/google.png" alt='google login' title="Google Login" height="50" width="280" /></a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </body>
</html>
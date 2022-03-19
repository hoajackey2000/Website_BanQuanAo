<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Sửa tài khoản</title>
</head>
    <body>
    <?php
        include './connect_db.php';
        $error = false;
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            if (isset($_POST['firstname']) && !empty($_POST['firstname']) && isset($_POST['lastname']) && !empty($_POST['lastname']) && isset($_POST['email']) && !empty($_POST['email'])) {
                $result = mysqli_query($con, "UPDATE `myguests` SET `firstname`=('" . $_POST['firstname'] . "'), `lastname`=('" . $_POST['lastname'] . "'), `email`=('" . $_POST['email'] . "') WHERE `myguests`.`id` = " . $_POST['id'] . ";");
                if (!$result) {
                    $error = "Không thể cập nhật tài khoản";
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
                    <div id="edit-notify" class="box-content">
                        <h1><?= ($error !== false) ? $error : "Sửa tài khoản thành công" ?></h1>
                        <a href="./index.php">Danh sách tài khoản</a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div id="edit-notify" class="box-content">
                    <h1>Vui lòng nhập đủ thông tin để sửa tài khoản</h1>
                    <a href="./edit_user.php?id=<?= $_POST['myguests_id'] ?>">Quay lại sửa tài khoản</a>
                </div>
            <?php
            }
        } else {
            $result = mysqli_query($con, "SELECT * FROM myguests where `id`=" . $_GET['id']);
            $user = $result->fetch_assoc();
            mysqli_close($con);
            if (!empty($user)) {
                ?>
                <div id="edit_user" class="box-content">
                    <h1>Sửa tài khoản "<?= $user['firstname'] ?>"</h1>
                    <form action="./edit_user.php?action=edit" method="Post" autocomplete="off">
                        
                        <label>Firstname</label></br>
                        <input type="firstname" name="firstname" value="" />
                        <br>
                        <label>Lastname</label></br>
                        <input type="hidden" name="myguests_id" value="<?= $user['id'] ?>" />
                        <input type="lastname" name="lastname" value="" />
                        <br>
                        <label>Email</label></br>
                        <input type="email" name="email" value="" />
                        <br>
                        <input type="submit" value="Edit" />
                    </form>
                </div>
            <?php
            }
        }
        ?>
    </body>
</html>
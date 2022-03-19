<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB BÁN HÀNG</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php
         
        include './connect_db.php';
        $result = mysqli_query($con, "SELECT * FROM myguests");
        mysqli_close($con);
        
        // while ($row = mysqli_fetch_array ($result)){
        //     var_dump($row);
        //      exit;
        // }
    ?>

    <div id="user-info">
        <h1>Danh sách tài khoản</h1>
        <a href="./create_user.php">Tạo tài khoản mới</a>
        <table id= "user-listing" style="width: 650px; ">
            <tr>
                <td>ID</td>
                <td>Firstname</td>
                <td>Lastname</td>
                <td>Email</td>
                <td>Sửa</td>
                <td>Xóa</td>
            </tr> 
            <?php
            while ($row = mysqli_fetch_array ($result)) {
                ?>
                <tr>
                <td><?= $row['id']  ?></td>
                    <td><?= $row['firstname']  ?></td> <!-- dấu = (thay cho php echo) !-->
                    <td><?= $row['lastname']  ?></td>
                    <td><?= $row['email']  ?></td>
                    <td><a href="./edit_user.php?id=<?= $row['id'] ?>">Sửa</a></td>
                    <td><a href="./delete_user.php?id=<?= $row['id'] ?>">Xóa</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
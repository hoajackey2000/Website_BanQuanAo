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
         
        include '../config/connect_db.php';
        $result = mysqli_query($con, "SELECT * FROM user");
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
                <td>Username</td>
                <td>Trạng thái</td>
                <td>Cập nhật lần cuối</td>
                <td>Ngày lập</td>
                <td>Sửa</td>
                <td>Xóa</td>
            </tr> 
            <?php
            while ($row = mysqli_fetch_array ($result)) {
                ?>
                <tr>
                    <td><?= $row['username']  ?></td> <!-- dấu = (thay cho php echo) !-->
                    <td><?= $row['status'] == 1 ? "Kích hoạt" : "Block" ?></td>
                    <td><?= date ('d/m/Y H:i' , $row['last_updated']) ?></td> <!-- Định dạng ngày tháng và giá trị  -->
                    <td><?= date ('d/m/Y H:i', $row['created_time']) ?></td>
                    <td><a href="./edit_user.php?id=<?= $row['id'] ?>">Sửa</a></td>
                    <td><a href="./delete_user.php?id=<?= $row['id'] ?>">Xóa</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
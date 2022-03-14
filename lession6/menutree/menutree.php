<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu đa cấp</title>
</head>
<body>
<div class="container">
		<h1>Menu đa cấp</h1>
		<?php
		include '../../config/connect_db.php';
		include '../../function/function.php';
		$result = mysqli_query($con, "SELECT * FROM `menu` ORDER BY `menu`.`position` ASC");
		$menuList = mysqli_fetch_all($result,MYSQLI_ASSOC);
		$menuTree = createMenuTree($menuList, 0);
		?>
		<select name="parent">
			<option value="">Lựa chọn</option>
			<?php if(!empty($menuTree)){ 
				showMenuSelectBox($menuTree,0);
			} ?>
		</select>
	</div>
</body>
</html>
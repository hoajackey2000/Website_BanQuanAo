<?php
include 'header.php';
$config_name = "member";
$config_title = "thành viên";
if (!empty($_SESSION['current_user'])) {
	if(!empty($_GET['action']) && $_GET['action'] == 'search' && !empty($_POST)){
		$_SESSION[$config_name.'_filter'] = $_POST;
		header('Location: '.$config_name.'_listing.php');exit;
	}
	$where = "id != ". $_SESSION['current_user']['id'];
	if(!empty($_SESSION[$config_name.'_filter'])){
		foreach ($_SESSION[$config_name.'_filter'] as $field => $value) {
			if(!empty($value)){
				switch ($field) {
					case 'fullname':
					$where .= (!empty($where))? " AND "."`".$field."` LIKE '%".$value."%'" : "`".$field."` LIKE '%".$value."%'";
					break;
					default:
					$where .= (!empty($where))? " AND "."`".$field."` = ".$value."": "`".$field."` = ".$value."";
					break;
				}
			}
		}
		extract($_SESSION[$config_name.'_filter']);
	}
	$item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 10;
	$current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
	$offset = ($current_page - 1) * $item_per_page;
	if(!empty($where)){
		$totalRecords = mysqli_query($con, "SELECT * FROM `user` where (".$where.")");
	}else{
		$totalRecords = mysqli_query($con, "SELECT * FROM `user`");
	}
	$totalRecords = $totalRecords->num_rows;
	$totalPages = ceil($totalRecords / $item_per_page);
	if(!empty($where)){
		$products = mysqli_query($con, "SELECT * FROM `user` where (".$where.") ORDER BY `id` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
	}else{
		$products = mysqli_query($con, "SELECT * FROM `user` ORDER BY `id` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
	}
	mysqli_close($con);
	?>
	<div id="member-listing" class="main-content">
		<h1>Danh sách <?=$config_title?></h1>
		<div class="listing-items">
			<div class="buttons">
				<a href="./<?=$config_name?>_editing.php">Thêm <?=$config_title?></a>
			</div>
			<div class="listing-search">
				<form id="<?=$config_name?>-search-form" action="<?=$config_name?>_listing.php?action=search" method="POST">
					<fieldset>
						<legend>Tìm kiếm <?=$config_title?>:</legend>
						ID: <input type="text" name="id" value="<?=!empty($id)?$id:""?>" />
						Tên <?=$config_title?>: <input type="text" name="fullname" value="<?=!empty($name)?$name:""?>" />
						<input type="submit" value="Tìm" />
					</fieldset>
				</form>
			</div>
			<div class="total-items">
				<span>Có tất cả <strong><?=$totalRecords?></strong> <?=$config_title?> trên <strong><?=$totalPages?></strong> trang</span>
			</div>
			<ul>
				<li class="listing-item-heading">
					<div class="listing-prop listing-username">Tên đăng nhập</div>
					<div class="listing-prop listing-fullname">Họ tên</div>
					<div class="listing-prop listing-button">
						Xóa
					</div>
					<div class="listing-prop listing-button">
						Sửa
					</div>
					<div class="listing-prop listing-privilege">
						Phân quyền
					</div>
					<div class="listing-prop listing-time">Ngày tạo</div>
					<div class="listing-prop listing-time">Ngày cập nhật</div>
					<div class="clear-both"></div>
				</li>
				<?php
				while ($row = mysqli_fetch_array($products)) {
					?>
					<li>
						<div class="listing-prop listing-username"><?= $row['username'] ?></div>
						<div class="listing-prop listing-fullname"><?= $row['fullname'] ?></div>
						<div class="listing-prop listing-button">
							<a href="./<?=$config_name?>_delete.php?id=<?= $row['id'] ?>"><img src="../images/icons_delete.png" ></a>
						</div>
						<div class="listing-prop listing-button">
							<a href="./<?=$config_name?>_editing.php?id=<?= $row['id'] ?>"><img src="../images/icons_edit.png" ></a>
						</div>
						<div class="listing-prop listing-privilege">
							<a href="./<?=$config_name?>_privilege.php?id=<?= $row['id'] ?>"><img src="../images/icons_privilege.png" ></a>
						</div>
						<div class="listing-prop listing-time"><?= date('d/m/Y H:i', $row['created_time']) ?></div>
						<div class="listing-prop listing-time"><?= date('d/m/Y H:i', $row['last_updated']) ?></div>
						<div class="clear-both"></div>
					</li>
				<?php } ?>
			</ul>
			<?php
			include '../../function/pagination.php';
			?>
			<div class="clear-both"></div>
		</div>
	</div>
	<?php
}
include './footer.php';
?>
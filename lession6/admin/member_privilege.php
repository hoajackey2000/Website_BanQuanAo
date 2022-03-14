<?php
include 'header.php';
if (!empty($_SESSION['current_user'])) {
    ?>
    <div class="main-content">
        <h1>Phân quyền thành viên</h1>
        <div id="content-box">
            <?php
            if (!empty($_GET['action']) && $_GET['action'] == "save"
            ) {
                $data = $_POST;
                $insertString = "";
                $deleteOldPrivileges = mysqli_query($con, "DELETE FROM `user_privilege` WHERE `user_id` = ".$data['user_id']);
                foreach ($data['privileges'] as $insertPrivilege) {
                    $insertString .= !empty($insertString) ? "," : "";
                    $insertString .= "(NULL, " . $data['user_id'] . ", " . $insertPrivilege . ", '1595430953', '1595430953')";
                }
                $insertPrivilege = mysqli_query($con, "INSERT INTO `user_privilege` (`id`, `user_id`, `privilege_id`, `created_time`, `last_updated`) VALUES " . $insertString);
                if(!$insertPrivilege){
                    $error = "Phân quyền không thành công. Xin thử lại";
                }
                ?>
                <?php if(!empty($error)){ ?>
                    echo $error;
                <?php } else { ?>
                    Phân quyền thành công. <a href="member_listing.php">Quay lại danh sách thành viên</a>
                <?php } ?>
            <?php } else { ?>
                <?php
                $privileges = mysqli_query($con, "SELECT * FROM `privilege`");
                $privileges = mysqli_fetch_all($privileges, MYSQLI_ASSOC);
                
                $privilegeGroup = mysqli_query($con, "SELECT * FROM `privilege_group` ORDER BY `privilege_group`.`position` ASC");
                $privilegeGroup = mysqli_fetch_all($privilegeGroup, MYSQLI_ASSOC);
                
                $currentPrivileges = mysqli_query($con, "SELECT * FROM `user_privilege` WHERE `user_id` = ".$_GET['id']);
                $currentPrivileges = mysqli_fetch_all($currentPrivileges, MYSQLI_ASSOC);
                $currentPrivilegeList = array();
                if(!empty($currentPrivileges)){
                    foreach($currentPrivileges as $currentPrivilege){
                        $currentPrivilegeList[] = $currentPrivilege['privilege_id'];
                    }
                }
                ?>
                <form id="editing-form" method="POST" action="?action=save" enctype="multipart/form-data">
                    <input type="submit" title="Lưu thành viên" value="" />
                    <input type="hidden" name="user_id" value="<?= $_GET['id'] ?>" />
                    <div class="clear-both"></div>
                    <?php foreach ($privilegeGroup as $group) { ?>
                        <div class="privilege-group">
                            <h3 class="group-name"><?= $group['name'] ?></h3>
                            <ul>
                                <?php foreach ($privileges as $privilege) { ?>
                                    <?php if ($privilege['group_id'] == $group['id']) { ?>
                                        <li>
                                            <input type="checkbox"
                                                <?php if(in_array($privilege['id'], $currentPrivilegeList)){ ?> 
                                                checked=""    
                                                <?php } ?>
                                                value="<?= $privilege['id'] ?>" id="privilege_<?= $privilege['id'] ?>" name="privileges[]" />
                                            <label for="privilege_<?= $privilege['id'] ?>"><?= $privilege['name'] ?></label>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                                <div class="clear-both"></div>
                            </ul>
                        </div>
                    <?php } ?>
                </form>
            <?php } ?>
        </div>
    </div>

    <?php
}
include './footer.php';
?>
<?php if (!empty($_SESSION['current_user'])) { ?>
    <div class="clear-both"></div>
    </div>
    </div>
    <div id="admin-footer">
        <div class="container">
            <div class="left-panel">
                <!-- © Copyright 2019 - PHP -->
                © Rose Blouse - PHP
            </div>
            <div class="right-panel">
                <a target="_blank" href="#" title=""><img height="48" src="../images/facebook_admin.png" /></a>
                <a target="_blank" href="#" title=""><img height="48" src="../images/youtube_admin.png" /></a>
            </div>
            <div class="clear-both"></div>
        </div>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="box-content">
            Bạn chưa đăng nhập. Mời bạn quay lại đăng nhập quản trị <a href="index.php">tại đây</a>
        </div>
    </div>
<?php } ?>
</body>
</html>
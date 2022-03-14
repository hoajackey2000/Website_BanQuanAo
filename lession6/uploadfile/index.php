<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Bài 6: Upload files, Quản lý, thêm, xóa file trong Php</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body{
                font-family: arial;
            }
            fieldset { 
                display: block;
                margin-left: 2px;
                margin-right: 2px;
                padding-top: 0.35em;
                padding-bottom: 0.625em;
                padding-left: 0.75em;
                padding-right: 0.75em;
                border: 2px groove (internal value);
            }
            .box-content{
                margin: 0 auto;
                width: 800px;
                border: 1px solid #ccc;
                text-align: center;
                padding: 20px;
            }
            .box-content form{
                width: 300px;
                margin: 40px auto;
            }
            .box-content form input{
                margin: 5px 0;
            }
            #gallery{
                display: table;
            }
            #gallery li{
                list-style: none;
                float: left;
                width: 23%;
                padding: 10px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                margin: 10px 1%;
            }
            #gallery li img{
                max-width: 100%;
                height: 120px;
            }
            .clear-both{
                clear: both;
            }
            #gallery li input{
                width: 100%;
            }
        </style>
    </head>
    <body>
        <?php
        include './function.php';
        if (isset($_GET['upload']) && $_GET['upload'] == 'file') {
            $uploadedFiles = $_FILES['file_upload'];
            $errors = uploadFiles($uploadedFiles);
            if (!empty($errors)) {
                print_r($errors);
                exit;
            } else {
                echo "Upload thành công. <a href='index.php'>Upload thêm ảnh</a>";
            }
            /**
             * Chú ý khi upload file
             * Trong file php.ini có các thông số max như sau: 
             * post_max_size = 8M // Dung lượng lớn nhất cho một lần upload
             * upload_max_filesize = 2M //Dung lượng file cho phép lớn nhất
             * max_file_uploads = 20 //Số lượng file upload tối đa
             * Các bạn muốn upload nhiều hơn thì thay các thông số này và restart lại wamp hoặc xamp
             */
        } else {
            ?>
            <div id="upload-zone" class="box-content">
                <fieldset>
                    <legend>Upload file</legend>
                    <form id="upload-file-form" action="?upload=file" method="POST" enctype="multipart/form-data">
                        <input multiple type="file" name="file_upload[]" />
                        <input type="submit" value="Upload File" />
                    </form>
                </fieldset>
            </div>
            <h1>Danh sách ảnh</h1>
            <?php
            $baseURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $allFiles = getAllFiles();
            if (!empty($allFiles)) {
                ?>
                <ul id="gallery">
                    <?php foreach ($allFiles as $file) { ?>
                        <li>
                            <img src="<?= $file ?>" />
                            <input readonly="" type="text" value="<?= $baseURL . $file ?>" />
                            <a href="./delete.php?url=<?=  urlencode($file)?>">Xóa</a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>
    </body>
</html>

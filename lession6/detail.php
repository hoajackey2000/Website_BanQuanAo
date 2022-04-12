<?php include 'header.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;1,100;1,200&display=swap" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;1,100;1,200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


</head>
<body>
<?php 
        include '../config/connect_db.php';
        $result = mysqli_query($con, "SELECT * FROM `product` WHERE `id` = ".$_GET['id']);
        $product = mysqli_fetch_assoc($result);
        $imgLibrary = mysqli_query($con, "SELECT * FROM `image_library` WHERE `product_id` = ".$_GET['id']);
        $product['images'] = mysqli_fetch_all($imgLibrary, MYSQLI_ASSOC);
        ?>
        <div class="detail">
        <?php
         
         if ($row = mysqli_fetch_array($products)) {
        ?>
            <div class="container_detail">
                <h2>Chi tiết sản phẩm</h2>
                <div id="product-detail">
                    <div id="product-img">

                            <div class="wrapper ">
                                <div class="image__detail">
                                        <img class="img__detail" src="./<?=$product['image']?>" />
                                        <?php foreach ($product['images'] as $img) { ?>
                                            <img class="img-product-img" src="./<?= $img['path'] ?>" />
                                        <?php } ?>
                                </div>
                            </div>  

                            <div class="gallery__detail">
                                <i class="fas fa-times close__detail"></i>
                                <div class="gallery__inner__detail">
                                    <img class="img_gallery" src="./" alt="">
                                </div>
                                <div class="control prev__detail">
                                    <i class="fas fa-chevron-left"></i>
                                </div>
                                <div class="control next__detail">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>

                        <!-- <img src="./<?=$product['image']?>" /> -->
                    </div>
                    <div id="product-info">
                        <h1><?= $product['name'] ?></h1>
                        <label>Giá: </label><span class="product-price"><?= number_format($product['price'], 0, ",", ".") ?> VND</span><br/>
                        <?php if ($product['quantity'] > 0) { ?>
                            <div class="product-quantity"><label>Tồn kho: </label><strong><?= $product['quantity'] ?></strong></div>
                            <form id="add-to-cart-form" action="cart.php?action=add" method="POST">
                                <div class="total-quantity">       

                                    <span class="input-group-text btn btn-danger" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"> <i class="fa-solid fa-minus"></i> </span>
                                    
                                    <input type="number" max="<?= $product['quantity'] ?>" min="1" value="1" name="quantity[<?= $product['id'] ?>]" /><br/>

                                    <span class="input-group-text btn btn-success" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" > <i class="fa-solid fa-plus"></i> </span>

                                </div> 
                                
                                <input type="submit" value="Mua sản phẩm" />
                                
                            </form>

                            <form class="add-to-ajax-cart-form" action="cart.php?action=add" method="POST">
                                <input type="hidden" value="1" name="quantity[<?= $row['id'] ?>]" />
                                <input type="submit" value="Thêm vào giỏ hàng" />
                            </form>


                        <?php } else { ?>
                            <span class="error">Hết hàng</span>
                        <?php } ?>



                        <?php if (!empty($product['images'])) { ?>
                            

                            <div class="wrapper">
                                <div class="image">
                                        <?php foreach ($product['images'] as $img) { ?>
                                            <img class="img" src="./<?= $img['path'] ?>" />
                                        <?php } ?>
                                        <img class="img" src="./<?=$product['image']?>" />
                                </div>
                            </div>  


                            <div class="gallery">
                                <i class="fas fa-times close"></i>
                                <div class="gallery__inner">
                                    <img class="img_gallery" src="./" alt="">
                                </div>
                                <div class="control prev">
                                    <i class="fas fa-chevron-left"></i>
                                </div>
                                <div class="control next">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="clear-both"></div>
                    <?= $product['content'] ?>
                    <div class="buy-button">
                        <a href="./index.php">Trang Chủ</a>
                        <a href="./cart.php">Giỏ Hàng</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
            ?>

<script src="js/gallery.js"></script>
<script src="js/gallery_detail.js"></script>
</body>
</html>
<?php include "footer.php"?>
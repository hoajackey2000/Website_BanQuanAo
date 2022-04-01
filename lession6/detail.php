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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;1,100;1,200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">


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
            <div class="container_detail">
                <h2>Chi tiết sản phẩm</h2>
                <div id="product-detail">
                    <div id="product-img">
                        <img src="./<?=$product['image']?>" />
                    </div>
                    <div id="product-info">
                        <h1><?= $product['name'] ?></h1>
                        <label>Giá: </label><span class="product-price"><?= number_format($product['price'], 0, ",", ".") ?> VND</span><br/>
                        <?php if ($product['quantity'] > 0) { ?>
                            <div class="product-quantity"><label>Tồn kho: </label><strong><?= $product['quantity'] ?></strong></div>
                            <form id="add-to-cart-form" action="cart.php?action=add" method="POST">
                        <div class="total-quantity">       
                           
                            <!-- <div class="input-group-append">
                                <button class="btn btn-light" type="button" id="button-minus" > − </button>
                            </div> -->

                            <span class="input-group-text btn btn-danger" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"> - </span>

                            
                            <input type="number" max="<?= $product['quantity'] ?>" min="1" value="1" name="quantity[<?= $product['id'] ?>]" /><br/>
                            


                             <!-- <div class="input-group-prepend">
                                <button class="btn btn-light" type="button" id="button-plus"> + </button>
                            </div> -->
                            
                            <span class="input-group-text btn btn-success" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"> +   </span>




                        </div> 
                        <!-- <input aria-label="quantity" class="input-qty" max="10" min="1" name="" type="number" value="1"> -->
                        
                            <input type="submit" value="Mua sản phẩm" />
                            </form>
                        <?php } else { ?>
                            <span class="error">Hết hàng</span>
                        <?php } ?>
                        <?php if (!empty($product['images'])) { ?>
                            <div id="gallery">
                                <ul>
                                    <?php foreach ($product['images'] as $img) { ?>
                                        <li><img src="./<?= $img['path'] ?>" /></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clear-both"></div>
                    <?= $product['content'] ?>
                    <div class="buy-button">
                        <a href="./index.php">Quay Lại</a>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
<?php include "footer.php"?>
<?php include 'header.php'; ?>

        

<section id="product-slide" class="carouseller"> 
    <a href="javascript:void(0)" class="carouseller__left">‹</a> 
    <div class="carouseller__wrap"> 
        <div class="carouseller__list"> 
            <div class="car__12">
                <section class="background-slide" style="background: #9ccd8d;"></section>
                <section class="wrap-slide">
                    <section class="slide-left">
                        <section class="product-name">
                            <span>Will</span><span>Helm</span><span class="last-span">Winter</span>
                            <section class="clear-both"></section>
                        </section>
                        <section class="wrap-button">
                            <section class="left-buy-button"></section>
                            <section class="content-buy-button"><section class="product-price">1.500.000 đ</section><a href="#">Mua ngay</a></section>
                            <section class="right-buy-button"></section>
                            <section class="clear-both"></section>
                        </section>
                    </section>
                    <section class="slide-right">
                        <img src="images/shoes-1.png" />
                    </section>
                </section>
            </div>
            <div class="car__12">
                <section class="background-slide" style="background: #6898ef;"></section>
                <section class="wrap-slide">
                    <section class="slide-left">
                        <section class="product-name">
                            <span>Will</span><span>Helm</span><span class="last-span">Winter 2</span>
                            <section class="clear-both"></section>
                        </section>
                        <section class="wrap-button">
                            <section class="left-buy-button"></section>
                            <section class="content-buy-button"><section class="product-price">1.250.000 đ</section><a href="#">Mua ngay</a></section>
                            <section class="right-buy-button"></section>
                            <section class="clear-both"></section>
                        </section>
                    </section>
                    <section class="slide-right">
                        <img src="images/shoes-2.png" />
                    </section>
                </section>
            </div>
        </div>
    </div>
    <a href="javascript:void(0)" class="carouseller__right">›</a>
</section>
<section id="hot-categories">
    <section class="container">
        <section id="wrap-categories">
            <section class="category">
                <h3>Nữ</h3>
                <section class="category-image">
                    <img src="images/woman.jpg" />
                </section>
                <section class="total-product">Tổng</section>
                <section class="number-product">357 sản phẩm</section>
                <img src="images/product-list-icon.png" />
            </section>
            <section class="category center-block">
                <h3>Nam</h3>
                <section class="category-image">
                    <img src="images/men.jpg" />
                </section>
                <section class="total-product">Tổng</section>
                <section class="number-product">125 sản phẩm</section>
                <img src="images/product-list-icon.png" />
            </section>
            <section class="category">
                <h3>Trẻ em</h3>
                <section class="category-image">
                    <img src="images/kids.jpg" />
                </section>
                <section class="total-product">Tổng</section>
                <section class="number-product">251 sản phẩm</section>
                <img src="images/product-list-icon.png" />
            </section>
            <section class="clear-both"></section>
        </section>
    </section>
</section>
<section id="hot-products">
    <section class="container">
        <section class="heading-title">
        <select id="sort-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="index.php">Sắp xếp giá</option>
            <option <?php if(isset($_GET['sort']) && $_GET['sort'] == "desc") { ?> selected <?php } ?> value="?<?=$sortParam?>field=price&sort=desc">Cao đến thấp</option>
            <option <?php if(isset($_GET['sort']) && $_GET['sort'] == "asc") { ?> selected <?php } ?> value="?<?=$sortParam?>field=price&sort=asc">Thấp đến cao</option>
        </select>
            <h2>Sản phẩm <span>hot</span></h2>
            <a href="category.php"><img src="images/arrow.png" />Xem tất cả</a>
            <section class="clear-both"></section>
        </section>
        <section class="box-content">
        <?php
            $num = 1;
        while ($row = mysqli_fetch_array($products)) {
        ?>
            <section class="product-item <?php if ($num % 4 == 1) { ?> first-line <?php } ?> ">
                    <section class="brand-icon"><img src="images/nike-icon.png" /></section>
                    <section class="product-image"><a href="detail.php?id=<?= $row['id'] ?>"><img src="./<?= $row['image'] ?>" title="<?= $row['name'] ?>" /></a></section>
                    <section class="product-name"><a href="detail.php?id=<?= $row['id'] ?>"><?= $row['name'] ?></a></section>
                    <section class="wrap-button">
                    <section class="left-buy-button"></section>
                    <section class="content-buy-button">
                        <?php if ($row['quantity'] > 0) { ?>
                            <section class="product-price"><?= number_format($row['price'], 0, ",", ".") ?> đ</section>
                            <form class="quick-buy-form" action="cart.php?action=add" method="POST">
                                <input type="hidden" value="1" name="quantity[<?= $row['id'] ?>]" />
                                <input type="submit" value="Mua ngay" />
                            </form>
                        <?php } else { ?>
                            <a href="#">Hết hàng</a>
                        <?php } ?>
                    </section>
                    <section class="right-buy-button"></section>
                    <section class="clear-both"></section>
                </section>
            </section>
                <?php
                $num++;
            }
            ?>
            <section class="clear-both"></section>
            <?php
                 include '../function/pagination.php';
            ?>
        </section>
    </section>
</section>
<?php include("footer.php"); ?>
<?php include 'header.php'; ?>

<?php
    $param = "";
    $sortParam = "";
    $orderConditon = "";
    //Tìm kiếm
    $search = isset($_GET['name']) ? $_GET['name'] : "";
    if ($search) {
        $where = "WHERE `name` LIKE '%" . $search . "%'";
        $param .= "name=" . $search . "&";
        $sortParam = "name=" . $search . "&";
    }

    //Sắp xếp
    $orderField = isset($_GET['field']) ? $_GET['field'] : "";
    $orderSort = isset($_GET['sort']) ? $_GET['sort'] : "";
    if (!empty($orderField) && !empty($orderSort)) {
        $orderConditon = "ORDER BY `product`.`" . $orderField . "` " . $orderSort;
        $param .= "field=" . $orderField . "&sort=" . $orderSort . "&";
    }

    include '../config/connect_db.php';
    $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 12;
    $current_page = !empty($_GET['page']) ? $_GET['page'] : 1; //Trang hiện tại
    $offset = ($current_page - 1) * $item_per_page;
    if ($search) {
        $products = mysqli_query($con, "SELECT * FROM `product` WHERE `name` LIKE '%" . $search . "%' " . $orderConditon . "  LIMIT " . $item_per_page . " OFFSET " . $offset);
        $totalRecords = mysqli_query($con, "SELECT * FROM `product` WHERE `name` LIKE '%" . $search . "%'");
    } else {
        $products = mysqli_query($con, "SELECT * FROM `product` " . $orderConditon . " LIMIT " . $item_per_page . " OFFSET " . $offset);
        $totalRecords = mysqli_query($con, "SELECT * FROM `product`");
    }
    $totalRecords = $totalRecords->num_rows;
    $totalPages = ceil($totalRecords / $item_per_page);
    ?>

<section id="hot-products">
    <section class="container">
        <section class="heading-title">
        <select id="sort-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="index.php">Sắp xếp giá</option>
            <option <?php if(isset($_GET['sort']) && $_GET['sort'] == "desc") { ?> selected <?php } ?> value="?<?=$sortParam?>field=price&sort=desc">Cao đến thấp</option>
            <option <?php if(isset($_GET['sort']) && $_GET['sort'] == "asc") { ?> selected <?php } ?> value="?<?=$sortParam?>field=price&sort=asc">Thấp đến cao</option>
        </select>
            <h2>Sản phẩm <span>hot</span></h2>
            <a href="categogy.php"><img src="images/arrow.png" />Xem tất cả</a>
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
                    <!-- <section class="content-buy-button"> -->

                    

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

                    <!-- </section> -->
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
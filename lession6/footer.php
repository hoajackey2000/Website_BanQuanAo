<footer>
    <section class="container">
        <section id="footer-logo">
            <img src="images/footer-logo.png" />
        </section>
        <section id="footer-link">
            <ul>
                <li><a href="#">Chúng tôi</a></li>
                <li><a href="#">Hỏi đáp</a></li>
                <li><a href="#">Điều khoản sử dụng</a></li>
                <li><a href="#">Thanh toán bảo mật</a></li>
                <li><a href="#">Giao hàng</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </section>
        <section id="social-network-link">
            <!-- <a href="#"><img src="images/pinterest.png" /></a>
            <a href="#"><img src="images/twitter.png" /></a>
            <a href="#"><img src="images/facebook.png" /></a> -->



            <div class="wrapper">
                <div class="icon facebook">
                    <i class="fab fa-facebook-f"><a href="#"><img src="images/facebook.png" /></a></i>
                </div>

                <div class="icon twitter">
                    <i class="fab fa-github"><a href="#"><img src="images/twitter.png" /></a></i>
                </div>

                <div class="icon youtube">
                    <i class="fab fa-youtube"><a href="#"><img src="images/pinterest.png" /></a></i>
                </div>
            </div>



        </section>
        <section class="clear-both"></section>
    </section>
</footer>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="js/carouseller.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="libs/fancybox/jquery.fancybox.min.js"></script>
<script>
    $(".quick-buy-form").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: './process_cart.php?action=add',
            data: $(this).serializeArray(),
            success: function (response) {
                response = JSON.parse(response);
                if (response.status == 0) { //Có lỗi
                    alert(response.message);
                } else { //Mua thành công
                    alert(response.message);
                    location.reload(); //load lại trang
                }
            }
        });
    });
</script>
<script>
    $(".add-to-ajax-cart-form").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: './process_cart.php?action=add',
            data: $(this).serializeArray(),
            success: function (response) {
                response = JSON.parse(response);
                if (response.status == 0) { //Có lỗi
                    alert(response.message);
                } else { //Mua thành công
                    alert(response.message);
                    location.reload(); //load lại trang
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#product-slide').carouseller();
    });
</script>

<script src="./js/carouseller_auto.js"></script>

</body>
</html>

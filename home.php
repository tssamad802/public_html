<?php
if (!isset($db)) {
    include_once __DIR__ . '/classes/commonfunctions.php';
}
?>
<style>
    .main-slider {
        position: relative;
        height: 100%;
    }

    .time {
        width: 100%;
        height: 100%;
        background: #bbb;
        color: #ddd;
        text-align: center;
        line-height: 320px;
        font-size: 640px;
    }

    /*.time { display: none;}*/
</style>
<script>
    /* Slider (work in progress)
 * 03/09/2015 by Andrew Errico
 */
    $(function () {

        // slider type
        $t = "slide"; // opitions are fade and slide

        //variables
        $f = 5000,  // fade in/out speed
            $s = 5000,  // slide transition speed (for sliding carousel)
            $d = 3000;  // duration per slide

        $n = $('.slide').length; //number of slides
        $w = $('.slide').width(); // slide width
        $c = $('.container').width(); // container width
        $ss = $n * $w; // slideshow width


        function timer() {
            $('.timer').animate({ "width": $w }, $d);
            $('.timer').animate({ "width": 0 }, 0);
        }


        // fading function
        function fadeInOut() {
            timer();
            $i = 0;
            var setCSS = {
                'position': 'absolute',
                'top': '0',
                'left': '0'
            }

            $('.slide').css(setCSS);

            //show first item
            $('.slide').eq($i).show();


            setInterval(function () {
                console.log("normal")
                timer();
                $('.slide').eq($i).fadeOut($f);
                if ($i == $n - 1) {
                    $i = 0;
                } else {
                    $i++;
                }
                $('.slide').eq($i).fadeIn($f, function () {
                    $('.timer').css({ 'width': '0' });
                });

            }, $d);

        }

        function slide() {
            timer();
            var setSlideCSS = {
                'float': 'left',
                'display': 'inline-block',
                'width': $c
            }
            var setSlideShowCSS = {
                'width': $ss // set width of slideshow container
            }
            $('.slide').css(setSlideCSS);
            $('.slideshow').css(setSlideShowCSS);


            setInterval(function () {
                timer();
                $('.slideshow').animate({ "left": -$w }, $s, function () {
                    // to create infinite loop
                    $('.slideshow').css('left', 0).append($('.slide:first'));
                });

            }, $d);

        }

        if ($t == "fade") {
            fadeInOut();
        } if ($t == "slide") {
            slide();
        } else {
        }
    });
</script>
<div class="site-wrapper animsition" data-animsition-in="fade-in" data-animsition-out="fade-out">

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-12" style="margin-top: -40px">
                    <div class="slide-wrap shadow">
                        <div class="main-slider">

                            <?php
                            $sql = "select * from tblslider where Active = 1";
                            $db->query($sql);
                            while ($db->next_record()) {
                                $code = $db->f('couponCode');
                                $offer = ($code != "" && $code != null) ? $db->f('URL') : "";
                                $url = ($offer != '') ? $db->f('URL') : "#";
                                $target = ($url == '#') ? '' : 'target="_blank"';
                                //  $target
                                //$url
                                ?>
                                <a href="<?= $db->f('URL') ?>" target="_blank"
                                    data-href="<?= RESOURCES_DOMAIN ?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponSlider&RecordID=' . $db->f('TableID')); ?>"
                                    data-tracking="<?= $db->f('trackURL') ?>" class="quickview"><img
                                        src="<?= RESOURCES_DOMAIN ?>/files/banners/<?= $db->f('Name') ?>"
                                        alt="<?= htmlspecialchars($db->f('Name')) ?> Coupon Banner" class="time"
                                        fetchpriority="high" loading="eager"> </a>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /col 12 -->





            <!--            </div>-->
            <div class="row">
                <div>
                    <h2 style="font-weight: bold;">Top Coupons</h2>
                </div>
                <div id="myTabContent">
                    <div class="tab-pane counties-pane active animated fadeIn" id="resultDiv"></div>
                </div>

            </div>

            <!-- end: Tab content -->
            <div class="clearfix"></div>
            <div class="widget">
                <!-- /widget heading -->
                <div class="widget-heading">
                    <h3 class="widget-title text-dark">
                        Top Stores
                    </h3>
                    <div class="widget-widgets"> <a href="<?= RESOURCES_DOMAIN ?>/stores">View More Stores</a> </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget-body">
                    <div class="row" id="storeListing"></div>
                </div>
                <div class="clearfix"></div>
                <div class="widget-heading">
                    <h3 class="widget-title text-dark">
                        Top Products
                    </h3>
                    <div class="widget-widgets"> <a href="<?= RESOURCES_DOMAIN ?>/products">View More Products</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="row" id="productListing" style="margin-left: 5px"></div><br>

            <!-- end: Tab content -->
        </div>

        <!-- end col -->
    </div>
    <!-- End row -->
</div>

</div>
</div>
<script>
    SimpleAjax('<?php echo RESOURCES_DOMAIN; ?>/ajax/ajax_home.php?actions=couponHomelisting&page=0', 'searchfrm', 'resultDiv');
    SimpleAjax('<?php echo RESOURCES_DOMAIN; ?>/ajax/ajax_home.php?actions=storeHomelisting&page=0', 'searchfrm', 'storeListing');
    SimpleAjax('<?php echo RESOURCES_DOMAIN; ?>/ajax/ajax_home.php?actions=productHomelisting&page=0', 'searchfrm', 'productListing');
</script>
<script>
    const copyCode = () => {
        const input = document.getElementById("code");
        input.select();
        document.execCommand("copy");
    }
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
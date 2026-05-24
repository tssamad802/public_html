<?php
    $db= new DB_Sql();
?>

<section class="results m-t-30">
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <div class="widget">
                    <div class="widget-heading widget-default b-b-0">
                        <h3 class="widget-title text-dark">
                          Expire Coupons
                        </h3>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- end: Widget -->

                <div class="row" id="resultDiv"></div>

            </div>

        </div>
    </div>
</section>
<script>
    <?php
        $data = ($_REQUEST['url'] == "") ? "" : $_REQUEST['url'];
    ?>
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_expireCoupon.php?actions=couponlisting&data=<?=$data?>&page=0','searchfrm','resultDiv');
    //SimpleAjax('<?php //echo RESOURCES_DOMAIN;?>///ajax/ajax_coupon.php?actions=relatedProduct&url=<?//=$data?>//&page=0','searchfrm','resultDiv1');
</script>
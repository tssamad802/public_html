<?php
$db= new DB_Sql();
$url = $_REQUEST['url'] ?? '';
$text = '';
$Query="SELECT * FROM `tblcoupontype` WHERE `URLKeyword` = '".secureTextForDb($url)."'";
$db->query($Query);
while ($db->next_record()) {
    $text= $db->f('Title');
}
?>
<section class="results m-t-30">
    <div class="container">
        <div class="row">

            <div class="col-sm-9">
                <div class="widget">
                    <div class="widget-heading widget-default b-b-0">
                        <h3 class="widget-title text-dark">
                            Coupons: <?=$text?>
                        </h3>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- end: Widget -->
            </div>
                <div class="col-sm-12 col-md-12">
                <!--/widget -->
                <div class="row" id="resultDiv">
                </div>
            </div>


        </div>
    </div>
</section>
<script>
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_coupon.php?actions=couponlistingType&data=<?=urlencode($url)?>&page=0','searchfrm','resultDiv');
</script>

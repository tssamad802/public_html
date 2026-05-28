<?php
    $db= new DB_Sql();
    $url = $_REQUEST['url'] ?? '';
    $text = '';
$Query="SELECT * FROM `tblcoupontype` WHERE `URLKeyword` = '".secureTextForDb($url)."'";
$db->query($Query);
while ($db->next_record()) {
    $text = $db->f('Title');
}
?>

<section class="results m-t-30">
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <div class="widget">
                    <div class="widget-heading widget-default b-b-0">
                        <h3 class="widget-title text-dark">
                           Coupons: <?=$text?>
                        </h3>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- end: Widget -->

                <div class="row" id="resultDiv"></div>
                <div class="row" id="resultDiv1"></div>


            </div>

        </div>
    </div>
</section>
<script>
    <?php
        $data = $url;
    ?>
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_coupon.php?actions=couponlisting&data=<?=$data?>&page=0','searchfrm','resultDiv');
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_coupon.php?actions=relatedProduct&url=<?=$data?>&page=0','searchfrm','resultDiv1');
</script>

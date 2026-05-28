<?php

$db = new DB_Sql();
$requestUrl = $_REQUEST['url'] ?? '';
$Description = '';
$sql = "select * from tblpages where URLKeyword = '".secureTextForDb($requestUrl)."'";


$db->query($sql);

while($db->next_record()){
    $Description = $db->f('description');
}
?>


<section class="results">
    <div class="dp-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    <h4>Category : <?=$requestUrl?></h4>
                    <p><?=$Description?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 dph-reviews">
            <!--                    <p><span>--><?//=$Rating?><!--</span>Positive Reviews</p>-->
            <!--                    <p class="dph-rec"><i class="ti-cut"></i><span>78</span> Offers</p>-->
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-sm-9">
                <!--/widget -->
                <!-- Tab panes -->
                <?php
                //                $query="SELECT A.*, Count((B.TableID)) as TotalCoupan
                //						 FROM tblcategory A,tblcoupan B
                //						 WHERE A.TableID = B.CategoryID
                //						 and ctype.Title = '".$_REQUEST['url']."'
                //						 and and c.endDate >= CURDATE()
                //						 GROUP BY A.TableID ";
                $query = "SELECT cc.featured , cc.TableID TableID  , cc.logo ,cc.CouponName name , cc.endDate as expire , cc.description Description
                            FROM `tblcategory` c INNER JOIN `tblcouponcategory` tc ON (c.`TableID`=tc.`CategoryID`) 
                            INNER JOIN `tblcoupon` cc ON (tc.`CouponID` = cc.Tableid) INNER JOIN `tblstore` s ON(s.`TableID` = cc.`StoreID`)
                             WHERE c.`Title` = '".secureTextForDb($requestUrl)."' ";// and cc.endDate >= CURDATE()";
                $db->query($query);
                while($db->next_record()){
                    ?>
                    <div class="coupon-wrapper coupon-single">
                        <div class="row">
                            <div class="ribbon-wrapper hidden-xs">
                                <?php
                                if($db->f('featured') == 1){
                                    ?>
                                    <div class="ribbon">Featured</div>
                                <?php } ?>
                            </div>
                            <div class="coupon-data col-sm-2 text-center col-md-2 text-center">
                                <div class="savings text-center">
                                    <?php
                                    if($db->f('logo')==null){
                                        ?>
                                        <div>
                                            <div class="large">30%</div>
                                            <div class="small">off</div>
                                            <div class="type">Coupon</div>
                                        </div>
                                    <?php } else {?>
                                        <div>
                                            <img src="../../files/banners/<?=$db->f('logo')?>" class="medium" alt=">
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- end:Savings -->
                            </div>
                            <!-- end:Coupon data -->
                            <div class="coupon-contain col-sm-7">
                                <ul class="list-inline list-unstyled">
                                    <li><span class="verified  text-success"><i class="ti-face-smile"></i>Verified </span> </li>
                                </ul>
                                <h4 class="coupon-title"><a href="#"><?=$db->f('name')?></a></h4>
                                <p data-toggle="collapse" data-target="#more"><?=$db->f('Description')?></p>

                            </div>
                            <!-- end:Coupon cont -->
                            <div class="button-contain col-sm-3 text-center">
                                <p class="btn-code" data-toggle="modal" data-target=".couponModal"> <span class="partial-code">BTSBAGS</span> <span class="btn-hover"><a href="javascript:;" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview">Get Code</a></span> </p>
                                <p>Expire At : <?=$db->f('expire')?></p>
                            </div>
                        </div>
                        <!-- //row -->
                    </div>
                <?php } ?>


            </div>

            <div class="col-sm-3">Banner
            </div>
        </div>
    </div>
</section>

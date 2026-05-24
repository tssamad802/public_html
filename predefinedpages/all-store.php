<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
    die("Direct Access Not Allowed");
}
$obj = new DB_Sql();

$string = "select * from tblstore where ACTIVE = 1";
$obj->query($string);
while($obj->next_record()){
    $StoreID = $obj->f('TableID');
    $StoreName = $obj->f('name');
    $Description = $obj->f('description');
    $Domain = $obj->f('domain');
    $WebURL = $obj->f('webUrl');
    $Discount = $obj->f('discount');
    $FbURL = $obj->f('fbUrl');
    $About = $obj->f('about');
    $Rating = $obj->f('rating');
    $StoreAddvertise = $obj->f('storeAdd');
    $Votes = $obj->f('votes');
    $Featured = $obj->f('featured');
    $CountryID = $obj->f('CountryID');
    $CategoryIDs = explode(',' , $obj->f('CategoryID'));
    $NetworkID = $obj->f('NetworkID');
    $Logo = $obj->f('logo');
}

?>

<section class="results">
    <div class="dp-header">
        <div class="container">
            <div class="row">
                <div class="col-md-8 dph-info">
                    <img src="../../files/banners/<?=$Logo?>" class="profile-img" alt=">
                    <div>

                        <h4><?=$StoreName?></h4>
                        <p><?=$Description?></p>
                        <!--                        <a href="#">Electronics</a> <a href="#">Fashion</a>-->
                    </div>
                </div>
                <div class="col-md-4 dph-reviews">
                    <p><span><?=$Rating?></span>Positive Reviews</p>
                    <!--                    <p class="dph-rec"><i class="ti-cut"></i><span>78</span> Offers</p>-->
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-sm-9">
                <!--/widget -->
                <!-- Tab panes -->
                <?php
                $query= "select * from tblcoupon where StoreID = ".$StoreID;
                //            $query= "select * from tblcoupon where StoreID = 1";
                $obj->query($query);
                while($obj->next_record()){
                    ?>
                    <div class="coupon-wrapper coupon-single">
                        <div class="row">
                            <div class="ribbon-wrapper hidden-xs">
                                <?php
                                if($obj->f('featured') == 1){
                                    ?>
                                    <div class="ribbon">Featured</div>
                                <?php } ?>
                            </div>
                            <div class="coupon-data col-sm-2 text-center">
                                <div class="savings text-center">
                                    <?php
                                    if($obj->f('logo')==null){
                                        ?>
                                        <div>
                                            <div class="large">30%</div>
                                            <div class="small">off</div>
                                            <div class="type">Coupon</div>
                                        </div>
                                    <?php } else {?>
                                        <div>
                                            <img src="../../files/banners/<?=$obj->f('logo')?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- end:Savings -->
                            </div>
                            <!-- end:Coupon data -->
                            <div class="coupon-contain col-sm-7">
                                <ul class="list-inline list-unstyled">
                                    <li><span class="verified  text-success"><i class="ti-face-smile"></i>Verified</span> </li>
                                </ul>
                                <h4 class="coupon-title"><a href="#"><?=$obj->f('CouponName')?></a></h4>
                                <p data-toggle="collapse" data-target="#more"><?=$obj->f('description')?></p>

                            </div>
                            <!-- end:Coupon cont -->
                            <div class="button-contain col-sm-3 text-center">
                                <p class="btn-code" data-toggle="modal" data-target=".couponModal"> <span class="partial-code">BTSBAGS</span> <span class="btn-hover"><a href="javascript:;" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$obj->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview">Get Code</a></span> </p>
                            </div>
                        </div>
                        <!-- //row -->
                    </div>
                <?php } ?>


            </div>

<!--            <div class="col-sm-3">Banner-->
            </div>
        </div>
    </div>
</section>

<section class="results m-t-30">
    <div class="container">

        <div class="widget m-t-20">
            <!-- /widget heading -->
            <div class="widget-heading">
                <h3 class="widget-title text-dark">
                    Featured Stores
                </h3>
<!--                <div class="widget-widgets"> <a href="#">View More Stores <span class="ti-angle-right"></span></a>-->
<!--                </div>-->
                <div class="clearfix"></div>
            </div>
            <div class="widget-body">
                <div class="row">
                    <?php
                        $Query ="select * from tblstore where featured = 1 limit 10";
                        $db->query($Query);
                        while($db->next_record()){
                    ?>
                    <div class="col-lg-1 col-md-2 col-sm-4 col-xs-6 thumb">
                        <div class="thumb-inside">
                            <a class="thumbnail" href="#">
                                <img class="img-responsive" src="http://placehold.it/240x240" alt=">
                            </a> <span class="favorite"><a href="#" data-toggle="tooltip" data-placement="left" title="" data-original-title="Save store"><i class="ti-heart"></i></a></span>
                        </div>
                        <div class="store_name text-center">
                            <h5><?=substr($db->f('name') , 0 ,6)?>...</h5>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
<!--        <div class="btn-toolbar">-->
<!--            <div class="btn-group btn-group-sm">-->
<!--                <button class="btn btn-default">All stores</button>-->
<!--                <button class="btn btn-default">A</button>-->
<!--                <button class="btn btn-default">B</button>-->
<!--                <button class="btn btn-default">C</button>-->
<!--                <button class="btn btn-default">D</button>-->
<!--                <button class="btn btn-default">E</button>-->
<!--                <button class="btn btn-default">F</button>-->
<!--                <button class="btn btn-default">G</button>-->
<!--                <button class="btn btn-default">H</button>-->
<!--                <button class="btn btn-default">I</button>-->
<!--                <button class="btn btn-default">J</button>-->
<!--                <button class="btn btn-default">K</button>-->
<!--                <button class="btn btn-default">L</button>-->
<!--                <button class="btn btn-default">M</button>-->
<!--                <button class="btn btn-default">N</button>-->
<!--                <button class="btn btn-default">O</button>-->
<!--                <button class="btn btn-default">P</button>-->
<!--                <button class="btn btn-default">Q</button>-->
<!--                <button class="btn btn-default">R</button>-->
<!--                <button class="btn btn-default">S</button>-->
<!--                <button class="btn btn-default">T</button>-->
<!--                <button class="btn btn-default">U</button>-->
<!--                <button class="btn btn-default">V</button>-->
<!--                <button class="btn btn-default">W</button>-->
<!--                <button class="btn btn-default">X</button>-->
<!--                <button class="btn btn-default">Y</button>-->
<!--                <button class="btn btn-default">Z</button>-->
<!--            </div>-->
<!--        </div>-->
        <div class="row m-t-30">

         <?php
            $Query ="SELECT A.*, Count((B.TableID)) as TotalCoupan
						 FROM tblcategory A,tblstore B
						 WHERE A.TableID = B.CategoryID 
						 GROUP BY A.TableID";
            $db->query($Query);
            while($db->next_record()){
         ?>

            <div class="col-sm-4">
                <div class="list-group"> <a href="#" class="list-group-item">
                        <?=$db->f('Title')?>
                    </a>
<!--                    <a href="#" class="list-group-item">Gift store</a>  <a href="#" class="list-group-item">Vendor store</a>  <a href="#" class="list-group-item">Stooree</a>  <a href="#" class="list-group-item">StoreVendor</a>-->
                </div>
            </div>
         <?php } ?>
<!--            <div class="col-sm-4">-->
<!--                <div class="list-group"> <a href="#" class="list-group-item">-->
<!--                        Shopname-->
<!--                    </a>  <a href="#" class="list-group-item">Gift store</a>  <a href="#" class="list-group-item">Vendor store</a>  <a href="#" class="list-group-item">Stooree</a>  <a href="#" class="list-group-item">StoreVendor</a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-sm-4">-->
<!--                <div class="list-group"> <a href="#" class="list-group-item">-->
<!--                        Shopname-->
<!--                    </a>  <a href="#" class="list-group-item">Gift store</a>  <a href="#" class="list-group-item">Vendor store</a>  <a href="#" class="list-group-item">Stooree</a>  <a href="#" class="list-group-item">StoreVendor</a>-->
<!--                </div>-->
<!--            </div>-->

        </div>
    </div>
</section>

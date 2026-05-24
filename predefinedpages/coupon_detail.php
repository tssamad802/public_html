<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
    die("Direct Access Not Allowed");
}
$obj = new DB_Sql();
$db = new DB_Sql();

$url = explode('__' , $_REQUEST['url']);

$string = "select s.* , c.CountryTag tag , c.`CountryKeyword` keyword  from tblstore s inner join tblcountry c on (s.CountryID = c.TableID) where URLKeyword = '".$url[0] ."' and s.ACTIVE = 1";
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
    $tag = $obj->f('tag');
    $url = $obj->f('url');
    $keyword = $obj->f('keyword');
    $H1 = $obj->f('H1');
    $H2 = $obj->f('H2');
}
if($StoreID > 0) {
    $Query = "select (select count(*) from tblcoupon where StoreID = $StoreID and couponClassification = 'code' ) as CouponCodes  , 
            (select count(*) from tblcoupon where StoreID = $StoreID) as TotalCoupon , 
            (select count(*) from tblcoupon where StoreID = $StoreID and couponClassification != 'code' ) as OfferCodes   
            from tblstore GROUP BY TotalCoupon order by sequence ASC";

    $db->query($Query);
    while ($db->next_record()) {
        $TotalCoupons = $db->f('TotalCoupon');
        $CouponCodes = $db->f('CouponCodes');
        $OfferCodes = $db->f('OfferCodes');
    }
}

?>
<style>
    #w74 { word-wrap: break-word; }

</style>

<!--<div class="breadcrmb-wrap hidden-xs">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-sm-6">-->
<!--                <ol class="breadcrumb">-->
<!--                    <li class="breadcrumb-item"><a href="#">Home</a> </li>-->
<!--                    <li class="breadcrumb-item active"><a href="#">Store</a> </li>-->
<!--                </ol>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<section class="results m-t-30">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="widget">
                    <!-- /widget heading -->
                    <!--        <div class="widget-heading">-->

                    <!--            <div class="clearfix"></div>-->
                    <!--        </div>-->
                    <div class="widget-body">
                        <div class="img-responsive">
                            <img src="/files/banners/<?=$Logo?>" />
                            <br>
                        </div>
                        <h3 style="font-weight: bold"><?=$StoreName?> Coupons <?=($H1!="") ? $H1 : $tag ?></h3>
                        <br>
                        <br>
                        <p id="w74"><?=$About?></p>
                        <br>
                        <h3>About <?=$StoreName?></h3>

                        <p id="w74"  class="EventContentDynamic"><?=$Description?></p>

                        <h3>Avg Discount <?=$Discount?></h3>

                        <p>Rating <?=$Rating?> / 5 (<?=$Votes?> vates cast) </p>

                        <h3><?=$StoreName?> Offers</h3>

                        <a onclick="filter('total');" style="cursor: pointer"><p>Total Coupons      :  <span style="font-weight: bolder"><?=$TotalCoupons?></span></p></a>
                        <a onclick="filter('code');" style="cursor: pointer" ><p>Coupon Codes      :  <span style="font-weight: bolder"><?=$CouponCodes?></span></p></a>
                        <a onclick="filter('offer');" style="cursor: pointer"><p> Offers Codes    :  <span style="font-weight: bolder"><?=$OfferCodes?></span></p></a>

                    </div>
                </div>

            </div>
            <h3 class="col-sm-8" style="margin-left: 14px;text-transform:capitalize; font-weight: bold"><?=$StoreName?> <?=($H2!="") ? $H2 : $keyword ?></h3>

            <div class="col-sm-9" id="resultDiv"></div>

            <div class="col-md-12 col-sm-12"><h3 style="text-transform:capitalize; margin: auto" ><?=$StoreName?> Products</h3></div>
            <div class="col-md-9 col-sm-9" id="productListing"></div>
            <div class="col-sm-12" id="relatedStore"></div>
        </div>

    </div>
</section>
<form id="formsearch">
    <input type="hidden" name="StoreID" value="<?=$StoreID?>">
</form>

<script>
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_store_detail.php?actions=couponlisting&data=<?=$url[1]?>&page=0','formsearch','resultDiv');
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_store_detail.php?actions=productListing&page=0','formsearch','productListing');
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_store_detail.php?actions=relatedStore&page=0','formsearch','relatedStore');


    const filter = (name) => {
        SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_store_detail.php?actions=datalisting&data='+name+'&page=0','formsearch','resultDiv');
    }
</script>
<?php
$arr = array($StoreName , $url);
return $arr;
?>
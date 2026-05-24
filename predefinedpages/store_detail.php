<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
    die("Direct Access Not Allowed");
}
$obj = new DB_Sql();
$db = new DB_Sql();

$string = "select s.* , c.CountryTag tag , c.`CountryKeyword` keyword  from tblstore s inner join tblcountry c on (s.CountryID = c.TableID) where URLKeyword = '".$_REQUEST['url'] ."' ";
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
            (select count(*) from tblcoupon where StoreID = $StoreID and couponClassification = 'offer' ) as OfferCodes   
            from tblstore GROUP BY TotalCoupon";

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

    <section class="results m-t-30">
    <div class="container">
        <div class="row">
    <div class="col-sm-3">
    <div class="widget">
        <div class="widget-body"id="hide">
            <div class="img-responsive" alt="">
                <a class="thumbnail" href="<?=$db1->f('trackingUrl')?>">
                <img src="/files/banners/<?=$Logo?>"/ alt="">
                </a>
                <br>
                <p style="font-weight: bold; color: #2075b3">Avg Discount <?=$Discount?></p>
                <br>
                <p style="font-weight: bold; color: #2075b3">Rating <?=$Rating?> / 5 (<?=$Votes?> votes cast) </p>
                <br>
            </div>
            <h3 style="font-weight: bold" ><?=$StoreName?> <?=($H1!="") ? $H1 : $tag ?> </h3>
            <br>

            <p id="w74"><?=$About?></p>

            <h3 style="font-weight: bold">About <?=$StoreName?></h3>

            <span id="w74"  class="EventContentDynamic" style="word-break: break-word;"><?=$Description?></span>


            <h3><?=$StoreName?> Offers</h3>
            <a onclick="filter('total');" style="cursor: pointer; font-weight: bold"><p>Total Coupons      :  <span style="font-weight: bolder"><?=$TotalCoupons?></span></p></a><br>
            <a onclick="filter('code');" style="cursor: pointer; font-weight: bold" ><p>Coupon Codes      :  <span style="font-weight: bolder"><?=$CouponCodes?></span></p></a><br>
            <a onclick="filter('offer');" style="cursor: pointer; font-weight: bold"><p> Offers     :  <span style="font-weight: bolder"><?=$OfferCodes?></span></p></a>

        </div>
    </div>

</div>
            <div class="showOnMobile" >
                <ul class="menu-ul" style="margin-left: -30px">
                    <li style="font-size: small; margin-right: 0px"><a onclick="filter('total');" style="margin-left : 10px; cursor: pointer; font-weight: bold"><p>Total Coupons      :  <span style="font-weight: bolder"><?=$TotalCoupons?></span></p></a><br></li>
                    <li style="font-size: small"><a onclick="filter('code');" style="margin-left : 10px;cursor: pointer; font-weight: bold" ><p>Coupon Codes      :  <span style="font-weight: bolder"><?=$CouponCodes?></span></p></a><br></li>
                    <li style="font-size: small"><a onclick="filter('offer');" style="margin-left : 10px;cursor: pointer; font-weight: bold"><p> Offers     :  <span style="font-weight: bolder"><?=$OfferCodes?></span></p></a></li>
                </ul>
            </div>
            <h3 class="col-sm-7" style="max-width: 716px; text-transform:capitalize; font-weight: bold" onclick="reload()"><a href="#" ><?=$StoreName?> <?=($H2!="") ? $H2 : $keyword ?></a></h3>
            <div class="col-sm-9" id="resultDiv"></div>
            <div class="col-md-12 col-sm-12" ><h3 style="margin-left: 14px;text-transform:capitalize; margin: auto;font-weight: bold" ><?=$StoreName?> Products</h3><br></div>
            <div class="col-md-12 col-sm-12" id="productListing"></div>
            <div class="col-sm-12" id="relatedStore"></div>
        </div>

    </div>
</section>
<form id="formsearch">
    <input type="hidden" name="StoreID" value="<?=$StoreID?>">
</form>

<script>
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_store_detail.php?actions=couponlisting&page=0','formsearch','resultDiv');
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_store_detail.php?actions=productListing&page=0','formsearch','productListing');
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_store_detail.php?actions=relatedStore&page=0','formsearch','relatedStore');


    const filter = (name) => {
        SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_store_detail.php?actions=datalisting&data='+name+'&page=0','formsearch','resultDiv');
    }
    const reload = () => {
        location.reload();
    }
</script>
<?php
    $arr = array($StoreName , $url);
    return $arr;
?>
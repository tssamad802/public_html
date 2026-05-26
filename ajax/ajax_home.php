<style type="text/css">
    h4:hover{
        color: #f30;
    }
</style>
<?php
include_once("ajax.php");
include_once("../classes/ajaxpagination.class.php");
$whereCond = '';
$q = $_REQUEST['q'] ?? '';
$Active = $_REQUEST['Active'] ?? '';


if($_REQUEST['actions'] == "couponHomelisting")
{
    $perPage = new PerPage();
    $pagelimit = $perPage->perpage;
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;
    $queryproduct = "SELECT c.sitewide AS sitewide, s.url as StoreURL ,s.trackingUrl AS storeTracking , country.Currency AS sumbol , s.Active Active,
                        s.URLKeyword AS URLKeyword ,c.TableID AS id,ctype.Title AS coponType , c.CreatedDateTime AS addedDate , s.disableUrl disableUrl, s.webUrl webUrl,
                        s.logo AS logo , c.description AS description , c.CouponName AS Name , c.`TableID` AS id ,
                         c.couponCode AS CODE , c.trackingLink AS trackURL , ctype.Title AS couponType , c.url as url , 
                         c.discount AS discount , c.couponClassification AS couponClassification 
                         FROM `tblcoupon` c INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`) 
                         INNER JOIN `tblcoupontype` ctype ON ( ctype.`TableID` = c.`CouponTypeID` ) 
                         INNER JOIN `tblcountry` country ON ( country.`TableID` = s.`CountryID` ) 
                         WHERE 1 AND c.ShowHome =1 LIMIT 12";
// , s.landingLink landingLink 
    $db->query($queryproduct);
    $rowcount = $db->num_rows();
//    $queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
    // $db->query($queryproduct);
    $RecordCount=$pagelimit * ($start - 1);

    // $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_store.php?actions=book_categories_listing&page=','searchfrm','resultDiv');
    $Counterlisting = 0;
    if($db->num_rows() > 0)
    { echo "<div class='col-sm-12 col-md-12 col-lg-12'>";
        while($db->next_record()){
            ?>
            <div class="col-md-3 col-lg-3" style="margin-top: 5px">
                <div class="coupon-wrapper row" style="background-color: white; margin:0px; margin-bottom: 12px">
            <?php if($db->f('sitewide')!='' && $db->f('sitewide')!=null) { ?>
                    <div class="dolphin sticker"><?=$db->f('sitewide') == "" ? "Sitewide" : $db->f('sitewide')?></div>
                <?php } ?>
<!--                     $db->f('couponType')=="percentage" ? '%' : $db->f('couponType')=="country" ? "$" : ''-->
                <?php if($db->f('discount')!="" && $db->f('discount')!=null){?>
                    <div class="banner"><?=($db->f('discount')=="") ? $db->f('sumbol').'OFF' : $db->f('discount') ?></div>
                <?php } ?>
                    <div class="coupon-data text-center">
                     

                            <!--<div class="offer-image">-->
                            <!--    <a href="<?=$db->f('StoreURL')?>">-->
                            <!--        <img class="cop-img" src="<?=RESOURCES_DOMAIN?>/files/banners/<?=$db->f('logo')?>" alt="offer banner image">-->
                            <!--    </a>-->
                            <!--</div>-->
                            
                            <div class="offer-image">
    <a href="<?=$db->f('StoreURL')?>">
        <img class="cop-img" 
             src="<?=RESOURCES_DOMAIN?>/files/banners/<?=$db->f('logo')?>" 
             alt="offer banner image"
            >
    </a>
</div>

                        <!-- end:Savings -->
                    </div>
                    <!-- end:Coupon data -->
                    <div class="coupon-contain col-sm-12">
                      
                           <?php
                        if($db->f('Active')==0){      
                            $url = $db->f('disableUrl');
                            $url .= $db->f('webUrl'); 
                        ?>

                            <a target="_blank"  href="<?=$url?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview" aria-label="Coupon details quickview" ><p class="btn-code" data-toggle="modal" data-target=".couponModal"  style="display: none;">
                                   <h3 class="coupon-title" style="font-weight: bold"><?=$db->f('Name')?></h3>
                               </p>
                           </a>
                        <?php }else{ ?>
                            <a target="_blank"  href="<?=($db->f('trackURL')!="") ? $db->f('trackURL') : $db->f('storeTracking')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview" aria-label="Coupon details quickview" ><p class="btn-code" data-toggle="modal" data-target=".couponModal" style="display: none;">
                                <h3 class="coupon-title" style="font-weight: bold"><?=$db->f('Name')?></h3>
                               </p>
                           </a>
                        <?php } ?>
                      
                        <div class="btn-group" role="group" aria-label="...">
<!--                            <p>=substr($db->f('description') , 0 ,65)//= strlen($db->f('description')) >65 ? "..." :""--</p>-->
                            <span style="color: #4A4848; font-weight: bold" class="small">Added on : <?=substr($db->f('addedDate') , 0 ,11)?></span>
                        </div>
                        <!-- end:Coupon details -->
                    </div> 
                    <!-- end:Coupon cont -->
                    <div class="price-line clearfix"></div>
                    <div class="buy-button button-outer code " data-html="false" data-offerid="8378836" data-printable-single-use="0" data-printable="0" data-simple="0" data-single-use="0">
                        <a href="<?=($db->f('landingLink')!='') ? $db->f('landingLink') : $db->f('storeTracking')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview" aria-label="Coupon details quickview"  ><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal"><span class="btn-hover"><?=($db->f('couponClassification')=="code") ? "Get Code" : "Get Offer" ?></span></p></a>
                    </div>
                  
                </div>
            </div>
        <?php

    }
    echo "</div>";
}
}

if( $_REQUEST['actions']=="storeHomelisting")
{
    $perPage = new PerPage();
    $pagelimit = $perPage->perpage;
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;

    // $queryproduct = "select * from tblstore where ";
$whereCond = ' s.ShowHome = 1 and s.active!=2 ';
$queryproduct = "SELECT s.*, s.trackingUrl AS trackingLink, s.Active active, s.URLKeyword, s.TableID AS id, n.Title as NetName FROM tblstore s 
INNER JOIN `tblcountry` c ON (s.`CountryID` = c.`TableID`) 
INNER JOIN tblnetwork n ON (n.`TableID` = s.`NetworkID`) where  $whereCond order by name ASC limit 12";
    $db->query($queryproduct);
    $rowcount = $db->num_rows();
//    $queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
    $db->query($queryproduct);
    $RecordCount=$pagelimit * ($start - 1);

    $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_store.php?actions=book_categories_listing&page=','searchfrm','resultDiv');
    $Counterlisting = 0;
    if($db->num_rows() > 0)
    {
        while($db->next_record()){
            ?>
            <!--<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 thumb">-->
            <div class="col-lg-2 col-md-2 col-sm-2 thumb">
                <div class="thumb-inside">
                    <a class="thumbnail" href="<?= RESOURCES_DOMAIN.'/'.STORE_URL.'/'.$db->f('URLKeyword')?>" aria-label="navigate to categories page" >
                        <img class="img-small" src="files/banners/<?=$db->f('logo')?>" alt="categories image ">
                    </a> 
                 <div class="store_name text-center">
                    <a href="<?=$db->f('trackingLink')?>" aria-label="go to categories"><h4 style="font-weight: bold"><?=$db->f('name')?></h4></a>
                </div>
                </div>
                
            </div>
        <?php }
    }
}


if( $_REQUEST['actions']=="productHomelisting")
{
    $perPage = new PerPage();
    $pagelimit = $perPage->perpage;
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;

    $queryproduct = " SELECT p.*, country.Currency Currency FROM tblproduct p 
                    INNER JOIN `tblstore` s ON (s.`TableID` = p.`StoreID`) 
                    INNER JOIN `tblproductcategory` c  ON (c.`ProductID` = p.`TableID`)
                    INNER JOIN  `tblcoupontype` ctype ON ( ctype.`TableID` = p.`ProductTypeID` )
                    INNER JOIN `tblcountry` country ON (`country`.`TableID` = p.`CountryID`)  WHERE p.ShowHome = 1 GROUP BY p.`TableID` LIMIT 8";
    $db->query($queryproduct);
    $rowcount = $db->num_rows();
//    $queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
    $db->query($queryproduct);
    $RecordCount=$pagelimit * ($start - 1);

    $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_store.php?actions=book_categories_listing&page=','searchfrm','resultDiv');
    $Counterlisting = 0;
    if($db->num_rows() > 0)
    {
        while($db->next_record()){
            $per = $db->f('NewPrice') / $db->f('OldPrice') * 100-100;
            $per = intval($per);
            $per = abs($per);
            ?>
            <div class="col-md-3 col-lg-3" style="padding-left: 0px !important;">
                <div class="coupon-wrapper row" style="background-color: white; margin:0px;">
                    <div style="visibility: hidden;">.</div>
                    <?php if($db->f('sitewide')!='' && $db->f('sitewide')!=null) {?>
                        <div class="dolphin sticker"><?=$db->f('sitewide') == "" ? "Sitewide" : $db->f('sitewide')?></div>
                    <?php } ?>
                    
                    <?php if($db->f('discount')!="" && $db->f('discount')!=null){ ?>
                        <div class="banner"><?=$db->f('discount')?></div>
                    <?php }else if ($per >0) { ?>
                        <div class="banner"><?= $per . '%' ?> OFF</div>
                        <?php $per = 0; } ?>
                    <div class="coupon-data col-sm-12 col-md-12 col-lg-12 text-center">
                        <a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=ProductDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview" aria-label="Coupon details quickview"  ><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal">
                            <div class="offer-image">
                                <img class="product-image" src="<?=RESOURCES_DOMAIN?>/files/banners/<?=$db->f('logo')?>"  style="margin-top: 0px;" alt="offer image" >
                            </div>
                        </p>
                    </a>
            
                        <!-- end:Savings -->
                    </div>
                    <!-- end:Coupon data -->
                    <div class="coupon-contain col-sm-12">

                         <a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=ProductDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview" aria-label="Coupon details quickview"  ><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal" style="display: none;">
                                <h3 class="coupon-title" style="font-weight: bold;"><?=$db->f('ProductName')?></h3>
                            </p>
                        </a>

                        <div class="btn-group" role="group" aria-label="...">
                            <span style="color:#4A4848" class="small">Added on : <?=substr($db->f('CreatedDateTime') , 0 ,11)?></span>
                            <br>
                            <?php
                            if($db->f('CutPrice')==1)
                            {
                                ?>
                                <span style="" class="small"><del><?=$db->f('Currency')?><?=$db->f('OldPrice')?></del></span>
                            <?php }  ?>
                            <span style="font-weight: bold" class=""><?=$db->f('NewPrice')>0 ? $db->f('Currency').''.$db->f('NewPrice') : ''?></span>
                        </div>
                    </div>
                   <div class="buy-button button-outer code " data-html="false" data-offerid="8378836" data-printable-single-use="0" data-printable="0" data-simple="0" data-single-use="0">
                        <a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=ProductDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview" aria-label="Coupon details quickview"  ><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal"><span class="btn-hover"><?=$db->f('ProductClassification') =="code" ? "Get Code" : "Get Offer" ?></span></p></a>
                    </div>

                </div>
            </div>

        <?php }
    }
}

?>
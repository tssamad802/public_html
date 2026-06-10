    <?php

    include_once("ajax.php");
    include_once("../classes/ajaxpagination.class.php");
    $whereCond = '';
    $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
    $Active = isset($_REQUEST['Active']) ? $_REQUEST['Active'] : '';
    $actions = $_REQUEST['actions'] ?? '';
    $data = $_REQUEST['data'] ?? '';
    $url = $_REQUEST['url'] ?? '';
    if($actions == "couponlisting")
    {
    $perPage = new PerPage();
    $pagelimit = $perPage->perpage;
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    echo '<div class="col-sm-9">';
    $whereCond = "";
    if($data != ""){
        $whereCond .= " and ctype.URLKeyword = '".secureTextForDb($data)."'";
    }
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;
    // $queryproduct="SELECT c.TableID as TableID, c.description description, c.landingLink landingLink,s.logo logo, s.webUrl as StoreWeb ,c.discount discount ,s.trackingUrl as storeTracking , c.featured as featured , c.endDate as endDate , ctype.Title as coponType , c.CouponName as name , c.`TableID` AS id , c.couponCode as code , c.trackingLink as trackURL , c.description as Description ,c.sitewide as sitewide, s.url as url ,
    //         s.Active storeStatus, s.disableUrl FROM `tblcoupon` c
    //                                             INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`)
    //                                             INNER JOIN  `tblcoupontype` ctype ON ( ctype.`TableID` = c.`CouponTypeID` )
    //                                              ".$whereCond." "; //c.endDate >= CURDATE() INNER JOIN `tblcoupontag` ctag ON (ctag.`TableID` = c.`CouponTagID`)
                                                //  exit($queryproduct);
$queryproduct = "SELECT 
    c.TableID as TableID, 
    c.description description, 
    c.landingLink landingLink,
    s.logo logo, 
    s.webUrl as StoreWeb,
    c.discount discount,
    s.trackingUrl as storeTracking,
    c.featured as featured,
    c.endDate as endDate,
    ctype.Title as coponType,
    c.CouponName as name,
    c.TableID AS id,
    c.couponCode as code,
    c.trackingLink as trackURL,
    c.description as Description,
    c.sitewide as sitewide,
    s.url as url,
    s.Active storeStatus,
    s.disableUrl,
    c.Active as couponStatus,
    c.CreatedDateTime as createdDate
FROM `tblcoupon` c
INNER JOIN `tblstore` s ON (c.StoreID = s.TableID)
INNER JOIN `tblcoupontype` ctype ON (ctype.TableID = c.CouponTypeID)
WHERE 1=1
AND c.Active = 1
AND (c.endDate >= CURDATE() OR c.endDate = '0000-00-00')
" . $whereCond . "
ORDER BY c.TableID DESC";
                                                // echo "<script>alert(" . json_encode($queryproduct) . ");</script>";
                                                //echo "<script>console.log(" . json_encode($queryproduct) . ");</script>";
    $db->query($queryproduct);
    $rowcount = $db->num_rows();
    $queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
    $db->query($queryproduct);
    $RecordCount=$pagelimit * ($start - 1);

    $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_coupon.php?actions=couponlisting&page=','searchfrm','resultDiv');
    //    print_r($perpageresult);
    $Counterlisting = 0;
    if($db->num_rows() > 0)
    {
    while($db->next_record()){
        ?>
        <div class="coupon-wrapper coupon-single">
            <div class="row">
                <div class="ribbon-wrapper hidden-xs">
                    <?php if($db->f('sitewide')!=''){ ?>
                        <div class="ribbon"  style="text-transform: uppercase;"><?=$db->f('sitewide')?></div>
                    <?php } ?>
                </div>
                <div class="coupon-data col-md-3 col-sm-3 text-center">
                    <div class="savings text-center">
                           
                                    <a href="<?=$db->f('url')?>">
                                        <img src="../files/banners/<?=$db->f('logo')?>" alt="">
                                    </a>
                    </div>
                    <!-- end:Savings -->
                </div>
                <!-- end:Coupon data -->
                <div class="coupon-contain col-md-6 col-sm-6">
                    <ul class="list-inline list-unstyled">
                        <li><span class="verified  text-success"><i class="fas fa-check"></i>Verified</span> </li>
                    </ul>
                    
                      <?php
                        if($db->f('storeStatus')==0){  
                            $url = $db->f('disableUrl');
                            $url .= $db->f('StoreWeb'); 
                        ?>

                                 <a target="_blank" style="font-weight: bold"  href="<?=$db->f('StoreWeb')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview">
                                     <p class="btn-code" data-toggle="modal" data-target=".couponModal"  style="display: none;">
                                      <h4 class="coupon-title" id="hover" style="font-weight: bold"><?=$db->f('name')?> </h4>
                                   </p>
                           </a>
                        <?php } else{ ?>
                            <a target="_blank" style="font-weight: bold"  href="<?=($db->f('landingLink')!="") ? $db->f('landingLink') : (($db->f('trackURL')!=null) ? $db->f('trackURL') : $db->f('storeTracking'))?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview">
                                <p class="btn-code" data-toggle="modal" data-target=".couponModal"  style="display: none;">
                                 <h4 class="coupon-title" style="font-weight: bold" id="hover"><?=$db->f('name')?></h4>
                               </p>
                           </a>
                        <?php } ?>


                  <span style="font-weight: bold; color: #2075b3"><?=$db->f('description')?></span>

                </div>
                <!-- end:Coupon cont -->
                <div class="button-contain col-sm-3 text-center">

                     <?php
                        if($db->f('storeStatus')==0){ 
                            ?>
                            <a target="_blank" style="font-weight: bold"  href="<?=$db->f('StoreWeb')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover">Get Code</span></p></a>
                        <?php }else{ ?>
                            <a target="_blank" style="font-weight: bold"  href="<?=($db->f('landingLink')!="") ? $db->f('landingLink') : (($db->f('trackURL')!=null) ? $db->f('trackURL') : $db->f('storeTracking'))?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover">Get Code</span></p></a>
                        <?php } ?>
                    
                    <?php if(($db->f('endDate')!="0000-00-00") && ($db->f('endDate')!="")){ ?>
                        <p style="font-weight: bold">Expire : <?=$db->f('endDate')?></p>
                    <?php } ?>
                </div>
            </div>
            <!-- //row -->
        </div>
    <?php }


    ?>
</div>

</div>

<div class="col-sm-3 olc-md-3">
    <div class="coupon-wrapper coupon-single">
        <h5 style="font-weight: bold">Similar Category</h5>

        <?php
        $queryproduct = "SELECT * from tblcategory WHERE parentID = 0 ORDER BY RAND() limit 10";
        $db->query($queryproduct);
        if($db->num_rows() > 0)
        {
            while($db->next_record())
            { ?>
                <hr>
                <i class="fas fa-archway"> <a href="<?$_SERVER['HTTP_HOST']?>/category/<?=$db->f('URLKeyword')?>" style="font-weight: bold;"><?=$db->f('Title')?></a></i>
            <?php }
        }
        ?>
    </div>
</div></div>
<?php


$output = '<br><div class="col-md-4">
                   <div class="box center float-left space-30">
					    <nav class="pagination paginationNew">' . $perpageresult . '</nav>
				    </div>
				</div>';
//        $output = ' <ul class="pagination pagination-lg ">'.$perpageresult.'</ul>';
echo $output;
}
else
    echo $output = "<h3>No coupon here</h3>";
}

if($actions == 'relatedProduct')
{   $type = $url;
    $Title = '';
$query="SELECT * FROM `tblcoupontype` WHERE URLKeyword = '".secureTextForDb($type)."'";
$db->query($query);
while($db->next_record()){
    $Title = $db->f('Title');
}
    ?>
    <div>
        <div class="widget-heading">
            <h3 class="widget-title text-dark" style="font-weight: bold">
                Related Products
            </h3>
            <div class="clearfix"></div>
        </div>
        <div class="widget-body">
            <div class="row">
                <div class="col-sm-12">
                <?php
                // $Query = "SELECT * FROM tblproduct p inner join tblcoupontype c ON (c.TableID = p.ProductTypeID) inner join tblcountry country ON(country.TableID = p.CountryID) WHERE c.Title = '".$type."' limit 30;";
                 $Query = "SELECT *,country.Currency as sumbol FROM tblproduct p INNER JOIN `tblproductstypes` pt ON (p.`TableID` = pt.`ProductID`) 
                 INNER JOIN `tblcountry` country ON (`country`.`TableID` = p.`CountryID`) 
                 INNER JOIN tblcoupontype ct ON(pt.`CouponTypeID`=`ct`.`TableID`) WHERE ct.`Title` = '".$Title."' limit 30;";
                $db->query($Query);
                if($db->num_rows() > 0)
                {
                    $db->query($Query);
                    while($db->next_record()){

                        if($db->f('NewPrice') > 0 && $db->f('OldPrice') > 0){
                            $per = $db->f('NewPrice') / $db->f('OldPrice') * 100-100;
                            $per = intval($per);
                            $per = abs($per);
                        }
                        ?>
                        <div class="col-md-3 col-lg-3" style="padding-left: 0px !important;">
                            <div class="coupon-wrapper cop-warp row" style="background-color: white; margin:0px;">
                                <div style="visibility: hidden;">.</div>
                                <?php if($db->f('sitewide')!='' && $db->f('sitewide')!=null) {?>
                                    <div class="dolphin sticker"><?=$db->f('sitewide') == "" ? "Sitewide" : $db->f('sitewide')?></div>
                                <?php } ?>
                                <?php if($db->f('discount')!="" && $db->f('discount')!=null){ ?>
                                                                <!--                    //= (isset($per)) ? $db->f('sumbol') : '' ?> -->

                                    <div class="banner"><?=$db->f('discount')?></div>
                                <?php }else if ($per >0) { ?>
                                    <div class="banner"><?= $per . '%' ?> OFF</div>
                                    <?php $per = 0; } ?>
                                <div class="coupon-data col-sm-12 col-md-12 col-lg-12 text-center">
                                    <a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal">
                                    <?php
                                    if($db->f('logo')==null){
                                        ?>
                                        <div class="offer-image">
                                            <div class="large" style="text-transform: uppercase;"><?=$db->f('discount')?></div>
                                            <!--                                    <div class="small">off</div>-->
                                            <div class="type">Coupon</div>
                                        </div>

                                    <?php } else {?>

                                        <div class="offer-image">
                                            <img src="<?=RESOURCES_DOMAIN?>/files/banners/<?=$db->f('logo')?>" style="margin-top: 0px; height: 200px">
                                        </div>

                                    <?php } ?>
                                </p></a>
                                    <!-- end:Savings -->
                                </div>
                                <!-- end:Coupon data -->
                                <div class="coupon-contain col-sm-12">

                                    <h4 class="coupon-title" id="hover"><a href="<?=RESOURCES_DOMAIN?>/<?=COUPON?>/<?=$db->f('URLKeyword')?>" style="font-weight: bold"><?=$db->f('ProductName')?></a></h4>

                                    <div class="btn-group" role="group" aria-label="...">
                                        <span style="color: #8a8b92" class="small">Added on : <?=substr($db->f('CreatedDateTime') , 0 ,11)?></span>
                                        <br>
                                        <?php
                                        if($db->f('CutPrice')==1){
                                            ?>
                                            <span style="" class="small"><del><?=$db->f('sumbol')?><?=$db->f('OldPrice')?></del></span>
                                        <?php }  ?>
                                                   
                                                    <span style="font-weight: bold" class=""><?=$db->f('NewPrice')>0 ? $db->f('sumbol').''.$db->f('NewPrice') : ''?></span>


                                    </div>
                                    <!-- end:Coupon details -->
                                </div>
                                <!-- end:Coupon cont -->
                                <!--                <div class="price-line clearfix"></div>-->
                                <div class="buy-button button-outer code " data-html="false" data-offerid="8378836" data-printable-single-use="0" data-printable="0" data-simple="0" data-single-use="0">
                                    <a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal"><span class="btn-hover"><?=$db->f('ProductClassification') =="code" ? "Get Code" : "Get Offer" ?></span></p></a>
                                </div>
                                <!--<div class="button-contain col-sm-3 text-center">
                                    <p class="btn-code" data-toggle="modal" data-target=".couponModal"> <span class="partial-code">BTSBAGS</span> <span class="btn-hover"><a href="javascript:;" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview">Get Code</a></span> </p>
                                </div>-->
                            </div>
                        </div>


                    <?php }} ?>
                </div>
            </div>
        </div>
    </div>
<?php }
if($actions == "couponlistingType")
{
    $perPage = new PerPage();
    $pagelimit = $perPage->perpage;
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;
    $queryproduct="SELECT c.TableID as TableID, c.description description, s.logo logo ,c.discount discount ,s.trackingUrl as storeTracking , c.featured as featured , c.endDate as expire , ctype.Title as coponType , c.CouponName as name , c.`TableID` AS id , c.couponCode as code , c.trackingLink as trackURL , c.description as Description ,c.sitewide as sitewide FROM `tblcoupon` c
                                                INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`)
                                                INNER JOIN  `tblcoupontype` ctype ON ( ctype.`TableID` = c.`CouponTypeID` )
                                                 WHERE c.Active = 1 and ctype.URLKeyword = '".secureTextForDb($data)."'"; //c.endDate >= CURDATE() INNER JOIN `tblcoupontag` ctag ON (ctag.`TableID` = c.`CouponTagID`)
    $db->query($queryproduct);
    $rowcount = $db->num_rows();
    $queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
    $db->query($queryproduct);
    $RecordCount=$pagelimit * ($start - 1);

    $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_coupon.php?actions=couponlisting&page=','searchfrm','resultDiv');
//    print_r($perpageresult);
    $Counterlisting = 0; ?>
    <div class="col-sm-9">
<?php    if($db->num_rows() > 0)
    {
        while($db->next_record()){
            ?>
            <div class="coupon-wrapper coupon-single">
                <div class="row">
                    <div class="ribbon-wrapper hidden-xs">
                        <?php if($db->f('sitewide')!=''){ ?>
                            <div class="ribbon"  style="text-transform: uppercase;"><?=$db->f('sitewide')?></div>
                        <?php } ?>
                    </div>
                    <div class="coupon-data col-sm-2 text-center">
                        <div class="savings text-center">
                          
                                <div>
                                    <a href="">
                                    <img src="../files/banners/<?=$db->f('logo')?>" alt=">
                                </a>
                                </div>
                        </div>
                        <!-- end:Savings -->
                    </div>
                    <!-- end:Coupon data -->
                    <div class="coupon-contain col-sm-7">
                        <ul class="list-inline list-unstyled">
                            <li><span class="verified  text-success"><i class="ti-face-smile"></i>Verified</span> </li>
                        </ul>
                        <h4 class="coupon-title" id="hover"><a href="#"><?=$db->f('name')?></a></h4>
                        <?php $replace1 = str_replace("<p>", "" , $db->f('description')) ?>
                        <span ><?=substr($replace1 , 0 , 40)?><!---->
                            <?php $replace = str_replace("</p>", "" , $db->f('description'));?>
                            <span class="collapse" id="<?=$db->f('TableID')?>" ><?=substr( $replace , 32)?></span></span>
                        <?php  if (strlen($db->f('description')) >= 40 ){?>
                            <span data-toggle="collapse" href="#<?=$db->f('TableID')?>" aria-expanded="false" aria-controls="collapseExample">
                            ...
                        </span>
                        <?php } ?>


                    </div>
                    <!-- end:Coupon cont -->
                    <div class="button-contain col-sm-3 text-center">
                        <a target="_blank"  href="<?=($db->f('trackURL')!='') ? $db->f('trackURL') : $db->f('storeTracking')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover">Get Code</span></p></a>
                        <?php if(($db->f('endDate')!="0000-00-00") && ($db->f('endDate')!="")){ ?>
                            <p style="font-weight: bold">Expire: <?=$db->f('endDate')?></p>
                        <?php } ?>
                    </div>
                </div>

            </div>

        <?php }
        echo '</div>';

        ?>

        <div class="col-sm-3 olc-md-3">
            <div class="coupon-wrapper coupon-single">
                <h5 style="font-weight: bold">Similar Category</h5>

                <?php
                $queryproduct = "SELECT * from tblcategory WHERE parentID = 0 ORDER BY RAND() limit 6";
                $db->query($queryproduct);
                if($db->num_rows() > 0)
                {
                    while($db->next_record())
                    { ?>
                        <hr>
                        <i class="fas fa-archway"> <a href="<?$_SERVER['HTTP_HOST']?>/category/<?=$db->f('URLKeyword')?>" style="position: absolute; left: 40px"><?=$db->f('Title')?></a></i>
                    <?php }
                }
                ?>
            </div>
        </div>
        <?php


        $output = '<div class="box center float-left space-30">
					<nav class="pagination paginationNew">' . $perpageresult . '</nav>
				</div>';
//        $output = ' <ul class="pagination pagination-lg ">'.$perpageresult.'</ul>';
        echo $output;
    }
    else
        echo $output = "<h3>No coupon here</h3>";
}
?>

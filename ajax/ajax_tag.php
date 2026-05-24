<style type="text/css">
    h4:hover{
        color: #f30;
    }
</style>
<?php

include_once("ajax.php");
include_once("../classes/ajaxpagination.class.php");
$whereCond = '';
$q = $_REQUEST['q'];
$Active = $_REQUEST['Active'];
if($_REQUEST['actions'] == "couponlisting")
{
    $perPage = new PerPage();
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;
    $queryproduct="SELECT c.*, s.url as url , s.trackingUrl,s.URLKeyword URLKeywords , s.webUrl as StoreWeb, s.Active, s.disableUrl,  s.logo as StoreLogo FROM `tblcoupon` c
                                                INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`)
                                                INNER JOIN  `tblcoupontype` ctype ON ( ctype.`TableID` = c.`CouponTypeID` )
                                                INNER JOIN  `tblcoupontag` ctag ON ( ctag.`TableID` = c.`CouponTagID` )
                                                 WHERE c.Active = 1 and ctag.URLKeyword = '".$_REQUEST['data']."'"; //c.endDate >= CURDATE() INNER JOIN `tblcoupontag` ctag ON (ctag.`TableID` = c.`CouponTagID`)
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
                         <?php if($db->f('sitewide')!='' && $db->f('sitewide')!=null) {?>
                    <div class="ribbon" style="text-transform: uppercase;"><?=$db->f('sitewide')?></div>
                <?php } ?>
                    </div>

                   <div class="coupon-data col-md-3 col-sm-3 text-center">
                        <div class="savings text-center">
                            
                                <div>
                                 <a href="<?=$db->f('url')?>">
                                       <img src="../files/banners/<?=$db->f('StoreLogo')?>" alt="">
                                </a>
                                </div>
                        
                        </div>
                        <!-- end:Savings -->
                    </div>
                    
                    <!-- end:Coupon data -->
                     <div class="coupon-contain  col-md-6 col-sm-6">
                        <ul class="list-inline list-unstyled">
                            <li><span class="verified  text-success"><i class="fas fa-check"></i>Verified</span> </li>
                        </ul>
                          <?php
                        if($db->f('Active')==0){  
                            $url = $db->f('disableUrl');
                            $url .= $db->f('StoreWeb'); 
                        ?>

                            <a target="_blank"  href="<?=$url?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"  style="display: none;">
                                   <h4 class="coupon-title" style="font-weight: bold"><?=$db->f('CouponName')?></h4>
                               </p>
                           </a>
                        <?php }else{ ?>
                            <a target="_blank"  href="<?=($db->f('landingLink')!="") ? $db->f('landingLink') : $db->f('trackingUrl')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal" style="display: none;">
                                <h4 class="coupon-title" style="font-weight: bold"><?=$db->f('CouponName')?></h4>
                               </p>
                           </a>
                        <?php } ?>

                        <span style="font-weight: bold; color: #2075b3"><?=$db->f('description')?></span>

                    </div>
                    <!-- end:Coupon cont -->
                    <div class="button-contain col-md-3 col-sm-3 text-center">
                        <?php
                        if($db->f('Active')==0){  
                            $url = $db->f('disableUrl');
                            $url .= $db->f('StoreWeb'); 
                        ?>

                            <a target="_blank"  href="<?=$url?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover" id="btn-text"><?=$db->f('couponCode')!="" ? "Get Code" : "Get Offer"?></span></p></a>
                        <?php }else{ ?>
                            <a target="_blank"  href="<?=($db->f('landingLink')!="") ? $db->f('landingLink') : $db->f('trackingUrl')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover" id="btn-text"><?=$db->f('couponCode')!="" ? "Get Code" : "Get Offer"?></span></p></a>
                        <?php } ?>
                        <?php if(($db->f('endDate')!="0000-00-00") && ($db->f('endDate')!="")){ ?>
                            <p style="font-weight: bold">Expire: <?=$db->f('endDate')?></p>
                        <?php } ?>
                    </div>

                </div>
                <!-- //row -->
            </div></div>
            
        

        <?php }

        $output = '<div class="box center float-left space-30">
					<nav class="pagination paginationNew">' . $perpageresult . '</nav>
				</div>';
        //$output = ' <ul class="pagination pagination-lg ">'.$perpageresult.'</ul>';
        echo $output;
    }
    else
        echo $output = "<h3>No coupon here</h3>";
}?>

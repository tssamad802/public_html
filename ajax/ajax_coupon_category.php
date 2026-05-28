<style>
    p{
        display: inline;
    }
    span{
        display: inline-block;
        font-weight: bold;
    }
    h4{
        font-weight: bold;
    }
    #hover:hover{
        color: #f30;
    }
</style>
<?php

include_once("ajax.php");
include_once("../classes/ajaxpagination.class.php");
$whereCond = '';
$q = $_REQUEST['q'] ?? '';
$Active = $_REQUEST['Active'] ?? '';
$actions = $_REQUEST['actions'] ?? '';
$data = $_REQUEST['data'] ?? '';
$query = "select * from `tblcategory` where `URLKeyword` = '".secureTextForDb($data)."';";
                $db->query($query);
                $TableID = 0;
                while ($db->next_record()) {
                    if(!$db->f('ParentID') > 0)
                        $TableID = $db->f('TableID');
                }
if($actions == "couponlisting")
{
$perPage = new PerPage();
$pagelimit = $perPage->perpage;
$page = 1;
if(!empty($_REQUEST["page"])) {
    $page = $_REQUEST["page"];
}
$start = ($page-1)*$perPage->perpage;
  

                if(!$TableID > 0)
                    $where = " category.`URLKeyword` = '".secureTextForDb($data)."'";
                else
                    $where = "category.`TableID` = '".$TableID."' OR category.`ParentID` = '".$TableID."'";

        
                $query="SELECT c.* , s.logo as StoreLogo , s.url as StoreURL , s.webUrl as StoreWeb, s.trackingUrl FROM `tblcategory` category inner join tblstorecategory st 
                ON (st.CategoryID = category.TableID ) INNER JOIN `tblstore` s ON(s.`TableID` = st.`StoreID`) inner join tblcoupon c on
                (c.StoreID=s.TableID)  WHERE $where   GROUP BY c.TableID"; //and cc.endDate >= CURDATE()
                             
                // exit($_REQUEST["data"]);
                $db->query($query);
                $rowcount = $db->num_rows();
                $query =  $query . " limit " . $start . "," . $perPage->perpage;
                $db->query($query);
                $RecordCount=$pagelimit * ($start - 1);

                $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_coupon_category.php?actions=couponlisting&data='.urlencode($data).'&page=','searchfrm','resultDiv');
                if($db->num_rows() > 0){
                while($db->next_record()){
                    ?>
                    <div class="coupon-wrapper coupon-single">
                        <div class="row">
                            <div class="ribbon-wrapper hidden-xs">
                                <?php if($db->f('sitewide')!='' && $db->f('sitewide')!=null) { ?>
                                    <div class="ribbon" style="text-transform: uppercase;"><?=$db->f('sitewide')?></div>
                                <?php } ?>

                            </div>
                            <div class="coupon-data col-md-3 col-sm-3 text-center">
                                <div class="savings text-center">

                                   
                                        <div>
                                            <a href="<?=$db->f('StoreURL')?>" ><img src="../files/banners/<?=$db->f('StoreLogo')?>" alt=""></a>
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
                                ?>
                            
                                    <h4 class="coupon-title" >
                                        <a target="_blank" id="hover" style="font-weight: bold" href="<?=$db->f('StoreWeb')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview">
                                            <?=$db->f('CouponName')?>
                                        </a>
                                    </h4>
                                
                                
                                  <?php } else{ ?>
                                       
                                         <h4 class="coupon-title">
                                                <a target="_blank" id="hover" style="font-weight: bold" href="<?=($db->f('landingLink')!="") ? $db->f('landingLink') : $db->f('trackingUrl')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview">
                                                    <?=$db->f('CouponName')?>
                                                </a>
                                             </h4>
                                         
                                </a>
                                <?php } ?>

                              <span style="font-weight: bold; color: #2075b3"><?=$db->f('description')?></span>
                            </div>
                            <!-- end:Coupon cont -->
                            <div class="button-contain col-md-3 col-sm-3 text-center">
                                <?php
                                    if($db->f('Active')==0){
                                ?>
                                    <a target="_blank"  href="<?=$db->f('StoreWeb')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover" id="btn-text"><?=$db->f('couponCode')!="" ? "Get Code" : "Get Offer"?></span></p></a>
                                <?php }else{ ?>
                                    <a target="_blank"  href="<?=($db->f('landingLink')!="") ? $db->f('landingLink') : $db->f('trackingUrl')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover" id="btn-text"><?=$db->f('couponCode')!="" ? "Get Code" : "Get Offer"?></span></p></a>
                                <?php } ?>
                                <?php if(($db->f('endDate')!="0000-00-00") && ($db->f('endDate')!="")){ ?>
                                    <p style="font-weight: bold">Expire : <?=$db->f('endDate')?></p>
                                <?php } ?>
                            </div>

                        </div>
                        <!-- //row -->
                    </div>
                <?php }
                   
                 

            } else
                echo $output = "<h3>No coupon here</h3>";


    $output = '<div class="box center float-left space-30">
					<nav class="pagination paginationNew">' . $perpageresult . '</nav>
				</div>';
    echo $output;
}



if($actions == "relatedProduct")
{

                if(!$TableID > 0)
                    $where = " c.`URLKeyword` = '".secureTextForDb($data)."' GROUP BY p.TableID";
                else
                    $where = "c.`ParentID` = '".$TableID."' GROUP BY p.TableID";
    ?>

      
            <div class="col-md-12 col-sm-12 col-lg-12">
                <?php
                    $Product ="SELECT p.* , country.Currency Currency , `category`.`CategoryID`,  s.trackingUrl as storeTracking FROM tblproduct p 
INNER JOIN tblcountry country ON (country.TableID = p.CountryID)
INNER JOIN `tblstore` s ON (s.`TableID` = p.`StoreID`)
 INNER JOIN `tblproductcategory` category ON (category.`ProductID` = p.`TableID` )
 INNER JOIN `tblcategory` c ON (`category`.`CategoryID`=c.`TableID`) 
                                WHERE $where ";
                    $db->query($Product);
                    if($db->num_rows()>0){ ?>
                        
                        <h1>Related Product</h1>

                        <?php
                    while($db->next_record())
                    {   
                        $per = 0;
                        if($db->f('NewPrice') > 0 && $db->f('OldPrice') > 0) {
                           $per = $db->f('NewPrice') / $db->f('OldPrice') * 100-100;
                            $per = intval($per);
                            $per = abs($per);
                        }
                        ?>
                        <div class="col-md-3 col-lg-3" style="padding-left: 0px !important;">
                            <div class="coupon-wrapper row" style="background-color: white; margin:0px; ">
                                <div style="visibility: hidden;">.</div>
                                <?php if($db->f('sitewide')!='' && $db->f('sitewide')!=null) {?>
                                    <div class="dolphin sticker"><?=$db->f('sitewide') == "" ? "Sitewide" : $db->f('sitewide')?></div>
                                <?php } ?>
                                <!--                    //= (isset($per)) ? $db->f('sumbol') : '' ?> -->
                                <?php if($db->f('discount')!="" && $db->f('discount')!=null){ ?>
                                    <div class="banner"><?=$db->f('discount')?></div>
                                <?php }else if ($per >0) { ?>
                                    <div class="banner"><?= $per . '%' ?> OFF</div>
                                    <?php $per = 0; } ?>
                                <div class="coupon-data col-sm-12 col-md-12 col-lg-12 text-center">
                                   
                                         <a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal" style="display: none;">
                                              <div class="offer-image">
                                                  <img src="<?=RESOURCES_DOMAIN?>/files/banners/<?=$db->f('logo')?>" style="margin-top: 0px; height: 200px" alt="">
                                               </div>
                                           </p>
                                       </a>

                                   
                                    <!-- end:Savings -->
                                </div>
                                <!-- end:Coupon data -->
                                <div class="coupon-contain col-sm-12">
                                
                                  <a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal" style="display: none;">
                                        <h4 class="coupon-title" id="hover" style="font-weight: bold;"><?=$db->f('ProductName')?></h4>
                                    </p>
                                </a>

                                    <div class="btn-group" role="group" aria-label="...">
                                        <span style="color: #8a8b92" class="small">Added on : <?=substr($db->f('CreatedDateTime') , 0 ,11)?></span>
                                        <br>
                                        <?php
                                        if($db->f('CutPrice')==1){
                                            ?>
                                            <span style="" class="small"><del><?=$db->f('Currency')?><?=$db->f('OldPrice')?></del></span>
                                           
                                        <?php }  ?>
                                         <span style="font-weight: bold" class=""><?=$db->f('NewPrice')>0 ? $db->f('Currency').''.$db->f('NewPrice') : ''?></span>
                                    </div>
                                    <!-- end:Coupon details -->
                                </div>
                                <!-- end:Coupon cont -->
                                <!--                <div class="price-line clearfix"></div>-->
                                <div class="buy-button button-outer code " data-html="false" data-offerid="8378836" data-printable-single-use="0" data-printable="0" data-simple="0" data-single-use="0">
                                    <a href="<?=($db->f('landingLink')!='') ? $db->f('landingLink') : $db->f('storeTracking')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?
									<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackingLink')?>" class="quickview">
										<p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal">
											<span class="btn-hover"><?=$db->f('ProductClassification') =="code" ? "Get Code" : "Get Offer" ?></span>
										</p>
									</a>
                                </div>
                                
                                <!--<div class="button-contain col-sm-3 text-center">
                                    <p class="btn-code" data-toggle="modal" data-target=".couponModal"> <span class="partial-code">BTSBAGS</span> <span class="btn-hover"><a href="javascript:;" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview">Get Code</a></span> </p>

                                </div>-->
                            </div>
                        </div>
                    <?php }} ?>  
                
            </div>

<?php }
?>

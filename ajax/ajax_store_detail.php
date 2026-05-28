<script>
function myFunction(id) {
  var dots = document.getElementById(id);
  var moreText = document.getElementById('1'+id);
//   var btnText = document.getElementById("myBtn");
// moreText.style.display = "inline";
  if (dots.style.display === "none") {
    dots.style.display = "inline";
    // btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    // btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
</script>
<style>
#more {display: none;}
p{
    display: inline;
}
span{
    display: inline-block;
}
a:hover{
        color: #f30;
    }
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
$_REQUEST['actions'] = $_REQUEST['actions'] ?? '';
$_REQUEST['data'] = $_REQUEST['data'] ?? '';
$pagelimit = 0;

if($_REQUEST['actions'] == "couponlisting")
{
    $perPage = new PerPage();
    $pagelimit = $perPage->perpage;
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    $StoreID = $_REQUEST['StoreID'];
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;

    $Query = "select * from tblstore where TableID = ".$StoreID." "; //and endDate >= CURDATE()
    $db1->query($Query);
    if(isset($_REQUEST['data']))
        $queryproduct = "select c.* , s.logo as StoreLogo , s.trackingUrl , s.webUrl as StoreWeb, s.Active, s.disableUrl from tblcoupon c inner join tblstore s on(s.TableID = c.StoreID) where  c.Active != 2 and StoreID = ".$StoreID." and endDate >= CURDATE() or endDate = '0000-00-00') order by FIELD (URLKeyword , '".$_REQUEST['data']."') DESC , Sequence ASC "; //and endDate >= CURDATE()
    else
        $queryproduct = "select c.* , s.logo as StoreLogo , s.trackingUrl  , s.webUrl as StoreWeb, s.Active, s.disableUrl from tblcoupon c inner join tblstore s on(s.TableID = c.StoreID) where c.Active != 2  and StoreID = ".$StoreID." and endDate >= CURDATE() or endDate = '0000-00-00' order by Sequence ASC"; //and endDate >= CURDATE()

    $db->query($queryproduct);
    $rowcount = $db->num_rows();
   // $queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
    $db->query($queryproduct);
    $RecordCount=$pagelimit * ($start - 1);
//    $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_store.php?actions=book_categories_listing&page=','searchfrm','resultDiv');
    $Counterlisting = 0;


        echo '<div class="col-sm-9" >';
        while($db1->next_record()){ $StoreBanner = $db1->f('storeAdd'); $StoreName = $db1->f('name');
        ?>

        <div class="coupon-wrapper coupon-single" style="border: 5px solid black;   border-radius: 25px;" >
            <div class="row">
                <div class="coupon-data col-sm-2 text-center">
                    <div class="savings text-center">
                        <a class="thumbnail" href="<?=$db1->f('trackingUrl')?>">
                        <?php
                        if($db1->f('logo')==null){                            ?>
                            <div>
                                <div class="large" style="text-transform: capitalize;"><?=$db1->f('discount')?></div>
                                <!--                                    <div class="small">off</div>-->
                                <div class="type">Coupon</div>
                            </div>
                        <?php } else { ?>
                            <div>
                                <img src="../files/banners/<?=$db1->f('logo')?>" alt="">
                            </div>
                        <?php } ?>
                        </a>
                    </div>
                    <!-- end:Savings -->
                </div>
                <!-- end:Coupon data -->
                <div class="coupon-contain col-sm-7">
                    <ul class="list-inline list-unstyled">
                        <li><span class="verified  text-success"><i class="fas fa-check"></i><a href="#" style="font-weight: bold">Verified</span> </li>
                    </ul>
                            <h4 class="coupon-title">
                     <a href="#" style="font-weight: bold">
                         Save Big with Latest Deals & Verified Coupons at 
                        <span style="color:#100ced; font-weight:900;"><?=$db1->f('domain')?></span> – <?=date("F Y")?>
                              </a>
                        </h4>
                </div>
                <!-- end:Coupon cont -->
                
                <div class="button-contain col-sm-3 text-center">
                    <!-- <a target="_blank"  href="<?=$db1->f('trackingUrl')?>"  class="quickview"><p class="btn-code"  data-toggle="modal" data-target=".couponModal"><span class="btn-hover" id="btn-text">Save Now</span></p></a> -->
                    <?php 
                        $url = "";
                        if($db1->f('Active')==0){
                           $url = $db1->f('disableUrl');
                           $url .= $db1->f('webUrl'); 
                        }
                        else
                            $url .= $db1->f('trackingUrl');

                    ?>
                     <a target="_blank" href="<?=$url?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=StoreDetail&RecordID='.$db1->f('TableID'));?>" data-tracking="<?=$db1->f('webUrl')?>" class="quickview" ><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover" id="btn-text">Save Now</span></p></a>
                </div>

            </div>
            <!-- //row -->
        </div>

        <?php }
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
                           
                              <?php
                        if($db->f('discount')!="" && $db->f('discount')!=null){
                            ?>
                            <div>
                                <div class="large" style="text-transform: uppercase;"><?=$db->f('discount')?></div>
                                <!--                                    <div class="small">off</div>-->
                                <div class="type">Coupon</div>
                            </div>
                        <?php } else {?>
                            <div>
                                <img src="../files/banners/<?=$db->f('StoreLogo')?>" alt="">
                            </div>
                        <?php } ?>
                           
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
                            <a target="_blank"  href="<?=($db->f('trackingUrl')!="") ? $db->f('trackingUrl') : $db->f('trackingUrl')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal" style="display: none;">
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
            </div>



        <?php } } ?>

<?php
    $queryproduct = "select c.* , s.logo as StoreLogo, s.webUrl as StoreWeb, s.Active, s.disableUrl , s.trackingUrl  from tblcoupon c inner join tblstore s on(s.TableID = c.StoreID) where (StoreID = ".$StoreID." AND c.Active = 0) OR (StoreID = ".$StoreID." AND endDate < CURDATE() AND endDate != '0000-00-00') order by Sequence ASC"; //and endDate >= CURDATE()
    // exit($queryproduct);
    $db->query($queryproduct);
    if($db->num_rows() > 0 ){ ?>
    <h3 style="font-weight: bold; color: #2075b3">Expire Coupons</h3>
    <?php
        while ($db->next_record())
    { 
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
                        <?php
                        if($db->f('discount')!="" && $db->f('discount')!=null){
                            ?>
                            <div>
                                <div class="large" style="text-transform: uppercase;"><?=$db->f('discount')?></div>
                                <!--                                    <div class="small">off</div>-->
                                <div class="type">Coupon</div>
                            </div>
                        <?php } else {?>
                            <div>
                                <img src="../files/banners/<?=$db->f('StoreLogo')?>" alt="">
                            </div>
                        <?php } ?>
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
                  <div class="button-contain col-md-3 col-sm-3 text-center">
                    <?php
                        if($db->f('Active')==0){ 
                            $url = $db->f('disableUrl');
                            $url .= $db->f('trackingUrl'); 
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
        </div>


   <?php }}
    ?>



    <?php
    echo '</div>';
        ?>


                  <div class="col-sm-3">
            <div class="coupon-wrapper coupon-single" id="hide">
                <?=$StoreBanner?>
            </div>
        </div>


        <div class="col-sm-3">
            <div class="coupon-wrapper coupon-single">
                <h5 style="font-weight: bold">Similar Category</h5>
<?php
$queryproduct = "
    SELECT c.`Title`, c.`URLKeyword` 
    FROM tblstore s 
    INNER JOIN `tblstorecategory` sc ON (s.`TableID` = sc.`StoreID`) 
    INNER JOIN `tblcategory` c ON (c.`TableID` = sc.`CategoryID`) 
    WHERE s.`TableID` = ".$StoreID;

$db->query($queryproduct);
if ($db->num_rows() > 0) {
    while ($db->next_record()) {
?>
        <hr>
        <i class="fas fa-archway"></i>
        <a href="<?= RESOURCES_DOMAIN ?>/category/<?= $db->f('URLKeyword') ?>" style="font-weight: bold">
            <?= $db->f('Title') ?>
        </a>
<?php
    }

        }
          ?>

            </div>
        </div>
        
<ins class="adv-2714c315ad4ec98c7ee4042f4f0e4f5e" data-sizes-desktop="120x600,160x600,300x600" data-sizes-mobile="120x600,160x600,300x600" data-sticky="5"></ins>
<?php

}



if($_REQUEST['actions'] == "datalisting")
{
    $perPage = new PerPage();
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    $StoreID = $_REQUEST['StoreID'];
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;
    if($_REQUEST['data'] == "total")
        $queryproduct = "select c.* , s.trackingUrl as storeTracking, s.logo StoreLogo  from tblcoupon c inner join tblstore s on(c.StoreID = s.TableID) where  StoreID = ".$StoreID."  "; //and endDate >= CURDATE()
    else
        $queryproduct = "select c.*, s.logo StoreLogo from tblcoupon c inner join tblstore s on(c.StoreID = s.TableID) where c.couponClassification = '".$_REQUEST['data']."' and c.StoreID = ".$StoreID."  "; //and endDate >= CURDATE()
    $Query = "select * from tblstore where TableID = ".$StoreID."  order by Sequence asc"; //and endDate >= CURDATE()
    $db1->query($Query);
    $db->query($queryproduct);
    $rowcount = $db->num_rows();
//    $queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
    $db->query($queryproduct);
    $RecordCount=$pagelimit * ($start - 1);
//    $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_store.php?actions=book_categories_listing&page=','searchfrm','resultDiv');
    $Counterlisting = 0;


    echo '<div class="col-sm-9" >';
    while($db1->next_record()){ $StoreBanner = $db1->f('storeAdd'); $StoreName = $db1->f('name');
        ?>

        <div class="coupon-wrapper coupon-single" style="border: 5px solid black; border-radius: 25px;" >
            <div class="row">
                <div class="coupon-data col-sm-2 text-center">
                    <div class="savings text-center">
                        <a class="thumbnail" href="<?=$db1->f('trackingUrl')?>">
                        <?php
                        if($db1->f('logo')==null){                            ?>
                            <div>
                                <div class="large" style="text-transform: capitalize;"><?=$db1->f('discount')?></div>
                                <!--                                    <div class="small">off</div>-->
                                <div class="type">Coupon</div>
                            </div>
                        <?php } else { ?>
                            <div>
                                <img src="../files/banners/<?=$db1->f('logo')?>" alt="">
                            </div>
                        <?php } ?>
                        </a>
                    </div>
                    <!-- end:Savings -->
                </div>
                <!-- end:Coupon data -->
                <div class="coupon-contain col-sm-7">
                    <ul class="list-inline list-unstyled">
                        <li><span class="verified  text-success"><i class="fas fa-check"></i>Verified</span> </li>
                    </ul>
                    <h4 class="coupon-title"><a href="#" style="font-weight: bold">Save money deals at<br><?=$db1->f('domain')?></a></h4>
                    <p data-toggle="collapse" data-target="#more" style="font-weight: bold">Check out the latest deals and discount coupon <br>codes at <?=$db1->f('domain')?></p>
                </div>
                <!-- end:Coupon cont -->
                <div class="button-contain col-sm-3 text-center">
                    <!-- <a target="_blank"  href="<?=$db1->f('trackingUrl')?>"  class="quickview"><p class="btn-code"  data-toggle="modal" data-target=".couponModal"><span class="btn-hover" id="btn-text">Save Now</span></p></a> -->
                    <?php 
                        $url = "";
                        if($db1->f('Active')==0){
                           $url = $db1->f('disableUrl');
                           $url .= $db1->f('webUrl'); 
                        }
                        else
                            $url .= $db1->f('trackingUrl');

                    ?>
                     <a target="_blank"  href="<?=$url?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=StoreDetail&RecordID='.$db1->f('TableID'));?>" data-tracking="<?=$db1->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover" id="btn-text">Save Now</span></p></a>
                </div>

            </div>
            <!-- //row -->
        </div>

    <?php }
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
                            <?php
                            if($db->f('discount')!="" && $db->f('discount')!=null){
                                ?>
                                <div>
                                    <div class="large" style="text-transform: uppercase;"><?=$db->f('discount')?></div>
<!--                                    <div class="small">off</div>-->
                                    <div class="type">Coupon</div>
                                </div>
                            <?php } else {?>
                                <div>
                                    <img src="../files/banners/<?=$db->f('StoreLogo')?>" alt="">
                                </div>
                            <?php } ?>
                        </div>
                        <!-- end:Savings -->
                    </div>
                    <!-- end:Coupon data -->
                    <div class="coupon-contain  col-md-6 col-sm-6">
                        <ul class="list-inline list-unstyled">
                            <li><span class="verified  text-success"><i class="fas fa-check"></i>Verified</span> </li>
                        </ul>
                        <h4 class="coupon-title"><a href="#" style="font-weight: bold"><?=$db->f('CouponName')?></h4>

                        <?php $replace1 = str_replace("<p>", "" , $db->f('description')) ?>
                        <span ><?=substr($replace1 , 0 , 40)?>
                            <?php $replace = str_replace("</p>", "" , $db->f('description'));?>
                            <span class="collapse" id="<?=$db->f('TableID')?>" ><?=substr( $replace , 32)?></span></span>
                        <?php if (strlen($db->f('description')) >= 40 ){?>
                        <span data-toggle="collapse" href="#<?=$db->f('TableID')?>" aria-expanded="false" aria-controls="collapseExample">
                            ...
                        </span>
                        <?php } ?>

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
            </div>



        <?php }

        echo '</div>';

        ?>


        <div class="col-sm-3">
            <div class="coupon-wrapper coupon-single">
                <?=$StoreBanner?>
            </div>
        </div>


        <div class="col-sm-3">
        <div class="coupon-wrapper coupon-single">
        <h5 style="font-weight: bold">Similar Category</h5>
        <?php
        $queryproduct = "SELECT c.`Title`, c.URLKeyword FROM tblstore s INNER JOIN `tblstorecategory` sc ON (s.`TableID` = sc.`StoreID`) INNER JOIN `tblcategory` c ON (c.`TableID` = sc.`CategoryID`) WHERE s.`TableID` = ".$StoreID;
        $db->query($queryproduct);
        if($db->num_rows() > 0)
        {
            while($db->next_record())
            { ?>
                <hr>
                <i class="fas fa-archway"> <a href="<?=RESOURCES_DOMAIN?>/category/<?=$db->f('URLKeyword')?>" ><?=$db->f('Title')?></a></i>
            <?php }
        }
        } ?>
        
    </div>
    <?php



}



if($_REQUEST['actions'] == "relatedStore"){
    $StoreID = $_REQUEST['StoreID'];
    ?>

    <div>
        <div class="widget-heading">
            <h3 class="widget-title text-dark" style="font-weight: bold">
                Related Stores
            </h3>
            <div class="clearfix"></div>
        </div>
        <div class="widget-body">
            <div class="row">
                <?php
                $Query ="SELECT * FROM tblstore WHERE TableID IN  ( SELECT SimilarStoreID FROM tblsimilarstore WHERE `StoreID` = ".$StoreID .") and TableID != $StoreID;";
                $db->query($Query);
                if($db->num_rows() > 0)
                {
                while($db->next_record()){
                    ?> 
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 thumb">
                        <div class="thumb-inside">
                            <a class="thumbnail" href="<?=RESOURCES_DOMAIN?>/store/<?=$db->f('URLKeyword')?>">
                                <?php
                                if($db->f('logo')!="" && $db->f('logo')!=null ){ ?>
                                    <img class="img-responsive" src="../files/banners/<?=$db->f('logo')?>" alt="" style="height: 110px ; width: 180px" alt="">
                                <?php  } 
                                else { ?>
                                    <img class="img-responsive" src="http://placehold.it/240x240" alt="">
                                <?php } ?>
                            </a> <span class="favorite"><a href="category-coupon#" data-toggle="tooltip" data-placement="left" title="" data-original-title="Save store"></a></span>
                        </div>

                    </div>
                    
                <?php }}
                else
                {

                $Query = "SELECT * FROM tblstore WHERE `TableID` IN (SELECT `StoreID` FROM tblstorecategory WHERE `CategoryID` IN (SELECT DISTINCT(`CategoryID`) FROM tblstorecategory WHERE `StoreID` =  ".$StoreID .") and `StoreID` !=  ".$StoreID ." ) group by TableID  ORDER BY RAND() limit 6;";
                   
                $db->query($Query);
                    while($db->next_record()){
                    ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 thumb">
                        <div class="thumb-inside">
                            <a class="thumbnail" href="<?=$db->f('URLKeyword')?>">
                                <?php
                                if($db->f('logo')!="" && $db->f('logo')!=null ){ ?>
                                    <img class="img-responsive" src="../files/banners/<?=$db->f('logo')?>" alt="" style="margin-top: 0px; height: 141px" alt="">
                                <?php  }
                                else {?>
                                    <img class="img-responsive" src="http://placehold.it/240x240" alt="" style="margin-top: 0px; height: 141px" alt="">
                                <?php } ?>
                            </a>
                            <span class="favorite"><a href="category-coupon#" data-toggle="tooltip" data-placement="left" title="" data-original-title="Save store"></a></span>
                        </div>

                    </div>
                <?php }} ?>
            </div>
        </div>
    </div>



    <div>
        <div class="widget-heading">
            <h3 class="widget-title text-dark" style="font-weight: bold">
                Related Products
            </h3>
            <div class="clearfix"></div>
        </div>
        <div class="widget-body">
            <div class="row">
                <?php
//                $Query = "SELECT * FROM tblproduct WHERE `TableID` IN (SELECT `StoreID` FROM tblstorecategory WHERE `CategoryID` IN (SELECT DISTINCT(`CategoryID`) FROM tblstorecategory WHERE `StoreID` =  ".$StoreID .")) limit 4;";

                // $Query ="SELECT p.* , country.Currency Currency FROM tblproduct p inner join tblcountry country  ON (country.TableID = p.CountryID)  WHERE p.`storeID` IN (SELECT DISTINCT(`StoreID`) FROM tblstorecategory WHERE `CategoryID` IN (SELECT DISTINCT(`CategoryID`) FROM tblstorecategory WHERE `StoreID` = ".$StoreID ." )) limit 4";
                 $Query="SELECT p.* , country.Currency Currency FROM tblproduct p inner join tblcountry country  ON (country.TableID = p.CountryID) ORDER BY RAND() limit 4";
                $db->query($Query);
                if($db->num_rows() > 0)
                {
                    $db->query($Query);
                    while($db->next_record()){
                        if($db->f('NewPrice') > 0 && $db->f('OldPrice') > 0) {
                        
                            $per = $db->f('NewPrice') / $db->f('OldPrice') * 100-100;
                            $per = intval($per);
                            $per = abs($per);
                        }
                        ?>
                        <div class="col-md-3 col-lg-3" >
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
                                    
                                    <a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=ProductDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal">
                        <p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal">
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
                                            <img src="<?=RESOURCES_DOMAIN?>/files/banners/<?=$db->f('logo')?>" style="margin-top: 0px; height: 200px" alt="">
                                        </div>

                                    <?php } ?>
                                </p>
                                </a>
                                    <!-- end:Savings -->
                                </div>
                                <!-- end:Coupon data -->
                                <div class="coupon-contain col-sm-12">

                                    <h4 class="coupon-title"><a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=ProductDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview" style="font-weight: bold"><?=$db->f('ProductName')?></a></h4>

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
                                    <a href="<?=$db->f('landingLink')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=ProductDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal"><span class="btn-hover"><?=$db->f('ProductClassification') =="code" ? "Get Code" : "Get Offer" ?></span></p></a>
                                </div>
                                <!--<div class="button-contain col-sm-3 text-center">
                                    <p class="btn-code" data-toggle="modal" data-target=".couponModal"> <span class="partial-code">BTSBAGS</span> <span class="btn-hover"><a href="javascript:;" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('id'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview">Get Code</a></span> </p>

                                </div>-->
                            </div>
                        </div>


                    <?php }}
                    $Query = "slect * fromo tblproduct where ";
                ?>
            </div>
        </div>
        
<?php }
if ($_REQUEST['actions']=="productListing")
{
    $Query = "select p.* , c.Title as couponType, country.Currency as  Currency from tblproduct p inner join tblcoupontype c ON(p.ProductTypeID = c.TableID ) inner join tblcountry country ON(country.TableID = p.CountryID) where StoreID = ".$_REQUEST['StoreID'];
    $db->query($Query);
    echo '<div class="col-sm-12 col-md-12" >';
    while($db->next_record()){
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
                             <a href="<?=($db->f('landingLink')!='') ? $db->f('landingLink') : $db->f('storeTracking')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=ProductDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackingLink')?>" class="quickview">
                            <img src="<?=RESOURCES_DOMAIN?>/files/banners/<?=$db->f('logo')?>" style="margin-top: 0px; height: 200px" alt="">
                            </a>
                        </div>

                    <?php } ?>
                    <!-- end:Savings -->
                </div>
                <!-- end:Coupon data -->
                <div class="coupon-contain col-sm-12">
  
                    <h4 class="coupon-title"><a href="<?=($db->f('landingLink')!='') ? $db->f('landingLink') : $db->f('storeTracking')?>" style="font-weight: bold" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=ProductDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackingLink')?>" class="quickview">
                        <?=$db->f('ProductName')?></a></h4>
    
                    <div class="btn-group" role="group" aria-label="...">
                        <span style="color: #8a8b92" class="small">Added on : <?=substr($db->f('CreatedDateTime') , 0 ,11)?></span>
                        <br>
                        <?php
                            if($db->f('CutPrice')==1){
                        ?>
                        <span style="" class="small"><del><?=$db->f('Currency')?><?=$db->f('OldPrice')?></del></span>
                        <span style="font-weight: bold" class=""><?=$db->f('Currency')?><?=$db->f('NewPrice')?></span>
                        <?php }  ?>
                    </div>
                    <!-- end:Coupon details -->
                </div>
                <!-- end:Coupon cont -->
<!--                <div class="price-line clearfix"></div>-->
                <div class="buy-button button-outer code " data-html="false" data-offerid="8378836" data-printable-single-use="0" data-printable="0" data-simple="0" data-single-use="0">
                    <a href="<?=($db->f('landingLink')!='') ? $db->f('landingLink') : $db->f('storeTracking')?>" target="_blank" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=ProductDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackingLink')?>" class="quickview"><p class="track-position btn btn-green  code " data-toggle="modal" data-target=".couponModal"><span class="btn-hover"><?=$db->f('ProductClassification') =="code" ? "Get Code" : "Get Offer" ?></span></p></a>
                </div>
              </div> 
        </div>


    <?php }
    echo '</div>';
 }
if($_REQUEST['actions']=="datalisting"){ ?>


<?php } ?>



<div class="col-sm-9">

    <?php

    include_once("ajax.php");
    include_once("../classes/ajaxpagination.class.php");
    $whereCond = '';
    $q = $_REQUEST['q'] ?? '';
    $Active = $_REQUEST['Active'] ?? '';
    if($_REQUEST['actions'] == "couponlisting")
    {
    $perPage = new PerPage();
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    $whereCond = "WHERE c.Active != 2 and c.endDate < CURDATE()";
    $whereCond .= ($_REQUEST['data'] == "") ? "" : "and ctype.URLKeyword = '".$_REQUEST['data']."'";
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;
    $queryproduct="SELECT c.TableID as TableID, c.description description, s.logo logo ,c.discount discount ,s.trackingUrl as storeTracking , c.featured as featured , c.endDate as endDate , ctype.Title as coponType , c.CouponName as name , c.`TableID` AS id , c.couponCode as code , c.trackingLink as trackURL , c.description as Description ,c.sitewide as sitewide FROM `tblcoupon` c
                                                INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`)
                                                INNER JOIN  `tblcoupontype` ctype ON ( ctype.`TableID` = c.`CouponTypeID` )
                                                 ".$whereCond." ";; //c.endDate >= CURDATE() INNER JOIN `tblcoupontag` ctag ON (ctag.`TableID` = c.`CouponTagID`)
    $db->query($queryproduct);
    $rowcount = $db->num_rows();
    $queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
    $db->query($queryproduct);
//    $RecordCount=$pagelimit * ($start - 1);

    $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_expireCoupon.php?actions=couponlisting&page=','searchfrm','resultDiv');
//        print_r($perpageresult);
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
                <div class="coupon-data col-sm-2 text-center">
                    <div class="savings text-center">
                        <a class="thumbnail" href="<?=$db->f('URLKeyword')?>">
                            <?php
                            if($db->f('logo')==null){
                                ?>
                                <div>
                                    <div class="large" style="text-transform: uppercase;"><?=$db->f('discount')?></div>
                                    <!--                                    <div class="small">off</div>-->
                                    <div class="type">Coupon</div>
                                </div>
                            <?php } else {?>
                                <div>
                                    <img src="../files/banners/<?=$db->f('logo')?>" alt=">
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
                    <h4 class="coupon-title" style="font-weight: 600"><a href="#"><?=$db->f('name')?></a></h4>
                    <?php $replace1 = str_replace("<p>", "" , $db->f('description')) ?>
                    <span style="color: #2075b3"><?=substr($replace1 , 0 , 88)?>
                        <?php $replace = str_replace("</p>", "" , $db->f('description'));?>

                            <span class="collapse" id="<?=$db->f('TableID')?>" ><?=substr( $replace , 32)?></span></span>
                    <?php if (strlen($db->f('description')) >= 88 ){?>
                        <span data-toggle="collapse" href="#<?=$db->f('TableID')?>" aria-expanded="false" aria-controls="collapseExample">
                            ...
                        </span>
                    <?php } ?>

                </div>
                <!-- end:Coupon cont -->
                <div class="button-contain col-sm-3 text-center">
                    <a target="_blank" style="font-weight: bold"  href="<?=($db->f('landingLink')!='') ? $db->f('landingLink') : $db->f('storeTracking')?>" data-href="<?=RESOURCES_DOMAIN?>/AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID='.$db->f('TableID'));?>" data-tracking="<?=$db->f('trackURL')?>" class="quickview"><p class="btn-code" data-toggle="modal" data-target=".couponModal"><span class="btn-hover">Get Code</span></p></a>
                    <?php if(($db->f('endDate')!="0000-00-00") && ($db->f('endDate')!="")){ ?>
                        <p style="font-weight: bold">Expire At : <?=$db->f('endDate')?></p>
                    <?php } ?>
                </div>
            </div>
            <!-- //row -->
        </div>

    <?php }
    echo '</div>';

    ?>
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
                <i class="fas fa-archway"> <a href="<?=$db->f('URLKeyword')?>" style="position: absolute; left: 40px"><?=$db->f('Title')?></a></i>
            <?php }
        }
        ?>
    </div>
</div>

<?php

$output = '<br><div class="col-md-4">
                   <div class="box center float-left space-30">
					    <nav class="pagination paginationNew">' . $perpageresult . '</nav>
				    </div>
				</div>';
//        $output = ' <ul class="pagination pagination-lg ">'.$perpageresult.'</ul>';
echo $output;
    }

    } ?>
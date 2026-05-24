<?php

$db = new DB_Sql();
$db1 = new DB_Sql();
$sql = "select * from tblpages where URLKeyword = '".$_REQUEST['url']."'";

$db->query($sql);
$Category = "";
while($db->next_record()){
    $Description = $db->f('description');
    $Category = $db->f('Title');
}
$Query ="select * from tblcategory where URLKeyword = '".$_REQUEST['url']."'";
$db->query($Query);
while($db->next_record())
{
    $Category = $db->f('Title');
}

$query = "select * from `tblcategory` where `URLKeyword` = '".$_REQUEST['url']."';";
                $db->query($query);
                $TableID = 0;
                while ($db->next_record()) {
                    if(!$db->f('ParentID') > 0)
                        $TableID = $db->f('TableID');
                }

                ?>



<section class="results">
    <div class="dp-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    <h4 style="font-weight: bold">Category : <?=$Category?></h4>
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
            <div class="col-sm-3">
            <div class="widget categories b-b-0">
                <!-- /widget heading -->
                <div class="widget-heading">
                    <h3 class="widget-title text-dark">
                       Categories
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div class="widget-body">
                    <!-- Sidebar navigation -->
                    <ul class="nav sidebar-nav">
                       <?php
                       $Query ="SELECT * FROM `tblcategory` WHERE ParentID = 0 AND `Active` = 1";
                       $db->query($Query);

                       while($db->next_record()){
                       ?>
                        <li >
                            <a href="<?=RESOURCES_DOMAIN . '/' . CATEGORY_URL . '/' . $db->f('URLKeyword');?>"
                                style="font-weight: bold !important; color: #2075b3 !important"
                                >
                                <i class="fas fa-check"></i><?=$db->f("Title")?><span class="sidebar-badge badge-circle">
                               <?php
                                    $query1 = "select count(TableID) as total from `tblcategory` where ParentID = ".$db->f('TableID');
                                    $db1->query($query1);
                                    if($db1->num_rows() >0){
                                        while($db1->next_record()){?>
                                 <?=$db1->f(0)?>
                             <?php } }else { ?>
                                         0
                                    <?php } ?>
                                 </span> </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <!-- Sidebar divider -->
                </div>
            </div>
        </div>

            <div class="col-sm-9">
                <!--/widget -->
                <div class="row" id="resultDiv">
                </div>
            </div>


<div id="resultDiv1"></div>

    </div>
</section>
<script>
    <?php
        $data = ($_REQUEST['url'] == "") ? "" : $_REQUEST['url'];
    ?>
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_coupon_category.php?actions=couponlisting&data=<?=$data?>&page=0','searchfrm','resultDiv');
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_coupon_category.php?actions=relatedProduct&data=<?=$data?>&page=0','searchfrm','resultDiv1');
</script>

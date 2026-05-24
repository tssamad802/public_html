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


<section class="results m-t-30">
    <div class="container">

        <div class="widget m-t-20">
            <!-- /widget heading -->cx  
            <div class="widget-heading">
                <h3 class="widget-title text-dark">
                    Featured Stores
                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body">
                <div class="row">
                    <?php
                    $Query ="select * from tblstore where Active = 1 limit 12";
                    $db->query($Query);

                    while($db->next_record()){
                        ?>
                        <div class="col-lg-1 col-md-2 col-sm-4 col-xs-6 thumb">
                            <div class="thumb-inside">
                                <a class="thumbnail" href="<?=$db->f('url')?>">
                                    <?php
                                    if($db->f('logo')!="" && $db->f('logo')!=null ){ ?>
                                        <img style="width: 100%;height: 78px;" class="img-responsive" src="/files/banners/<?=$db->f('logo')?>" alt=">
                                    <?php  }
                                    else {?>
                                        <img style="width: 100%;height: 78px;" class="img-responsive" src="http://placehold.it/240x240">" alt=">
                                    <?php } ?>
                                </a> <span class="favorite"><a href="category-coupon#" data-toggle="tooltip" data-placement="left" title="" data-original-title="Save store"></a></span>
                            </div>
                            <div class="store_name text-center">
                                <h5 style="font-weight: bold;"><?=substr($db->f('name') , 0 ,9)?>...</h5>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>


        <div class="widget m-t-20">
            <!-- /widget heading -->
            <div class="widget-heading">
                <h3 class="widget-title text-dark">
                    All Stores
                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body">
                <div class="row" id="resultDiv"></div>
            </div>
        </div>
    </div>
</section>
<script>
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_store.php?actions=storelisting&page=0','searchfrm','resultDiv');
</script>

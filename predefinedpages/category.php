<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
    die("Direct Access Not Allowed");
}
$db = new DB_Sql();
$db1 = new DB_Sql();
?>


<section class="results m-t-30">
    <div class="container">

        <div class="widget m-t-20">
            <!-- /widget heading -->
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
                                    <img class="img-responsive" src="../files/banners/<?=$db->f('logo')?>"/>
                                </a>
                            </div>
                            <div class="store_name text-center">
                                <h5 style="font-weight: bold;"><?=substr($db->f('name') , 0 ,6)?>...</h5>
                            </div>
                        </div>
                    <?php } ?>


                </div>
            </div>
        </div>
        <div class="row m-t-30">

            <?php
            $Query ="SELECT * FROM `tblcategory` WHERE ParentID = 0 AND `Active` = 1";
            $db->query($Query);

            while($db->next_record()){
                ?>

                <div class="col-sm-4">
                    <div class="list-group"> <a  class="list-group-item"  href="<?=RESOURCES_DOMAIN.'/'.CATEGORY_URL.'/'.$db->f('URLKeyword')?>" style="font-weight: bold;">
                            <?=$db->f('Title')?>
                        </a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php
$db= new DB_Sql();
$db1= new DB_Sql();

//echo $_REQUEST['url'].'<br/>';

$queryproduct="SELECT * from tblcoupontag where URLKeyword = '".$_REQUEST['url']."'";
$db->query($queryproduct);
while($db->next_record()){
    $Name = $db->f('Title');
    $Description = $db->f('description');
    $TagDate = $db->f('tagDate');
    // $Logo = $db->f('logo');
}

//echo $TagDate.'<br/>';

$sql = "SELECT DATEDIFF( CURDATE(), `tagDate` ) as days FROM `tblcoupontag`  WHERE Active = 1 and URLKeyword = '".$_REQUEST['url']."'";

//echo $sql;

$db1->query($sql);
while($db1->next_record()){
    $days = $db1->f('days');
}
?>

<section class="results m-t-30">
    <div class="container">
        <div class="row">

            <div class="col-sm-9">
                <div class="widget">
                    <div class="widget-heading widget-default b-b-0">
                        <h3 class="widget-title text-dark">
                             <?=$Name?> Coupons
                        </h3>
                    <br>
                        <div>
                            <h4>About <?=$Name?></h4>
                            <span style="color: Black"><?=$Description?></span>
                            <button class="btn btn-primary"><?=$days?> Days Remaining  </button>
                        </div>
                  
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- end: Widget -->

                <div class="row" id="resultDiv"></div>

            </div>

        </div>
    </div>
</section>
<script>
    <?php
        $Title = $_REQUEST['url'];
    ?>
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_tag.php?actions=couponlisting&data=<?=$Title?>&page=0','searchfrm','resultDiv');
</script>
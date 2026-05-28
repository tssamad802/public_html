<?php
include_once("ajax.php");
include_once("../classes/ajaxpagination.class.php");
$whereCond = '';
$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
$Active = isset($_REQUEST['Active']) ? $_REQUEST['Active'] : ''; 
$actions = $_REQUEST['actions'] ?? '';

if($actions == "storelisting")
{
	$perPage = new PerPage();
	$page = 1;
	if(!empty($_REQUEST["page"])) {
	$page = $_REQUEST["page"];
	}
	$start = ($page-1)*$perPage->perpage;
	if($start < 0) $start = 0;
    $whereCond="active !=2";
	$queryproduct = "select * from tblstore where ".$whereCond." order by name asc";
	//echo $queryproduct;
	$db->query($queryproduct);
	$rowcount = $db->num_rows();
	$queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
	$db->query($queryproduct);
//	 $RecordCount=$pagelimit * ($start - 1);
	$perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_store.php?actions=storelisting&page=','searchfrm','resultDiv');
	$Counterlisting = 0;
	if($db->num_rows() > 0)
	{
        while($db->next_record()){
    ?>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 thumb">
        <div class="thumb-inside">
            <?php
            $url = RESOURCES_DOMAIN . '/' . STORE_URL . '/' . $db->f('URLKeyword');
            ?>
            <a class="thumbnail" href="<?=$url?>">
                <?php
                if($db->f('logo') == "" && $db->f('logo') ==null)
                {
                    ?>
                    <img style="width: 100%;height: 188px;" class="img-responsive store-img" src="http://placehold.it/240x240" alt="">
                    <?php
                }else { ?>
<!--                    <img class="img-responsive" src="http://placehold.it/240x240" alt=""> change height here height: 188px;-->
                       <img style="width: 100%;height: 78px;" class="img-responsive" src="/files/banners/<?=$db->f('logo')?>" />
                <?php  } ?>
            </a> <span class="favorite"><a href="category-coupon#" data-toggle="tooltip" data-placement="left" title="" data-original-title="Save store"></a></span>
        </div>
        <div class="store_name text-center">
            <h5 style="font-weight: bold;"><?=$db->f('name')?></h5>
        </div>
    </div></div>
    <?php }


        $output = '<br><div class="col-md-12">
                   <div class="box center float-left space-30">
					    <nav class="pagination paginationNew">' . $perpageresult . '</nav>
				    </div>
				</div>';
//        $output = ' <ul class="pagination pagination-lg ">'.$perpageresult.'</ul>';
        echo $output;
    }
    else
        echo $output = "<h3>No coupon here</h3>";
}?>

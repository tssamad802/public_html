<?php
include_once("ajax.php");
include_once("../classes/ajaxpagination.class.php");
$whereCond = '';
$q = $_REQUEST['q'];
$Active = $_REQUEST['Active'];


if($_REQUEST['term'] != "")
{
    $perPage = new PerPage();
    $page = 1;
    if(!empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    $whereCond = "and name LIKE '%".$_REQUEST['term']."%' ORDER BY name ASC";
    $start = ($page-1)*$perPage->perpage;
    if($start < 0) $start = 0;
    $queryproduct = "select * from tblstore where Active = 1 ".$whereCond." ";
    $db->query($queryproduct);
    $rowcount = $db->num_rows();
    $queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage;
    $db->query($queryproduct);
    $RecordCount=$pagelimit * ($start - 1);

    $perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_store.php?actions=book_categories_listing&page=','searchfrm','resultDiv');
    $Counterlisting = 0;
    $searchData = array();
    if($db->num_rows() > 0)
    {
        while($db->next_record()){
            $data['id'] = $db->f('TableID');
            $data['value'] = $db->f('name');
            array_push($searchData , $data);
        }

//        $output = '<div class="box center float-left space-30">
//					<nav class="pagination paginationNew">' . $perpageresult . '</nav>
//				</div>';
//        echo $output;
    }
    echo json_encode($searchData);
}?>

<?php
include_once("../../classes/commonfunctions.php");

$db = new DB_Sql();

if(($_REQUEST['StoreID']) > 0){
    $sql = "select domain from tblstore where TableID = ".$_REQUEST['StoreID'];
    $db->query($sql);
    while($db->next_record()){
        echo $db->f('domain');
    }
}
?>
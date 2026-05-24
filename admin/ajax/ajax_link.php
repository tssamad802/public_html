<?php
require_once 'ajax.php';
if($_REQUEST['storeID'] > 0)
{
    $Query = "SELECT webUrl FROM tblstore WHERE TableID = ".$_REQUEST['storeID'];
    $db->query($Query);
    while($db->next_record()){
        $tracking=$db->f('webUrl');
        $netlink=$db->f('NetDeepLinkCode');
        $data[] =$db->f('webUrl');
        $data[] =$db->f('NetDeepLinkCode');
    }
    print_r(json_encode($data));
//    echo "{tracking: $tracking , NetDeepLinkCode: $netlink}";

}

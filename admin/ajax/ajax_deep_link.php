<?php
require_once 'ajax.php';
if($_REQUEST['storeID'] > 0)
{
    $Query = "select s.trackingURL , n.NetDeepLinkCode from tblstore s inner join tblnetwork n ON(s.NetworkID = n.TableID) where s.TableID = ".$_REQUEST['storeID'];
    $db->query($Query);
    while($db->next_record()){
        $tracking=$db->f('trackingURL');
        $netlink=$db->f('NetDeepLinkCode');
        $data[] =$db->f('trackingURL');
        $data[] =$db->f('NetDeepLinkCode');
    }
    print_r(json_encode($data));
//    echo "{tracking: $tracking , NetDeepLinkCode: $netlink}";

}
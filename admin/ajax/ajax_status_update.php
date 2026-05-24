<?php
require_once 'ajax.php';

if($_REQUEST['StoreStatusUpdate']!="")
{
    $active = $_REQUEST['StoreStatusUpdate'];

        $Query="select * from tblstore where disableUrl !='' LIMIT 1 ";
        $db->query($Query);
        $disableUrl= '';
        while($db->next_Record()){
            $disableUrl = $db->f('disableUrl');
        }
    $Query = "update tblstore set Active = ".$_REQUEST['StoreStatusUpdate'] .", disableUrl='$disableUrl' where TableID = ".$_REQUEST['id'];
    $status = $db->query($Query);
    if($status ==1)
        echo "updated";
    else
        echo "not updated";
}

if($_REQUEST['CouponStatusUpdate']!="")
{
    $active = $_REQUEST['CouponStatusUpdate'];
    $Query = "update tblcoupon set Active = ".$_REQUEST['CouponStatusUpdate'] ." , endDate=NOW() - INTERVAL 1 DAY where TableID = ".$_REQUEST['id'];
    $db->query($Query);
    echo "updated";
}

if($_REQUEST['ProductStatusUpdate']!="")
{
    $active = $_REQUEST['ProductStatusUpdate'];
    $Query = "update tblproduct set Active = ".$_REQUEST['ProductStatusUpdate'] ." where TableID = ".$_REQUEST['id'];
    $db->query($Query);
    echo "updated";
}

if($_REQUEST['MasterStatusUpdate']!="")
{
    $active = $_REQUEST['MasterStatusUpdate'];
    $Query = "update ".$_REQUEST['TableName']." set Active = ".$_REQUEST['MasterStatusUpdate'] ." where TableID = ".$_REQUEST['id'];
    $db->query($Query);
    echo "updated";
}

if($_REQUEST['SliderStatus']!="")
{
    $active = $_REQUEST['SliderStatus'];
    $Query = "update tblslider set Active = ".$_REQUEST['SliderStatus'] ." where TableID = ".$_REQUEST['id'];
    $db->query($Query);
    echo "updated";
}

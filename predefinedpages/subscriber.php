<?php
// include_once("classes/commonfunctions.php");
include_once("../ajax/ajax.php");


 if($_SERVER['HTTP_REFERER'] == '' || $_SERVER['HTTP_X_REQUESTED_WITH'] == '')
 {
 	die("Direct Access Not Allowed");
 }
 
function getIPAddress() {
if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
//whether ip is from the remote address
    else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$ip = getIPAddress();
$db = new DB_Sql();

    $sql = "insert into tblsubscriber (IP, email, CreateAt) values ('".$ip."' , '".$_REQUEST['email']."', CURDATE());";
    $db->query($sql);
    echo "inserted";
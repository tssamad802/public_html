<?php
error_reporting(0);
session_start();

$cookie_value = "InventorySystem";  
setcookie ($cookie_name, "en", time()-100 , '/' );
setcookie ($cookie_name, "ar", time()-100 , '/' );
include_once("classes/commonfunctions.php");
$userdet = FetchRecordByID($_SESSION[session_id().'_frontuser'],'TableID','tbluserregistration');
if(isset($_SESSION[session_id().'_frontuser']) && $_SESSION[session_id().'_frontuser'] != '')
{
$UpdateOnlineStatus = "update tbluserregistration set SessionID='0' where TableID='".$_SESSION[session_id().'_frontuser']."'";
$db->query($UpdateOnlineStatus);
$UpdateLogoutTime = "insert into tbluserregistration_login_log set UserID='".$_SESSION[session_id().'_frontuser']."', UserIP='".$_SERVER['REMOTE_ADDR']."', Status=1, DateTime=NOW(), Type=0, Email='".$userdet['Email']."'";
$db->query($UpdateLogoutTime);
}
session_destroy();
$msg = '';
$url = 'index.php';
if(isset($_REQUEST['messageshow']))
{
	$url = 'login.html';
	$msg = '?'.EncodeUrl('messageshow='.$_REQUEST['messageshow']);
}
redirect($url.$msg,0);
?>
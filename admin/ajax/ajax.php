<?php
session_start();
include_once('../../classes/commonfunctions.php');
DecodeUrl();
//load dashboard language files
/*if(!isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='')
	include_once("../lang/en.php");
 else
	include_once("../lang/".$_SESSION['LANGUAGE'].".php");*/

define("PAGE_LIMIT",100);
//defaults for action files
$Return["Msg"]='';
$Return["Error"]=0;
$Return["Redirect"]='';
$Return["Focus"]='';

if(isset($_SESSION[WEB_SESSION.'_userid']))
{
	$UserRecordGetting = FetchRecordByID($_SESSION[WEB_SESSION.'_userid'],"TableID","tblsystemusers"); 
	$pagelimit = $UserRecordGetting['PerPageRecord'];
	$CheckEvent = explode(",",$UserRecordGetting['EventID']);
}
else
{
	$pagelimit = PAGE_LIMIT;
}

if($pagelimit==0)
	$pagelimit = PAGE_LIMIT;
?>

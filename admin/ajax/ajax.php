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

$UserRecordGetting = [];
$CheckEvent = [];

if (isset($_SESSION[WEB_SESSION . '_userid']) && $_SESSION[WEB_SESSION . '_userid'] != '') {
	$userRecord = FetchRecordByID($_SESSION[WEB_SESSION . '_userid'], "TableID", "tblsystemusers");
	if (is_array($userRecord)) {
		$UserRecordGetting = $userRecord;
		$pagelimit = !empty($UserRecordGetting['PerPageRecord']) ? $UserRecordGetting['PerPageRecord'] : PAGE_LIMIT;
		if (!empty($UserRecordGetting['EventID'])) {
			$CheckEvent = explode(",", $UserRecordGetting['EventID']);
		}
	} else {
		$pagelimit = PAGE_LIMIT;
	}
} else {
	$pagelimit = PAGE_LIMIT;
}

if($pagelimit==0)
	$pagelimit = PAGE_LIMIT;
?>

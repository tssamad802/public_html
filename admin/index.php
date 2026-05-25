<?php 
// ini_set('session.save_path', __DIR__ . '/tmp');
// phpinfo();

$localSessionPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'sessions';
if (is_dir($localSessionPath) && is_writable($localSessionPath)) {
	session_save_path($localSessionPath);
}
session_start();

include_once(__DIR__ . "/../classes/commonfunctions.php");
DecodeUrl();

//  echo '<pre>';
//  print_r( $_SESSION );
//  echo '</pre>';
//  exit;

if(isset($_SESSION[WEB_SESSION.'_userid']) && $_SESSION[WEB_SESSION.'_userid'] != '')
{ 
	$UserRecordGetting = FetchRecordByID($_SESSION[WEB_SESSION.'_userid'],"TableID","tblsystemusers");
}

$CURRENT_ACTIVE_INDEX = 0;
$RUNFILE_FROM_INDEX_PAGE = 'YES';

$current_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

 
if(isset($_REQUEST['changepass']))
{ 
	$currentpage = 'changepassword';
}
else if(empty($_SESSION[WEB_SESSION.'_userid']))
{ 
	$currentpage = 'login';
}
else if(isset($_REQUEST['action']))
{
	if(file_exists("predefinedpages/".$_REQUEST['action'].".php"))
	{
		$currentpage = "predefinedpages/".$_REQUEST['action'];
	}
	else  
	{	
		$currentpage = "home";
	} 
}  
else
{
	$currentpage = 'home';
}

if(!file_exists($currentpage.".php"))
{
	$currentpage = 'home';
}
$website_config = generateConfigData();
include_once("template.php");
?>

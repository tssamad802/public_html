<?php
require_once('classes/commonfunctions.php');
date_default_timezone_set('Asia/Dubai');
?>
<html lang="en">
<head> 
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <meta http-equiv="refresh" content="5; URL='<?php echo RESOURCES_DOMAIN;?>/cronjobs.php'" />  
</head>
<body>
<?php
$website_config = generateConfigData();
if($website_config['AccountunblockType'] == 1)
{
	$db = new DB_Sql();
	$alluserQuery = "select TableID,BlockTime from tblsystemusers where Active=0 and BlockBy=1";
	$db->query($alluserQuery);

	while($db->next_record())
	{
		if($db->f('BlockTime') != '0000-00-00 00:00:00')
		{
			$currentdatetime = mysqldatetime();
			$currentdatetimestr = strtotime($currentdatetime);
			$blockeddatetime = $db->f('BlockTime');
			$blockeddatetimeNew = strtotime($blockeddatetime.' + '.$website_config['AccountunblockTime'].' minute');
			if($currentdatetimestr >= $blockeddatetimeNew){
				$UpdateOnlineStatus = "update tblsystemusers set Active=1, BlockTime='', BlockBy=0, InvalidLoginAttempt=0 where TableID='".$db->f('TableID')."'";
				$db->query($UpdateOnlineStatus);
			}
		}
	}
}


?>
</body>
</html>
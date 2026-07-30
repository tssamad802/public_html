<?php

$localSessionPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'sessions';
if (is_dir($localSessionPath) && is_writable($localSessionPath)) {
	session_save_path($localSessionPath);
}
session_start();
include_once("../classes/commonfunctions.php");
DecodeUrl();
//load dashboard language files




$UserRecordGetting = FetchRecordByID($_SESSION[WEB_SESSION . '_userid'], "TableID", "tblsystemusers");

// print_r($_SESSION['HTTP_REFERER'] . '  - ');
// exit;

if ($_SERVER['HTTP_REFERER'] == '' || $_SERVER['HTTP_X_REQUESTED_WITH'] == '') {
	// die("Direct Access Not Allowed");
}




$result = array("error" => "", "success" => "", "redirect" => "", "selfredirect" => "", "html" => '', "divtoplace" => "", "downloadgraphlink" => "", "redirecturl" => "", "ShowinPopup" => "", "OpenInNewWindow" => "", "divid" => "", "closepopup" => "", "hidedivbox" => "", "muntipledivdata" => "", "blanckdivbox" => "", "setdata" => "", "preview" => "");

function systemUserPasswordHashes($password)
{
	return array(
		'sha256' => hash('sha256', $password),
		'sha1' => sha1($password),
		'md5_salt' => md5(PREDEFINED_SALT_VALUE . md5($password) . PREDEFINED_SALT_VALUE),
	);
}

function systemUserPasswordHash($password)
{
	return hash('sha256', $password);
}

function systemUserPasswordMatches($password, $storedPassword)
{
	$storedPassword = trim((string) $storedPassword);
	if ($storedPassword === '') {
		return false;
	}

	$passwordInfo = function_exists('password_get_info') ? password_get_info($storedPassword) : array('algo' => 0);
	if (!empty($passwordInfo['algo'])) {
		return password_verify($password, $storedPassword);
	}

	foreach (systemUserPasswordHashes($password) as $hash) {
		if (hash_equals($storedPassword, $hash)) {
			return true;
		}
	}

	return false;
}

function systemUserPasswordWasUsed($password, $storedPasswords)
{
	foreach ($storedPasswords as $storedPassword) {
		if (systemUserPasswordMatches($password, $storedPassword)) {
			return true;
		}
	}

	return false;
}



$Action = '';
$POSTAction = '';
$ActionAjax = '';
if (isset($_REQUEST['Action']))
	$Action = $_REQUEST['Action'];
if (isset($_REQUEST['ActionFlag']))
	$ActionFlag = decodeencriptstring($_REQUEST['ActionFlag']);
if (isset($_REQUEST['Trigger']))
	$Trigger = decodeencriptstring($_REQUEST['Trigger']);
if (isset($_REQUEST['actionpage']))
	$action = decodeencriptstring($_REQUEST['actionpage']);
if (isset($_REQUEST['SubLinkID']))
	$SubLinkID = decodeencriptstring($_REQUEST['SubLinkID']);
if (isset($_REQUEST['RecordID']))
	$RecordID = decodeencriptstring($_REQUEST['RecordID']);
if (isset($_REQUEST['MasterTable']))
	$MasterTableName = decodeencriptstring($_REQUEST['MasterTable']);
if (isset($_REQUEST['TableID']))
	$TableID = decodeencriptstring($_REQUEST['TableID']);
if (isset($_POST['Action']))
	$POSTAction = $_POST['Action'];
if (isset($_REQUEST['ActionAjax']))
	$ActionAjax = decodeencriptstring($_REQUEST['ActionAjax']);
if (isset($_REQUEST['TypeID']))
	$TypeID = decodeencriptstring($_REQUEST['TypeID']);
if (isset($_REQUEST['ParentID']))
	$ParentID = decodeencriptstring($_REQUEST['ParentID']);





function sitemap($loc, $lastmod, $prioroty)
{
	$dom = new DOMDocument();
	$dom->formatOutput = true;

	$dom->load('../sitemap.xml', LIBXML_NOBLANKS);

	$root = $dom->documentElement;
	$newresult = $root->appendChild($dom->createElement('url'));

	//$newresult->setAttribute('loc');
	$newresult->appendChild($dom->createElement('loc', $loc));
	$newresult->appendChild($dom->createElement('changefreq', 'daily'));
	$newresult->appendChild($dom->createElement('lastmod', $lastmod));
	$newresult->appendChild($dom->createElement('priority', $prioroty));

	$dom->save('../sitemap.xml') or die('XML Manipulate Error');
}



if ($Action != "ChangeLanguage" && $POSTAction != 'SortRecords' && $ActionFlag != "DeleteRecord" && $ActionAjax != "ajaxsearch" && $ActionAjax != 'GetPopItems' && $ActionAjax != 'GetAllImageGal' && $ActionAjax != 'AllFormDetails' && (!isset($_REQUEST['SetTime']) || $_REQUEST['SetTime'] != 'ShowTime')) {
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);
	if ($csrf->check_valid('post')) {
		//var_dump($_POST[$token_id]);
	} else {
		//die("Direct Access Not Allowed");
	}
}

if ($_REQUEST['ActionFlag'] == "CheckUserName") {
	$UserName = getFieldDataByID("TableID", "UserName", secureTextForDb($_REQUEST['Username']), "tblsystemusers");
	if ($UserName > 0) {
		echo "Username Unavailable";
	}
}

if ($ActionAjax == 'ajaxsearch' && !isset($_REQUEST['ActionFlag'])) {
	$q = $_REQUEST['q'];
	$tablename = decodeencriptstring($_REQUEST['tablename']);

	$finalArray = array();

	$query = "select * from " . $tablename . " where (Title like '%" . $q . "%' OR TitleAr like '%" . $q . "%' OR MenuTitle like '%" . $q . "%' OR MenuTitleAr like '%" . $q . "%') limit 0,20";
	$db1->query($query);

	while ($db1->next_Record()) {
		$finalArray[] = array("label" => stripslashes($db1->f("MenuTitle")), "value" => stripslashes($db1->f("MenuTitle")), "TableID" => $db1->f("TableID"));
	}

	echo json_encode($finalArray);
} else if ($ActionAjax == 'GetPopItems' && !isset($_REQUEST['ActionFlag'])) {

	$finalArray = array();

	$query = "select * from tbllandingpopupcampaign where TypeID = '" . $_REQUEST['TypeID'] . "' and Active='1' order by Title" . LANG_SEP_DB . " ASC";
	$db1->query($query);

	$popitems = '<option value="0">' . TXT_SELECT_POPUP . '</option>';
	while ($db1->next_Record()) {
		$selected = ($db1->f("TableID") == $_REQUEST['selectedtype']) ? 'selected' : '';
		$popitems .= '<option value="' . $db1->f("TableID") . '" ' . $selected . '>' . $db1->f("Title" . LANG_SEP_DB) . '</option>';
	}

	echo json_encode($popitems);
} else if ($ActionAjax == 'GetAllImageGal' && !isset($_REQUEST['ActionFlag'])) {

	$finalArray = array();

	$query = "select * from tblsystemimages where TypeID = '" . $_REQUEST['TypeID'] . "' and ParentID = '" . $_REQUEST['ParentID'] . "' order by Sequence";
	$db1->query($query);

	$popitems = '<ul class="bxsliderbanner">';
	while ($db1->next_Record()) {
		$popitems .= '<li><img src="../' . FILES_FOLDER . '/' . ORIGINAL_IMAGES . '/' . $db1->f("FileName") . '" width="100%" class="bxitems" /></li>';
	}
	$popitems .= '</ul>';

	echo json_encode($popitems);
} else if ($ActionAjax == 'AllFormDetails' && !isset($_REQUEST['ActionFlag'])) {
	$TableName = decodeencriptstring($_REQUEST['Table']);
	$FormName = decodeencriptstring($_REQUEST['formname']);
	$TableID = decodeencriptstring($_REQUEST['TableID']);

	$query = "select * from " . $TableName . " where TableID = '" . $TableID . "'";
	$db1->query($query);

	if ($FormName == 'ContactForm') {

		$db1->next_Record();
		$popitems = ' <div class="hk-pg-header mb-0 headerboxdesign"><h4 class="hk-pg-title" style="font-size:16px; color:#fff">' . TXT_CONTACTFORM . '</h4></div>';
		$popitems .= '<table class="table table-hover table-bordered mb-0">';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_NAME . '</th><td>' . $db1->f('Name') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_EMAIL . '</th><td>' . $db1->f('Email') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_MOBILE . '</th><td>' . $db1->f('Phone') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_MESSAGE . '</th><td>' . $db1->f('Message') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_DATE . '</th><td>' . onlydateshortformat($db1->f('DateTime')) . '</td>';
		$popitems .= '</tr>';
		$popitems .= '</table>';
	} else if ($FormName == 'RegisterUserForm') {

		$sql = "select U.*,N.Nationality,N.NationalityAr,C.Name,C.NameAr from  $TableName U 
		  INNER JOIN tblcountries N ON N.TableID = U.NationalityID 
		  INNER JOIN tblcountries C ON C.TableID = U.Country_ResidenceID 
		   where U.TableID = '" . $TableID . "'";
		$db1->query($sql);
		$db1->next_Record();
		$gender = ($db->f('Gender') == 1) ? TXT_MALE : TXT_FEMALE;
		$popitems = ' <div class="hk-pg-header mb-0 headerboxdesign"><h4 class="hk-pg-title" style="font-size:16px; color:#fff">' . TXT_USERREGISTERFORM . '</h4></div>';
		$popitems .= '<table class="table table-hover table-bordered mb-0">';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_NAME . '</th><td>' . $db1->f('FullName') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_GENDER . '</th><td>' . $gender . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_DOB . '</th><td>' . onlydateshortformat($db1->f('DOB')) . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_EMAIL . '</th><td>' . $db1->f('Email') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_MOBILE . '</th><td>' . $db1->f('Mobile') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_NATIONALITY . '</th><td>' . $db1->f('Nationality' . LANG_SEP_DB) . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_COUNTRY_RESIDENCE . '</th><td>' . $db1->f('Name' . LANG_SEP_DB) . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_DATE . '</th><td>' . onlydateshortformat($db1->f('CreationDate')) . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_REG_ID . '</th><td>' . $db1->f('RegID') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '</table>';
	} else if ($FormName == 'ComplaintForm') {

		$db1->next_Record();
		$popitems = ' <div class="hk-pg-header mb-0 headerboxdesign"><h4 class="hk-pg-title" style="font-size:16px; color:#fff">' . TXT_COMPLAINTFORM . '</h4></div>';
		$popitems .= '<table class="table table-hover table-bordered mb-0">';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_NAME . '</th><td>' . $db1->f('Name') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_EMAIL . '</th><td>' . $db1->f('Email') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_MOBILE . '</th><td>' . $db1->f('Phone') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_COMPLAINT . '</th><td>' . $db1->f('Complaint') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_DATE . '</th><td>' . onlydateshortformat($db1->f('DateTime')) . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_COMPLAINTID . '</th><td>' . $db1->f('RequestNo') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '</table>';
	} else if ($FormName == 'SuggestionForm') {

		$db1->next_Record();
		$popitems = ' <div class="hk-pg-header mb-0 headerboxdesign"><h4 class="hk-pg-title" style="font-size:16px; color:#fff">' . TXT_SUGGESTIONFORM . '</h4></div>';
		$popitems .= '<table class="table table-hover table-bordered mb-0">';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_NAME . '</th><td>' . $db1->f('Name') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_EMAIL . '</th><td>' . $db1->f('Email') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_MOBILE . '</th><td>' . $db1->f('Phone') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_SUGGESTION . '</th><td>' . $db1->f('Suggestion') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_DATE . '</th><td>' . onlydateshortformat($db1->f('DateTime')) . '</td>';
		$popitems .= '</tr>';
		$popitems .= '<tr>';
		$popitems .= '<th>' . TXT_SUGGESTIONID . '</th><td>' . $db1->f('RequestNo') . '</td>';
		$popitems .= '</tr>';
		$popitems .= '</table>';
	}

	echo json_encode($popitems);
}

//login panel
if ($ActionFlag == "LoginPanel") {
	if ($_REQUEST["txtUserName"] == '') {
		$result['error'] = TXT_ENTERNAME;
	} else if ($_REQUEST["txtPassword"] == '') {
		$result['error'] = TXT_ENTERPASSWORD;
	} else {
		$UserName = secureTextForDb($_REQUEST['txtUserName']);
		$PasswordRaw = $_REQUEST['txtPassword'];

		$CheckUserQuery = "select TableID, Active, LastloginDateTime, PasswordActive, ActiveLogin, Online, Password, InvalidLoginAttempt from tblsystemusers
		where UserName='$UserName'
		limit 1";
		$db->query($CheckUserQuery);
		$CountRecords = $db->num_rows();

		if ($CountRecords > 0) {
			$db->next_Record();
			$UserID = $db->f('TableID');
			$UserActive = $db->f('Active');
			$UserPasswordActive = $db->f('PasswordActive');
			$CountAcyivelogin = ($db->f('ActiveLogin') == '') ? 0 : $db->f('ActiveLogin');
			$InvalidLoginAttempt = $db->f('InvalidLoginAttempt');
			$PasswordMatched = systemUserPasswordMatches($PasswordRaw, $db->f('Password'));
		} else {
			$PasswordMatched = false;
		}

		if (!$PasswordMatched) {
			$result['error'] = TXT_LOGIN_ERROR;
			if ($CountRecords > 0) {
				if ($InvalidLoginAttempt == $website_config['Accountlockout'])
					$db->query("update tblsystemusers set Active=0, BlockTime=NOW(), BlockBy=1  where TableID='" . $UserID . "'");
				else
					$db->query("update tblsystemusers set InvalidLoginAttempt='" . ($InvalidLoginAttempt + 1) . "' where TableID='" . $UserID . "'");

				$result['error'] = TXT_LOGIN_ERROR;
			}
			$db->query("insert into tblsystemusers_login_log set UserName='" . addslashes($UserName) . "', UserIP='" . $_SERVER['REMOTE_ADDR'] . "', Status=0, Reason=1, DateTime=NOW(), Type=1");

		} else if ($UserActive == INACTIVE) {
			$result['error'] = TXT_LOGIN_ACCOUNT_BLOCK_ERROR;
			$db->query("insert into tblsystemusers_login_log set UserID='" . $UserID . "', UserName='" . addslashes($UserName) . "', UserIP='" . $_SERVER['REMOTE_ADDR'] . "', Status=0, Reason=2, DateTime=NOW(), Type=1");
		} else {
			/*
						if($db->f('Active')==INACTIVE)
						{
							$result['error'] = TXT_LOGIN_ACCOUNT_BLOCK_ERROR;
							$db->query("insert into tblsystemusers_login_log set UserID='".$UserID."', UserName='".$_REQUEST[txtUserName]."', UserIP='".$_SERVER['REMOTE_ADDR']."', Status=0, Reason=2, DateTime=NOW(), Type=1");
						}
						else if ($db->f('Online') == 1 && $CountAcyivelogin >= $website_config['UserSession'])
						{
							$result['error'] = TXT_USERLOGGEDIN;
						}
						else
						{
							if($UserPasswordActive==ACTIVE && (checkPasswordExpiry($UserID) == 1))
							{*/
			session_regenerate_id(true);
			$_SESSION['un_sessionid'] = session_id();
			$_SESSION[WEB_SESSION . '_userid'] = $UserID;

			$CountAcyivelogin++;

			$UpdateLoginDateTime = "update tblsystemusers set LastloginDateTime=NOW(),LastLoginIP='" . $_SERVER['REMOTE_ADDR'] . "',InvalidLoginAttempt=0,Online=1,LastActiveTime=" . time() . ",UserAgent='" . md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) . "',SessionID='" . $_SESSION['un_sessionid'] . "', ActiveLogin='" . $CountAcyivelogin . "' where TableID=" . $UserID;
			$db->query($UpdateLoginDateTime);
			/*
			echo "LOGIN SESSION ID: ".session_id();
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	exit;
	*/
			// session_start();
			$result['success'] = 1;
			//	if($_REQUEST['RedirectURL']!='')
			//		$result['redirect']= "http://".$_SERVER['HTTP_HOST'].$_REQUEST['RedirectURL'];
			///	else
			$result['redirect'] = "index.php";
			$_SESSION['samad'] = "test";
			$_SESSION[WEB_SESSION . '_userid'] = $UserID;
			//$_SESSION['Message']['Msg'] = TXT_WELCOME_MESSAGE;
			$_SESSION['Message']['Type'] = 2;


			$db->query("delete from tblsystemusers_activelogin where SessionID='" . session_id() . "'");
			$db->query("insert into tblsystemusers_login_log set UserID='" . $UserID . "', UserName='" . addslashes($UserName) . "', UserIP='" . $_SERVER['REMOTE_ADDR'] . "', Status=1, DateTime=NOW(), Type=1");
			$LogID = $db->MysqlInsertID();
			$db->query("insert into tblsystemusers_activelogin set UserID='" . $UserID . "', SessionID='" . session_id() . "', LogID='" . $LogID . "'");
			/*
			}
		else{
			$result['success'] = 1;
			$result['redirect']= "index.php?".EncodeUrl("UserID=".$UserID."&&changepass=1");
			$_SESSION[session_id().'_changeP'] = encodeencriptstring($UserID);
		}
	}*/
		}

	}
	$_SESSION[WEB_SESSION . '_userid'] = $UserID;

	// set_user_id($user_id);
	echo json_encode($result);
}


//sort table records
else if ($POSTAction == 'SortRecords') {
	$tablename = decodeencriptstring($_POST['tablename']);
	$parentid = $_POST['parentid'];

	if ($tablename != '') {
		foreach ($_POST['listItem'] as $Sequence => $item):

			if ($parentid > 0)
				$query = "UPDATE " . $tablename . " SET ParentTableID='" . $parentid . "', Sequence = $Sequence WHERE TableID = $item";
			else
				$query = "UPDATE " . $tablename . " SET Sequence = $Sequence WHERE TableID = $item";

			$db->query($query);
		endforeach;
	}
} else if ($ActionFlag == "DeleteRecord") {
	$recordID = decodeencriptstring($_REQUEST['recordID']);
	$tablename = decodeencriptstring($_REQUEST['tablename']);

	if ($recordID > 0) {
		/*if($tablename=="tblimages")
		{
			deletefiles(THEME_FOLDER,"FileName","tblimages",$recordID);
		}
		if($tablename=="tblvideos" )
		{
			deletefiles(THEME_FOLDER,"FileName","tblvideos",$recordID);
		}*/

		//insertlogTable($tablename,$recordID,3);

		$querycategory = "delete from $tablename  where TableID=" . $recordID;
		$db->query($querycategory);
	}
	$_SESSION['Message']['Msg'] = "Selected Record is Deleted";
	$_SESSION['Message']['Type'] = 1;
	$result['selfredirect'] = 1;
	$result['success'] = 1;
	//$result['error'] = "test".$ActionFlag;
	echo json_encode($result);
}
//update or add role
else if ($ActionFlag == 'AddEditRole') {

	if ($Trigger == 'edit') {
		$Query = "update tblroles set ";
		$logaction = 2;
	} else {
		$Query = "insert into tblroles set ";
		$logaction = 1;
	}

	$Query .= "RoleName='" . secureTextForDb($_POST['Title']) . "', 
				RoleNameAr='" . secureTextForDb($_POST['TitleAr']) . "', 
				Active='" . secureTextForDb($_POST['Active']) . "' 
			   ";

	if ($Trigger == 'edit')
		$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
					ModifiedDateTime=NOW()
					Where TableID='" . $RecordID . "'
				  ";
	else
		$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
					CreatedDateTime=NOW()
				  ";
	$db->query($Query);
	$InsertID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;

	insertlogTable('tblroles', $InsertID, $logaction);

	$result['success'] = 1;

	if ($Trigger == 'edit')
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
	else
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID . '&PageType=Permission&RecordID=' . $InsertID);

	$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? "Role Edited Successfully" : "Role Added Successfully";
	$_SESSION['Message']['Type'] = 2;

	echo json_encode($result);
}

/// role permission
else if ($ActionFlag == 'RolePermission') {
	if (count($_POST['ViewPermissions']) == 0 && count($_POST['AddPermissions']) == 0 && count($_POST['EditPermissions']) == 0 && count($_POST['DeletePermissions']) == 0) {
		$result['error'] = "Please select any one option";
	}
	if ($result['error'] == "") {
		$DeleteRolesPermisison = "Delete from tblrolespermission where RoleID='" . $RecordID . "'";
		$db->query($DeleteRolesPermisison);

		$FetchSubLinks = "select * from tblsublinks  order by TableID";
		$db1->query($FetchSubLinks);
		while ($db1->next_record()) {
			$ViewPermissions = 0;
			$AddPermissions = 0;
			$EditPermissions = 0;
			$DeletePermissions = 0;
			if (isset($_POST['ViewPermissions'][$db1->f('TableID')])) {
				if ($_POST['ViewPermissions'][$db1->f('TableID')] != '') {

					$ViewPermissions = 1;
				} else {
					$ViewPermissions = 0;
				}
			}

			if (isset($_POST['AddPermissions'][$db1->f('TableID')])) {
				if ($_POST['AddPermissions'][$db1->f('TableID')] != '') {

					$AddPermissions = 1;
				} else {
					$AddPermissions = 0;
				}
			}

			if (isset($_POST['EditPermissions'][$db1->f('TableID')])) {
				if ($_POST['EditPermissions'][$db1->f('TableID')] != '') {

					$EditPermissions = 1;
				} else {
					$EditPermissions = 0;
				}
			}

			if (isset($_POST['DeletePermissions'][$db1->f('TableID')])) {
				if ($_POST['DeletePermissions'][$db1->f('TableID')] != '') {

					$DeletePermissions = 1;
				} else {
					$DeletePermissions = 0;
				}
			}

			$Query = "insert into tblrolespermission set  
						RoleID='" . secureTextForDb($RecordID) . "',
						SublinkID='" . secureTextForDb($db1->f('TableID')) . "', 
						ViewPermissions='" . $ViewPermissions . "' ,
						AddPermissions='" . $AddPermissions . "' ,
						EditPermissions='" . $EditPermissions . "' ,
						DeletePermissions='" . $DeletePermissions . "' ,
						CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";
			$db->query($Query);

			$InsertID = $db->MysqlInsertID();
			$tableid = $InsertID;
			insertlogTable('tblrolespermission', $tableid, 1);

		}
		/*$Trigger = decodeencriptstring($_REQUEST['Trigger']);
	$action = decodeencriptstring($_REQUEST['action']);
	$SubLinkID = decodeencriptstring($_REQUEST['SubLinkID']);
	$RecordID = decodeencriptstring($_REQUEST['RecordID']);	*/
		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = "Role Permissions Updated Successfully";
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);

}
/// add edit system users
else if ($ActionFlag == 'AddEditSystemUser') {
	$Password = systemUserPasswordHash($_POST['Password']);
	$EmailValidation = getFieldDataByID("TableID", "Email", secureTextForDb($_POST['Email']) . "  and ", "tblsystemusers");
	$UserName = getFieldDataByID("TableID", "UserName", secureTextForDb($_POST['UserName']), "tblsystemusers");

	/*if($EmailValidation  > 0 && $RecordID!=$EmailValidation)
	{
		$result['error'] = "Sorry, the email address already exists";
	}
	else */
	if ($UserName > 0 && $RecordID != $UserName) {
		$result['error'] = "The username exists already in the system. Please enter a different username";
	}
	/*else if(6 > strlen($_POST['UserName']) && $_POST['UserName']!='' && $Trigger != 'edit')
	{
		$result['error'] = "Please enter minimum 6 character username";
	}*/ else if ($_POST['PasswordStrength'] < 3 && $_POST['Password'] != '') {
		$result['error'] = "Please enter strong password";
	} else if ($_POST['Password'] != $_POST['CPassword']) {
		$result['error'] = "Sorry, the password does not matxh";
	} else if ($_POST['SendEmail'] == 1 && $_POST['Password'] == '') {
		$result['error'] = "Please enter password for sending credential";
	}

	if ($result['error'] == '') {
		if ($Trigger == 'edit')
			$Query = "update tblsystemusers set ";
		else
			$Query = "insert into tblsystemusers set ";

		$Query .= "RoleID='" . secureTextForDb($_POST['RoleID']) . "',
					FullName='" . secureTextForDb($_POST['FullName']) . "', 
					FullNameAr='" . secureTextForDb($_POST['FullNameAr'] ?? '') . "' , 
					Email='" . secureTextForDb($_POST['Email']) . "' , 
					EmpNo='" . secureTextForDb($_POST['EmpNo'] ?? '') . "' , 
					MobileNo='" . secureTextForDb($_POST['MobileNo'] ?? '') . "' , 
					EventID='" . (isset($_POST['EventID']) && is_array($_POST['EventID']) ? implode(",", $_POST['EventID']) : '') . "' ,  
					PerPageRecord='" . secureTextForDb($_POST['PerPageRecord'] ?? 500) . "' , 
					Active='" . secureTextForDb($_POST['Active']) . "',   
					BlockBy='0'   
				   ";

		if (($_POST['UserName'] ?? '') != '' && $Trigger != 'edit')
			$Query .= " , UserName = '" . secureTextForDb($_POST['UserName']) . "' ";

		if (($_POST['Password'] ?? '') != '')
			$Query .= " , Password = '" . secureTextForDb($Password) . "' ";

		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModifiedDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;

		$logaction = $Trigger != 'edit' ? 1 : 2;
		insertlogTable('tblsystemusers', $InsertRecordID, $logaction);

		if ($InsertRecordID > 0) {
			if ($_POST['Password'] != '') {
				$InsertPasswordHistory = "insert into tblsystemuserpasswords set UserID='" . $InsertRecordID . "',Password='" . secureTextForDb($Password) . "',
											DateTime=NOW()";
				$db->query($InsertPasswordHistory);
			}
			if ($Trigger != 'edit') {
				$CheckRolePermissionQuery = "select * from tblrolespermission where RoleID='" . $_POST['RoleID'] . "'";
				$db->query($CheckRolePermissionQuery);
				if ($db->num_rows() > 0) {
					while ($db->next_Record()) {
						$SystemUserPermission = "insert into tbluserpermissions set  
							SublinkID='" . $db->f('SublinkID') . "', 
							ViewPermissions='" . $db->f('ViewPermissions') . "' , 
							AddPermissions='" . $db->f('AddPermissions') . "' , 
							EditPermissions='" . $db->f('EditPermissions') . "' , 
							DeletePermissions='" . $db->f('DeletePermissions') . "' , 
							UserID='" . $InsertRecordID . "' , 
							CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
							CreatedDateTime=NOW()  
						   ";
						$db1->query($SystemUserPermission);
						$InsertpermisnID = $db1->MysqlInsertID();
						insertlogTable('tbluserpermissions', $InsertpermisnID, 1);
					}
				}
			}


			if ($_POST['SendEmail'] == 1 && $_POST['Password'] != '') {

				$MailMessage .= 'Kindly find the access and credentials details below : 
								<br /> 
								<br />
								<table width="100%"  border="0" cellspacing="2" cellpadding="10"> 
										<tr style="background:#f1f1f1;"> 
											<td width="30%" style="font-weight:bold">Portal URL</td>
											<td><a href="' . DOMAINNAME_ADMIN . '">Click Here</a></td> 
										</tr>
										<tr style="background:#f1f1f1;"> 
											<td width="30%" style="font-weight:bold">User Name</td>
											<td>' . $_POST['UserName'] . '</td> 
										</tr>
										<tr style="background:#f1f1f1;">  
											<td style="font-weight:bold">Password</td>
											<td>' . $_POST['Password'] . '</td> 
										</tr> 
										 
								 </table>';

				// mail($_POST['Email'], "Your credential details for RSI Digital Signage System". $MailMessage,"Dear ".$_POST['FullName'],$headers);

				SendMail($_POST['Email'], "Your credential details for RSI Digital Signage System", $MailMessage, "Dear " . $_POST['FullName'], "ltr");

			}
			// 		exit($_POST['Email']);

		}

		$result['success'] = 1;

		/*if($Trigger == 'edit')
			$result['redirect']= 'index.php?'.EncodeUrl('action='.$_POST['action'].'&SubLinkID='.$_POST['SubLinkID']);
		else
			$result['redirect']= 'index.php?'.EncodeUrl('action='.$_POST['action'].'&SubLinkID='.$_POST['SubLinkID'].'&PageType=Permission&RecordID='.$RecordID);*/

		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? "User Edited Successfully" : "User Added Successfully";
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
}


/// system user permission
else if ($ActionFlag == 'SystemUserPermission') {
	if (count($_POST['ViewPermissions']) == 0 && count($_POST['AddPermissions']) == 0 && count($_POST['EditPermissions']) == 0 && count($_POST['DeletePermissions']) == 0) {
		$result['error'] = "Please select any one option";
	}
	if ($result['error'] == "") {
		$DeleteRolesPermisison = "Delete from tbluserpermissions where UserID='" . $RecordID . "'";
		$db->query($DeleteRolesPermisison);

		$FetchSubLinks = "select * from tblsublinks  order by TableID";
		$db1->query($FetchSubLinks);
		while ($db1->next_record()) {
			if ($_POST['ViewPermissions'][$db1->f('TableID')] != '') {

				$ViewPermissions = 1;
			} else {
				$ViewPermissions = 0;
			}

			if ($_POST['AddPermissions'][$db1->f('TableID')] != '') {

				$AddPermissions = 1;
			} else {
				$AddPermissions = 0;
			}

			if ($_POST['EditPermissions'][$db1->f('TableID')] != '') {

				$EditPermissions = 1;
			} else {
				$EditPermissions = 0;
			}

			if ($_POST['DeletePermissions'][$db1->f('TableID')] != '') {

				$DeletePermissions = 1;
			} else {
				$DeletePermissions = 0;
			}

			$Query = "insert into tbluserpermissions set  
						UserID='" . secureTextForDb($RecordID) . "',
						SublinkID='" . secureTextForDb($db1->f('TableID')) . "', 
						ViewPermissions='" . $ViewPermissions . "' ,
						AddPermissions='" . $AddPermissions . "' ,
						EditPermissions='" . $EditPermissions . "' ,
						DeletePermissions='" . $DeletePermissions . "' ,
						CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";
			$db->query($Query);
			$InsertpermisnID = $db->MysqlInsertID();
			insertlogTable('tbluserpermissions', $InsertpermisnID, 1);
		}

		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = "User Permissions Updated Successfully";
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);

}
/// add edit configuration
else if ($ActionFlag == 'EditSystemUserconfiguration') {

	foreach ($_REQUEST['PostData'] as $key => $values) {
		$Query = "update tblwebsiteconfiguration set Value='" . secureTextForDb($values) . "' where TableID=$key ";
		$db->query($Query);
		insertlogTable('tblwebsiteconfiguration', $key, 2);
	}
	$result['success'] = 1;
	$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
	$_SESSION['Message']['Msg'] = "Configuration Edited Successfully";
	$_SESSION['Message']['Type'] = 2;


	echo json_encode($result);
} else if ($ActionFlag == 'EditChangePassword') {
	$Password = systemUserPasswordHash($_POST['Password']);
	$userID = $_SESSION[WEB_SESSION . '_userid'];
	if (isset($_POST['ChangePassUserID'])) {
		$userID = decodeencriptstring($_POST['ChangePassUserID']);
	}
	$PrevPasswordSave = getFieldDataByID("Password", "TableID", $userID, "tblsystemusers");

	$Fetcholdpass = "select Password from tblsystemuserpasswords where UserID = '" . $userID . "'  order by TableID DESC LIMIT " . $website_config['PasswordHistory'] . "";
	$db1->query($Fetcholdpass);
	$OldPasswordSave = array();
	while ($db1->next_record()) {
		$OldPasswordSave[] = $db1->f('Password');
	}

	if (!systemUserPasswordMatches($_POST['OldPassword'], $PrevPasswordSave)) {
		$result['error'] = TXT_PASS_ENTER_CORRCT;
	} elseif (systemUserPasswordWasUsed($_POST['Password'], $OldPasswordSave)) {
		$result['error'] = TXT_PASS_USED;
	} else if ($_POST['PasswordStrength'] < 3 && $_POST['Password'] != '') {
		$result['error'] = TXT_ENTER_PASS_STRONG;
	} else if ($_POST['Password'] != $_POST['CPassword']) {
		$result['error'] = TXT_PASS_NOTMATCH;
	}


	if ($result['error'] == '') {
		$Query = "update tblsystemusers set  
						Password='" . secureTextForDb($Password) . "' , PasswordActive=1
					Where TableID = '" . $userID . "'
					  ";
		$db->query($Query);
		$InsertPasswordHistory = "insert into tblsystemuserpasswords set UserID='" . $userID . "',Password='" . secureTextForDb($Password) . "', DateTime=NOW()";
		$db->query($InsertPasswordHistory);

		$result['success'] = 1;
		$result['redirect'] = DOMAINNAME . '/admin/logout.php?messageshow=' . PASSWORD_CHANGED;
	}

	echo json_encode($result);
} else if ($ActionFlag == 'AddEditCmspage') {
	$TableName = "tblpages";
	if (isset($_POST['URLKeyword']))
		$URLKeywordDublicate = getFieldDataByID("TableID", "URLKeyword", $_POST['URLKeyword'], $TableName);

	$FileName = '';


	if ($URLKeywordDublicate > 0 && $RecordID != $URLKeywordDublicate && $Trigger == 'edit') {
		$result['error'] = ERROR_PAGE_URL;
	}


	if ($result['error'] == '') {

		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;
		} else {
			$Query = "insert into $TableName set   ";
			$logaction = 1;
			$_POST['MetaTitle'] = ($_POST['MetaTitle'] == "") ? $_POST['Title'] : $_POST['MetaTitle'];
		}
		$Query .= "PageType='" . secureTextForDb($_POST['PageType']) . "',
					Title='" . secureTextForDb($_POST['Title']) . "', 				
					MenuTitle='" . secureTextForDb($_POST['MenuTitle']) . "', 
					BannerTitle='" . secureTextForDb($_POST['BannerTitle']) . "', 				
					ExternalLink='" . secureTextForDb($_POST['ExternalLink']) . "', 				  			
					ParentTableID='" . secureTextForDb($_POST['ParentTableID']) . "' ,  
					Active='" . secureTextForDb($_POST['Active']) . "' ,  
					ShowInNav='" . secureTextForDb($_POST['ShowInNav']) . "' ,  
					ShowInFooterNav1='" . secureTextForDb($_POST['ShowInFooterNav1']) . "' ,  
					ShowInFooterNav2='" . secureTextForDb($_POST['ShowInFooterNav2']) . "' ,  
					MetaTitle='" . secureTextForDb($_POST['MetaTitle']) . "' ,  		
					MetaKeywords='" . secureTextForDb($_POST['MetaKeywords']) . "' ,  	 
					MetaDescription='" . secureTextForDb($_POST['MetaDescription']) . "' , 		
					MetaOthers='" . secureTextForDb($_POST['MetaOthers']) . "' 

				   ";

		if ($_POST['URLKeyword'] == '') {
			$URLKeyword = SEOFriendlyURL($_POST['Title']);

			$URLKeyword = SEOFriendlyPageURL($URLKeyword, $URLKeyword, $TableName);
		} else {
			$URLKeyword = $_POST['URLKeyword'];
		}

		if ($URLKeyword != '')
			$Query .= " , URLKeyword = '" . secureTextForDb($URLKeyword) . "' ";


		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModificationDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreationDateTime=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;
		insertlogTable($TableName, $InsertRecordID, $logaction);

		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? PAGE_EDIT_SUCESSFULLY : PAGE_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
} else if ($ActionFlag == 'AddEditBanner') {
	$TableName = "tblbanners";

	$IconFile1 = '';
	$IconFile2 = '';
	$IconFile3 = '';
	$IconFile4 = '';
	if ($Trigger == 'edit') {
		$BannerDet = FetchRecordByID($RecordID, "TableID", $TableName);
		$IconFile1 = $BannerDet['IconFile1'];
		$IconFile2 = $BannerDet['IconFile2'];
		$IconFile3 = $BannerDet['IconFile3'];
		$IconFile4 = $BannerDet['IconFile4'];
	}
	$Sequence = maxID("Sequence", $TableName, 1);

	if (in_array($_FILES['IconFile1']['type'], $AllowedImageExtension) && $_FILES['IconFile1']['type'] != '') {
		$IconFile1Width = getWidth($_FILES['IconFile1']['tmp_name']);
		$IconFile1Height = getHeight($_FILES['IconFile1']['tmp_name']);
	}
	if (in_array($_FILES['IconFile2']['type'], $AllowedImageExtension) && $_FILES['IconFile2']['type'] != '') {
		$IconFile2Width = getWidth($_FILES['IconFile2']['tmp_name']);
		$IconFile2Height = getHeight($_FILES['IconFile2']['tmp_name']);
	}
	if (in_array($_FILES['IconFile3']['type'], $AllowedImageExtension) && $_FILES['IconFile3']['type'] != '') {
		$IconFile3Width = getWidth($_FILES['IconFile3']['tmp_name']);
		$IconFile3Height = getHeight($_FILES['IconFile3']['tmp_name']);
	}
	if (in_array($_FILES['IconFile4']['type'], $AllowedImageExtension) && $_FILES['IconFile4']['type'] != '') {
		$IconFile4Width = getWidth($_FILES['IconFile4']['tmp_name']);
		$IconFile4Height = getHeight($_FILES['IconFile4']['tmp_name']);
	}

	if (is_url($_POST['Link1']) == false) {
		$result['error'] = ERROR_LINK_NOTVALID1;
	} else if ($_FILES['IconFile1']['name'] == '' && $IconFile1 == '') {
		$result['error'] = ERROR_BANNER_CHOOSE1;
	} else if (!in_array($_FILES['IconFile1']['type'], $AllowedImageExtension) && $_FILES['IconFile1']['type'] != '' && $_FILES['IconFile1']['name'] != '') {
		$result['error'] = ERROR_PAGE_BANNER_CHOOSE1;
	}
	/*else if($IconFile1Width > 0 && ($IconFile1Width!=MAIN_PAGE_BANNER_WIDTH1  ||  $IconFile1Height!=MAIN_PAGE_BANNER_HEIGHT1) && $_FILES['IconFile1']['name'] != '')
	{
		$result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT1.MAIN_PAGE_BANNER_WIDTH1."x".MAIN_PAGE_BANNER_HEIGHT1;
	}*/ else if (is_url($_POST['Link2']) == false) {
		$result['error'] = ERROR_LINK_NOTVALID2;
	} else if ($_FILES['IconFile2']['name'] == '' && $IconFile2 == '') {
		$result['error'] = ERROR_BANNER_CHOOSE2;
	} else if (!in_array($_FILES['IconFile2']['type'], $AllowedImageExtension) && $_FILES['IconFile2']['type'] != '' && $_FILES['IconFile2']['name'] != '') {
		$result['error'] = ERROR_PAGE_BANNER_CHOOSE2;
	}
	/*else if($IconFile2Width > 0 && ($IconFile2Width!=MAIN_PAGE_BANNER_WIDTH2 || $IconFile2Height!=MAIN_PAGE_BANNER_HEIGHT2) && $_FILES['IconFile2']['name'] != '')
	{
		$result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT2.MAIN_PAGE_BANNER_WIDTH2."x".MAIN_PAGE_BANNER_HEIGHT2;
	}*/ else if (is_url($_POST['Link3']) == false) {
		$result['error'] = ERROR_LINK_NOTVALID3;
	} else if ($_FILES['IconFile3']['name'] == '' && $IconFile3 == '') {
		$result['error'] = ERROR_BANNER_CHOOSE3;
	} else if (!in_array($_FILES['IconFile3']['type'], $AllowedImageExtension) && $_FILES['IconFile3']['type'] != '' && $_FILES['IconFile3']['name'] != '') {
		$result['error'] = ERROR_PAGE_BANNER_CHOOSE2;
	}
	/*else if($IconFile3Width > 0 && ($IconFile3Width!=MAIN_PAGE_BANNER_WIDTH3  ||  $IconFile3Height!=MAIN_PAGE_BANNER_HEIGHT3) && $_FILES['IconFile3']['name'] != '')
	{
		$result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT3.MAIN_PAGE_BANNER_WIDTH3."x".MAIN_PAGE_BANNER_HEIGHT3;
	}*/ else if (is_url($_POST['Link4']) == false) {
		$result['error'] = ERROR_LINK_NOTVALID4;
	} else if ($_FILES['IconFile4']['name'] == '' && $IconFile4 == '') {
		$result['error'] = ERROR_BANNER_CHOOSE4;
	} else if (!in_array($_FILES['IconFile4']['type'], $AllowedImageExtension) && $_FILES['IconFile4']['type'] != '' && $_FILES['IconFile4']['name'] != '') {
		$result['error'] = ERROR_PAGE_BANNER_CHOOSE2;
	}
	/*else if($IconFile4Width > 0 && ($IconFile4Width!=MAIN_PAGE_BANNER_WIDTH4 || $IconFile4Height!=MAIN_PAGE_BANNER_HEIGHT4) && $_FILES['IconFile4']['name'] != '')
	{
		$result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT4.MAIN_PAGE_BANNER_WIDTH4."x".MAIN_PAGE_BANNER_HEIGHT4;
	}*/
	if ($result['error'] == '') {

		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;
		} else {
			$Query = "insert into $TableName set   ";
			$logaction = 1;
		}

		$Query .= "Title1='" . secureTextForDb($_POST['Title1']) . "',
					Title1Ar='" . secureTextForDb($_POST['Title1Ar']) . "',
					Link1='" . secureTextForDb($_POST['Link1']) . "',
					Title2='" . secureTextForDb($_POST['Title2']) . "',
					Title2Ar='" . secureTextForDb($_POST['Title2Ar']) . "',
					Link2='" . secureTextForDb($_POST['Link2']) . "',					
					Title3='" . secureTextForDb($_POST['Title3']) . "',
					Title3Ar='" . secureTextForDb($_POST['Title3Ar']) . "',
					Link3='" . secureTextForDb($_POST['Link3']) . "',
					Title4='" . secureTextForDb($_POST['Title4']) . "',
					Title4Ar='" . secureTextForDb($_POST['Title4Ar']) . "',
					Link4='" . secureTextForDb($_POST['Link4']) . "',
					BriefDescription='" . secureTextForDb($_POST['BriefDescription']) . "', 
					BriefDescriptionAr='" . secureTextForDb($_POST['BriefDescriptionAr']) . "' ,  
					Active='" . secureTextForDb($_POST['Active']) . "' 
				   ";

		if ($_FILES['IconFile1']['name'] != '') {
			$tmpBannerImage = $_FILES['IconFile1']['tmp_name'];
			$FileNameIconFile1 = date("YmdHis") . '-' . rand(0, 1000);
			$UploadBannerImage = $FileNameIconFile1 . makeExtention($_FILES['IconFile1']['type']);
			$FileNameBannerImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;
			$FileNameBannerImageCrop1 = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/cropthumb_' . $UploadBannerImage;
			if (move_uploaded_file($tmpBannerImage, $FileNameBannerImage)) {
				$Query .= " , IconFile1 = '" . secureTextForDb($UploadBannerImage) . "' ";
				CropimageSave($_POST['ImageCropData1'], $FileNameBannerImageCrop1);
			}
		}
		if ($_FILES['IconFile2']['name'] != '') {
			$tmpBannerImage = $_FILES['IconFile2']['tmp_name'];
			$FileNameIconFile2 = date("YmdHis") . '-' . rand(0, 1000);
			$UploadBannerImage = $FileNameIconFile2 . makeExtention($_FILES['IconFile2']['type']);
			$FileNameBannerImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;
			$FileNameBannerImageCrop2 = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/cropthumb_' . $UploadBannerImage;
			if (move_uploaded_file($tmpBannerImage, $FileNameBannerImage)) {
				$Query .= " , IconFile2 = '" . secureTextForDb($UploadBannerImage) . "' ";
				CropimageSave($_POST['ImageCropData2'], $FileNameBannerImageCrop2);
			}
		}
		if ($_FILES['IconFile3']['name'] != '') {
			$tmpBannerImage = $_FILES['IconFile3']['tmp_name'];
			$FileNameIconFile3 = date("YmdHis") . '-' . rand(0, 1000);
			$UploadBannerImage = $FileNameIconFile3 . makeExtention($_FILES['IconFile3']['type']);
			$FileNameBannerImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;
			$FileNameBannerImageCrop3 = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/cropthumb_' . $UploadBannerImage;
			if (move_uploaded_file($tmpBannerImage, $FileNameBannerImage)) {
				$Query .= " , IconFile3 = '" . secureTextForDb($UploadBannerImage) . "' ";
				CropimageSave($_POST['ImageCropData3'], $FileNameBannerImageCrop3);
			}
		}
		if ($_FILES['IconFile4']['name'] != '') {
			$tmpBannerImage = $_FILES['IconFile4']['tmp_name'];
			$UploadBannerImage = date("YmdHis") . '-' . rand(0, 1000) . makeExtention($_FILES['IconFile4']['type']);
			$FileNameBannerImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;
			$FileNameBannerImageCrop4 = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/cropthumb_' . $UploadBannerImage;
			if (move_uploaded_file($tmpBannerImage, $FileNameBannerImage)) {
				$Query .= " , IconFile4 = '" . secureTextForDb($UploadBannerImage) . "' ";
				CropimageSave($_POST['ImageCropData4'], $FileNameBannerImageCrop4);
			}
		}

		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModificationDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,Sequence='" . $Sequence . "', CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreationDateTime=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;
		insertlogTable($TableName, $InsertRecordID, $logaction);

		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? BANNER_EDIT_SUCESSFULLY : BANNER_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
} else if ($ActionFlag == 'AddEditImageGal') {
	$TableName = "tbllandingpopupcampaign";

	if ($_FILES['FileName']['name'][0] == '' && $Trigger != 'edit') {
		$result['error'] = ERROR_IMAGE_CHOOSE;
	} else if ($_FILES['FileName']['name'][0] != '') {
		$filetypes = array_unique($_FILES['FileName']['type']);
		$countfiletype = count($filetypes);
		$filetypediff = array_intersect($AllowedImageExtension, $filetypes);
		$countdifffiletype = count($filetypediff);
		if ($countfiletype != $countdifffiletype) {
			$result['error'] = ERROR_IMAGEGALLERY_CHOOSE;
		}

	}

	if ($result['error'] == '') {

		$Sequence = maxID("Sequence", "tblsystemimages", 1);
		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;
		} else {
			$Query = "insert into $TableName set   ";
			$logaction = 1;
		}

		$Query .= "Title='" . secureTextForDb($_POST['Title1']) . "',
					TitleAr='" . secureTextForDb($_POST['Title1Ar']) . "',
					TypeID='1',
					Active='" . secureTextForDb($_POST['Active']) . "' 
				   ";

		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModifiedDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;
		insertlogTable($TableName, $InsertRecordID, $logaction);

		if ($_FILES['FileName']['name'][0] != '') {
			$i = 0;
			foreach ($_FILES['FileName']['name'] as $FileName) {
				$tmpGalleryImage = $_FILES['FileName']['tmp_name'][$i];
				$UploadGalleryImage = date("YmdHis") . '-' . rand(0, 1000) . makeExtention($_FILES['FileName']['type'][$i]);
				$FileNameGalleryImage = '../' . FILES_FOLDER . '/' . ORIGINAL_IMAGES . '/' . $UploadGalleryImage;
				$UploadThumbnailImageSmall = '../' . FILES_FOLDER . '/' . THUMBNAIL_IMAGES . '/thumbnail_' . $UploadGalleryImage;
				if (move_uploaded_file($tmpGalleryImage, $FileNameGalleryImage)) {
					$resizeObj = new resize($FileNameGalleryImage);
					$resizeObj->resizeImage(THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, 'crop');
					$resizeObj->saveImage($UploadThumbnailImageSmall, 100);

					$Queryimage = "insert into tblsystemimages set ParentID = '" . $InsertRecordID . "' , FileName = '" . secureTextForDb($UploadGalleryImage) . "' ";
					$Queryimage .= ",TypeID='6',Sequence='" . $Sequence . "' ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";
					$db->query($Queryimage);
					$Sequence++;
				}
				$i++;
			}
		}


		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? IMAGEGALLERY_EDIT_SUCESSFULLY : IMAGEGALLERY_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
} else if ($ActionFlag == 'AddEditVideoGal') {
	$TableName = "tbllandingpopupcampaign";

	$valid = preg_match("/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/watch\?v\=\w+$/", $_POST['FileName']);
	if ($valid == false && $_POST['VideoType'] == 1) {
		$result['error'] = ERROR_YOUTUBE_LINK;
	} else if ($_POST['VideoType'] == 2 && $_FILES['Video']['name'] == '' && $Trigger != 'edit') {
		$result['error'] = ERROR_SELECT_VIDEO;
	} else if ($_FILES['Video']['type'] != '' && $_POST['VideoType'] == 2 && $_FILES['Video']['size'] > (VIDEO_UPLOAD_SIZE * 1000000)) {
		$result['error'] = str_replace("{mb}", VIDEO_UPLOAD_SIZE, ERROR_VIDEO_SIZE);
	} else if (!in_array($_FILES['Video']['type'], $AllowedVideoExtension) && $_FILES['Video']['type'] != '' && $_POST['VideoType'] == 2) {
		$result['error'] = ERROR_VIDEO_FORMAT;
	}

	if ($result['error'] == '') {

		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;
		} else {
			$Query = "insert into $TableName set   ";
			$logaction = 1;
		}

		$Query .= "Title='" . secureTextForDb($_POST['Title1']) . "',
					TitleAr='" . secureTextForDb($_POST['Title1Ar']) . "',
					TypeID='2',
					VideoType='" . secureTextForDb($_POST['VideoType']) . "', 
					Active='" . secureTextForDb($_POST['Active']) . "' 
				   ";

		if ($_POST['VideoType'] == 1 && $_REQUEST['FileName'] != '') {
			$Query .= " , FileName = '" . secureTextForDb($_REQUEST['FileName']) . "' ";
		}

		if ($_POST['VideoType'] == 2 && $_FILES['Video']['name'] != '') {
			$tmpBannerImage = $_FILES['Video']['tmp_name'];
			$UploadBannerImage = date("YmdHis") . '-' . rand(0, 1000) . makeExtention($_FILES['Video']['type']);
			$FileNameBannerImage = '../' . FILES_FOLDER . '/' . UPLOAD_VIDEOS . '/' . $UploadBannerImage;
			if (move_uploaded_file($tmpBannerImage, $FileNameBannerImage)) {
				$Query .= " , FileName = '" . secureTextForDb($UploadBannerImage) . "' ";
			}
		}

		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModifiedDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;
		insertlogTable($TableName, $InsertRecordID, $logaction);

		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? IMAGEGALLERY_EDIT_SUCESSFULLY : IMAGEGALLERY_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
} else if ($ActionFlag == 'AddEditSchedule') {
	$TableName = "tblproduct";
	if (isset($_POST['URLKeyword']))
		$URLKeywordDublicate = getFieldDataByID("TableID", "URLKeyword", $_POST['URLKeyword'], $TableName);

	if (in_array($_FILES['logo']['type'], $AllowedImageExtension) && $_FILES['logo']['type'] != '') {
		$BannerImageWidth = getWidth($_FILES['logo']['tmp_name']);
		$BannerImageHeight = getHeight($_FILES['logo']['tmp_name']);
	}

	if ($URLKeywordDublicate > 0 && $RecordID != $URLKeywordDublicate && $Trigger == 'edit') {
		//		$result['error'] = ERROR_PAGE_URL;
	} else if (!in_array($_FILES['logo']['type'], $AllowedImageExtension) && $_FILES['logo']['type'] != '') {
		$result['error'] = ERROR_PAGE_BANNER_CHOOSE;
	} else if (!in_array($_FILES['ThumbnailImage']['type'], $AllowedImageExtension) && $_FILES['ThumbnailImage']['type'] != '') {
		$result['error'] = ERROR_THUMBNAIL_IMAGE_CHOOSE;
	} else if ($BannerImageWidth > 0 && ($BannerImageWidth != INNER_PAGE_BANNER_WIDTH || $BannerImageHeight != INNER_PAGE_BANNER_HEIGHT)) {
		// $result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT.INNER_PAGE_BANNER_WIDTH."x".INNER_PAGE_BANNER_HEIGHT;
	}


	if ($result['error'] == '') {

		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;
		} else {
			$Query = "insert into $TableName set   ";
			$logaction = 1;
			$_POST['MetaTitle'] = ($_POST['MetaTitle'] == "") ? $_POST['Title'] : $_POST['MetaTitle'];
			$_POST['MetaTitleAr'] = ($_POST['MetaTitleAr'] == "") ? $_POST['TitleAr'] : $_POST['MetaTitleAr'];

			sitemap($_POST['url'], date('Y-m-d'), '0.64');
		}

		$ShowHome = 0;
		if ($_POST['ShowHome'] == 1) {
			$ShowHome = 1;
		}

		$Query .= "ProductName='" . secureTextForDb($_POST['ProductName']) . "',
					url='" . secureTextForDb($_POST['url']) . "',  
					trackingLink='" . secureTextForDb($_POST['trackingLink']) . "', 
					landingLink='" . secureTextForDb($_POST['landingLink']) . "' ,    
					Active='" . secureTextForDb($_POST['Active']) . "' ,   
					ShowHome='" . secureTextForDb($ShowHome) . "' ,    
					CountryID='" . secureTextForDb($_POST['CountryID']) . "' ,
					ProductTagID='" . secureTextForDb($_POST['ProductTagID']) . "' ,  
					startDate='" . secureTextForDb($_POST['startDate']) . "' , 
					endDate='" . secureTextForDb($_POST['endDate']) . "' ,  
					StoreID='" . secureTextForDb($_POST['StoreID']) . "' ,  
					upVotes='" . secureTextForDb($_POST['upVotes']) . "' , 
					downVotes='" . secureTextForDb($_POST['downVotes']) . "' , 
					featured='" . secureTextForDb($_POST['featured']) . "' ,  
					sitewide='" . secureTextForDb($_POST['sitewide']) . "' ,
					CutPrice='" . secureTextForDb($_POST['CutPrice']) . "' ,
					productCode='" . secureTextForDb($_POST['productCode']) . "' ,
					discount='" . secureTextForDb($_POST['discount']) . "' ,  
					ProductClassification='" . secureTextForDb($_POST['ProductClassification']) . "' ,
					CategoryID='" . secureTextForDb(implode(",", $_POST['CategoryID'])) . "' ,
					ProductTypeID='" . secureTextForDb(implode(",", $_POST['ProductTypeID'])) . "' ,
					OldPrice='" . secureTextForDb($_POST['OldPrice']) . "' ,
					NewPrice='" . secureTextForDb($_POST['NewPrice']) . "' ,
					MetaTitle='" . secureTextForDb($_POST['MetaTitle']) . "' ,
					MetaKeywords='" . secureTextForDb($_POST['MetaKeywords']) . "' ,
					MetaDescription='" . secureTextForDb($_POST['MetaDescription']) . "' ,
					description='" . secureTextForDb($_POST['description']) . "'    
				   ";

		if ($_POST['URLKeyword'] == '') {
			$URLKeyword = explode(" ", $_POST['CouponName']);
			$URLKeyword = SEOFriendlyURL($URLKeyword[0]);

			$URLKeyword = SEOFriendlyPageURL($URLKeyword, $URLKeyword, $TableName);
		} else {
			$URLKeyword = explode(" ", $_POST['URLKeyword']);
			$URLKeyword = $URLKeyword[0];
		}

		if ($URLKeyword != '')
			$Query .= " , URLKeyword = '" . secureTextForDb($URLKeyword) . "' ";


		$tmpBannerImage = $_FILES['logo']['tmp_name'];
		$FileNameBanner = date("YmdHis") . '-' . rand(0, 1000);
		$UploadBannerImage = $FileNameBanner . makeExtention($_FILES['logo']['type']);
		$FileNameBannerImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;
		$FileNameBannerImageCrop = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;

		if (move_uploaded_file($_FILES['logo']['tmp_name'], $FileNameBannerImage)) {
			$Query .= " , logo = '" . secureTextForDb($UploadBannerImage) . "' ";
			//			CropimageSave($_POST['ImageCropData1'],$FileNameBannerImageCrop);
		}



		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModifiedDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;
		if ($Trigger == 'edit') {
			$sql = "delete from tblproductcategory  Where ProductID='" . $RecordID . "';";
			$db->query($sql);
			$sql = "delete from tblproductstypes  Where ProductID='" . $RecordID . "';";
			$db->query($sql);
		}


		foreach ($_POST['CategoryID'] as $a) {
			$sql = "insert into tblproductcategory set  ProductID='" . secureTextForDb($InsertRecordID) . "',
				CategoryID='" . secureTextForDb($a) . "';";
			$db->query($sql);
		}

		foreach ($_POST['ProductTypeID'] as $a) {
			$sql = "insert into tblproductstypes set  ProductID='" . secureTextForDb($InsertRecordID) . "',
				CouponTypeID='" . secureTextForDb($a) . "';";
			$db->query($sql);
		}

		// Get Store Category here

		//		if(count($_POST['CategoryID'])==0)
//		{
//			$sql = "select * from tblstorecategory where StoreID = ".$_POST['StoreID'];
//			$db->query($sql);
//			while($db->next_Record())
//			{
//				$InsertCoponCategory = "insert into tblcouponcategory set CouponID='".$InsertRecordID."' , CategoryID = ".$db->f('CategoryID');
//				$db1->query($InsertCoponCategory);
//			}
//		}

		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? NEWS_EDIT_SUCESSFULLY : NEWS_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
} else if ($ActionFlag == 'AddEditEmailtemplate') {
	$TableName = "tblemailtemplates";

	if ($_POST['SendTo'] != '' && !filter_var($_POST['SendTo'], FILTER_VALIDATE_EMAIL)) {
		$result['error'] = ERROR_EMAILFORMAT;
	}
	if ($result['error'] == '') {

		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;
		} else {
			$Query = "insert into $TableName set   ";
			$logaction = 1;
		}

		$Query .= "Title='" . secureTextForDb($_POST['Title']) . "',
					TitleAr='" . secureTextForDb($_POST['TitleAr']) . "', 
					Subject='" . secureTextForDb($_POST['Subject']) . "', 
					SubjectAr='" . secureTextForDb($_POST['SubjectAr']) . "', 
					SubmitFormMessage='" . secureTextForDb($_POST['SubmitFormMessage']) . "', 
					SubmitFormMessageAr='" . secureTextForDb($_POST['SubmitFormMessageAr']) . "', 
					SendTo='" . secureTextForDb($_POST['SendTo']) . "', 
					Message='" . secureTextForDb($_POST['Message']) . "' ,  
					MessageAr='" . secureTextForDb($_POST['MessageAr']) . "'
				   ";

		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModifiedDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;
		insertlogTable($TableName, $InsertRecordID, $logaction);

		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? NEWS_EDIT_SUCESSFULLY : NEWS_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
} else if ($ActionFlag == "AddMasterDataBySubCategory") {
	if ($Trigger != 'edit') {
		for ($i = 0; $i < count($_POST['Title']); $i++) {
			$Title = getFieldDataByID("TableID", "Title", secureTextForDb($_POST['Title'][$i]), $MasterTableName);
			//  $TitleAr = getFieldDataByID("TableID","TitleAr",secureTextForDb($_POST['TitleAr'][$i]),$MasterTableName);

			if ($_POST['Title'][$i] == '') {
				$result['error'] = ERROR_TITLE_ENGLISH;
			}

		}
	} else {

		$Title = getFieldDataByID("TableID", "Title", secureTextForDb($_POST['Title']), $MasterTableName);
		// $TitleAr = getFieldDataByID("TableID","TitleAr",secureTextForDb($_POST['TitleAr']),$MasterTableName);
		if ($Title > 0 && $Title != $RecordID) {
			$result['error'] = $_POST['Title'] . " " . ERROR_ALREADY_EXISTS;
		}

	}

	if ($Trigger != 'edit' && $result['error'] == '') {
		for ($i = 0; $i < count($_POST['Title']); $i++) {
			$count++;
			if ($result['error'] == '') {

				//   sitemap($_POST['url'], date('Y-m-d'), '0.64');


				$Sequence = maxID("Sequence", $MasterTableName, 1);
				$Query = "insert into " . $MasterTableName . " set ";

				$Query .= "Title='" . secureTextForDb($_POST['subCategory'][$i]) . "',  
							Active='" . secureTextForDb($_POST['Active']) . "',  
							Sequence='" . secureTextForDb($Sequence) . "'    
						   ";
				if ($_POST['TitleAr'][$i] != '')
					$Query .= " ,TitleAr = '" . secureTextForDb($_POST['TitleAr'][$i]) . "' 
						  ";

				if ($_POST['CountryID'] != '')
					$Query .= " ,CountryID = '" . secureTextForDb($_POST['CountryID']) . "' 
						  ";

				if ($_POST['CityID'][$i] != '')
					$Query .= " ,CityID = '" . secureTextForDb($_POST['CityID']) . "' 
						  ";

				if ($_POST['FlatType'][$i] != '')
					$Query .= " ,FlatType = '" . secureTextForDb($_POST['FlatType'][$i]) . "' 
						  ";

				if ($_POST['Prefix'][$i] != '')
					$Query .= " ,Prefix = '" . secureTextForDb($_POST['Prefix'][$i]) . "' 
						  ";

				if ($_POST['JobTypeID'][$i] != '')
					$Query .= " ,JobTypeID = '" . secureTextForDb($_POST['JobTypeID'][$i]) . "' 
						  ";


				$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
							CreatedDateTime=NOW()
						  ";

				$db->query($Query);
				$recordID = $db->MysqlInsertID();

				//insertlogTable($MasterTableName,$recordID,1);
			}
		}

	}
	if ($Trigger == 'edit' && $result['error'] == '') {

		$QueryUpdate = "Update " . $MasterTableName . " set ";

		$QueryUpdate .= "Title='" . secureTextForDb($_POST['subCategory']) . "', 
						Active='" . secureTextForDb($_POST['Active']) . "'    
					   ";

		if ($_POST['TitleAr'] != '')
			$QueryUpdate .= " ,TitleAr = '" . secureTextForDb($_POST['TitleAr']) . "' 
					  ";

		if ($_POST['CountryID'] != '')
			$QueryUpdate .= " ,CountryID = '" . secureTextForDb($_POST['CountryID']) . "' 
					  ";

		if ($_POST['CityID'][$i] != '')
			$QueryUpdate .= " ,CityID = '" . secureTextForDb($_POST['CityID']) . "' 
					  ";

		if ($_POST['FlatType'][$i] != '')
			$QueryUpdate .= " ,FlatType = '" . secureTextForDb($_POST['FlatType'][$i]) . "' 
					  ";

		if ($_POST['Prefix'][$i] != '')
			$QueryUpdate .= " ,Prefix = '" . secureTextForDb($_POST['Prefix'][$i]) . "' 
			
					  ";


		$QueryUpdate .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModifiedDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		$db->query($QueryUpdate);
		// insertlogTable($MasterTableName,$RecordID,2);
	}
	if ($result['error'] == '') {
		$result['success'] = 1;
		//if($_REQUEST['ImportData']==1)
		//$result['redirect']= 'index.php?'.EncodeUrl('action=viewallnormalmaster&SubLinkID=3&TableName='.$MasterTableName);
		//else
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID . '&TableName=' . $MasterTableName);
		$_SESSION['Message']['Msg'] = ($Trigger != 'edit') ? "Master Record Added Successfully" : "Master Record Updated Successfully";
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
} else if ($ActionFlag == "AddMasterData") {
	if (in_array($_FILES['logo']['type'], $AllowedImageExtension) && $_FILES['logo']['type'] != '') {
		$BannerImageWidth = getWidth($_FILES['logo']['tmp_name']);
		$BannerImageHeight = getHeight($_FILES['logo']['tmp_name']);
	}
	if ($Trigger != 'edit') {

		for ($i = 0; $i < count($_POST['Title']); $i++) {
			if ($SubLinkID == 5)
				$Title = getFieldDataByID2("TableID", "Title", "'" . secureTextForDb($_POST['Title'][$i]) . "' AND ParentID='" . $_POST['ParentID'] . "'", $MasterTableName);
			else
				$Title = getFieldDataByID("TableID", "Title", secureTextForDb($_POST['Title'][$i]), $MasterTableName);
			if ($_POST['Title'][$i] == '') {
				$result['error'] = ERROR_TITLE_ENGLISH;
			} else if (sizeof($Title) > 0) {
				$result['error'] = "This Title Already insert";
			}
		}
	} else {
		if ($SubLinkID == 5)
			$Title = getFieldDataByID2("TableID", "Title", "'" . secureTextForDb($_POST['Title']) . "' AND ParentID='" . $_POST['ParentID'] . "'", $MasterTableName);
		else
			$Title = getFieldDataByID("TableID", "Title", secureTextForDb($_POST['Title']), $MasterTableName);

		if ($Title > 0 && $Title != $RecordID) {
			$result['error'] = $_POST['Title'] . " " . ERROR_ALREADY_EXISTS;
		}
	}

	if ($Trigger != 'edit' && $result['error'] == '') {
		for ($i = 0; $i < count($_POST['Title']); $i++) {

			$count++;
			if ($result['error'] == '') {
				$url = "https://" . $_SERVER['HTTP_HOST'] . "/";

				if ($MasterTableName == "tblcategory")
					$url .= 'category/';
				else if ($MasterTableName == "tblcoupontype")
					$url .= 'type/';
				else if ($MasterTableName == "tblcoupontag")
					$url .= 'tag/';


				$Sequence = maxID("Sequence", $MasterTableName, 1);
				$Query = "insert into " . $MasterTableName . " set ";

				$Query .= "Title='" . secureTextForDb($_POST['Title'][$i]) . "',  
							Active='" . secureTextForDb($_POST['Active']) . "',  
							Sequence='" . secureTextForDb($Sequence) . "'
						   ";


				if ($_POST['ShowHome'] > 0)
					$Query .= " ,ShowHome = '" . secureTextForDb($_POST['ShowHome']) . "' 
						  ";

				if ($_POST['CountryID'] != '')
					$Query .= " ,CountryID = '" . secureTextForDb($_POST['CountryID']) . "' 
						  ";

				if ($_POST['URL'] != '')
					$Query .= " ,URL = '" . secureTextForDb($_POST['URL']) . "' ";


				if ($_POST['CountryTag'] != '')
					$Query .= " ,CountryTag = '" . secureTextForDb($_POST['CountryTag']) . "' 
						  ";

				if ($_POST['Currency'] != '')
					$Query .= " ,Currency = '" . secureTextForDb($_POST['Currency']) . "' 
						  ";

				if ($_POST['CountryKeyword'] != '')
					$Query .= " ,CountryKeyword = '" . secureTextForDb($_POST['CountryKeyword']) . "' 
						  ";

				if ($_POST['CityID'][$i] != '')
					$Query .= " ,CityID = '" . secureTextForDb($_POST['CityID']) . "' 
						  ";

				if ($_POST['ParentID'] != '')
					$Query .= " ,ParentID = '" . secureTextForDb($_POST['ParentID']) . "' 
						  ";

				if ($_POST['Prefix'][$i] != '')
					$Query .= " ,Prefix = '" . secureTextForDb($_POST['Prefix'][$i]) . "' 
						  ";

				if ($_POST['JobTypeID'][$i] != '')
					$Query .= " ,JobTypeID = '" . secureTextForDb($_POST['JobTypeID'][$i]) . "' 
						  ";

				if ($_POST['description'] != '')
					$Query .= " , description='" . secureTextForDb($_POST['description']) . "'";


				if ($_POST['NetID'] != '')
					$Query .= " ,NetID = '" . secureTextForDb($_POST['NetID']) . "' 
						  ";

				if ($_POST['NetDeepLinkCode'] != '')
					$Query .= " ,NetDeepLinkCode = '" . secureTextForDb($_POST['NetDeepLinkCode']) . "' 
						  ";

				if ($_POST['URLKeyword'] != '') {
					$Query .= ", URLKeyword='" . secureTextForDb($_POST['URLKeyword']) . "'";
					$url .= $_POST['URLKeyword'];
				}

				if ($_POST['tagDate'] != '')
					$Query .= ", tagDate='" . secureTextForDb($_POST['tagDate']) . "'";

				if ($_POST['MetaTitle'] != '')
					$Query .= ", MetaTitle='" . secureTextForDb($_POST['MetaTitle']) . "'";

				if ($_POST['MetaKeywords'] != '')
					$Query .= ", MetaKeywords='" . secureTextForDb($_POST['MetaKeywords']) . "'";

				if ($_POST['MetaDescription'] != '')
					$Query .= ", MetaDescription='" . secureTextForDb($_POST['MetaDescription']) . "'";

				$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
							CreatedDateTime=NOW()
						  ";

				$tmpBannerImage = $_FILES['logo']['tmp_name'];
				$FileNameBanner = date("YmdHis") . '-' . rand(0, 1000);
				$UploadBannerImage = $FileNameBanner . makeExtention($_FILES['logo']['type']);
				$FileNameBannerImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;
				$FileNameBannerImageCrop = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/cropthumb_' . $UploadBannerImage;

				if (move_uploaded_file($_FILES['logo']['tmp_name'], $FileNameBannerImage)) {
					$Query .= " , logo = '" . secureTextForDb($UploadBannerImage) . "' ";
				}
				$db->query($Query);
				$recordID = $db->MysqlInsertID();
				//insertlogTable($MasterTableName,$recordID,1);

				sitemap($url, date('Y-m-d'), '0.64');

			}
		}
	}
	if ($Trigger == 'edit' && $result['error'] == '') {

		$QueryUpdate = "Update " . $MasterTableName . " set ";

		$QueryUpdate .= "Title='" . secureTextForDb($_POST['Title']) . "', 
						Active='" . secureTextForDb($_POST['Active']) . "'    
					   ";

		if ($_POST['ShowHome'] != "")
			$QueryUpdate .= " ,ShowHome = '" . secureTextForDb($_POST['ShowHome']) . "' 
						  ";
		//	exit($_POST['ShowHome']);
//		if($_POST['URLKeyword']!='')
//			$QueryUpdate .= " ,URLKeyword = '".secureTextForDb($_POST['URLKeyword'])."'
//						  ";

		if ($_POST['CountryID'] != '')
			$QueryUpdate .= " ,CountryID = '" . secureTextForDb($_POST['CountryID']) . "' 
					  ";

		if ($_POST['CountryTag'] != '')
			$QueryUpdate .= " ,CountryTag = '" . secureTextForDb($_POST['CountryTag']) . "' 
						  ";

		if ($_POST['Currency'] != '')
			$QueryUpdate .= " ,Currency = '" . secureTextForDb($_POST['Currency']) . "' 
						  ";

		if ($_POST['CountryKeyword'] != '')
			$QueryUpdate .= " ,CountryKeyword = '" . secureTextForDb($_POST['CountryKeyword']) . "' 
						  ";


		if ($_POST['description'] != '')
			$QueryUpdate .= " , description='" . secureTextForDb($_POST['description']) . "'";

		if (isset($_POST['NetDeepLinkCode']))
			$QueryUpdate .= " ,NetDeepLinkCode = '" . secureTextForDb($_POST['NetDeepLinkCode']) . "' 
						  ";

		if ($_POST['CityID'][$i] != '')
			$QueryUpdate .= " ,CityID = '" . secureTextForDb($_POST['CityID']) . "' 
					  ";

		if (isset($_POST['ParentID']))
			$QueryUpdate .= " ,ParentID = '" . secureTextForDb($_POST['ParentID'][$i]) . "' 
					  ";

		if ($_POST['Prefix'][$i] != '')
			$QueryUpdate .= " ,Prefix = '" . secureTextForDb($_POST['Prefix'][$i]) . "' 
					  ";

		if ($_POST['NetID'] != "")
			$QueryUpdate .= " ,NetID = '" . secureTextForDb($_POST['NetID']) . "' 
						  ";

		if ($_POST['tagDate'] != '')
			$QueryUpdate .= ", tagDate='" . secureTextForDb($_POST['tagDate']) . "'";

		if ($_POST['MetaTitle'] != '')
			$QueryUpdate .= ", MetaTitle='" . secureTextForDb($_POST['MetaTitle']) . "'";

		if ($_POST['MetaKeywords'] != '')
			$QueryUpdate .= ", MetaKeywords='" . secureTextForDb($_POST['MetaKeywords']) . "'";

		if ($_POST['MetaDescription'] != '')
			$QueryUpdate .= ", MetaDescription='" . secureTextForDb($_POST['MetaDescription']) . "'";


		$tmpBannerImage = $_FILES['logo']['tmp_name'];
		$FileNameBanner = date("YmdHis") . '-' . rand(0, 1000);
		$UploadBannerImage = $FileNameBanner . makeExtention($_FILES['logo']['type']);
		$FileNameBannerImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;
		$FileNameBannerImageCrop = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/cropthumb_' . $UploadBannerImage;

		if (move_uploaded_file($_FILES['logo']['tmp_name'], $FileNameBannerImage)) {
			$QueryUpdate .= " , logo = '" . secureTextForDb($UploadBannerImage) . "' ";
		}

		$QueryUpdate .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModifiedDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";

		$db->query($QueryUpdate);

		// insertlogTable($MasterTableName,$RecordID,2);
	}
	if ($result['error'] == '') {
		$result['success'] = 1;
		//if($_REQUEST['ImportData']==1)
		//$result['redirect']= 'index.php?'.EncodeUrl('action=viewallnormalmaster&SubLinkID=3&TableName='.$MasterTableName);
		//else
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID . '&TableName=' . $MasterTableName);
		$_SESSION['Message']['Msg'] = ($Trigger != 'edit') ? "Master Record Added Successfully" : "Master Record Updated Successfully";
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
} else if ($ActionFlag == 'AddEditStore') {
	$TableName = "tblstore";
	if (isset($_POST['URLKeyword']))
		$URLKeywordDublicate = getFieldDataByID("TableID", "URLKeyword", $_POST['URLKeyword'], $TableName);

	if (isset($_POST['name']))
		$NameDublicate = getFieldDataByID2("TableID", "name", "'" . $_POST['name'] . "' AND CountryID='" . $_POST['CountryID'] . "'", $TableName);

	if (in_array($_FILES['logo']['type'], $AllowedImageExtension) && $_FILES['logo']['type'] != '') {
		$logoImageWidth = getWidth($_FILES['logo']['tmp_name']);
		$logoImageHeight = getHeight($_FILES['logo']['tmp_name']);
	}
	else {
		$logoImageWidth = 0;
		$logoImageHeight = 0;
	}
	if ($URLKeywordDublicate > 0 && $RecordID != $URLKeywordDublicate && $Trigger == 'edit') {
		$result['error'] = ERROR_PAGE_URL;
	} else if ($NameDublicate > 0 && $RecordID != $NameDublicate) {
		$result['error'] = "This store name already existes in this country";
	} else if (!in_array($_FILES['logo']['type'], $AllowedImageExtension) && $_FILES['logo']['type'] != '') {
		$result['error'] = ERROR_PAGE_BANNER_CHOOSE;
	} else if (!in_array($_FILES['logo']['type'], $AllowedImageExtension) && $_FILES['logo']['type'] != '') {
		$result['error'] = ERROR_THUMBNAIL_IMAGE_CHOOSE;
	} else if ($logoImageWidth > 0 && ($logoImageWidth != INNER_PAGE_BANNER_WIDTH || $logoImageHeight != INNER_PAGE_BANNER_HEIGHT)) {
		// $result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT.INNER_PAGE_BANNER_WIDTH."x".INNER_PAGE_BANNER_HEIGHT;
	}

	if ($URLKeywordDublicate > 0 && $RecordID != $URLKeywordDublicate && $Trigger == 'edit') {
		$result['error'] = ERROR_PAGE_URL;
	}

	if ($result['error'] == '') {
		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;

		} else {
			$Query = "insert into $TableName set   ";
			$logaction = 1;
			$_POST['MetaTitle'] = (!empty($_POST['MetaTitle'])) ? $_POST['MetaTitle'] : (isset($_POST['Title']) ? $_POST['Title'] : '');
			$_POST['MetaTitleAr'] = (!empty($_POST['MetaTitleAr'])) ? $_POST['MetaTitleAr'] : (isset($_POST['TitleAr']) ? $_POST['TitleAr'] : '');

			sitemap($_POST['url'], date('Y-m-d'), '0.64');
		}

		$Query .= "name='" . secureTextForDb($_POST['name'] ?? '') . "',
				url='" . secureTextForDb($_POST['url'] ?? '') . "', 
				storeDate='" . secureTextForDb($_POST['storeDate'] ?? '') . "', 
				domain='" . secureTextForDb($_POST['domain'] ?? '') . "' ,  
				webUrl='" . secureTextForDb($_POST['webUrl'] ?? '') . "' ,  
				trackingUrl='" . secureTextForDb($_POST['trackingUrl'] ?? '') . "' ,
				Active='" . secureTextForDb($_POST['Active'] ?? '') . "' ,  
				ShowHome='" . secureTextForDb($_POST['ShowHome'] ?? '') . "' ,  
				CountryID='" . secureTextForDb($_POST['CountryID'] ?? '') . "' ,  
				NetworkID='" . secureTextForDb($_POST['NetworkID'] ?? '') . "' ,  
				storeIDActiveNetwork='" . secureTextForDb($_POST['storeIDActiveNetwork'] ?? '') . "' ,  
				CategoryID='" . secureTextForDb(isset($_POST['CategoryID']) ? implode(",", (array)$_POST['CategoryID']) : '') . "' ,  
				impressionCode='" . secureTextForDb($_POST['impressionCode'] ?? '') . "' ,   
				discount='" . secureTextForDb($_POST['discount'] ?? '') . "' , 
				fbUrl='" . secureTextForDb($_POST['fbUrl'] ?? '') . "' , 
				votes='" . secureTextForDb($_POST['votes'] ?? '') . "' ,
				H1='" . secureTextForDb($_POST['H1'] ?? '') . "' ,  
				H2='" . secureTextForDb($_POST['H2'] ?? '') . "' ,
				about='" . secureTextForDb($_POST['aboutStore'] ?? '') . "' ,  
				description='" . secureTextForDb($_POST['description'] ?? '') . "' ,
				MetaTitle='" . secureTextForDb($_POST['MetaTitle'] ?? '') . "' ,
				MetaKeywords='" . secureTextForDb($_POST['MetaKeywords'] ?? '') . "' ,
				MetaDescription='" . secureTextForDb($_POST['MetaDescription'] ?? '') . "' ,
				SimilarStoreID='" . secureTextForDb(isset($_POST['SimilarStore']) ? implode(",", (array)$_POST['SimilarStore']) : '') . "' ,
				storeAdd = '" . secureTextForDb($_POST['storeAdd'] ?? '') . "',
				rating='" . secureTextForDb($_POST['rating'] ?? '') . "' ";

		if ($_POST['URLKeyword'] == '') {
			$URLKeyword = $_POST['URLKeyword'];
			$URLKeyword = SEOFriendlyURL($URLKeyword);

			$URLKeyword = SEOFriendlyPageURL($URLKeyword, $URLKeyword, $TableName);
		} else {
			$URLKeyword = $_POST['URLKeyword'];
			$URLKeyword = $URLKeyword;
		}

		if ($URLKeyword != '')
			$Query .= " , URLKeyword = '" . secureTextForDb($URLKeyword) . "' ";

		$tmplogoImage = $_FILES['logo']['tmp_name'];
		$FileNamelogo = date("YmdHis") . '-' . rand(0, 1000);
		$UploadlogoImage = $FileNamelogo . makeExtention($_FILES['logo']['type']);
		$FileNamelogoImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadlogoImage;
		$FileNamelogoImageCrop = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadlogoImage;

		if (move_uploaded_file($_FILES['logo']['tmp_name'], $FileNamelogoImage)) {
			$Query .= " , logo = '" . secureTextForDb($UploadlogoImage) . "' ";
		}


		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModifiedDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;
		if ($Trigger == 'edit') {
			$sql = "delete from tblstorecategory  Where StoreID='" . $RecordID . "';";
			$db->query($sql);
			$sql = "delete from  tblsimilarstore  Where StoreID='" . $RecordID . "';";
			$db->query($sql);
		}

		foreach ($_POST['CategoryID'] as $a) {
			$sql = "insert into tblstorecategory set  StoreID='" . secureTextForDb($InsertRecordID) . "',
					CategoryID='" . secureTextForDb($a) . "';";
			$db->query($sql);
		}

		foreach ($_POST['SimilarStore'] as $a) {
			$sql = "insert into tblsimilarstore set  StoreID='" . secureTextForDb($InsertRecordID) . "',
					SimilarStoreID='" . secureTextForDb($a) . "';";
			$db->query($sql);
		}

		//        insertlogTable($TableName,$InsertRecordID,$logaction);
		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? NEWS_EDIT_SUCESSFULLY : NEWS_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
} else if ($ActionFlag == 'AddEditCoupon') {
	$TableName = "tblcoupon";
	$URLKeywordDublicate = 0;
	if (isset($_POST['URLKeyword']) && $_POST['URLKeyword'] != '')
		$URLKeywordDublicate = getFieldDataByID("TableID", "URLKeyword", $_POST['URLKeyword'], $TableName);

	$logoType = $_FILES['logo']['type'] ?? '';
	$logoTmpName = $_FILES['logo']['tmp_name'] ?? '';
	$BannerImageWidth = 0;
	$BannerImageHeight = 0;
	if (in_array($logoType, $AllowedImageExtension) && $logoType != '') {
		$BannerImageWidth = getWidth($logoTmpName);
		$BannerImageHeight = getHeight($logoTmpName);
	}

	$thumbnailType = $_FILES['ThumbnailImage']['type'] ?? '';

	if ($URLKeywordDublicate > 0 && $RecordID != $URLKeywordDublicate && $Trigger == 'edit') {
		//		$result['error'] = ERROR_PAGE_URL;
	} else if (!in_array($logoType, $AllowedImageExtension) && $logoType != '') {
		$result['error'] = ERROR_PAGE_BANNER_CHOOSE;
	} else if (!in_array($thumbnailType, $AllowedImageExtension) && $thumbnailType != '') {
		$result['error'] = ERROR_THUMBNAIL_IMAGE_CHOOSE;
	} else if ($BannerImageWidth > 0 && ($BannerImageWidth != INNER_PAGE_BANNER_WIDTH || $BannerImageHeight != INNER_PAGE_BANNER_HEIGHT)) {
		// $result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT.INNER_PAGE_BANNER_WIDTH."x".INNER_PAGE_BANNER_HEIGHT;
	}


	if ($result['error'] == '') {

		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;
		} else {
			$Sequence = maxID("Sequence", $TableName, 1);
			$Query = "insert into $TableName set  Sequence=$Sequence , ";
			$logaction = 1;
			$_POST['MetaTitle'] = (($_POST['MetaTitle'] ?? '') == "") ? ($_POST['Title'] ?? '') : $_POST['MetaTitle'];
			$_POST['MetaTitleAr'] = (($_POST['MetaTitleAr'] ?? '') == "") ? ($_POST['TitleAr'] ?? '') : $_POST['MetaTitleAr'];

			// 			sitemap($_POST['url'], date('Y-m-d'), '0.64');
		}

		$ShowHome = 0;
		if (($_POST['ShowHome'] ?? 0) == 1) {
			$ShowHome = 1;
		}

		$couponTagID = trim($_POST['CouponTagID'] ?? '');
		$Query .= "CouponName='" . secureTextForDb($_POST['CouponName'] ?? '') . "',
					url='" . secureTextForDb($_POST['url'] ?? '') . "',  
					trackingLink='" . secureTextForDb($_POST['trackingLink'] ?? '') . "', 
					landingLink='" . secureTextForDb($_POST['landingLink'] ?? '') . "' ,  
					webUrl='" . secureTextForDb($_POST['webUrl'] ?? '') . "' ,  
					Active='" . secureTextForDb($_POST['Active'] ?? '') . "' ,   
					ShowHome='" . secureTextForDb($ShowHome) . "' ,    
					CouponTagID=" . ($couponTagID === '' ? "NULL" : (int)$couponTagID) . ", 
					startDate='" . secureTextForDb($_POST['startDate'] ?? '') . "' , 
					endDate='" . secureTextForDb($_POST['endDate'] ?? '') . "' ,  
					StoreID='" . secureTextForDb($_POST['StoreID'] ?? '') . "' ,  
					upVotes='" . secureTextForDb($_POST['upVotes'] ?? 0) . "' , 
					downVotes='" . secureTextForDb($_POST['downVotes'] ?? 0) . "' , 
					featured='" . secureTextForDb($_POST['featured'] ?? 0) . "' ,  
					sitewide='" . secureTextForDb($_POST['sitewide'] ?? '') . "' ,
					couponCode='" . secureTextForDb($_POST['couponCode'] ?? '') . "' ,
					discount='" . secureTextForDb($_POST['discount'] ?? '') . "' ,  
					couponClassification='" . secureTextForDb($_POST['couponClassification'] ?? '') . "' ,
					CategoryID='" . secureTextForDb(implode(",", $_POST['CategoryID'] ?? [])) . "' ,
					CouponTypeID='" . secureTextForDb(implode(",", $_POST['CouponTypeID'] ?? [])) . "' ,
					MetaTitle='" . secureTextForDb($_POST['MetaTitle'] ?? '') . "' ,
					MetaKeywords='" . secureTextForDb($_POST['MetaKeywords'] ?? '') . "' ,
					MetaDescription='" . secureTextForDb($_POST['MetaDescription'] ?? '') . "' ,
					description='" . secureTextForDb($_POST['description'] ?? '') . "'    
				   ";
		// echo "<script>alert(" . $Query . ");</script>";
		// exit; alert is not working here because of json encode in the end of this file

		if (($_POST['URLKeyword'] ?? '') == '') {
			$URLKeyword = $_POST['URLKeyword'] ?? '';
			$URLKeyword = SEOFriendlyURL($URLKeyword);

			$URLKeyword = SEOFriendlyPageURL($URLKeyword, $URLKeyword, $TableName);
		} else {
			$URLKeyword = $_POST['URLKeyword'];
			$URLKeyword = $URLKeyword;
		}

		if ($URLKeyword != '')
			$Query .= " , URLKeyword = '" . secureTextForDb($URLKeyword) . "' ";


		if (isset($_FILES['logo']['tmp_name']) && $_FILES['logo']['tmp_name'] != '') {
			$tmpBannerImage = $_FILES['logo']['tmp_name'];
			$FileNameBanner = date("YmdHis") . '-' . rand(0, 1000);
			$UploadBannerImage = $FileNameBanner . makeExtention($logoType);
			$FileNameBannerImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;
			$FileNameBannerImageCrop = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;

			if (move_uploaded_file($tmpBannerImage, $FileNameBannerImage)) {
				$Query .= " , logo = '" . secureTextForDb($UploadBannerImage) . "' ";
				//			CropimageSave($_POST['ImageCropData1'],$FileNameBannerImageCrop);
			}
		}



		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModifiedDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreatedDateTime=NOW()
					  ";
		$db->query($Query);
		//  echo "<script>alert(" . $Query . ");</script>";
		// exit();
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;
		if ($Trigger == 'edit') {
			$sql = "delete from tblcouponcategory  Where CouponID='" . $RecordID . "';";
			$db->query($sql);
			$sql = "delete from tblcouponstypes  Where CouponID='" . $RecordID . "';";
			$db->query($sql);
		}


		foreach (($_POST['CategoryID'] ?? []) as $a) {
			$sql = "insert into tblcouponcategory set  CouponID='" . secureTextForDb($InsertRecordID) . "',
				CategoryID='" . secureTextForDb($a) . "';";
			$db->query($sql);
		}

		foreach (($_POST['CouponTypeID'] ?? []) as $a) {
			$sql = "insert into tblcouponstypes set  CouponID='" . secureTextForDb($InsertRecordID) . "',
				CouponTypeID='" . secureTextForDb($a) . "';";
			$db->query($sql);
		}


		// Get Store Category here

		if (isset($_POST['StoreID']) && $_POST['StoreID'] != '' && count($_POST['CategoryID'] ?? []) > 0) {
			$sql = "select * from tblstorecategory where StoreID = " . $_POST['StoreID'];
			$db->query($sql);
			while ($db->next_Record()) {
				$InsertCoponCategory = "insert into tblcouponcategory set CouponID='" . $InsertRecordID . "' , CategoryID = " . $db->f('CategoryID');
				$db1->query($InsertCoponCategory);
			}
		}


		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		// $result['sql'] = $Query;
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? NEWS_EDIT_SUCESSFULLY : NEWS_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}
	// print_r($Query);
	// exit;
	echo json_encode($_POST);
} else if ($ActionFlag == 'AddEditSlider') {
	$TableName = "tblslider";

	if (!in_array($_FILES['Name']['type'], ["image/jpeg", "image/jpg", "image/png"]) && $_FILES['Name']['type'] != '') {
		$result['error'] = ERROR_PAGE_BANNER_CHOOSE;
	}


	if ($result['error'] == '') {

		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;
		} else {
			$Sequence = maxID("Sequence", $TableName, 1);
			$Query = "insert into $TableName set  Sequence=$Sequence , ";
			$logaction = 1;
		}

		$ShowHome = 0;
		if ($_POST['ShowHome'] == 1) {
			$ShowHome = 1;
		}

		$Query .= "URL='" . secureTextForDb($_POST['URL']) . "',
		            couponClassification='" . secureTextForDb($_POST['couponClassification']) . "',
					couponCode='" . secureTextForDb($_POST['couponCode']) . "',
					Title='" . secureTextForDb($_POST['Title']) . "',
					description='" . $_POST['description'] . "',
					Active='" . secureTextForDb($_POST['Active']) . "'    
				   ";

		$tmpBannerImage = $_FILES['Name']['tmp_name'];
		$FileNameBanner = date("YmdHis") . '-' . rand(0, 1000);
		$UploadBannerImage = $FileNameBanner . makeExtention($_FILES['Name']['type']);
		$FileNameBannerImage = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;
		$FileNameBannerImageCrop = '../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $UploadBannerImage;

		if (move_uploaded_file($_FILES['Name']['tmp_name'], $FileNameBannerImage)) {
			$Query .= " , Name = '" . secureTextForDb($UploadBannerImage) . "' ";
			//			CropimageSave($_POST['ImageCropData1'],$FileNameBannerImageCrop);
		}

		//		$file_name = $_FILES['Name']['name'];
//		$file_tmp =$_FILES['Name']['tmp_name'];
//		if(move_uploaded_file($_FILES['Name']['tmp_name'], "files/sliderImg/".$file_name))
//		{
//			$Query .= " , Name = '".$_FILES['Name']['tmp_name']."' ";
//		}


		if ($Trigger == 'edit')
			$Query .= " , ModifiedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						ModificationDateTime=NOW()
						Where TableID='" . $RecordID . "'
					  ";
		else
			$Query .= " ,CreatedBy = '" . $_SESSION[WEB_SESSION . '_userid'] . "',
						CreationDateTime=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;

		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? NEWS_EDIT_SUCESSFULLY : NEWS_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($_POST);
	//echo "<script>alert(". json_encode($result) . ");</script>";
} else if ($ActionFlag == 'AddEditPublicationForm') {
	$TableName = "tblpolicy";

	if (!in_array($_FILES['Name']['type'], ["image/jpeg", "image/jpg", "image/png"]) && $_FILES['Name']['type'] != '') {
		$result['error'] = ERROR_PAGE_BANNER_CHOOSE;
	}


	if ($result['error'] == '') {

		if ($Trigger == 'edit') {
			$Query = "update $TableName set ";
			$logaction = 2;
		} else {
			$Sequence = maxID("Sequence", $TableName, 1);
			$Query = "insert into $TableName set ";
			$logaction = 1;
		}

		$ShowHome = 0;
		if ($_POST['ShowHome'] == 1) {
			$ShowHome = 1;
		}

		$Query .= "Title='" . secureTextForDb($_POST['Title']) . "',
					Description='" . secureTextForDb($_POST['Description']) . "'
				   ";


		if ($Trigger == 'edit') {
			// $Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
			// 			ModificationDateTime=NOW()
			// 			Where TableID='".$RecordID."'
			// 		  ";
			$Query .= "Where id=" . $RecordID . "";

		}
		// else
		// 	$Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
		// 				CreationDateTime=NOW()
		// 			  ";

		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit' ? $db->MysqlInsertID() : $RecordID;

		$result['success'] = 1;
		$result['redirect'] = 'index.php?' . EncodeUrl('action=' . $action . '&SubLinkID=' . $SubLinkID);
		$_SESSION['Message']['Msg'] = $Trigger == 'edit' ? NEWS_EDIT_SUCESSFULLY : NEWS_ADDED_SUCESSFULLY;
		$_SESSION['Message']['Type'] = 2;
	}

	echo json_encode($result);
}

if (isset($_REQUEST['updateStatus']) && $_REQUEST['updateStatus'] != "") {
	$active = $_REQUEST['updateStatus'];
	echo $active;
}
//include_once("ajax_functions_ali.php");





?>
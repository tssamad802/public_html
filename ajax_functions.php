<?php
$localSessionPath = __DIR__ . DIRECTORY_SEPARATOR . 'sessions';
if (is_dir($localSessionPath) && is_writable($localSessionPath)) {
	session_save_path($localSessionPath);
}
session_start();
include_once("classes/commonfunctions.php");
include_once("classes/ajaxpagination.class.php");

DecodeUrl();
//load dashboard language files
if (!isset($_SESSION['Frontendlanguage']) || $_SESSION['Frontendlanguage'] == '')
    include_once("lang/en.php");
else
    include_once("lang/" . $_SESSION['Frontendlanguage'] . ".php");

//fetch current logged in user details
$UserRecordGetting = FetchRecordByID($_SESSION[WEB_SESSION.'_userid'],"TableID","tblsystemusers");
$Action = '';
$FormAction = '';
if(isset($_REQUEST['actions']))
	$Action = decodeencriptstring($_REQUEST['actions']);


if(isset($_REQUEST['Action']))
	$FormAction = decodeencriptstring($_REQUEST['Action']);


if($_SERVER['HTTP_REFERER'] == '' || $_SERVER['HTTP_X_REQUESTED_WITH'] == '')
{
	die("Direct Access Not Allowed");
}
$result = array("error"=>"","success"=>"","redirect"=>"","selfredirect"=>"","html" => '',"divtoplace" => "","downloadgraphlink" => "","redirecturl" => "","ShowinPopup" => "","OpenInNewWindow" => "","divid" => "","closepopup" => "","hidedivbox" => "","muntipledivdata" => "","blanckdivbox" => "");
if($_REQUEST['actions'] != "ChangeLanguage" && $Action != "SaveDownload" && $FormAction != "WatchCourseVideo" && $_REQUEST['Action']  !='ajaxsearchautocompele')
{
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);
	if($csrf->check_valid('post')) {
		//var_dump($_POST[$token_id]);
	} else {
		$result['successMsg'] = "Direct Access Not Allowed";
		$result['success'] = 0;
		echo json_encode($result);

		die();
	}
}
// Change Langugage

if ($_REQUEST['actions'] == "ChangeLanguage") {
	$_SESSION['Frontendlanguage'] = $_REQUEST['SessionLang'];
}
else if ($Action == "SaveDownload") {
	$catid = decodeencriptstring($_REQUEST['catid']);
	$PubDet = FetchRecordByID($catid,"TableID","tblpublications");
	$FileName = $PubDet['FileName'.LANG_SEP_DB];
	$Title = $PubDet['Title'.LANG_SEP_DB];
	$db->query("insert into tbldownload_log set UserIP='".$_SERVER['REMOTE_ADDR']."', UserID='".$_SESSION[WEB_SESSION_FRONT.'_frontuser']."', Publication_ID='".$catid."', DateTime=NOW()");

	$result['download'] = 1;
	$result['Link'] = RESOURCES_DOMAIN.'/'.FILES_FOLDER.'/'.DOCUMENT_FOLDER.'/'.$FileName;
	$result['FileName'] = $Title;

	echo json_encode($result);

}

elseif ($FormAction == "subscribeForm") {

	$email = $_REQUEST['Email'];
    $name = $_REQUEST['username'];
    $phone = $_REQUEST['phone'];
	$maildetails = FetchRecordByID(4,"TableID","tblemailtemplates");
	$MailSubject = $maildetails['Subject'.LANG_SEP_DB];
	$MailMessage = $maildetails['Message'.LANG_SEP_DB];
	$MailSendTo = $maildetails['SendTo'];
	$FormSuccess = $maildetails['SubmitFormMessage'.LANG_SEP_DB];

		//    $MailMessageAdmin = '
		// 		   <table width="100%"  border="0" cellspacing="2" cellpadding="10" class="data-table2" >
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Name : </td>
		// 				   <td>'.$name.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Email : </td>
		// 				   <td>'.$email.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td>Phone : </td>
		// 				   <td>'.$phone.'</td>
		// 			   </tr>';
		// 			   </table>';


		//    SendMail($MailSendTo, TXT_SUBSCRIPTION_TYPE_TEXT, $MailMessageAdmin,$email);

		//    SendMailToUser($email, $MailSubject, $MailMessage, $name);


	$query = "select * from tblnewslettercontact where Email= '".$email."'";
	$db->query($query);
	if($db->num_rows() > 0)
	{

		$result['successMsg'] = TXT_SUBSCRIPTION_ERROR_MSG;
		$result['success'] = 0;
	}else{
		$Query = "insert into tblnewslettercontact set 
		FullName = '".$name."',
		Email = '".$email."',
		MobileNumber = '".$phone."',
		Subscribe  = 0,
		CategoryID = 1,
		IsWebsite  = 1
				";
		$db->query($Query);

		$result['success'] = 1;
		$result['successMsg'] = $FormSuccess;
	}




	   echo json_encode($result);
}
else if ($FormAction == "RegisterUser") {
	$result['Gender'] = '';
	$result['FullName'] = '';
	$result['Nationality'] = '';
	$result['DOB'] = '';
	$result['Mobile'] = '';
	$result['Country_Residence'] = '';
	$result['Email'] = '';
	$result['Password'] = '';
	$result['ConfirmPassword'] = '';
	$emailcount = getCountRecord('tbluserregistration','Email',$_POST['Email']);
	if($_POST['Gender'] == '')
	{
		$result['error'] = 1;
		$result['Gender'] = ERROR_GENDER;
	}
	if($_POST['FullName'] == '')
	{
		$result['error'] = 1;
		$result['FullName'] = ERROR_FULLNAME;
	}
	if($_POST['Nationality'] == '')
	{
		$result['error'] = 1;
		$result['Nationality'] = ERROR_NATIONALITY;
	}
	if($_POST['DOB'] == '')
	{
		$result['error'] = 1;
		$result['DOB'] = ERROR_DOB;
	}
	if($_POST['Mobile'] == '' || strlen($_POST['Mobile']) < 9 || is_numeric($_POST['Mobile']) != 1)
	{
		$result['error'] = 1;
		$result['Mobile'] = ERROR_MOBILE;
	}
	if($_POST['Country_Residence'] == '')
	{
		$result['error'] = 1;
		$result['Country_Residence'] = ERROR_COUNTRYRESIDENCE;
	}
	if(!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL))
	{
		$result['error'] = 1;
		$result['Email'] = ERROR_EMAIL;
	}
	else if($emailcount != 0)
	{
		$result['error'] = 1;
		$result['Email'] = ERROR_EMAIL_REGISTERED;
	}
	if($_POST['Password'] == '')
	{
		$result['error'] = 1;
		$result['Password'] = ERROR_PASSWORD;
	}
	if($_POST['PasswordStrength'] < 3 && $_POST['Password'] != '')
	{
		$result['error'] = 1;
		$result['Password'] = ERROR_PASSWORD;
	}
	if($_POST['Password'] != $_POST['ConfirmPassword'])
	{
		$result['error'] = 1;
		$result['ConfirmPassword'] = ERROR_CONFIRMPASSWORD;
	}
	if($result['error'] == '')
	{
		$Password=sha1($_POST['Password']);
		$RegID = GenerateUniqueID('tblcomplaintform','R');
		$Query = "insert into tbluserregistration set ";
		$Query .=  "Gender='".secureTextForDb($_POST['Gender'])."',
					FullName='".secureTextForDb($_POST['FullName'])."', 
					NationalityID='".secureTextForDb($_POST['Nationality'])."' , 
					DOB='".secureTextForDb($_POST['DOB'])."' , 
					Mobile='".secureTextForDb($_POST['Mobile'])."' , 
					Country_ResidenceID='".secureTextForDb($_POST['Country_Residence'])."' , 
					Email='".secureTextForDb($_POST['Email'])."' ,  
					RegID='".secureTextForDb($RegID)."' ,  
					Password='".secureTextForDb($Password)."'
				   ";
		$Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreationDate=NOW()
					  ";

		$db->query($Query);
		$InsertRecordID = $db->MysqlInsertID();
		insertlogTable('tbluserregistration',$InsertRecordID,1);

		$InsertPasswordHistory =  "insert into tblwebuserpasswords set UserID='".$InsertRecordID."',Password='".secureTextForDb($Password)."', DateTime=NOW()";
		$db->query($InsertPasswordHistory);

		$activationlink = DOMAINNAME.'/activateuser.html?'.EncodeUrl('userid='.$InsertRecordID);
		$Fromemail = $_POST['Email'];
		$maildetails = FetchRecordByID(2,"TableID","tblemailtemplates");
		$MailSendTo = $_POST['Email'];
		$MailSubject = $maildetails['Subject'.LANG_SEP_DB];
		$MailMessage = str_replace("{USERNAME}",$_POST['FullName'],$maildetails['Message'.LANG_SEP_DB]);
		$MailMessage = str_replace("{ACTIVATIONLINK}",$activationlink,$MailMessage);
		// SendMailToUser($MailSendTo, $MailSubject, $MailMessage, $_POST['FullName']);

		/****mail to admin****/
		$Gender = ($_POST['Gender']==1)?TXT_MALE:TXT_FEMALE;
		$Nationality = getFieldDataByID('Nationality'.LANG_SEP_DB,'TableID',$_POST['Nationality'],'blcountries');
		$Country = getFieldDataByID('Name'.LANG_SEP_DB,'TableID',$_POST['Country_Residence'],'blcountries');
		$MailMessageAdmin = '
		 		   <table width="100%"  border="0" cellspacing="2" cellpadding="10" class="data-table2" >
		 			   <tr style="background:#f1f1f1;">
		 				   <td width="20%">Name : </td>
		 				   <td>'.$_POST['FullName'].'</td>
		 			   </tr>
					   <tr style="background:#f1f1f1;">
		 				   <td width="20%">Gender : </td>
		 				   <td>'.$Gender.'</td>
		 			   </tr>
					   <tr style="background:#f1f1f1;">
		 				   <td width="20%">DOB : </td>
		 				   <td>'.$_POST['DOB'].'</td>
		 			   </tr>
					   <tr style="background:#f1f1f1;">
		 				   <td width="20%">Nationality : </td>
		 				   <td>'.$_POST['DOB'].'</td>
		 			   </tr>
					   <tr style="background:#f1f1f1;">
		 				   <td width="20%">Country of Residence : </td>
		 				   <td>'.$Country.'</td>
		 			   </tr>
		 			   <tr style="background:#f1f1f1;">
		 				   <td width="20%">Email : </td>
		 				   <td>'.$_POST['Email'].'</td>
					   </tr>
					   <tr style="background:#f1f1f1;">
		 				   <td>Mobile : </td>
		 				   <td>'.$_POST['Mobile'].'</td>
		 			   </tr>
					   </table>';


		//    SendMail($MailSendTo, TXT_REGISTERFORM_SUBMISSION, $MailMessageAdmin,$Fromemail);


		$result['link'] = $activationlink;
		$result['successMsg'] = getFieldDataByID('SubmitFormMessage'.LANG_SEP_DB,'TableID',2,'tblemailtemplates');
		$result['success'] = 1;

	}

	echo json_encode($result);
}

else if($FormAction=="LoginUser")
{
	if(!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL))
	{
		$result['error'] = 1;
		$result['Email'] = ERROR_EMAIL;
	}
	if($_REQUEST["Password"]=='')
	{
		$result['error'] = 1;
		$result['Password'] = TXT_ENTERPASSWORD;
	}

	if($result['error'] == '')
	{
		$Password=sha1($_REQUEST['Password']);
		$CheckUserQuery = "select TableID,Status from tbluserregistration
		where 
		Email='$_REQUEST[Email]' and 
		Password='$Password'";
		$db->query($CheckUserQuery);
		$db->next_Record();
		$CountRecords = $db->num_rows();
		if($CountRecords==0)
		{
			$result['error'] = 1;
			$result['InvalidCred'] = ERROR_LOGINERROR;
			$db->query("insert into tbluserregistration_login_log set Email='".$_REQUEST['Email']."', Reason='1', UserIP='".$_SERVER['REMOTE_ADDR']."', Status=0, DateTime=NOW(), Type=1");

		}
		else if($db->f('Status')==0)
		{
			$result['error'] = 1;
			$result['InvalidCred'] = ERROR_ACCOUNT_INACTIVE;
			$db->query("insert into tbluserregistration_login_log set Email='".$_REQUEST['Email']."', Reason='2', UserIP='".$_SERVER['REMOTE_ADDR']."', Status=0, DateTime=NOW(), Type=1");

		}
		else
		{

					session_regenerate_id(true);
					$_SESSION['front_sessionid'] = session_id().'::F';
					$_SESSION[session_id().'::F'.'_frontuser'] = $db->f(0);
					$UserID = $db->f(0);

					$result['success'] = 1;
					if($_REQUEST['RedirectURL']!='')
					$result['redirect']= "http://".$_SERVER['HTTP_HOST'].$_REQUEST['RedirectURL'];
					else
					$result['redirect']= "dashboard.html";
					$db->query("update tbluserregistration set SessionID='".$_SESSION['front_sessionid']."' where TableID='".$UserID."'");
					$db->query("insert into tbluserregistration_login_log set Email='".$_REQUEST['Email']."',UserID='".$UserID."', UserIP='".$_SERVER['REMOTE_ADDR']."', Status=1, DateTime=NOW(), Type=1");
					$LogID = $db->MysqlInsertID();
					$db->query("insert into tbluserregistration_activelogin set UserID='".$UserID."', SessionID='".$_SESSION['front_sessionid']."', LogID='".$LogID."'");


		}
	}


	echo json_encode($result);
}

else if($FormAction=="ForgotPassword")
{
	$emailcount = getCountRecord('tbluserregistration','Email',$_POST['Email']);
	if(!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL))
	{
		$result['error'] = 1;
		$result['Email'] = ERROR_EMAIL;
	}
	else if($emailcount == 0)
	{
		$result['error'] = 1;
		$result['Email'] = ERROR_EMAIL_NOTREGISTERED;
	}

	if($result['error'] == '')
	{
		$UserDet = FetchRecordByID($_POST['Email'],"Email","tbluserregistration");
		$PassID = GenerateUniqueID('tblforgotpassword','F');
		$UserID = $UserDet['TableID'];
		$db->query("insert into tblforgotpassword set UserID='".$UserID."', PassID='".$PassID."', 	DateTime=NOW()");

		$resetlink = DOMAINNAME.'/reset-password.html?'.EncodeUrl('userid='.$UserID.'&PassID='.$PassID);
		$maildetails = FetchRecordByID(3,"TableID","tblemailtemplates");
		$MailSubject = $maildetails['Subject'.LANG_SEP_DB];
		$MailMessage = str_replace('{RESET_LINK}',$resetlink,$maildetails['Message'.LANG_SEP_DB]);
		$MailSendTo = $maildetails['SendTo'];
		$FormSuccess = $maildetails['SubmitFormMessage'.LANG_SEP_DB];

		$MailMessage = str_replace('{RESET_LINK}',$resetlink,$MailMessage);
		$MailMessage = str_replace('{USER_NAME}',$UserDet['FullName'],$MailMessage);

		// SendMailToUser($_POST['Email'], $MailSubject, $MailMessage, $UserDet['FullName']);

		$result['success'] = 1;
		$result['successMsg'] = $FormSuccess;
	}


	echo json_encode($result);
}

else if($FormAction=="ResetPassword")
{
	if($_POST['Password'] == '')
	{
		$result['error'] = 1;
		$result['Password'] = ERROR_PASSWORD;
	}
	if($_POST['PasswordStrength'] < 3 && $_POST['Password'] != '')
	{
		$result['error'] = 1;
		$result['Password'] = ERROR_PASSWORD;
	}
	if($_POST['Password'] != $_POST['ConfirmPassword'])
	{
		$result['error'] = 1;
		$result['ConfirmPassword'] = ERROR_CONFIRMPASSWORD;
	}
	if($result['error'] == '')
	{
		$Password=sha1($_POST['Password']);
		$PassID = decodeencriptstring($_POST['PassID']);
		$UserID = getFieldDataByID('UserID','PassID',$PassID,'tblforgotpassword');
		$db->query("update tbluserregistration set Password = '".$Password."' where TableID='".$UserID."'");
		insertlogTableFront('tbluserregistration',$UserID,2,$UserID);

		$InsertPasswordHistory =  "insert into tblwebuserpasswords set UserID='".$UserID."',Password='".secureTextForDb($Password)."', DateTime=NOW()";
		$db->query($InsertPasswordHistory);

		$result['redirect']= "login.html";
	}

	echo json_encode($result);
}

else if($FormAction == 'ChangePassword')
{
	$Password = sha1($_POST['Password']);
	$OldPassword = sha1($_POST['OldPassword']);
	$userID = $_SESSION[WEB_SESSION_FRONT.'_frontuser'];
	if(isset($_POST['ChangePassUserID']))
	{
		$userID = decodeencriptstring($_POST['ChangePassUserID']);
	}
	$PrevPasswordSave = getFieldDataByID("Password","TableID",$userID,"tbluserregistration");

	$Fetcholdpass="select Password from tblwebuserpasswords where UserID = '".$userID."'  order by TableID DESC LIMIT ".$website_config['PasswordHistory']."";
	$db1->query($Fetcholdpass);
	$OldPasswordSave = array();
	while($db1->next_record())
	{
		$OldPasswordSave[] = $db1->f('Password');
	}

	if($OldPassword != $PrevPasswordSave)
	{
		$result['error'] = 1;
		$result['OldPassword'] = TXT_PASS_ENTER_CORRCT;
	}
	if(in_array($Password,$OldPasswordSave))
	{
		$result['error'] = 1;
		$result['Password'] = TXT_PASS_USED;
	}
	else if($_POST['PasswordStrength'] < 3 && $_POST['Password'] != '')
	{
		$result['error'] = 1;
		$result['Password'] = TXT_ENTER_PASS_STRONG;
	}
	if($_POST['Password'] != $_POST['ConfirmPassword'])
	{
		$result['error'] = 1;
		$result['ConfirmPassword'] = TXT_PASS_NOTMATCH;
	}


	if($result['error']=='')
	{
		$Query = "update tbluserregistration set  
						Password='".secureTextForDb($Password)."'
					Where TableID = '".$userID."'
					  ";
		$db->query($Query);
		insertlogTableFront('tbluserregistration',$userID,2,$userID);

		$InsertPasswordHistory =  "insert into tblwebuserpasswords set UserID='".$userID."',Password='".secureTextForDb($Password)."', DateTime=NOW()";
		$db->query($InsertPasswordHistory);

		$result['success'] = 1;
		$result['redirect']= DOMAINNAME.'/logout.php?messageshow='.PASSWORD_CHANGED;
	}

	echo json_encode($result);
}

elseif ($FormAction == "contact-us") {

	$email = $_REQUEST['Email'];
    $name = $_REQUEST['Name'];
    $phone = $_REQUEST['phone'];
	$Message = $_REQUEST['Message'];

	if($_POST['Name'] == '')
	{
		$result['error'] = 1;
		$result['Name'] = TXT_SUBSCRIBE_ENTER_NAME;
	}
	if($_POST['Email'] == '')
	{
		$result['error'] = 1;
		$result['Email'] = TXT_SUBSCRIBE_ENTER_EMAIL;
	}
	if($result['error'] == '')
	{
	$maildetails = FetchRecordByID(4,"TableID","tblemailtemplates");
	$MailSubject = $maildetails['Subject'.LANG_SEP_DB];
	$MailMessage = $maildetails['Message'.LANG_SEP_DB];
	$MailSendTo = $maildetails['SendTo'];
	$FormSuccess = $maildetails['SubmitFormMessage'.LANG_SEP_DB];
		//    $MailMessageAdmin = '
		// 		   <table width="100%"  border="0" cellspacing="2" cellpadding="10" class="data-table2" >
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Name : </td>
		// 				   <td>'.$name.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Email : </td>
		// 				   <td>'.$email.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td>Phone : </td>
		// 				   <td>'.$phone.'</td>
		// 			   </tr>';
		// 			   </table>';


		//    SendMail($MailSendTo, TXT_SUBSCRIPTION_TYPE_TEXT, $MailMessageAdmin,$email);

		//    SendMailToUser($email, $MailSubject, $MailMessage, $name);



		$Query = "insert into tblcontactform set 
		Name = '".$name."',
		Email = '".$email."',
		Phone = '".$phone."',
		Message  = '".$Message."',
		DateTime = NOW()";
		$db->query($Query);

		$result['success'] = 1;
		$result['successMsg'] = $FormSuccess;
	}




	   echo json_encode($result);
}

elseif ($FormAction == "SuggestionsForm") {

	$email = $_REQUEST['Email'];
    $name = $_REQUEST['Name'];
    $phone = $_REQUEST['phone'];
	$Message = $_REQUEST['Message'];

	if($_POST['Name'] == '')
	{
		$result['error'] = 1;
		$result['Name'] = TXT_SUBSCRIBE_ENTER_NAME;
	}
	if($_POST['Email'] == '')
	{
		$result['error'] = 1;
		$result['Email'] = TXT_SUBSCRIBE_ENTER_EMAIL;
	}
	if($result['error'] == '')
	{
	$maildetails = FetchRecordByID(1,"TableID","tblemailtemplates");
	$MailSubject = $maildetails['Subject'.LANG_SEP_DB];
	$MailMessage = $maildetails['Message'.LANG_SEP_DB];
	$FormSuccess = $maildetails['SubmitFormMessage'.LANG_SEP_DB];
	$MailSendTo = $maildetails['SendTo'];

		//    $MailMessageAdmin = '
		// 		   <table width="100%"  border="0" cellspacing="2" cellpadding="10" class="data-table2" >
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Name : </td>
		// 				   <td>'.$name.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Email : </td>
		// 				   <td>'.$email.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td>Phone : </td>
		// 				   <td>'.$phone.'</td>
		// 			   </tr>';
		// 			   </table>';


		//    SendMail($MailSendTo, TXT_SUBSCRIPTION_TYPE_TEXT, $MailMessageAdmin,$email);

		//    SendMailToUser($email, $MailSubject, $MailMessage, $name);


		$ticketID = GenerateUniqueID('tblcomplaintform','S');
		$Query = "insert into tblsuggestionform set 
		Name = '".$name."',
		Email = '".$email."',
		Phone = '".$phone."',
		Suggestion  = '".$Message."',
		RequestNo  = '".$ticketID."',
		DateTime = NOW()";
		$db->query($Query);

		$result['success'] = 1;
		$result['successMsg'] = $FormSuccess;
	}
	   echo json_encode($result);
}


elseif ($FormAction == "ComplaintForm") {

	$email = $_REQUEST['Email'];
    $name = $_REQUEST['Name'];
    $phone = $_REQUEST['phone'];
	$Message = $_REQUEST['Message'];

	if($_POST['Name'] == '')
	{
		$result['error'] = 1;
		$result['Name'] = TXT_SUBSCRIBE_ENTER_NAME;
	}
	if($_POST['Email'] == '')
	{
		$result['error'] = 1;
		$result['Email'] = TXT_SUBSCRIBE_ENTER_EMAIL;
	}
	if($result['error'] == '')
	{
	$maildetails = FetchRecordByID(5,"TableID","tblemailtemplates");
	$MailSubject = $maildetails['Subject'.LANG_SEP_DB];
	$MailMessage = $maildetails['Message'.LANG_SEP_DB];
	$MailSendTo = $maildetails['SendTo'];
	$FormSuccess = $maildetails['SubmitFormMessage'.LANG_SEP_DB];

		//    $MailMessageAdmin = '
		// 		   <table width="100%"  border="0" cellspacing="2" cellpadding="10" class="data-table2" >
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Name : </td>
		// 				   <td>'.$name.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Email : </td>
		// 				   <td>'.$email.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td>Phone : </td>
		// 				   <td>'.$phone.'</td>
		// 			   </tr>';
		// 			   </table>';


		//    SendMail($MailSendTo, TXT_SUBSCRIPTION_TYPE_TEXT, $MailMessageAdmin,$email);

		//    SendMailToUser($email, $MailSubject, $MailMessage, $name);


		$ticketID = GenerateUniqueID('tblcomplaintform','C');
		$Query = "insert into tblcomplaintform set 
		Name = '".$name."',
		Email = '".$email."',
		Phone = '".$phone."',
		Complaint  = '".$Message."',
		RequestNo  = '".$ticketID."',
		DateTime = NOW()";
		$db->query($Query);

		$result['success'] = 1;
		$result['successMsg'] = $FormSuccess;
	}




	   echo json_encode($result);
}


elseif ($FormAction == "SportsComplexForm") {

	$email = $_REQUEST['Email'];
    $name = $_REQUEST['Name'];
    $phone = $_REQUEST['phone'];
	$Gender = $_REQUEST['Gender'];
	$Nationality = $_REQUEST['Nationality'];
	$Message = $_REQUEST['Message'];

	if($_POST['Name'] == '')
	{
		$result['error'] = 1;
		$result['Name'] = TXT_SUBSCRIBE_ENTER_NAME;
	}
	if($_POST['Email'] == '')
	{
		$result['error'] = 1;
		$result['Email'] = TXT_SUBSCRIBE_ENTER_EMAIL;
	}
	if($_POST['Nationality'] == '-1')
	{
		$result['error'] = 1;
		$result['Nationality'] = ERROR_NATIONALITY;
	}
	if($phone == '')
	{
		$result['error'] = 1;
		$result['phone'] = TXT_ERROR_PHONE_NUMBER;
	}
	if($result['error'] == '')
	{
	$maildetails = FetchRecordByID(11,"TableID","tblemailtemplates");
	$MailSubject = $maildetails['Subject'.LANG_SEP_DB];
	$MailMessage = $maildetails['Message'.LANG_SEP_DB];
	$MailSendTo = $maildetails['SendTo'];
	$FormSuccess = $maildetails['SubmitFormMessage'.LANG_SEP_DB];

		//    $MailMessageAdmin = '
		// 		   <table width="100%"  border="0" cellspacing="2" cellpadding="10" class="data-table2" >
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Name : </td>
		// 				   <td>'.$name.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Email : </td>
		// 				   <td>'.$email.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td>Phone : </td>
		// 				   <td>'.$phone.'</td>
		// 			   </tr>';
		// 			   </table>';


		//    SendMail($MailSendTo, TXT_SUBSCRIPTION_TYPE_TEXT, $MailMessageAdmin,$email);

		//    SendMailToUser($email, $MailSubject, $MailMessage, $name);


		$ticketID = GenerateUniqueID('tblsportscomplex','SC');
		$Query = "insert into tblsportscomplex set 
		FullName = '".$name."',
		Email = '".$email."',
		Gender = '".$Gender."',
		MobileNo = '".$phone."',
		NationalityID  = '".$Nationality."',
		RequestNo  = '".$ticketID."',
		Message  = '".$Message."'
		";
		$db->query($Query);

		$result['success'] = 1;
		$result['successMsg'] = $FormSuccess;
	}

	   echo json_encode($result);
}


elseif ($FormAction == "PublicationsForm") {

	$email = $_REQUEST['Email'];
    $name = $_REQUEST['Name'];
    $phone = $_REQUEST['phone'];
	$Gender = $_REQUEST['Gender'];
	$Nationality = $_REQUEST['Nationality'];
	$Message = $_REQUEST['Message'];

	if($_POST['Name'] == '')
	{
		$result['error'] = 1;
		$result['Name'] = TXT_SUBSCRIBE_ENTER_NAME;
	}
	if($_POST['Email'] == '')
	{
		$result['error'] = 1;
		$result['Email'] = TXT_SUBSCRIBE_ENTER_EMAIL;
	}
	if($_POST['Nationality'] == '-1')
	{
		$result['error'] = 1;
		$result['Nationality'] = ERROR_NATIONALITY;
	}
	if($phone == '')
	{
		$result['error'] = 1;
		$result['phone'] = TXT_ERROR_PHONE_NUMBER;
	}
	if($result['error'] == '')
	{
	$maildetails = FetchRecordByID(11,"TableID","tblemailtemplates");
	$MailSubject = $maildetails['Subject'.LANG_SEP_DB];
	$MailMessage = $maildetails['Message'.LANG_SEP_DB];
	$MailSendTo = $maildetails['SendTo'];
	$FormSuccess = $maildetails['SubmitFormMessage'.LANG_SEP_DB];

		//    $MailMessageAdmin = '
		// 		   <table width="100%"  border="0" cellspacing="2" cellpadding="10" class="data-table2" >
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Name : </td>
		// 				   <td>'.$name.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td width="20%">Email : </td>
		// 				   <td>'.$email.'</td>
		// 			   </tr>
		// 			   <tr style="background:#f1f1f1;">
		// 				   <td>Phone : </td>
		// 				   <td>'.$phone.'</td>
		// 			   </tr>';
		// 			   </table>';


		//    SendMail($MailSendTo, TXT_SUBSCRIPTION_TYPE_TEXT, $MailMessageAdmin,$email);

		//    SendMailToUser($email, $MailSubject, $MailMessage, $name);


		$ticketID = GenerateUniqueID('tblpublicationsubmission','P');
		$Query = "insert into tblpublicationsubmission set 
		FullName = '".$name."',
		Email = '".$email."',
		Gender = '".$Gender."',
		MobileNo = '".$phone."',
		NationalityID  = '".$Nationality."',
		RequestNo  = '".$ticketID."',
		Message  = '".$Message."'
		";
		$db->query($Query);

		$result['success'] = 1;
		$result['successMsg'] = $FormSuccess;
	}




	   echo json_encode($result);
}

elseif ($FormAction == "SendPublication") {

	$email = $_REQUEST['Email'];
    $name = $_REQUEST['FullName'];
    $Pub_ID = decodeencriptstring($_REQUEST['pub_id']);

	if($name == '')
	{
		$result['error'] = 1;
		$result['Name'] = TXT_SUBSCRIBE_ENTER_NAME;
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$result['error'] = 1;
		$result['Email'] = TXT_SUBSCRIBE_ENTER_EMAIL;
	}

	if($result['error'] == '')
	{
		$PubDet = FetchRecordByID($Pub_ID,"TableID","tblpublications");
		$db->query("insert into tblsharepublication_log set FullName='".$name."',Email='".$email."',UserIP='".$_SERVER['REMOTE_ADDR']."', UserID='".$_SESSION[WEB_SESSION_FRONT.'_frontuser']."', Publication_ID='".$Pub_ID."', DateTime=NOW()");

		$publicationlink = DOMAINNAME.'/'.PUBLICATION_DETAIL_URL.'/'.$PubDet['URLKeyword'];
		$maildetails = FetchRecordByID(12,"TableID","tblemailtemplates");
		$MailSendTo = $_POST['Email'];
		$MailSubject = $maildetails['Subject'.LANG_SEP_DB];
		$FormSuccess = $maildetails['SubmitFormMessage'.LANG_SEP_DB];
		$MailMessage = str_replace("{USERNAME}",$name,$maildetails['Message'.LANG_SEP_DB]);
		$MailMessage = str_replace("{PUBLICATIONLINK}",$publicationlink,$MailMessage);
		// SendMailToUser($MailSendTo, $MailSubject, $MailMessage, $_POST['FullName']);

		$result['success'] = 1;
		$result['closemodal'] = 1;
		$result['closemodalID'] = 'myModalShare';
		$result['successMsg'] = $FormSuccess;
	}




	   echo json_encode($result);
}

elseif ($FormAction == "WatchCourseVideo") {
	$CourseID = $_REQUEST['CourseID'];
	$VideoId = $_REQUEST['VideoId'];
	$query = "select * from tblwatchvideosfortest where CourseID= '".$CourseID."' and VideoId='".$VideoId."' and UserID='".$_SESSION[WEB_SESSION_FRONT.'_frontuser']."'";
	$db->query($query);
	if($db->num_rows() > 0)
	{
		$db->next_record();
		$Trigger = 'edit';
		$RecordID = $db->f('TableID');
		$Query = "update tblwatchvideosfortest set 
				ViewCounter=ViewCounter+1,
				LastViewDateTime=NOW()
				where TableID = '".$RecordID."'
				";

		$db1->query($Query);


		$Query = "insert into tblwatchvideosfortest_log set 
		CourseID='".$CourseID."',
					VideoId='".$VideoId."',
					UserID='".$_SESSION[WEB_SESSION_FRONT.'_frontuser']."',
					LastViewDateTime =NOW()
				";
		$db1->query($Query);
	}else{
		$Query = "insert into tblwatchvideosfortest set 
					CourseID='".$CourseID."',
					VideoId='".$VideoId."',
					UserID='".$_SESSION[WEB_SESSION_FRONT.'_frontuser']."',
					ViewCounter=1,
					LastViewDateTime =NOW()
				";

		$db1->query($Query);

		$Query = "insert into tblwatchvideosfortest_log set 
					CourseID='".$CourseID."',
					VideoId='".$VideoId."',
					UserID='".$_SESSION[WEB_SESSION_FRONT.'_frontuser']."',
					LastViewDateTime =NOW()
				";
		$db1->query($Query);
	}


	$result['success'] = 1;
	echo json_encode($result);
}
if($_REQUEST['Action'] == 'ajaxsearchautocompele')
{
	$q = $_REQUEST['q'];

	$finalArray = array();
	$whereCond = "where name LIKE '%".$_REQUEST['q']."%' ORDER BY name ASC";
	$query = "select * from tblstore ".$whereCond." LIMIT 10";
	$db1->query($query);

	while($db1->next_Record())
	{
		$url = ($db1->f('url')=="")?'':$db1->f('url');
		$finalArray[] = array("img" => RESOURCES_DOMAIN.'/files/banners/'.stripslashes($db1->f("logo")),"src" => RESOURCES_DOMAIN.'/files/banners/'.stripslashes($db1->f("logo")), "label" => stripslashes($db1->f("name")),"value" => stripslashes($db1->f("name")),"TableID" => $db1->f("name"),"Link" => $url);
	}
	echo json_encode($finalArray);
}

//function get_city($term){
//	$query = "SELECT * FROM tblstore WHERE name LIKE '%".$term."%' ORDER BY city_name ASC";
//	$data = $db->query($query);
//	return $data;
//}
//if (isset($_GET['term'])) {
//$getCity = get_city($_GET['term']);
//$cityList = array();
//foreach($getCity as $city){
//	$cityList[] = $city['city_name'];
//}
?>

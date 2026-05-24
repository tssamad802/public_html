<?php
// require_once("db_mysql.php");
require_once __DIR__ . "/db_mysql.php";
require_once __DIR__ . "/constants.php";

// Load the correct language file for the current area.
$language = $_SESSION['LANGUAGE'] ?? 'en';
if (
	(isset($_SERVER['SCRIPT_NAME']) && strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false) ||
	(isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], '/admin/') !== false)
) {
	$langFile = __DIR__ . "/../admin/lang/" . $language . ".php";
} else {
	$language = $_SESSION['Frontendlanguage'] ?? $language;
	$langFile = __DIR__ . "/../lang/" . $language . ".php";
}
if ($langFile && file_exists($langFile)) {
	include_once($langFile);
}

require_once("csrf.class.php");
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
$db = new DB_Sql();
$db->Database = DATABASE_NAME;
$db->User = DATABASE_USER;
$db->Password = DATABASE_PASSWORD;
$db->Host = DATABASE_HOST;
$db1 = new DB_Sql();
$db1->Database = DATABASE_NAME;
$db1->User = DATABASE_USER;
$db1->Password = DATABASE_PASSWORD;
$db1->Host = DATABASE_HOST;
$db2 = new DB_Sql();
$db2->Database = DATABASE_NAME;
$db2->User = DATABASE_USER;
$db2->Password = DATABASE_PASSWORD;
$db2->Host = DATABASE_HOST;
$db3 = new DB_Sql();
$db3->Database = DATABASE_NAME;
$db3->User = DATABASE_USER;
$db3->Password = DATABASE_PASSWORD;
$db3->Host = DATABASE_HOST;
$db4 = new DB_Sql();
$db4->Database = DATABASE_NAME;
$db4->User = DATABASE_USER;
$db4->Password = DATABASE_PASSWORD;
$db4->Host = DATABASE_HOST;
$db5 = new DB_Sql();
$db5->Database = DATABASE_NAME;
$db5->User = DATABASE_USER;
$db5->Password = DATABASE_PASSWORD;
$db5->Host = DATABASE_HOST;

$dbPagination = new DB_Sql();

// Convert non-standard characters to HTML
function tohtml($strValue)
{
	return htmlspecialchars($strValue);
}
// Convert value to URL
function tourl($strValue)
{
	return urlencode($strValue);
}
// Obtain specific URL Parameter from URL string
function get_param($param_name)
{
	global $HTTP_POST_VARS;
	global $HTTP_GET_VARS;

	$param_value = "";
	if (isset($HTTP_POST_VARS[$param_name]))
		$param_value = $HTTP_POST_VARS[$param_name];
	else if (isset($HTTP_GET_VARS[$param_name]))
		$param_value = $HTTP_GET_VARS[$param_name];
	return $param_value;
}

//Destroying Session on logout

function initialize($action)
{
	if (isset($action)) {
		session_start();
		session_destroy();
	}
}
function get_session($param_name)
{
	global $HTTP_POST_VARS;
	global $HTTP_GET_VARS;
	global ${$param_name};

	$param_value = "";
	if (!isset($HTTP_POST_VARS[$param_name]) && !isset($HTTP_GET_VARS[$param_name]) && session_is_registered($param_name))
		$param_value = ${$param_name};

	return $param_value;
}

function tosql($value, $type)
{
	if ($value == "")
		return "NULL";
	else
		if ($type == "Number")
			return str_replace(",", ".", doubleval($value));
		else {
			if (get_magic_quotes_gpc() == 0) {
				$value = str_replace("'", "''", $value);
				$value = str_replace("\\", "\\\\", $value);
			} else {
				$value = str_replace("\\'", "''", $value);
				$value = str_replace("\\\"", "\"", $value);
			}

			return "'" . $value . "'";
		}
}

function strip($value)
{
	if (get_magic_quotes_gpc() == 0)
		return $value;
	else
		return stripslashes($value);
}


//-------------------------------
// Obtain lookup value from array containing List Of Values
//-------------------------------
function get_lov_value($value, $array)
{
	$return_result = "";

	if (sizeof($array) % 2 != 0)
		$array_length = sizeof($array) - 1;
	else
		$array_length = sizeof($array);
	reset($array);

	for ($i = 0; $i < $array_length; $i = $i + 2) {
		if ($value == $array[$i])
			$return_result = $array[$i + 1];
	}

	return $return_result;
}


// Deleting of Directory
function deldir($dir)
{

	if (!is_dir($dir))
		return;

	$current_dir = opendir($dir);
	if (!$current_dir)
		return;

	while (($entryname = readdir($current_dir)) !== false) {

		if ($entryname == "." || $entryname == "..")
			continue;

		$path = $dir . "/" . $entryname;

		if (is_dir($path)) {
			deldir($path);
		} else {
			unlink($path);
		}
	}

	closedir($current_dir);
	rmdir($dir);
}

// Making of Directory

function mkdir_p($target)
{
	if (is_dir($target) || empty($target))
		return 1; // best case check first
	if (file_exists($target) && !is_dir($target))
		return 0;
	if (mkdir_p(substr($target, 0, strrpos($target, '/'))))
		return mkdir($target); // crawl back up & create dir tree
	return 0;
}
function php2sql($phpString)
{
	$pieces = explode("/", $phpString);
	$sqlString = $pieces[2] . "-" . $pieces[1] . "-" . $pieces[0];
	return $sqlString;
}

// Takes care of SQL Injection

function sqlInjection($phpString)
{
	$pieces = explode("/", $phpString);
	$sqlString = $pieces[0];
	return $sqlString;
}

function sql2php($sqlString)
{
	$pieces = explode("-", $sqlString);
	$phpString = $pieces[2] . "/" . $pieces[1] . "/" . $pieces[0];
	return $phpString;
}

//******************** Searching Through Primary Key and returns String Data

function getFieldDataByID($StringField, $WhereField, $WhereValue, $TableName)
{
	//$_SESSION['QueryCount'] = $_SESSION['QueryCount']+1;
	$sqlQuery = "Select " . $StringField . " from " . $TableName . " where " . $WhereField . "='" . $WhereValue . "'";
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		return $row[0];
	}
}

function getFieldDataByID2($StringField, $WhereField, $WhereValue, $TableName)
{
	//$_SESSION['QueryCount'] = $_SESSION['QueryCount']+1;
	$sqlQuery = "Select " . $StringField . " from " . $TableName . " where " . $WhereField . "=" . $WhereValue . "";
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		return $row[0];
	}
}

function getFieldDataBycustomeCondition($StringField, $WhereFieldcontion, $TableName)
{
	//$_SESSION['QueryCount'] = $_SESSION['QueryCount']+1;
	$sqlQuery = "Select " . $StringField . " from " . $TableName . " where " . $WhereFieldcontion . "";
	// return $sqlQuery;exit();
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		return $row[0];
	}
}

function FetchTotal($id, $primarykey, $tablename)
{
	$sqlQuery = "Select count(*) from " . $tablename . " where " . $primarykey . "='" . $id . "'";
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	$count = mysqli_num_fields($result);
	$i = 0;

	while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
		while ($i < $count) {
			$fieldName = mysqli_fetch_field_direct($result, $i)->name;

			$object[$fieldName] = $row[$i];
			$i++;
		}
	}
	if ($i == 0) {
		return $i;
	} else {
		return $object;
	}
}

//Fetch Entire Data
function FetchRecordByID($id, $primarykey, $tablename)
{
	$sqlQuery = "Select * from " . $tablename . " where " . $primarykey . "='" . $id . "'";
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	$count = mysqli_num_fields($result);
	$i = 0;

	while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
		while ($i < $count) {
			$fieldName = mysqli_fetch_field_direct($result, $i)->name;

			$object[$fieldName] = $row[$i];
			$i++;
		}
	}
	if ($i == 0) {
		return $i;
	} else {
		return $object;
	}
}

//******************** Fill The Combo Box

function fillcombocontrolWithMultiSelect($SelectedIndex, $FieldOne, $FieldTwo, $TableName, $SortField)
{
	$SelectedIndexarray = explode(",", $SelectedIndex);
	$db = new DB_Sql();
	$sqlQuery = "Select $FieldOne,$FieldTwo from $TableName order by $SortField";

	$db->query($sqlQuery);

	$Text = "";

	while ($db->next_record()) {
		if (in_array($db->f(0), $SelectedIndexarray)) {
			$Text .= "<option selected value='" . $db->f(0) . "'>" . $db->f(1) . "</option>";
		} else {
			$Text .= "<option value='" . $db->f(0) . "'>" . $db->f(1) . "</option>";
		}
	}

	return $Text;
}

function fillcombocontrol($SelectedIndex, $FieldOne, $FieldTwo, $TableName, $SortField)
{
	$db = new DB_Sql();
	$sqlQuery = "Select $FieldOne,$FieldTwo from $TableName order by $SortField";

	$db->query($sqlQuery);

	$Text = "";

	while ($db->next_record()) {
		if ($SelectedIndex == $db->f(0)) {
			$Text .= "<option selected value='" . $db->f(0) . "'>" . $db->f(1) . "</option>";
		} else {
			$Text .= "<option value='" . $db->f(0) . "'>" . $db->f(1) . "</option>";
		}
	}

	return $Text;
}

// Fill Combo boxes with dual values
function fillcombocontroldual($SelectedIndex, $FieldOne, $FieldTwo, $FieldThree, $Seprator, $TableName, $SortField)
{
	$sqlQuery = "Select $FieldOne,$FieldTwo,$FieldThree from $TableName order by $SortField";
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	$Text = "";
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	}
	return $Text;
}

// Fill Combo boxes with where clause
function fillcombocontrolwhereclause($SelectedIndex, $FieldOne, $FieldTwo, $TableName, $WhereField, $WhereValue, $WhereFieldTwo, $WhereValueTwo, $SortField, $SortType = "asc")
{
	$sqlQuery = "Select $FieldOne,$FieldTwo from $TableName where $WhereField=$WhereValue and $WhereFieldTwo=$WhereValueTwo order by $SortField $SortType";
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	$Text = "";
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {

	}
	return $Text;
}




//Month String Date
function getcurrentstringdate()
{
	return date(d . " - " . F . " - " . Y);
}
//numerical date
function getcurrentdate()
{
	return date(Y . "-" . m . "-" . d);
}

function formatdate($DateValue)
{
	return date("D F d, g:i a", strtotime($DateValue));
}
//******************** Getting The Application Status
function getcurrentdatetime()
{
	return date(d . " - " . F . " - " . Y . " " . h . ":" . i . ":" . s . " A");
	return date(d . " - " . F . " - " . Y . " " . h . ":" . i . ":" . s . " A");
}
function getcurrenttime()
{
	return date(h . ":" . i . ":" . s . " A");
}
function get_time_difference($start, $end)
{
	$uts['start'] = strtotime($start);
	$uts['end'] = strtotime($end);
	if ($uts['start'] !== -1 && $uts['end'] !== -1) {
		if ($uts['end'] >= $uts['start']) {
			$diff = $uts['end'] - $uts['start'];
			if ($days = intval((floor($diff / 86400))))
				$diff = $diff % 86400;
			if ($hours = intval((floor($diff / 3600))))
				$diff = $diff % 3600;
			if ($minutes = intval((floor($diff / 60))))
				$diff = $diff % 60;
			$diff = intval($diff);
			return (array('days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $diff));
		} else {
			trigger_error("Ending date/time is earlier than the start date/time", E_USER_WARNING);
		}
	} else {
		trigger_error("Invalid date/time data detected", E_USER_WARNING);
	}
	return (false);
}
// Function for Creating Thumbnails for the Images
function createthumbnail($files, $newfile, $newname, $extension, $newwidth, $newheight, $location)
{
	list($width, $height) = getimagesize($newfile);
	$image_p = imagecreatetruecolor($newwidth, $newheight);
	ini_set("max_execution_time", "500");
	ini_set("max_input_time", "500");
	$extension = strtolower($extension);
	if ($extension == 'image/pjpeg') {
		$img = @imagecreatefromjpeg($newfile);
		imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		$location = $location . $newname;
		imagejpeg($image_p, $location, 100);
	} else if ($extension == 'image/gif') {
		$img = @imagecreatefromgif($newfile);
		imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		$location = $location . $newname;
		imagegif($image_p, $location, 100);
	} else if ($extension == 'image/png') {
		$img = @imagecreatefrompng($newfile);
		imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		$location = $location . $newname;
		imagepng($image_p, $location, 100);
	} else if ($extension == 'image/jpg') {
		$img = @imagecreatefromjpg($newfile);
		imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		$location = $location . $newname;
		imagejpg($image_p, $location, 100);
	}
}

//Function for creating JPEG Images
function create_jpeg_image()
{
	$md5 = md5(rand(0, 999));
	$pass = substr($md5, 10, 5);
	$width = 100;
	$height = 20;
	$image = ImageCreate($width, $height);
	$white = ImageColorAllocate($image, 255, 255, 255);
	$black = ImageColorAllocate($image, 0, 0, 0);
	$grey = ImageColorAllocate($image, 204, 204, 204);
	ImageFill($image, 0, 0, $black);
	ImageString($image, 3, 30, 3, $pass, $white);
	ImageRectangle($image, 0, 0, $width - 1, $height - 1, $grey);
	imageline($image, 0, $height / 2, $width, $height / 2, $grey);
	imageline($image, $width / 2, 0, $width / 2, $height, $grey);
	header("Content-Type: image/jpeg");
	ImageJpeg($image);
	ImageDestroy($image);
}
function generatepassword($length)
{
	$password = "";
	$possible = "0123456789bcdfghjkmnpqrstvwxyz";
	$i = 0;
	while ($i < $length) {
		$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
		if (!strstr($password, $char)) {
			$password .= $char;
			$i++;
		}
	}
	return $password;
}
function redirect($url, $time)
{
	echo '<meta http-equiv=refresh content=' . $time . ';URL=' . $url . '>';
	exit;
}
//Uploading with Thumbnailing
function uploadfilethumbnail($File, $width, $height, $dir, $newLocation, $filescheme)
{
	if ($filescheme == 'R') {
		$extension = explode('.', $File['name']);
		$FileName = generatePassword(15) . '.' . $extension[1];
	} else {
		$FileName = $filescheme . '_' . $File['name'];
	}

	if (!file_exists($dir))
		mkdir($dir);
	$uploaddir = realpath($dir);
	$path = $uploaddir . "/";
	//******** Uploadin to a temporary location
	if (is_uploaded_file($File['tmp_name'])) {
		//******** Copy the file to the location
		$resultCopy = copy($File['tmp_name'], $path . $FileName);

		if (!$resultCopy) {
			echo "Transaction failed!";
			return 0;
		} else {
			$location = $dir . '/' . $FileName;
			$type = $File['type'];
			if (!file_exists($newLocation))
				mkdir($newLocation);
			createthumbnail($File, $location, $FileName, $type, $width, $height, $newLocation);
			return $FileName;
		}
	}
}
function uploadfile($File, $dir)
{
	$extension = explode('.', $File['name']);
	$FileName = generatePassword(15) . '.' . $extension[count($extension) - 1];
	if (!file_exists($dir))
		mkdir($dir);
	$uploaddir = realpath($dir);
	$path = $uploaddir . "/";
	if (is_uploaded_file($File['tmp_name'])) {
		$resultCopy = copy($File['tmp_name'], $path . $FileName);
		if (!$resultCopy) {
			echo "Transaction failed!";
			return 0;
		} else {
			return $FileName;
		}
	}
}

//Unlinking File
function unlinkfile($filelocations, $filename)
{
	foreach ($filelocations as $location) {
		unlink($location . '/' . $filename);
	}
}

//Showing Alert Message
function showmessage($msg)
{
	?>
	<script language="javascript">
		alert("<?= $msg ?>");
	</script>
	<?php
}

//Fetching the Max ID from a given table using a ID
function maxID($PKField, $TableName, $increment)
{
	$db = new DB_Sql();

	$sqlQuery = "Select max(" . $PKField . ") from " . $TableName;

	$db->query($sqlQuery);

	while ($db->next_record()) {
		if ($db->f(0) == '') {
			return 1;
		} else {
			return ($db->f(0) + $increment);
		}
	}
}

//Getting Values to store File in the Database
function StoreFileDB($filecontrolname)
{
	$filevalues['filename'] = $_FILES[$filecontrolname]['name'];
	$filevalues['tmpname'] = $_FILES[$filecontrolname]['tmp_name'];
	$filevalues['filesize'] = $_FILES[$filecontrolname]['size'];
	$filevalues['filetype'] = $_FILES[$filecontrolname]['type'];
	$fp = fopen($filevalues['tmpname'], 'r');
	$filevalues['content'] = fread($fp, $filevalues['filesize']);
	$filevalues['content'] = addslashes($filevalues['content']);
	fclose($fp);
	if (!get_magic_quotes_gpc()) {
		$filevalues['filename'] = addslashes($filevalues['filename']);
	}
	return $filevalues;
}
//Calculating Date
function calculateforwarddate($to, $days)
{
	$dateset;
	$dateset[] = $to;
	$i = 0;
	for ($i = 1; $i <= $days; $i++) {
		$timestamp = strtotime($to);
		$seconds_diff = $i * 24 * 3600; // taking 60 (days) * 24 (hours) * 3600 (seconds)
		$warning_timestamp = $timestamp + $seconds_diff;
		$from = date('Y-m-d', $warning_timestamp);
		$dateset[] = $from;
	}
	return $dateset;
}

//Sending Emails
function sendemail($emailToSend, $mailsubject, $message, $headers)
{
	mail($emailToSend, $mailsubject, $message, $headers);
}


//Check User Permission
function checkPermission($permissiontype, $UserID, $SubLinkID)
{
	$db = new DB_Sql();
	//Check Required Permissions
	$FetchPermission = "select " . $permissiontype . " from tbluserpermissions where SubLinkID=$SubLinkID and UserID=$UserID";
	$db->query($FetchPermission);
	$db->next_Record();
	if ($db->f(0) == 1) {
		return true;
	} else {
		showmessage(TXT_PERMISSION_ERROR);
		redirect(DOMAINNAME . '/admin', 0);
	}
}

//Return User Permission
function ReturnPermission($userid, $pagename, $permissiontype, $db)
{
	//Check if action is null to make sure it is not home page
	if ($pagename == '') {
		//If Home Page Allow
		return true;
	} else {
		//Check Required Permissions
		$LinkID = FetchSubLinkID($pagename, $db);
		$FetchPermission = "select " . $permissiontype . " from tbluserpermissions where SubLinkID=$LinkID and UserID=$userid";
		$db->query($FetchPermission);
		if ($db->num_rows() != 0) {
			while ($db->next_Record()) {
				if ($db->f(0) == 1) {
					return true;
				} else if ($db->f(0) == 0) {
					return false;
				}
			}
		} else {
			return false;
		}
	}
}
//Fetch Sub Link ID from Link Table
function FetchSubLinkID($pagename, $db)
{
	$FetchLink = "select TableID from tblsublinks where URL='" . $pagename . "'";
	$db->query($FetchLink);
	while ($db->next_Record()) {
		return $db->f(0);
	}
}

//Printing Page Titles
function PrintTitle($pagename, $db)
{
	$FetchDetails = "select MasterLinkID,LinkName from tblsublinks where URL='$pagename'";
	$db->query($FetchDetails);
	while ($db->next_Record()) {
		$masterlinkid = $db->f('MasterLinkID');
		$linkname = $db->f('LinkName');
	}

	$FetchDetails = "select MenuName from tblmasterlinks where TableID=$masterlinkid";

	$db->query($FetchDetails);
	while ($db->next_Record()) {
		$masterlinkname = $db->f('MasterLinkTitle');
	}
	echo $masterlinkname . " : " . $linkname;

}
//Check Permission for Editing
function checkExistingPermission($userid, $pagename, $db)
{
	//Check Required Permissions
	$LinkID = FetchSubLinkID($pagename, $db);
	$FetchPermission = "select ViewPermissions,AddPermissions,EditPermissions,DeletePermissions from tbluserpermissions where SubLinkID=$LinkID and UserID=$userid";
	$db->query($FetchPermission);
	$RecordCount = 0;
	if ($db->num_rows() != 0) {
		while ($db->next_Record()) {
			$permissionarray[0] = $db->f('ViewPermissions');
			$permissionarray[1] = $db->f('AddPermissions');
			$permissionarray[2] = $db->f('EditPermissions');
			$permissionarray[3] = $db->f('DeletePermissions');
		}
	} else {
		$permissionarray[0] = 0;
		$permissionarray[1] = 0;
		$permissionarray[2] = 0;
		$permissionarray[3] = 0;
	}
	if ($permissionarray[0] == 0) {
		$permissionflags['ViewPermissions'] = ' ';
	} else {
		$permissionflags['ViewPermissions'] = ' checked ';
	}
	if ($permissionarray[1] == 0) {
		$permissionflags['AddPermissions'] = ' ';
	} else {
		$permissionflags['AddPermissions'] = ' checked ';
	}
	if ($permissionarray[2] == 0) {
		$permissionflags['EditPermissions'] = ' ';
	} else {
		$permissionflags['EditPermissions'] = ' checked ';
	}
	if ($permissionarray[3] == 0) {
		$permissionflags['DeletePermissions'] = ' ';
	} else {
		$permissionflags['DeletePermissions'] = ' checked ';
	}

	return $permissionflags;
}
//Get Status
function getStatus($status)
{
	if ($status == ACTIVE) {
		echo "Active";
	} else if ($status == INACTIVE) {
		echo "Inactive";
	}
}

//Disable controls

function disablecontrols()
{
	?>
	<script language="javascript">
		disablecontrols();
	</script>
	<?php
}

//Change Date/Time to Only Time;

function ChangeDateTimetoTime($DateValue)
{
	return date("g : i : s a", strtotime($DateValue));
}

//Change Date Format

function ChangeDateFormat($DateValue)
{
	return date(d . " " . F . " " . Y, strtotime($DateValue));
}

//Closing Window

function windowclose()
{
	?>
	<script language="javascript">
		window.close();
	</script>
	<?php
}
function windowopen($url)
{
	?>
	<script language="javascript">
		window.open("<?= $url ?>");
	</script>
	<?php
}

function kioskdatetime($Flag = 0)
{
	$date = date(l . " " . dS . " " . F . " " . Y . " " . h . " : " . i . " : " . s . " A");
	if ($Flag == 1) {
		return $date;
	} else {
		return "<p>" . $date . "</p>";
	}
}

function PlayMediaPlayer($location, $moviefile, $Width, $Height)
{
	?>
	<OBJECT id='mediaPlayer' width="<?php echo $Width; ?>" height="<?php echo $Height; ?>"
		classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95'
		codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701'
		standby='Loading Microsoft Windows Media Player components...' type='application/x-oleobject'>
		<param name='fileName' value="<?= $location ?>/<?= $moviefile ?>">
		<param name='animationatStart' value='true'>
		<param name='transparentatStart' value='true'>
		<param name='autoStart' value="true">
		<param name='showControls' value="true">
		<param name='loop' value="true">
		<EMBED type='application/x-mplayer2' pluginspage='http://microsoft.com/windows/mediaplayer/en/download/'
			id='mediaPlayer' name='mediaPlayer' displaysize='4' autosize='-1' bgcolor='darkblue' showcontrols="true"
			showtracker='-1' showdisplay='0' showstatusbar='-1' videoborder3d='-1' width="<?php echo $Width; ?>"
			height="<?php echo $Height; ?>" src="<?= $location ?>/<?= $moviefile ?>" autostart="true" designtimesp='5311'
			loop="true">
		</EMBED>
	</OBJECT>
	<?php
}
function PlayFLVFile123($location, $file, $width, $heigth)
{
	?>
	<object type="application/x-shockwave-flash" data="FlowPlayer.swf" width="<?= $width ?>" height="<?= $heigth ?>"
		id="FlowPlayer">
		<param name="allowScriptAccess" value="always" />
		<param name="movie" value="FlowPlayer.swf" />
		<param name="quality" value="high" />
		<param name="scaleMode" value="showAll" />
		<param name="allowfullscreen" value="false" />
		<param name="wmode" value="transparent" />
		<param name="allowNetworking" value="all" />
		<param name="flashvars" value="config={
				loop: true,
				autoPlay: true,
				initialScale: 'scale',
				showLoopButton: false,
				showPlayListButtons: false,
				playList: [
				{ url: '<?= $location ?>/<?= $file ?>' },
				]
				}" />
	</object>
	<?php
}


function PlayFLVFile($location, $file, $width, $heigth)
{
	?>
	<script>
		var myListener = new Object();
		myListener.onInit = function () {

		};
		myListener.onClick = function () {
			var total = document.getElementById("info_click").innerHTML;
			document.getElementById("info_click").innerHTML = Number(total) + 1;
		};

		/**
		 * onKeyUp event on the video
		 */
		myListener.onKeyUp = function (pKey) {
			document.getElementById("info_key").innerHTML = pKey;
		};

		myListener.onFinished = function () {
			window.location.reload();
		};
		myListener.onUpdate = function () {
			var timelineWidth = 160;
			var sliderWidth = 40;
			var sliderPositionMin = 40;
			var sliderPositionMax = sliderPositionMin + timelineWidth - sliderWidth;
			var sliderPosition = sliderPositionMin + Math.round((timelineWidth - sliderWidth) * this.position / this
				.duration);

			if (sliderPosition < sliderPositionMin) {
				sliderPosition = sliderPositionMin;
			}

			if (sliderPosition > sliderPositionMax) {
				sliderPosition = sliderPositionMax;
			}
		};

		function getFlashObject() {
			return document.getElementById("myFlash");
		}

		function play() {
			getFlashObject().SetVariable("method:setUrl", "<?php echo MEDIAFILES; ?>/<?php echo $_SESSION['FileName']; ?>");
			getFlashObject().SetVariable("method:play", "");
			getFlashObject().SetVariable("method:setVolume", "0");
		}

		function playVideo() {
			getFlashObject().SetVariable("method:setUrl", "<?php echo MEDIAFILES; ?>/<?php echo $_SESSION['FileName']; ?>");
			getFlashObject().SetVariable("method:play", "");
			getFlashObject().SetVariable("method:setVolume", "0");
		}

		function pause() {
			getFlashObject().SetVariable("method:pause", "");
		}

		function stop() {
			getFlashObject().SetVariable("method:stop", "");
		}

		function setWidth() {
			var width = document.getElementById("inputWidth").value;
			getFlashObject().width = width + "px";
		}

		function setHeight() {
			var height = document.getElementById("inputHeight").value;
			getFlashObject().height = height + "px";
		}

		function setPosition() {
			var position = document.getElementById("inputPosition").value;
			getFlashObject().SetVariable("method:setPosition", position);
		}

		function setVolume() {
			var volume = document.getElementById("inputVolume").value;
			getFlashObject().SetVariable("method:setVolume", volume);
		}

		function loadImage() {
			var url = document.getElementById("inputImage").value;
			var depth = document.getElementById("inputImageDepth").value;
			var verticalAlign = document.getElementById("inputImageVertical").value;
			var horizontalAlign = document.getElementById("inputImageHorizontal").value;
			getFlashObject().SetVariable("method:loadMovieOnTop", url + "|" + depth + "|" + verticalAlign + "|" +
				horizontalAlign);
		}

		function unloadImage() {
			var depth = document.getElementById("inputUnloadDepth").value;
			getFlashObject().SetVariable("method:unloadMovieOnTop", depth);
		}
	</script>
	<object class="playerpreview" id="myFlash" type="application/x-shockwave-flash" data="flv_player.swf"
		width="<?= $width ?>" height="<?= $heigth ?>">
		<param name="movie" value="flv_player.swf" />
		<param name="FlashVars"
			value="listener=myListener&amp;interval=500&amp;useHandCursor=0&amp;bgcolor=000000&amp;buffer=9&amp;play=1" />
	</object>
	<script>
		setTimeout("play();", 2000);
	</script>
	<?php
}

function PlayFlashObject($Folder, $File, $width, $height)
{
	?>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
		codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0" width="<?= $width ?>"
		height="<?= $height ?>">
		<param name=movie value="<?= $Folder ?>/<?= $File ?>">
		<param name="quality" value="high">
		<embed src="<?= $Folder ?>/<?= $File ?>" quality="high"
			pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"
			type="application/x-shockwave-flash" width="<?= $width ?>" height="<?= $height ?>"></embed>
	</object>
	<?php
}

function mysqldatetime()
{
	return date('Y-m-d H:i:s');
}
//Image Component Functions
function resizeImage($image, $width, $height, $scale)
{
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
	switch ($imageType) {
		case "image/gif":
			$source = imagecreatefromgif($image);
			break;
		case "image/pjpeg":
		case "image/jpeg":

		case "image/jpg":
			$source = imagecreatefromjpeg($image);
			break;
		case "image/png":
		case "image/x-png":
			$source = imagecreatefrompng($image);
			break;
	}
	imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $width, $height);

	switch ($imageType) {
		case "image/gif":
			imagegif($newImage, $image);
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			imagejpeg($newImage, $image, 90);
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage, $image);
			break;
	}

	chmod($image, 0777);
	return $image;
}
//You do not need to alter these functions
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale)
{
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);

	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
	switch ($imageType) {
		case "image/gif":
			$source = imagecreatefromgif($image);
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source = imagecreatefromjpeg($image);
			break;
		case "image/png":
		case "image/x-png":
			$source = imagecreatefrompng($image);
			break;
	}
	imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
	switch ($imageType) {
		case "image/gif":
			imagegif($newImage, $thumb_image_name);
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			imagejpeg($newImage, $thumb_image_name, 90);
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage, $thumb_image_name);
			break;
	}
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}
//You do not need to alter these functions
function getHeight($image)
{
	$size = getimagesize($image);
	$height = $size[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image)
{
	$size = getimagesize($image);
	$width = $size[0];
	return $width;
}

function refreshparentwindow()
{
	?>
	<script language="javascript">
		window.opener.location.reload();
	</script>
	<?php
}

//Fill Combo with Where Field
function fillcombocontrolWhereField($SelectedIndex, $FieldOne, $FieldTwo, $WhereField, $WhereValue, $TableName, $SortField, $SortType = "asc")
{
	$sqlQuery = "Select $FieldOne,$FieldTwo from $TableName where $WhereField=$WhereValue order by $SortField $SortType";
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	$Text = "";
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	}
	return $Text;
}





//Fill Combo with Where Field
function fillcombocontrolWhereFieldAllSelected($SelectedIndex, $FieldOne, $FieldTwo, $WhereField, $WhereValue, $TableName, $SortField, $SortType = "asc")
{
	$sqlQuery = "Select $FieldOne,$FieldTwo from $TableName where $WhereField=$WhereValue order by $SortField $SortType";
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	$Text = "";
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM))

		return $Text;
}

function CheckBrowser()
{
	if (IE_ENABLED == NO)
		$BrowserInformation = $_SERVER['HTTP_USER_AGENT'];
	if (strpos($BrowserInformation, "MSIE 6.0")) {
		require_once('browsererror.php');
		exit;
	} else if (strpos($BrowserInformation, "Firefox")) {
		require_once('browsererror.php');
		exit;
	} else if (strpos($BrowserInformation, "Chrome")) {
		require_once('browsererror.php');
		exit;
	}
}


function convertArabicNumeric($digit, $Lang = '')
{
	if (empty($digit)) {
		return '٠';
	}
	if ($Lang == '2') {
		$ar_digit = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', '-' => '', '.' => '.');
	} else {
		$ar_digit = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-' => '', '.' => '.', ',' => ',');
	}

	$arabic_digit = '';
	$length = strlen($digit);
	for ($i = 0; $i < $length; $i++) {
		if (isset($ar_digit[$digit[$i]])) {
			$arabic_digit .= $ar_digit[$digit[$i]];
		}
	}
	return $arabic_digit;
}

function EncodeUrl($Url)
{
	// $UrlObjects = trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, PREDEFINED_SALT_VALUE, $Url, MCRYPT_MODE_ECB, mcrypt_create_iv(16, MCRYPT_RAND))));
	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
	$UrlObjects = openssl_encrypt($Url, 'aes-256-cbc', PREDEFINED_SALT_VALUE, 0, $iv);
	$UrlObjects = base64_encode($UrlObjects . '::' . $iv);

	return $UrlObjects;
}

function DecodeUrl()
{
	$CompletionUrl = $_SERVER['REQUEST_URI'];
	$UrlData = explode("?", $CompletionUrl);
	if (count($UrlData) <= 1) {
		$_REQUEST['action'] = "";
		return;
	} else {
		$RemainingUrl = $UrlData[1];
		$decoded = base64_decode($RemainingUrl, true);
		if ($decoded === false) {
			return;
		}
		$UrlPieces = explode('::', $decoded, 2);
		if (count($UrlPieces) !== 2) {
			return;
		}
		list($encrypted_data, $iv) = $UrlPieces;
		$RemainingUrl = openssl_decrypt($encrypted_data, 'aes-256-cbc', PREDEFINED_SALT_VALUE, 0, $iv);
		if ($RemainingUrl === false) {
			return;
		}
		$RemainingUrlDataObject = explode("&", $RemainingUrl);
		foreach ($RemainingUrlDataObject as $UrlObjects) {
			$UrlObject = explode("=", $UrlObjects);
			if (isset($UrlObject[0]) && isset($UrlObject[1])) {
				$_REQUEST[$UrlObject[0]] = $UrlObject[1];
			}
		}
		return;
	}
}

function encodeencriptstring($string)
{
	$encodeobject = base64_encode($string);
	return $encodeobject;
}

function decodeencriptstring($string)
{
	$decodeobject = base64_decode($string);
	return $decodeobject;
}

function CheckModulePermission($UserID, $SublinkID, $ActionType)
{
	$db = new DB_Sql();
	$FetchModuleCheck = "select $ActionType from tbluserpermissions where UserID=$UserID and SublinkID=$SublinkID";
	$db->query($FetchModuleCheck);
	$db->next_Record();
	return $db->f(0);
}

function getCountRecord($TableName, $WhereFiled, $WhereFiledValue)
{
	$db = new DB_Sql();
	$sqlQuery = "Select COUNT(TableID) as counter from " . $TableName . " where " . $WhereFiled . "='" . $WhereFiledValue . "'";
	$db->query($sqlQuery);
	$db->next_record();

	return $db->f('counter');
}
function getCountRecord2($TableName, $WhereFiled, $WhereFiledValue)
{
	$db = new DB_Sql();
	$sqlQuery = "Select COUNT(TableID) as counter from " . $TableName . " where " . $WhereFiled . "=" . $WhereFiledValue . "";
	$db->query($sqlQuery);
	$db->next_record();

	return $db->f('counter');
}

function getCountRecordbyCondition($TableName, $WhereCondition)
{
	$db = new DB_Sql();
	$sqlQuery = "Select COUNT(TableID) as counter from " . $TableName . " where " . $WhereCondition;
	$db->query($sqlQuery);
	$db->next_record();

	return $db->f('counter');
}

function onlydatetimeformat($passvalue)
{
	return date("jS F Y g:i a", strtotime($passvalue));
}

function onlydateformat($passvalue)
{
	return date("jS F Y", strtotime($passvalue));
}

function onlydateshortformat($passvalue)
{
	return date("jS M Y", strtotime($passvalue));
}

function onlydateformatWithArabic($passvalue)
{
	return date("Y/m/d", strtotime($passvalue));
}

function onlydatetimeshortformat($passvalue)
{
	return date("jS M Y g:i a", strtotime($passvalue));
}

function FetchSubLinkMenuName($TableID)
{
	$db = new DB_Sql();

	$FetchLink = "select LinkName,LinkNameAr from tblsublinks where TableID='" . $TableID . "'";
	$db->query($FetchLink);

	while ($db->next_Record()) {
		return $db->f('LinkName' . LANG_SEP_DB);
	}

}

// my function

function getCountry()
{
	//    $db = new DB_Sql();
//    $FetchLink = "SELECT * FROM tblcountry ORDER BY title";
//    $db->query($FetchLink);
//    $db->next_record();
//    print_r($db->next_record());
//    return $db->f('Title');
	$sqlQuery = "SELECT * FROM tblcountry ORDER BY title";
	$db_conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	$selectDB = mysqli_select_db($db_conn, DATABASE_NAME);
	$result = mysqli_query($db_conn, $sqlQuery);
	$count = mysqli_num_fields($result);
	$i = 0;
	while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
		while ($i < $count) {
			$fieldName = mysqli_fetch_field_direct($result, $i)->name;

			$object[$fieldName] = $row[$i];
			$i++;
		}
	}
	if ($i == 0) {
		return $i;
	} else {
		return $object;
	}
}


function CheckIsBase64($str)
{
	if (base64_encode(base64_decode($str, true)) === $str) {
		return true;
	} else {
		return false;
	}
}

function AddSublinkUserPermission($MasterID, $ParentID, $RoleID, $RoleForUser, $Counter)
{
	$db = new DB_Sql();
	global $Counter2;
	$SublinkHtml = "";
	$FetchSublinkLink = "select TableID, ParentID, LinkName from tblsublinks where MasterLinkID='" . $MasterID . "' and  ParentID='" . $ParentID . "' and Active  > 0  order By Sequence";
	$db->query($FetchSublinkLink);
	while ($db->next_Record()) {
		$OtherCounter = ($ParentID > 0) ? $Counter . '.' . ++$Counter2 : ++$Counter;
		if ($RoleForUser == 1) {
			$CheckedViewPermissions = checkExistingGroupPermission("ViewPermissions", $RoleID, $db->f(0), $RoleForUser);
			$CheckedAddPermissions = checkExistingGroupPermission("AddPermissions", $RoleID, $db->f(0), $RoleForUser);
			$CheckedEditPermissions = checkExistingGroupPermission("EditPermissions", $RoleID, $db->f(0), $RoleForUser);
			$CheckedDeletePermissions = checkExistingGroupPermission("DeletePermissions", $RoleID, $db->f(0), $RoleForUser);
		}

		if ($RoleForUser == 2) {
			$CheckedViewPermissions = checkExistingGroupPermission("ViewPermissions", $RoleID, $db->f(0), $RoleForUser);
			$CheckedAddPermissions = checkExistingGroupPermission("AddPermissions", $RoleID, $db->f(0), $RoleForUser);
			$CheckedEditPermissions = checkExistingGroupPermission("EditPermissions", $RoleID, $db->f(0), $RoleForUser);
			$CheckedDeletePermissions = checkExistingGroupPermission("DeletePermissions", $RoleID, $db->f(0), $RoleForUser);
		}
		echo '<tr>
					<td align="center">' . $OtherCounter . '</td>
					<td>' . $db->f(2) . '</td>
					<td align="center"><input ' . $CheckedViewPermissions . ' type="checkbox" name="ViewPermissions[' . $db->f(0) . ']" value="' . $db->f(0) . '" class="select-all-view' . $MasterID . '"></td>
					
					<td align="center"><input ' . $CheckedAddPermissions . ' type="checkbox" name="AddPermissions[' . $db->f(0) . ']"  value="' . $db->f(0) . '" class="select-all-add' . $MasterID . '"></td>
					
					<td align="center"><input ' . $CheckedEditPermissions . ' type="checkbox" name="EditPermissions[' . $db->f(0) . ']" value="' . $db->f(0) . '" class="select-all-edit' . $MasterID . '"></td> 
					<td align="center"><input ' . $CheckedDeletePermissions . ' type="checkbox" name="DeletePermissions[' . $db->f(0) . ']" value="' . $db->f(0) . '" class="select-all-delete' . $MasterID . '"></td> 
				</tr>';

		AddSublinkUserPermission($MasterID, $db->f(0), $RoleID, $RoleForUser, $Counter);
	}
}

function checkExistingGroupPermission($PermissionType, $RoleID, $SubLinkID, $IsUserRole)
{
	$db = new DB_Sql();

	//Check Required Permissions
	if ($IsUserRole == 1)
		$FetchPermission = "select $PermissionType from tblrolespermission where SubLinkID=$SubLinkID and RoleID=$RoleID";
	if ($IsUserRole == 2)
		$FetchPermission = "select $PermissionType from tbluserpermissions where SubLinkID=$SubLinkID and UserID=$RoleID";

	$db->query($FetchPermission);
	$permissionflags = 0;
	$permissioncheked = 0;
	if ($db->num_rows() > 0) {
		$db->next_Record();
		$permissioncheked = $db->f($PermissionType);
	}

	if ($permissioncheked > 0)
		$permissionflags = ' checked="checked" ';
	else
		$permissionflags = "";

	return $permissionflags;
}

//function secureTextForDb($text)
//{
//	$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
//	$text = addslashes(strip_tags(mysqli_real_escape_string($db_conn,$text)));
//	return $text;
//}

function secureTextForDb($text)
{
	//$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
	//$text = addslashes(strip_tags(mysqli_real_escape_string($db_conn,$text)));
	$text = addslashes($text);
	return $text;
}

function showFrontEndDescription($text)
{
	//$text = clearTextForField($text);
	$text = str_replace("../files/", DOMAINNAME . "/files/", $text);
	$text = str_replace("../speedtest/", DOMAINNAME . "/speedtest/", $text);
	$text = str_replace("tiny_mce/plugins/media/", DOMAINNAME . "/images/", $text);
	return $text;
}

function ChekingTextForDb($text)
{
	if (addslashes(strip_tags(mysql_real_escape_string($text)))) {
		return false;
	} else {
		return true;
	}
}

function clearTextForDb($text)
{
	$text = addslashes($text);

	return $text;
}

function clearTextForField($text)
{
	$text = stripslashes($text);

	return $text;
}

function clearTextForFieldTextarea($text)
{
	$text = str_ireplace(array("\r\n", '\r\n'), '<br />', $text);
	return $text;
}

function generateConfigData()
{
	$finalarray = array();

	$db = new DB_Sql();

	$query = "select * from tblwebsiteconfiguration where 1";
	$db->query($query);

	while ($db->next_record()) {
		$finalarray[$db->f("Keyword")] = $db->f("Value");
	}

	return $finalarray;
}

function checkPasswordExpiry($userid)
{
	$website_config = generateConfigData();
	$db1 = new DB_Sql();
	$db1->query("select datediff(NOW(),DateTime) AS DateInterval from tblsystemuserpasswords where UserID='" . $userid . "' order by TableID DESC limit 1");
	$db1->next_Record();
	if ($db1->num_rows() == 0 || $db1->f('DateInterval') > $website_config['PasswordChange'])
		return 0;
	else
		return 1;
}

function GenerateUniqueID($TableName, $Prefix = '')
{
	global $db;
	$query = "select TableID as total from " . $TableName . " order by TableID DESC limit 1";
	$db->query($query);
	$db->next_Record();

	$TodayNo = 0;

	if ($db->f("total") > 0) {
		$TodayNo = $db->f("total");
	}

	$TodayNo += 1;

	$EnquiryNo = date("ymd") . '-' . $TodayNo;
	if ($Prefix != '')
		$EnquiryNo = $Prefix . '-' . $EnquiryNo;

	return $EnquiryNo;
}

function insertlogTable($tablename, $TableID, $action)
{
	$db = new DB_Sql();
	$ColumNameQ = "SELECT COLUMN_NAME as colums FROM INFORMATION_SCHEMA.COLUMNS WHERE `TABLE_SCHEMA`='" . DATABASE_NAME . "' and TABLE_NAME = '" . $tablename . "' and COLUMN_NAME != 'TableID'";
	$db->query($ColumNameQ);
	$Allcolumns = array();
	while ($db->next_record()) {
		$Allcolumns[] = $db->f('colums');
	}
	$Allcolumnsinsert = implode(",", $Allcolumns);
	$insertQuery = "insert into " . $tablename . "_log (LogTableID," . $Allcolumnsinsert . ") select TableID," . $Allcolumnsinsert . " from " . $tablename . " where " . $tablename . ".TableID='" . $TableID . "'";
	$db->query($insertQuery);
	$InsertID = $db->MysqlInsertID();
	$insertQuery = "update " . $tablename . "_log set Action='" . $action . "', ActionBY='" . $_SESSION[WEB_SESSION . '_userid'] . "', DateTime=NOW() where TableID='" . $InsertID . "'";
	$db->query($insertQuery);
}

function insertlogTableFront($tablename, $TableID, $action, $actionby)
{
	$db = new DB_Sql();
	$ColumNameQ = "SELECT COLUMN_NAME as colums FROM INFORMATION_SCHEMA.COLUMNS WHERE `TABLE_SCHEMA`='" . DATABASE_NAME . "' and TABLE_NAME = '" . $tablename . "' and COLUMN_NAME != 'TableID'";
	$db->query($ColumNameQ);
	$Allcolumns = array();
	while ($db->next_record()) {
		$Allcolumns[] = $db->f('colums');
	}
	$Allcolumnsinsert = implode(",", $Allcolumns);
	$insertQuery = "insert into " . $tablename . "_log (LogTableID," . $Allcolumnsinsert . ") select TableID," . $Allcolumnsinsert . " from " . $tablename . " where " . $tablename . ".TableID='" . $TableID . "'";
	$db->query($insertQuery);
	$InsertID = $db->MysqlInsertID();
	$insertQuery = "update " . $tablename . "_log set Action='" . $action . "', ActionBY='" . $actionby . "', DateTime=NOW(), ActionFrom='1' where TableID='" . $InsertID . "'";
	$db->query($insertQuery);
}




// sohail work

/// Image Gallery Section
function generateGallerySection($ParentID, $ImageType)
{
	global $db;
	$query = "select * from tblsystemimages where TypeID='" . $ImageType . "' AND ParentID='" . $ParentID . "'  order by Sequence";
	$db->query($query);
	if ($db->num_rows() > 0) {
		echo '<div class="col-md-12"><div class="title-v1 HeadingFloatUnset arabicFloatRight">
				<h3 class="HeadingFloatUnset">' . TXT_TOP_STORIES . '</h3>
			</div>
			<div class="article-page-slider-1 size-18 nav-ver2 nav-white full-width box space-30 TopStoriesSlider">
                 ';
		while ($db->next_Record()) {
			$ImagePath = RESOURCES_DOMAIN . "/" . FILES_FOLDER . "/" . THUMBNAIL_IMAGES . "/thumbnail_" . $db->f('FileName') . "?v=101";
			$PopupImagePath = RESOURCES_DOMAIN . "/" . FILES_FOLDER . "/" . ORIGINAL_IMAGES . "/" . $db->f('FileName');
			echo '<div class="post-item ver3 cat-1 overlay">
						<div class="wrap-images">
							<a href="' . $PopupImagePath . '" class="images img_gallery" >
								<img src="' . $ImagePath . '" class="img-responsive galleryimage" />
							</a> 
						</div>
					</div>
						';
		}

		echo '</div></div>';
	}
}

/// Video Gallery Section
function generateVideoGallerySection($ParentID, $VideoType)
{
	global $db;
	$query = "select * from tblsystemvideos where TypeID='" . $VideoType . "' AND ParentID='" . $ParentID . "'  order by Sequence";
	$db->query($query);
	if ($db->num_rows() > 0) {
		echo '<div class="title-v1 HeadingFloatUnset arabicFloatRight">
				<h3 class="HeadingFloatUnset">' . TXT_YOUTUBE_ARCHIVES . '</h3>
			</div>
			<div class="article-page-slider-2 slide-item-youtube-arabic space-30 nav-ver2 full-width">';
		while ($db->next_Record()) {
			if ($db->f("VideoType") == 2) {
				$imageUrl = DOMAINNAME . '/images/videoimage.jpg';
				$videoUrl = RESOURCES_DOMAIN . '/' . FILES_FOLDER . "/" . UPLOAD_VIDEOS . '/' . $db->f('FileName');
			} else {
				$v_Value = PareYouTubeLink($db->f('FileName'));
				$videoUrl = 'http://www.youtube.com/embed/' . $v_Value . '?rel=0&amp;wmode=transparent&autoplay=1';
				$imageUrl = 'http://img.youtube.com/vi/' . $v_Value . '/hqdefault.jpg';
			}
			if ($VideoType == COURSE_MEDIA_TYPE) {

				if ($_SESSION[WEB_SESSION_FRONT . '_frontuser'] != '') {
					$url = RESOURCES_DOMAIN . "/ajax_functions.php?" . EncodeUrl("Action=" . encodeencriptstring('WatchCourseVideo') . "&CourseID=" . $ParentID . "&VideoId=" . $db->f('TableID'));
					echo '<div class="post-item ver1 overlay popupVideo">
							<a href="' . $videoUrl . '" onclick="CourseVideoCheck(\'' . $url . '\')" class="courseVideoPopup popUpVideoIcon" ><img src="' . $imageUrl . '" class="img-responsive galleryimage" /></a> 
						</div>';
				} else {
					echo '<div class="post-item ver1 overlay popupVideo">
					<a href="' . RESOURCES_DOMAIN . '/login.html' . '" class=" popUpVideoIcon" ><img src="' . $imageUrl . '" class="img-responsive galleryimage" title="' . $_SESSION[session_id() . '::F' . '_frontuser'] . '" /></a> 
				</div>';
				}

			} else {
				echo '<div class="post-item ver1 overlay popupVideo">
						<a href="' . $videoUrl . '" class="img_video popUpVideoIcon" ><img src="' . $imageUrl . '" class="img-responsive galleryimage" /></a> 
				</div>';
			}

		}

		echo '</div>';
	}
}

function leftloadFrontNavigation($parentid, $currentactivemenu)
{
	global $PageTypeAr;
	$db = new DB_Sql();
	$db1 = new DB_Sql();
	$sql = "select * from tblpages where ParentTableID = '" . $parentid . "' and Active='" . ACTIVE . "' order by Sequence ASC";
	$db->query($sql);
	if ($db->num_rows() > 0) {
		$finalstring .= '<ul class="sideBarList">';
		$counter = 0;
		while ($db->next_record()) {
			$counter++;
			$class = ($currentactivemenu == $db->f("TableID")) ? ' active' : '';
			$target = ($db->f("PageType") == 4) ? " target='_blank'" : "";

			$finalstring .= '<li class="' . $class . '"><a   href="' . generateURLLinkforleftmenu($db) . '" ' . $target . ' ' . $parentclass . '>' . clearTextForField($db->f("MenuTitle" . LANG_SEP_DB)) . '</a></li>';


		}
		$finalstring .= '</ul>';

		echo $finalstring;
	}
	if ($counter == 0) {
		$sql = "select * from tblpages where ParentTableID = 0 and Active='" . ACTIVE . "' and ShowInNav='" . ACTIVE . "' order by Sequence ASC";
		$db1->query($sql);
		if ($db1->num_rows() > 0) {
			$finalstring .= '<ul class="sideBarList">';
			while ($db1->next_record()) {
				$class = ($currentactivemenu == $db1->f("TableID")) ? ' active' : '';
				$target = ($db1->f("PageType") == 4) ? " target='_blank'" : "";

				$finalstring .= '<li class="' . $class . '"><a   href="' . generateURLLinkforleftmenu($db1) . '" ' . $target . ' ' . $parentclass . '>' . clearTextForField($db1->f("MenuTitle" . LANG_SEP_DB)) . '</a></li>';

			}
			$finalstring .= '</ul>';
			echo $finalstring;
		}
	}


}
function leftloadNewsListing($currentactivemenu)
{
	$db = new DB_Sql();
	$sql = "select * from tblnews where Active='" . ACTIVE . "' order by NewsDate DESC";
	$db->query($sql);

	if ($db->num_rows() > 0) {

		$finalstring .= '<ul class="sideBarList">';

		while ($db->next_record()) {
			$urlPath = RESOURCES_DOMAIN . '/' . NEWS_URL . '/' . $db->f('URLKeyword');

			$finalstring .= '<li class="' . $class . '"><a href="' . $urlPath . '">' . clearTextForField($db->f("Title" . LANG_SEP_DB)) . '</a></li>';
		}

		$finalstring .= '</ul>';

		echo $finalstring;
	}
}

function generateURLLinkforleftmenu($dbobj)
{
	$finallink = '';
	if ($dbobj->f("PageType") == 3) {
		$finallink = "javascript:void(0)";
	} else if ($dbobj->f("PageType") == 4) {
		//$finallink = "http://".str_replace("http://","",$dbobj->f("ExternalLink".LANG_SEP_DB));
		$finallink = $dbobj->f("ExternalLink");
	} else if ($dbobj->f("PageType") == 22) {
		//$finallink = "http://".str_replace("http://","",$dbobj->f("ExternalLink".LANG_SEP_DB));
		$finallink = $dbobj->f("ExternalLink" . LANG_SEP_DB);
	} else {

		$finallink = DOMAINNAME . '/' . $dbobj->f("URLKeyword") . ".html";
	}

	return $finallink;
}

function PareYouTubeLink($url)
{
	$url = $url . '&';

	$pattern = '/v=(.+?)&+/';

	preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);

	//echo $matches[1]; die;
	return ($matches[1]);
}

function deletefiles($location, $field, $tablename, $tableid)
{
	if ($tableid > 0)
		$FileName = getFieldDataByID($field, "TableID", $tableid, $tablename);
	if ($FileName != '')
		unlink('../' . FILES_FOLDER . '/' . $location . '/' . $FileName);
}

function GallaryImageHtml($image)
{
	$BannerImage = '<div class="hk-gallery" style="cursor: pointer;">
            <div data-src="' . $image . '"><i class="icon-camera"></i> 
              <div class="gallery-img" style="background-image:url("' . $image . '");"></div>
            </div>                            
            </div>';
	return $BannerImage;
}


function SEOFriendlyURL($label)
{
	if (is_string($label)) {
		$label = str_replace("&", "and", $label);
		$finalstring = strtolower(preg_replace("/[^a-zA-Z0-9\-]+/", "-", $label));
		if ($finalstring == '-')
			$finalstring = strtolower(preg_replace("/[\s]+/", "-", $label));
		return $finalstring;
	}
	return false;
}

function SEOFriendlyPageURL($originalstring, $finalstring, $tablename)
{
	if ($finalstring != '') {
		$db = new DB_Sql();

		$query = "select * from " . $tablename . " where URLKeyword='" . $finalstring . "' order by TableID DESC limit 0,1";
		$db->query($query);
		if ($db->num_rows() > 0) {
			//$db->next_record();
			$finalval = end(explode("-", $finalstring));
			if ($finalval > 0) {
				$finalval += 1;
			} else {
				$finalval = 1;
			}

			$finalstring = $originalstring . '-' . $finalval;
			return SEOFriendlyPageURL($originalstring, $finalstring, $tablename);
		} else {
			return $finalstring;
		}
	}
}


function makeExtention($extension)
{
	if ($extension == "image/jpeg") {
		$extensionvalue = ".jpeg";
	} else if ($extension == "image/jpg") {
		$extensionvalue = ".jpg";
	} else if ($extension == "image/png") {
		$extensionvalue = ".png";
	} else if ($extension == "image/gif") {
		$extensionvalue = ".gif";
	} else if ($extension == "video/mp4") {
		$extensionvalue = ".mp4";
	} else if ($extension == "application/pdf") {
		$extensionvalue = ".pdf";
	} else if ($extension == "application/msword") {
		$extensionvalue = ".doc";
	} else if ($extension == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
		$extensionvalue = ".docx";
	} else if ($extension == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
		$extensionvalue = ".xlsx";
	} else if ($extension == "application/vnd.ms-excel") {
		$extensionvalue = ".xls";
	} else {
		$extensionvalue = ".unknown";
	}

	return $extensionvalue;
}

function is_url($uri)
{
	if (preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $uri)) {
		return true;
	} else {
		return false;
	}
}



function SendMailToUser($MailSendTo, $MailSubject, $MailMessage, $userName)
{
	$email_message = '<html>
		<head>
			<meta http-equiv="Content-Language" content="en-us">
			<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
			<meta name="ProgId" content="FrontPage.Editor.Document">
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			
		</head>
		<body>
			<div>
				<font face="Arial" size="2">
					<div style="color:#900">Dear ' . $userName . ',</div>
					' . $MailMessage . '
				</font>
			</div>
		</body>
	</html>';

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: " . FROMNAME . "<" . FROMEMAIL . ">\r\n";

	//mail($MailSendTo, $MailSubject, $email_message, $headers);

	include_once('phpmailer/class.phpmailer.php');
	$mail = new PHPMailer();
	$body = preg_replace("[\]", '', $MailMessage);
	$mail->IsSMTP(); // telling the class to use SMTP

	$mail->Host = SMTP_HOST; // SMTP server
	$mail->Port = SMTP_PORT;
	$mail->SMTPAuth = false;
	//$mail->Username = "SMTP_USER";
	//$mail->Password = "SMTP_PASSWORD";
	$mail->From = FROMEMAIL;
	$mail->FromName = FROMNAME;


	$mail->CharSet = 'UTF-8';
	$mail->Subject = $MailSubject;
	$mail->MsgHTML($email_message);
	$emailToSendAr = explode(",", $MailSendTo);
	foreach ($emailToSendAr as $key => $email) {
		$mail->AddAddress($email);
	}
	if (!$mail->Send()) {
		//echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		//echo "Message sent!";
	}
}



function SendMail($MailSendTo, $MailSubject, $MailMessage, $FromEmail, $AttachmentFile = '')
{
	$email_message = '<html>

		<head>

			<meta http-equiv="Content-Language" content="en-us">

			<meta name="GENERATOR" content="Microsoft FrontPage 5.0">

			<meta name="ProgId" content="FrontPage.Editor.Document">

			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

			<title>Dear Recipient</title>

		</head>

		<body>

			<div>

				<font face="Arial" size="2">

					<div align="center">

						<p align="left"><strong><b><font face="Tahoma" color="#993300" size="1">

						<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Dear Recepient,</span></font></b></strong>

					</div>

					<div align="center">

						<p align="left" dir="ltr">' . $MailSubject . '</p>

					</div>

					<div align="center">

						<p align="left" dir="ltr"></p>

					</div>

					<div align="center">' . $MailMessage . '</div>

				</font>

			</div>

			<p class="MsoBodyText" style="line-height: 100%" align="justify">

				<font color="#000000" face="Verdana" size="1">

					<strong>Thanks &amp; very best regards,<br /><br /></strong>

				</font>

				<strong>

					<font face="Tahoma" color="#993300" size="1">

						<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Web Administrator<br /><br /></span>

					</font>

					<font face="Tahoma" size="1" color="#0000FF">' . FROMNAME . '</span>

					</font>

				</strong>

			</p>

		</body>

	</html>';
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: " . FROMNAME . "<" . FROMEMAIL . ">\r\n";

	//mail($MailSendTo, $MailSubject, $email_message, $headers);

	include_once('phpmailer/class.phpmailer.php');
	$mail = new PHPMailer();
	$body = preg_replace("[\]", '', $MailMessage);
	//$body             = $MailMessage;
	$mail->IsSMTP(); // telling the class to use SMTP


	$mail->Host = SMTP_HOST; // SMTP server
	$mail->Port = SMTP_PORT;
	$mail->SMTPAuth = true;
	$mail->Username = SMTP_USER;
	$mail->Password = SMTP_PASSWORD;
	$mail->From = FROMEMAIL;
	$mail->FromName = FROMNAME;

	$mail->CharSet = 'UTF-8';
	$mail->Subject = $MailSubject;
	$mail->MsgHTML($email_message);
	$emailToSendAr = explode(",", $MailSendTo);

	if ($AttachmentFile != '') {
		//$mail->AddAttachment('../'.FILES_FOLDER.'/'.UPLOAD_DOCUMENT.'/'.$AttachmentFile);
		$mail->addStringAttachment(file_get_contents(DOMAINNAME . '/' . FILES_FOLDER . '/' . UPLOAD_DOCUMENT . '/' . $AttachmentFile), $AttachmentFile);
	}
	foreach ($emailToSendAr as $key => $email) {
		$mail->AddAddress($email);
	}
	if (!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}
}

function checkActiveAdminUser()
{
	$ActiveIDcount = getCountRecord('tblsystemusers_activelogin', 'SessionID', session_id());
	if ($ActiveIDcount == 0) {
		redirect('logout.php', 0);
	}
}

function CropimageSave($ImageCode, $Filelocation)
{
	$image_array_1 = explode(";", $ImageCode);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);
	$fileurl = $Filelocation;
	file_put_contents($fileurl, $data);
}

function checkUserLogin()
{
	$ActiveIDcount = getCountRecord('tbluserregistration', 'TableID', $_SESSION[WEB_SESSION_FRONT . '_frontuser']);
	if ($ActiveIDcount == 0 || $_SESSION[WEB_SESSION_FRONT . '_frontuser'] == '') {
		redirect('logout.php', 0);
	}
}

function loginRedirect($url)
{
	$ActiveIDcount = getCountRecord('tbluserregistration', 'TableID', $_SESSION[WEB_SESSION_FRONT . '_frontuser']);
	if ($ActiveIDcount > 0 && $_SESSION[WEB_SESSION_FRONT . '_frontuser'] != '') {
		redirect($url, 0);
	}
}

function filtersearchtext($searchkeyword)
{
	$searchkeyword = addslashes(addslashes(addslashes($searchkeyword)));
	$badWords = array("delete", "update", "union", "insert", "drop", "http", "iframe", "frame", "script", "src", "--");
	$searchkeyword = str_replace($badWords, "", $searchkeyword);
	$searchkeyword = preg_replace("/[^0-9a-zA-Z ]/", "", $searchkeyword);

	return $searchkeyword;
}

?>
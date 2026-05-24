<?php
ob_start();
error_reporting(0);
$localSessionPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'sessions';
if (is_dir($localSessionPath) && is_writable($localSessionPath)) {
	session_save_path($localSessionPath);
}
session_start();

$_SESSION = array();

if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

session_destroy();
$msg = '';
if(isset($_REQUEST['messageshow']))
		$msg = '?messageshow='.urlencode($_REQUEST['messageshow']);
if (ob_get_length()) {
	ob_end_clean();
}
header("Location: index.php".$msg, true, 302);
exit;
?>

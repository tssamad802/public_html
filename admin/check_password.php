<?php
// Include database connection
require_once('classes/databaseconnection.class.php');

// Create database connection
$db = new database();

// Query the samad user
$db->query("SELECT TableID, UserName, Password, Active FROM tblsystemusers WHERE UserName='samad'");

if($db->num_rows() > 0) {
    $db->next_Record();
    echo "Found user: " . $db->f('UserName') . "\n";
    echo "TableID: " . $db->f('TableID') . "\n";
    echo "Active: " . $db->f('Active') . "\n";
    echo "Stored Password Hash: " . $db->f('Password') . "\n\n";
    
    // Now compute what the hashes should be
    $password = "samad";
    $salt = "sdfjh24h2k34h234";
    $sha1_hash = sha1($password);
    $md5_salt_hash = md5($salt . md5($password) . $salt);
    
    echo "Expected SHA1 hash: $sha1_hash\n";
    echo "Expected MD5+Salt hash: $md5_salt_hash\n";
    echo "\nComparison:\n";
    echo "Stored password matches SHA1? " . ($db->f('Password') == $sha1_hash ? "YES" : "NO") . "\n";
    echo "Stored password matches MD5+Salt? " . ($db->f('Password') == $md5_salt_hash ? "YES" : "NO") . "\n";
} else {
    echo "User 'samad' not found in database!\n";
}
?>

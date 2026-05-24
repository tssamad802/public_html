<?php
// Direct database connection test
$conn = mysqli_connect('localhost', 'grabdisc_root', 'zcRN}lTDBB49', 'coupon');

if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
    exit;
}

// Query the samad user
$result = mysqli_query($conn, "SELECT TableID, UserName, Password, Active FROM tblsystemusers WHERE UserName='samad'");

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo "Found user: " . $row['UserName'] . "\n";
    echo "TableID: " . $row['TableID'] . "\n";
    echo "Active: " . $row['Active'] . "\n";
    echo "Stored Password Hash: " . $row['Password'] . "\n\n";
    
    // Now compute what the hashes should be for password "samad"
    $password = "samad";
    $salt = "sdfjh24h2k34h234";
    $sha1_hash = sha1($password);
    $md5_salt_hash = md5($salt . md5($password) . $salt);
    
    echo "=== COMPUTED HASHES FOR PASSWORD 'samad' ===\n";
    echo "Expected SHA1 hash: $sha1_hash\n";
    echo "Expected MD5+Salt hash: $md5_salt_hash\n\n";
    
    echo "=== COMPARISON ===\n";
    echo "Stored password matches SHA1? " . ($row['Password'] == $sha1_hash ? "YES ✓" : "NO ✗") . "\n";
    echo "Stored password matches MD5+Salt? " . ($row['Password'] == $md5_salt_hash ? "YES ✓" : "NO ✗") . "\n";
} else {
    echo "User 'samad' not found in database!\n";
}

mysqli_close($conn);
?>

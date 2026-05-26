<?php
require_once 'classes/commonfunctions.php';

$db = new DB_Sql();
$db->query("SELECT TableID, name, ShowHome, Active, CreatedBy FROM tblstore");
echo "Total stores in tblstore: " . $db->num_rows() . "\n";
while ($db->next_record()) {
    echo "ID: " . $db->f('TableID') . " | Name: " . $db->f('name') . " | ShowHome: " . $db->f('ShowHome') . " | Active: " . $db->f('Active') . " | CreatedBy: " . $db->f('CreatedBy') . "\n";
}
?>

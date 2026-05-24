<?php

require_once 'ajax.php';
if ($_REQUEST['url'] !="") {

    $Query="UPDATE tblstore SET disableUrl='".$_REQUEST['url']."' WHERE Active = 0 OR disableUrl = ''";
    
        $status = $db->query($Query);
        echo "{status : updated for update link} ";
}
<?php
require_once 'ajax.php';
$CheckDeletePermissioon = 1;
$userTableId = (is_array($UserRecordGetting) && isset($UserRecordGetting['TableID'])) ? (int) $UserRecordGetting['TableID'] : 2;

$subLinkId = isset($_REQUEST['SubLinkID']) ? (int) $_REQUEST['SubLinkID'] : 0;
// $CheckDeletePermissioon = $userTableId ? CheckModulePermission($userTableId, $subLinkId, "DeletePermissions") : 0;
if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listing') {
    //start search
    $whereCond = '';
    $filterActive = isset($_POST['active']) ? (int) $_POST['active'] : -1;
    $filterFeature = isset($_POST['feature']) ? (int) $_POST['feature'] : -1;
    $postValue = function ($key, $default = '') {
        return $_POST[$key] ?? $default;
    };
    

    if ($postValue('CouponName') != '') {
        $whereCond .= ' and c.CouponName LIKE "%' . secureTextForDb($postValue('CouponName')) . '%"';
    }

    if ((int) $postValue('StoreID', 0) > 0) {
        $whereCond .= ' and c.StoreID = "' . (int) $postValue('StoreID') . '"';
    }
    if ($postValue('url') != "") {
        $whereCond .= ' and c.url = "' . secureTextForDb($postValue('url')) . '"';
    }
    if ($postValue('discount') != "") {
        $whereCond .= ' and c.discount = "' . secureTextForDb($postValue('discount')) . '"';
    }
    if ($postValue('endDate') != "") {
        $whereCond .= ' and c.endDate = "' . secureTextForDb($postValue('endDate')) . '"';
    }
    if ($postValue('startDate') != "") {
        $whereCond .= ' and c.startDate = "' . secureTextForDb($postValue('startDate')) . '"';
    }
    if ((int) $postValue('CreatedBy', 0) > 0) {
        $whereCond .= ' and c.CreatedBy = "' . (int) $postValue('CreatedBy') . '"';
    }
    if ((int) $postValue('ModifiedBy', 0) > 0) {
        $whereCond .= ' and c.ModifiedBy = "' . (int) $postValue('ModifiedBy') . '"';
    }
    if ($filterActive > -1) {
        if ($filterActive == 0)
            $whereCond .= ' and c.Active = 0';
        if ($filterActive == 1)
            $whereCond .= ' and c.Active = 1';
        if ($filterActive == 2)
            $whereCond .= ' and c.Active = 2';
    }
    if ($filterFeature > -1) {
        if ($filterFeature == 1)
            $whereCond .= ' and c.featured = 1';
        if ($filterFeature == 0)
            $whereCond .= ' and c.featured = 0';
    }

    
    $TableName = "tblcoupon";
    $refresh_div = 'resultDiv';

    //     $sql = "SELECT * , c.`TableID` AS id ,c.Active AS active , s.name as storeName FROM `tblcoupon` c 
// INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`) 
// INNER JOIN  `tblsystemusers` u ON (u.`TableID` = c.`CreatedBy` ) where 1 $whereCond order  by s.name, c.Sequence";

    $sql = "SELECT *,
c.`TableID` AS id,
c.Active AS active,
s.name AS storeName
FROM tblcoupon c
INNER JOIN tblstore s ON (c.StoreID = s.TableID)
INNER JOIN tblsystemusers u ON (u.TableID = c.CreatedBy)
WHERE 1 $whereCond
ORDER BY s.name, c.Sequence";   // No semicolon here
    // echo $sql;
    // exit;
    // exit($sql);

    // current page (start) is the page number; default to 1
    $start = isset($_REQUEST['start']) && is_numeric($_REQUEST['start']) ? max(1, (int) $_REQUEST['start']) : 1;
    // allow configurable items per page via request (fallback to 100)
    $per_page = isset($_REQUEST['per_page']) && is_numeric($_REQUEST['per_page']) ? max(1, (int) $_REQUEST['per_page']) : 100;

    $pagination = new pagination($sql, $per_page, $start, $refresh_div, 'searchfrm');
    $sql_page = $pagination->get_query();
    $db->query($sql_page);

    $page_links = $pagination->get_linksDashoard("ajax_news.php?FireAction=listing&action=" . ($_REQUEST['action'] ?? '') . "&SubLinkID=" . ($_REQUEST['SubLinkID'] ?? '') . "&");

    // Record numbering start (serial number): calculate based on page and per-page
    $RecordCount = ($start > 1) ? (($start - 1) * $per_page) + 1 : 1;

    if ($db->num_rows() > 0) {
        ?>
                                            <table class="table table-hover w-100 display pb-30 dataTable" >
                                                 <thead>
                                                      <tr>
                                                        <th width="10" align="center" ><?= SNO ?></th>
                                                        <th align="center">Store</th>
                                                        <th align="left">Name</th>
                                                        <th align="right" style="text-align:right;">Code</th>
                                                     <!--   <th align="center" style="text-align:center;">Tracking</th>-->
                                                            <!--<th align="center">Logo</th>-->
                                                        <th align="center">Init</th>
                                                        <th align="center">Expire</th>
                                        <!--                  <th width="8%" align="center">Date</th>-->
                                                        <th align="center">Status</th>
                                                        <th align="center">Add By</th>
                                        <!--                  <th width="8%" align="center">Update By</th>-->
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody >
                                            <?php
                                            while ($db->next_Record()) {
                                                //	$RecordCount++;
                                                // print_r($db->Record);
                                                $Status = ($db->f('active') == 1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
                                                $StatusClass = ($db->f('active') == 1) ? 'badge-success' : 'badge-danger';
                                                //      <td align="center">//=onlydateshortformat($db->f('CreatedDateTime'))<!--</td>-->
//        <td align="right">//=$db->f('FullName')<!--</td>-->
                                                ?>
                                                                    <tr id="listItem_<?= $db->f('id') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td align="center"><?= $db->f('storeName') ?></td>
                                                                        <td align="center"><?= $db->f('CouponName') ?></td>
                                                                        <td align="center"><?= $db->f('couponCode') ?></td>
                                                                        <!--<td align="center"><?= ($db->f('trackingLink') != "") ? "Yes" : "No" ?></td>-->
                                                                        <!--<td align="center"><?= ($db->f('logo') != "") ? "Yes" : "No" ?></td>-->
                                                                        <td align="center"><?= onlydateshortformat($db->f('startDate')) ?></td>
                                                                        <td align="center"><?= onlydateshortformat($db->f('endDate')) ?></td>

                                                                        <td align="center" class=""><span class="badge <?= $StatusClass ?>" id="c<?= $db->f('id') ?>" onclick="UpdateCouponActive(<?= json_encode($Status) ?>, <?= (int) $db->f('id') ?>)"><?= $Status ?></span></td>
                                                                        <td align="center"><?= $db->f('FullName') ?></td>

                                                                        <td align="center">
                                                                            <div class="action-buttons" style="white-space:nowrap;">
                                                                                <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('id') . "&Trigger=edit") ?>" class="iconhoverbox" style="margin:0 6px;"> <i class="icon-pencil"></i> </a>
                                                                             <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                     <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring($TableName) ?>" data-id="<?= encodeencriptstring($db->f('id')) ?>" style="margin:0 6px;"> <i class="icon-trash txt-danger"></i> </a>
                                                                             <?php } ?>
                                                                                     <a href="javascript:;" data-href="AllQuickViewDetails.php?<?php echo EncodeUrl('Action=CouponDetail&RecordID=' . $db->f('id')); ?>" class="iconhoverbox quickview" style="margin:0 6px;"><i class="icon-eye"></i></a>
                                                                            </div>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                                                $RecordCount++;
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <div class="dataTables_paginate paging_simple_numbers" id="datable_1_paginate">
                                                    <?php echo $page_links; ?>
                                                </div>
                                            <?php
    }
}
if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listinggallery') {

    $TableName = "tblslider";
    $refresh_div = 'resultDiv';
    $sql = "select * from  $TableName where TableID=" . $_REQUEST['ParentID'];

    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th align="left"><?= IMAGES ?></th>
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>" >
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;

                                                /*$BannerImage = "-";
                                                if($db->f('BannerImage')!='')
                                                {
                                                    $BannerImage = GallaryImageHtml('../'.FILES_FOLDER.'/'.DOCUMENT_FOLDER.'/'.$db->f('BannerImage'));
                                                }*/

                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td align="left"><img src="<?= '../' . FILES_FOLDER . '/' . THUMBNAIL_IMAGES . '/thumbnail_' . $db->f('Name') ?>" height="80" /></td>
                                                                        <td align="center">
                                                                         <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring($TableName) ?>" data-id="<?= encodeencriptstring($db->f('TableID')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>
                                                                         <?php } ?>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}

if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingvideogallery') {

    $TableName = "tblsystemvideos";
    $refresh_div = 'resultDiv';

    $sql = "select * from  $TableName where TypeID='" . $_REQUEST['TypeID'] . "' AND ParentID='" . $_REQUEST['ParentID'] . "' order by Sequence ASC";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th align="left"><?= IMAGES ?></th>
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>" >
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $BannerImage = "-";
                                                if ($db->f("VideoType") == 2) {
                                                    $Thumnbanil = '<video  preload="metadata" width="200" height="100">
							  <source src="' . RESOURCES_DOMAIN . '/' . FILES_FOLDER . "/" . UPLOAD_VIDEOS . '/' . $db->f('FileName') . '" type="video/mp4">
							</video>';
                                                } else {
                                                    $v_Value = PareYouTubeLink($db->f('FileName'));
                                                    //$Thumnbanil = '<iframe width="200" height="100" src="http://www.youtube.com/embed/'.$v_Value.'?rel=0&amp;wmode=transparent"></iframe>';
                                                    $Thumnbanil = '<img src="http://img.youtube.com/vi/' . $v_Value . '/mqdefault.jpg" height="100" />';
                                                }

                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td align="left"><?= $Thumnbanil ?></td>
                                                                        <td align="center">
                                                                         <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring($TableName) ?>" data-id="<?= encodeencriptstring($db->f('TableID')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>
                                                                         <?php } ?>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}

if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'sortstore') {

    ?>

                    <script type="text/javascript">
                        //alert('Test');
                        //const element = document.getElementById("printdivbox");
                        //element.remove();
    
    
                        //const element = document.getElementByClassName("preloader-it");
                        //element.remove();    
                        //document.getElementByClassName('preloader-it').style.display = "none":
    
                    </script>


                    <?php

                    //start search
                    $whereCond = '';
                    $filterActive = isset($_POST['active']) ? (int) $_POST['active'] : -1;
                    $filterFeature = isset($_POST['feature']) ? (int) $_POST['feature'] : -1;

                    if ($_POST['name'] != '') {
                        $whereCond .= ' and s.name LIKE "%' . $_POST['name'] . '%"';
                    }

                    if ($_POST['CountryID'] > 0) {
                        $whereCond .= ' and s.CountryID = "' . $_POST['CountryID'] . '"';
                    }
                    if ($_POST['url'] != "") {
                        $whereCond .= ' and s.url = "' . $_POST['url'] . '"';
                    }
                    if ($_POST['discount'] != "") {
                        $whereCond .= ' and s.discount = "' . $_POST['discount'] . '"';
                    }
                    if ($_POST['NetworkID'] > 0) {
                        $whereCond .= ' and s.NetworkID = "' . $_POST['NetworkID'] . '"';
                    }
                    if ($_POST['startDate'] != "") {
                        $whereCond .= ' and c.startDate = "' . $_POST['startDate'] . '"';
                    }
                    if ($_POST['CreatedBy'] > 0) {
                        $whereCond .= ' and s.CreatedBy = "' . $_POST['CreatedBy'] . '"';
                    }
                    if ($_POST['ModifiedBy'] > 0) {
                        $whereCond .= ' and s.ModifiedBy = "' . $_POST['ModifiedBy'] . '"';
                    }
                    if ($filterActive > -1) {
                        if ($filterActive == 0)
                            $whereCond .= ' and s.Active = 0';
                        if ($filterActive == 1)
                            $whereCond .= ' and s.Active = 1';
                        if ($filterActive == 2)
                            $whereCond .= ' and s.Active = 2';
                    }
                    if ($filterFeature > 0) {
                        if ($filterFeature == 1)
                            $whereCond .= ' and s.featured = 1';
                        if ($filterFeature == 0)
                            $whereCond .= ' and s.featured = 0';
                    }


                    $TableName = "tblcoupon";
                    $refresh_div = 'resultDiv';
                    $whereCond = "s.`TableID` = " . $_REQUEST['RecordID'] . "  and c.endDate >= CURDATE()";//
//$sql="select * from  $TableName order by storeDate DESC";
                    $sql = "SELECT c.* ,s.name as name ,s.Active active , s.`TableID` AS id ,c.TableID as TableID , c.couponName CouponName , c.endDate date FROM tblcoupon c 
INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`)  where $whereCond order by c.SEQUENCE ASC";          

                    // echo $sql;
                
                    // exit;
                 
                    $db->query($sql);
                    $RecordCount = 0;
                    if ($db->num_rows() > 0) {                                   
                        ?>
                                                <table id="couponSorting" class="table table-hover w-100 display pb-30 sort-table"> <!-- removed id datatable_1 -->
                                                    <thead>
                                                    <tr>                                                                                                                              
                                        <!--                <th width="4%" align="center" >--><?//=SNO ?><!--</th>-->
                                                        <th align="left">Coupon Name</th>
                                                        <th align="left">Coupon Class</th>
                                                        <th width="8%" align="center">Sort</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>">
                                                    <?php

                                                    while ($db->next_Record()) {
                                                        $RecordCount++;
                                                        $Status = ($db->f('active') == 1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
                                                        $StatusClass = ($db->f('active') == 1) ? 'badge-success' : 'badge-danger';
                                                        if ($RecordCount == 1)
                                                            echo "Store Name : " . $db->f('name');
                                                        ?>
                                                                            <tr id="listItem_<?= $db->f('TableID') ?>">
                                                            <!--                    <td class="line-height" align="center">--><?//=$RecordCount ?><!--</td>-->
                                                                                <td align="left"><?= $db->f('CouponName') ?></td>
                                                                                <td align="left"><?= $db->f('couponClassification') ?></td>
                                                                                <td align="center"><a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=SortRecord&RecordID=" . $db->f('id') . "&Trigger=edit") ?>" class="iconhoverbox" title="<?= TXT_EDIT_RECORD ?>"> <img src="../admin/images/sort.png"> </a></td>
                                                                            </tr>
                                                                            <?php
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <?php
                    }
                    if ($RecordCount == 0) {
                        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
                    }

                    if ($pagination->tot_pages > 1) {
                        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                            <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
                    }
}

if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingstore') {

    //start search
    $whereCond = '';
    $filterActive = isset($_POST['active']) ? (int) $_POST['active'] : -1;
    $filterFeature = isset($_POST['feature']) ? (int) $_POST['feature'] : -1;

    if ($_POST['name'] != '') {
        $whereCond .= ' and s.name LIKE "%' . $_POST['name'] . '%"';
    }

    if ($_POST['CountryID'] > 0) {
        $whereCond .= ' and s.CountryID = "' . $_POST['CountryID'] . '"';
    }
    if ($_POST['url'] != "") {
        $whereCond .= ' and s.url = "' . $_POST['url'] . '"';
    }
    if ($_POST['discount'] != "") {
        $whereCond .= ' and s.discount = "' . $_POST['discount'] . '"';
    }
    if ($_POST['NetworkID'] > 0) {
        $whereCond .= ' and s.NetworkID = "' . $_POST['NetworkID'] . '"';
    }
    // if ($_POST['startDate'] != "") {
    //     $whereCond .= ' and c.startDate = "' . $_POST['startDate'] . '"';
    // }
    if (!empty($_POST['startDate'])) {
        $whereCond .= ' and c.startDate = "' . $_POST['startDate'] . '"';
    }
    if ($_POST['CreatedBy'] > 0) {
        $whereCond .= ' and s.CreatedBy = "' . $_POST['CreatedBy'] . '"';
    }
    if ($_POST['ModifiedBy'] > 0) {
        $whereCond .= ' and s.ModifiedBy = "' . $_POST['ModifiedBy'] . '"';
    }
    if ($filterActive > -1) {
        if ($filterActive == 0)
            $whereCond .= ' and s.Active = 0';
        if ($filterActive == 1)
            $whereCond .= ' and s.Active = 1';
        if ($filterActive == 2)
            $whereCond .= ' and s.Active = 2';
    }
    if ($filterFeature > 0) {
        if ($filterFeature == 1)
            $whereCond .= ' and s.featured = 1';
        if ($filterFeature == 0)
            $whereCond .= ' and s.featured = 0';
    }


    $TableName = "tblstore";
    $refresh_div = 'resultDiv';

    $sql = "select * from  $TableName order by storeDate DESC";
//     $sql = "SELECT * ,s.Active active , s.`TableID` AS id , n.Title as NetName FROM tblstore s 
// INNER JOIN `tblcountry` c ON (s.`CountryID` = c.`TableID`) 
// INNER JOIN `tblsystemusers` u ON (u.`TableID` = s.`CreatedBy`) 
// INNER JOIN tblnetwork n ON (n.`TableID` = s.`NetworkID`) where 1 $whereCond order by name ASC";
$sql = "SELECT *,
s.Active AS active,
s.TableID AS id,
n.Title AS NetName
FROM tblstore s
INNER JOIN tblcountry c ON (s.CountryID = c.TableID)
INNER JOIN tblsystemusers u ON (u.TableID = s.CreatedBy)
INNER JOIN tblnetwork n ON (n.TableID = s.NetworkID)
WHERE 1
ORDER BY s.name ASC;";

    // $sql = "SELECT
//     s.TableID AS id,
//     s.Name,
//     s.Active AS active,
//     s.CountryID,
//     s.CreatedBy,
//     s.NetworkID,
//     u.Username AS CreatedByUser,
//     n.Title AS NetName
// FROM tblstore s
// INNER JOIN tblcountry c ON s.CountryID = c.TableID
// INNER JOIN tblsystemusers u ON s.CreatedBy = u.TableID
// INNER JOIN tblnetwork n ON s.NetworkID = n.TableID
// ORDER BY s.Name ASC";

    // echo $sql;
    // exit;
    $db->query($sql);

    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>

                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th align="left">Name</th>
                                                        <th align="center" style="text-align:center;">Tracking</th>
                                                        <th width="8%" align="center">Network</th>
                                                        <th width="8%" align="center">Logo</th>
                                                        <th width="8%" align="center">Status</th>
                                                        <th width="8%" align="center">Date</th>
                                                          <th width="8%" align="center">Created By</th>
                                        <!--                <th width="8%" align="center">Update</th>-->
                                        <!--                  <th width="8%" align="center">Updated By</th>-->
                                                          <th width="8%" align="center">Sort</th>
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody >
                                            <?php
                                            //echo $db->next_Record();
                                    
                                            // Step 1: Fetch all records into an array
                                            $records = [];
                                            while ($db->next_Record()) {
                                                $records[] = $db->Record; // store each row (assuming $db->Record is the associative array)
                                                //echo "<script>console.log(" . json_encode($records) . ");</script>";
                                            }

                                            // Step 2: Loop using a for loop
                                            $RecordCount = 0;
                                            $total = count($records);
                                            for ($i = 0; $i < $total; $i++) {
                                                $row = $records[$i];
                                                $RecordCount++;

                                                $Status = ($row['active'] == 1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
                                                $StatusClass = ($row['active'] == 1) ? 'badge-success' : 'badge-danger';
                                                $StatusTracking = ($row['trackingUrl'] != "") ? 'Yes' : 'No';
                                                ?>
                                                                <tr>
                                                                    <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                    <td align="center"><?= $row['name'] ?></td>
                                                                    <td align="center"><?= $StatusTracking ?></td>
                                                                    <td align="center"><?= $row['NetName'] ?></td>
                                                                    <td align="center"><?= ($row['logo'] != null) ? "Yes" : "No" ?></td>
                                                                    <td align="center">
                                                                        <span id="<?= (int) $row['id'] ?>" class="badge <?= $StatusClass ?>" onclick="UpdateActive(<?= json_encode($Status) ?>, <?= (int) $row['id'] ?>)">
                                                                            <?= $Status ?>
                                                                        </span>
                                                                    </td>
                                                                    <td align="center"><?= onlydateshortformat($row['storeDate']) ?></td>
                                                                    <td align="center"><?= $row['FullName'] ?></td>
                                                                    <td align="center">
                                                                        <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=SortRecord&RecordID=" . $row['id'] . "&Trigger=edit") ?>" class="iconhoverbox" >
                                                                            <img src="../admin/images/sort.png">
                                                                        </a>
                                                                    </td>
                                                                    <td align="center">
                                                                        <div class="action-buttons" style="white-space:nowrap;">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $row['id'] . "&Trigger=edit") ?>" class="iconhoverbox" style="margin:0 6px;">
                                                                                <i class="icon-pencil"></i>
                                                                            </a>
                                                                         <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                <a class="deleterecord iconhoverbox" href="#" data-action_title="<?= TXT_DELETE_CONFIRM ?>" data-action_msg="<?= TXT_SELECTED_RECORD_DELETED ?>" data-message="<?= TXT_RECORD_DELETE_ACTION ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring($TableName) ?>" data-id="<?= encodeencriptstring($row['id']) ?>" style="margin:0 6px;">
                                                                                    <i class="icon-trash txt-danger"></i>
                                                                                </a>
                                                                         <?php } ?>
                                                                                <a href="javascript:;" data-href="AllQuickViewDetails.php?<?= EncodeUrl('Action=StoreDetail&RecordID=' . $row['id']) ?>" class="iconhoverbox quickview" style="margin:0 6px;">
                                                                                    <i class="icon-eye"></i>
                                                                                </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                            } // end for loop
                                            ?>

                                        </tbody>
                                            </table>
    
                                            <script type="text/javascript">
        
                                                $(".loader-div").hide();
        
                                            </script>
    
                                        <?php

                                        // 	while($db->next_Record())
// 	{
// 		$RecordCount++;
// 		$Status = ($db->f('active')==1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
//         $StatusClass =   ($db->f('active')==1)?'badge-success':'badge-danger';
//         $StatusTracking =   ($db->f('trackingUrl')!="")?'Yes':'No';
                                        ?>
                                        <!--		<tr >-->
                                        <!--			<td class="line-height" align="center"><?= $RecordCount ?></td>-->
                                        <!--			<td align="center"><?= $db->f('name') ?></td>-->
                                        <!--			<td align="center"><?= $StatusTracking ?></td>-->
                                        <!--            <td align="center"><?= $db->f('NetName') ?></td>-->
                                        <!--            <td align="center"><?php if ($db->f('logo') != null)
                                            echo "Yes";
                                        else
                                            echo "No"; ?></td>-->
                                        <!--            <td align="center" class=""><span id="<?= $db->f('id') ?>" class="badge <?= $StatusClass ?>" onclick="UpdateActive('<?= $Status ?>' , <?= $db->f('id') ?>)" ><?= $Status ?></span></td>-->
                                        <!--            <td align="center"><?= onlydateshortformat($db->f('storeDate')) ?></td>-->
                                        <!--            <td align="center"><?= $db->f('FullName') ?></td>-->
                                        <!--            <td align="center"> $db->f('ModifiedDateTime')?> </td>-->
                                        <!--            <td align="center"> $db->f('ModifiedBy')?> </td>-->
                                        <!--            <td align="center"><a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=SortRecord&RecordID=" . $db->f('id') . "&Trigger=edit") ?>" class="iconhoverbox" title=""> <img src="../admin/images/sort.png"> </a></td>-->
                                        <!--            <td align="center">-->
                                        <!--           	 <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('id') . "&Trigger=edit") ?>" class="iconhoverbox" title=""> <i class="icon-pencil"></i> </a>-->
                                        <!--             <?php if ($CheckDeletePermissioon == 1) { ?>-->
                                                            <!--             &nbsp;&nbsp;-->
                                                            <!--             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring($TableName) ?>" data-id="<?= encodeencriptstring($db->f('id')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>-->
                                                            <!--             <a href="javascript:;" data-href="AllQuickViewDetails.php?<?php echo EncodeUrl('Action=StoreDetail&RecordID=' . $db->f('id')); ?>" class="iconhoverbox quickview"><i class="icon-eye"></i></a>-->
                                                     <?php } ?>
                                          <!--          </td>-->

                                                <!--</tr>-->
                                            <?php
                                            //} ?>
                                            <!--	</tbody>-->
                                            <!--</table>-->
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

   if (isset($pagination) && $pagination->tot_pages > 1) {
?>
<tr>
    <td colspan="11">
        <center>
            <?php echo $page_links ?? ''; ?>
        </center>
    </td>
</tr>
<?php
}
}
if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingevents') {
    $TableName = "tblevents";
    $refresh_div = 'resultDiv';

    $sql = "select * from  $TableName order by Sequence";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th align="left"><?= TXT_TITLE_ENGLISH ?></th>
                                                        <th align="right" style="text-align:right;"><?= TXT_TITLE_ARABIC ?></th>
                                                        <th  align="center" style="text-align:center;"><?= TXT_FROM_DATE ?></th>
                                                        <th  align="center" style="text-align:center;"><?= TXT_TO_DATE ?></th>
                                                        <th width="8%" align="center"><?= TXT_ACTIVE_USER ?></th>
                                                        <th width="8%" align="center"><?= TXT_IMAGE_GALLERY ?></th>
                                                        <th width="8%" align="center"><?= TXT_VIDEO_GALLERY ?></th>
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>">
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $Status = ($db->f('Active') == 1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
                                                $StatusClass = ($db->f('Active') == 1) ? 'badge-success' : 'badge-danger';
                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td align="left"><?= $db->f('Title') ?></td>
                                                                        <td align="right"><?= $db->f('TitleAr') ?></td>
                                                                        <td align="center"><?= onlydateshortformat($db->f('FromDate')) ?></td>
                                                                        <td align="center"><?= onlydateshortformat($db->f('ToDate')) ?></td>
                                                                        <td align="center" class=""><span class="badge <?= $StatusClass ?>"><?= $Status ?></span></td>
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=PageGallery&ParentID=" . $db->f('TableID') . "&TypeID=" . EVENT_MEDIA_TYPE . "&TableName=" . $TableName) ?>" class="iconhoverbox" > <i class="icon-link"></i> </a>
                                                                        </td>
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=PageVideo&ParentID=" . $db->f('TableID') . "&TypeID=" . EVENT_MEDIA_TYPE . "&TableName=" . $TableName) ?>" class="iconhoverbox" > <i class="icon-camera"></i> </a>
                                                                        </td>
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('TableID') . "&Trigger=edit") ?>" class="iconhoverbox" title="<?= TXT_EDIT_RECORD ?>"> <i class="icon-pencil"></i> </a>
                                                                         <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring($TableName) ?>" data-id="<?= encodeencriptstring($db->f('TableID')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>
                                                                         <?php } ?>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}

if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingpublication') {

    $TableName = "tblpublications";
    $refresh_div = 'resultDiv';
    $whereCond = '1';
    $sql = "SELECT * ,s.Active active , s.`TableID` AS id , n.Title as NetName FROM tblstore s 
INNER JOIN `tblcountry` c ON (s.`CountryID` = c.`TableID`) 
INNER JOIN `tbluserregistration_log` u ON (u.`TableID` = s.`CreatedBy`) 
INNER JOIN tblnetwork n ON (n.`TableID` = s.`NetworkID`) where  $whereCond order by name ASC";

// echo $sql;
// exit;
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                            <thead>
                                                <tr>
                                                    <th width="4%" align="center" ><?= SNO ?></th>
                                                    <th align="left">Name</th>
                                                    <th align="center" style="text-align:center;">Tracking</th>
                                                    <th width="8%" align="center">Network</th>
                                                    <th width="8%" align="center">Logo</th>
                                        <!--            <th width="8%" align="center">Status</th>-->
                                                    <th width="8%" align="center">Date</th>
                                                    <th width="8%" align="center">Created By</th>
                                                                    <th width="8%" align="center">Update</th>
                                        <!--                              <th width="8%" align="center">Updated By</th>-->
                                        <!--            <th width="8%" align="center">/Sort</th>-->
                                                    <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                </tr>
                                                </thead>
                                                <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>">
                                                <?php
                                                while ($db->next_Record()) {
                                                    $RecordCount++;
                                                    //            $Status = ($db->f('active')==1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
//            $StatusClass =   ($db->f('active')==1)?'badge-success':'badge-danger';
                                                    $StatusTracking = ($db->f('trackingUrl') != "") ? 'Yes' : 'No';

                                                    ?>
                                                                        <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                            <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                            <td align="center"><?= $db->f('name') ?></td>
                                                                            <td align="center"><?= $StatusTracking ?></td>
                                                                            <td align="center"><?= $db->f('NetName') ?></td>
                                                                            <td align="center"><?php if ($db->f('logo') != null)
                                                                                echo "Yes";
                                                                            else
                                                                                echo "No"; ?></td>
                                                            <!--                <td align="center" class=""><span id="--=$db->f('id')<--" class="badge /=$StatusClass?>" onclick="UpdateActive('<?//=$Status ?>//' , <?//=$db->f('id') ?>//)" ><?//=$Status ?></span></td>-->
                                                                            <td align="center"><?= onlydateshortformat($db->f('storeDate')) ?></td>
                                                                            <td align="center"><?= $db->f('FullName') ?></td>
                                                                                        <td align="center"><?= $db->f('ModifiedDateTime') ?> </td>
                                                            <!--                            <td align="center"><?//=$db->f('ModifiedBy') ?>- </td>-->
                                                            <!--                <td align="center"><a href="<?//="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=SortRecord&RecordID=".$db->f('id')."&Trigger  =edit") ?><-" class="iconhoverbox" title="--><?//=TXT_EDIT_RECORD ?><!--"> <img src="../admin/images/sort.png"> </a></td>-->
                                                                            <td align="center">
                                                            <!--                    <a href="<?//="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&RecordID=".$db->f('id')."&Trigger=edit") ?><!--" class="iconhoverbox" title="--><?//=TXT_EDIT_RECORD ?><!--"> <i class="icon-pencil"></i> </a>-->
                                                            <!--                    <a href="<?//="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&RecordID=".$db->f('id')."&Trigger=edit") ?>  " class="iconhoverbox" title="--><?//=TXT_EDIT_RECORD ?><!--"> <i class="icon-pencil"></i> </a>-->

                                                                                <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                                        &nbsp;&nbsp;
                                                                                                        <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring('tblstore') ?>" data-id="<?= encodeencriptstring($db->f('id')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>
                                                                                <!--                        <a href="javascript:;" data-href="AllQuickViewDetails.php?--><?php //echo EncodeUrl('Action=StoreDetail&RecordID='.$db->f('id')); ?><!--" class="iconhoverbox quickview"><i class="icon-eye"></i></a>-->
                                                                                <?php } ?>
                                                                            </td>

                                                                        </tr>
                                                                        <?php
                                                } ?>
                                                </tbody>
                                            </table>    <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}
if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingslider') {
    $TableName = "tblslider";
    $refresh_div = 'resultDiv';

    $sql = "select * from $TableName";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th align="left">URL</th>
                                        <!--                  <th align="left">Type</th>-->
                                                          <th align="left">Title</th>
                                        <!--                  <th align="left">ShowHome</th>-->
                                                          <th align="left">Code</th>
                                                        <th width="8%" align="center"><?= TXT_ACTIVE_USER ?></th>

                                        <!--            	<th width="8%" align="center" style="text-align:center;">--><?//=TXT_IMAGE_GALLERY ?><!--</th>-->
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>">
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $Status = ($db->f('Active') == 1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
                                                $StatusClass = ($db->f('Active') == 1) ? 'badge-success' : 'badge-danger';
                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td align="left"><?= $db->f('URL') ?></td>
                                                                        <td align="left"><?= $db->f('Title') ?></td>
                                                                        <td align="left"><?= $db->f('couponCode') ?></td>
                                                            <!--            <td align="center" class=""><span class="badge --><?//=$StatusClass ?><!--">--><?//=$Status ?><!--</span></td>-->
                                                            <!--            <td align="center">-->
                                                                        <td align="center" class=""><span class="badge <?= $StatusClass ?>" id="<?= (int) $db->f('TableID') ?>" onclick="UpdateActive(<?= json_encode($Status) ?>, <?= (int) $db->f('TableID') ?>, <?= json_encode($_REQUEST['TableName'] ?? $TableName) ?>)"><?= $Status ?></span></td>

                                                                        <!--           	 <a href="//="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=PageGallery&ParentID=".$db->f('TableID')."&TypeID=".COURSE_MEDIA_TYPE."&TableName=".$TableName)?>" class="iconhoverbox" > <i class="icon-link"></i> </a>-->
                                                            <!--            </td>-->
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('TableID') . "&Trigger=edit") ?>" class="iconhoverbox" title="<?= TXT_EDIT_RECORD ?>"> <i class="icon-pencil"></i> </a>
                                                                         <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                                <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring($TableName) ?>" data-id="<?= encodeencriptstring($db->f('TableID')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>
                                                                         <?php } ?>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}

if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingcoursesassestmenttest') {
    $TableName = "tblcoursequestion";
    $refresh_div = 'resultDiv';

    $sql = "select A.*,B.Title" . LANG_SEP_DB . " as Course from  $TableName A 
inner join  tblcourses B on B.TableID=A.CourseID
where A.CourseID='" . $_REQUEST['ParentID'] . "' order by A.Sequence ASC";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th align="left"><?= TXT_TITLE_ENGLISH ?></th>
                                                        <th align="right" style="text-align:right;"><?= TXT_TITLE_ARABIC ?></th>
                                                        <th width="8%" align="center"><?= TXT_ACTIVE_USER ?></th>
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>">
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $Status = ($db->f('Active') == 1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
                                                $StatusClass = ($db->f('Active') == 1) ? 'badge-success' : 'badge-danger';
                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td align="left"><?= $db->f('Title') ?></td>
                                                                        <td align="right"><?= $db->f('TitleAr') ?></td>
                                                                        <td align="center" class=""><span class="badge <?= $StatusClass ?>"><?= $Status ?></span></td>
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecordQuestion&RecordID=" . $db->f('TableID') . "&Trigger=edit&ParentID=" . $_REQUEST['ParentID']) ?>" class="iconhoverbox" title="<?= TXT_EDIT_RECORD ?>"> <i class="icon-pencil"></i> </a>
                                                                         <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring($TableName) ?>" data-id="<?= encodeencriptstring($db->f('TableID')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>
                                                                         <?php } ?>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}

if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listinglibrary') {
    $TableName = "tblbooklibrary";
    $refresh_div = 'resultDiv';

    $sql = "select A.*,B.Title" . LANG_SEP_DB . " as Category from  $TableName A 
inner join  tblbookcategory B on B.TableID=A.CategoryID
order by B.Title" . LANG_SEP_DB . " ASC, A.BookName" . LANG_SEP_DB . " ASC";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th><?= TXT_CATEGORY ?></th>
                                                        <th ><?= TXT_BOOK ?></th>
                                                        <th ><?= TXT_AUTHOR ?></th>
                                                        <th ><?= TXT_AUDITOR ?></th>
                                                        <th ><?= TXT_PUBLISHER ?></th>
                                                        <th width="8%" align="center"><?= TXT_ACTIVE_USER ?></th>
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>">
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $Status = ($db->f('Active') == 1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
                                                $StatusClass = ($db->f('Active') == 1) ? 'badge-success' : 'badge-danger';
                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td ><?= $db->f('Category') ?></td>
                                                                        <td ><?= $db->f('BookName' . LANG_SEP_DB) ?></td>
                                                                        <td ><?= $db->f('AuthorName' . LANG_SEP_DB) ?></td>
                                                                        <td ><?= $db->f('AuditorName' . LANG_SEP_DB) ?></td>
                                                                        <td ><?= $db->f('PublisherName' . LANG_SEP_DB) ?></td>
                                                                        <td align="center" class=""><span class="badge <?= $StatusClass ?>"><?= $Status ?></span></td>
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('TableID') . "&Trigger=edit") ?>" class="iconhoverbox" title="<?= TXT_EDIT_RECORD ?>"> <i class="icon-pencil"></i> </a>
                                                                         <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                             &nbsp; &nbsp; <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring($TableName) ?>" data-id="<?= encodeencriptstring($db->f('TableID')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>
                                                                         <?php } ?>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}
if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingsportcomplex') {
    $TableName = "tblsportscomplex";
    $refresh_div = 'resultDiv';

    $sql = "select A.*,B.Nationality" . LANG_SEP_DB . " NationalityName, C.Title" . LANG_SEP_DB . " as StatusName  from  tblsportscomplex A 
inner join  tblcountries B on B.TableID=A.NationalityID
left join  tblsportcomplexstatus C on C.TableID=A.Status
order by A.TableID DESC";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th align="left"><?= TXT_REQUEST_NO ?></th>
                                                        <th align="left"><?= TXT_NAME ?></th>
                                                        <th align="left"><?= TXT_GENDER ?></th>
                                                        <th align="left"><?= TXT_EMAIL ?></th>
                                                        <th align="left"><?= TXT_NATIONALITY ?></th>
                                                        <th width="5%" align="center" style="text-align:center;"><?= TXT_STATUS ?></th>
                                                        <th width="5%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>">
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $Status = ($db->f('Status') == 0) ? '-' : $db->f('StatusName');
                                                $StatusClass = ($db->f('Status') > 0) ? 'badge-success' : 'badge-danger';
                                                $Gender = ($db->f('Gender') == 1) ? TXT_MALE : TXT_FEMALE;
                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td ><?= $db->f('RequestNo') ?></td>
                                                                        <td ><?= $db->f('FullName') ?></td>
                                                                        <td ><?= $Gender ?></td>
                                                                        <td ><?= $db->f('Email') ?></td>
                                                                        <td ><?= $db->f('NationalityName') ?></td>
                                                                        <td align="center" class=""><span class="badge <?= $StatusClass ?>"><?= $Status ?></span></td>
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('TableID') . "&Trigger=edit") ?>" class="iconhoverbox" > <i class="icon-eye"></i> </a>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}
if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingpublicationsubmission') {
    $TableName = "tblpolicy";
    $refresh_div = 'resultDiv';
    $whereCond = 's.active = 2';
    $sql = "select * from $TableName";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                 <thead>
                                                      <tr>
                                                          <th width="4%" align="center" ><?= SNO ?></th>
                                                          <th align="left">Title</th>
                                                          <th align="center" style="text-align:center;">Description</th>
                                                          <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody data-tablename="<?= encodeencriptstring("$TableName") ?>">
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $Status = ($db->f('Status') == 0) ? '-' : $db->f('StatusName');
                                                $StatusClass = ($db->f('Status') > 0) ? 'badge-success' : 'badge-danger';
                                                $Gender = ($db->f('Gender') == 1) ? TXT_MALE : TXT_FEMALE;
                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td align="center"><?= $db->f('Title') ?></td>
                                                                        <td align="center"><?= $db->f('Description') ?></td>
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('id') . "&Trigger=edit") ?>" class="iconhoverbox" title="<?= TXT_EDIT_RECORD ?>"> <i class="icon-pencil"></i> </a>
                                                                        </td> 
                                                                    </tr>
                                            <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if (isset($pagination) && $pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}

if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingtestresult') {
    $refresh_div = 'resultDiv';

    $sql = "select A.*,B.Title" . LANG_SEP_DB . " CourseName, C.FullName" . LANG_SEP_DB . " as SubmitName,C.Email,C.RegID  from  tblsubmittest A 
inner join  tblcourses B on B.TableID=A.CourseID
inner join  tbluserregistration C on C.TableID=A.UserID
order by A.TableID DESC";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th align="left"><?= TXT_REQUEST_NO ?></th>
                                                        <th align="left"><?= TXT_COURSE ?></th>
                                                        <th align="left"><?= TXT_REGISTER_NO ?></th>
                                                        <th align="left"><?= TXT_NAME ?></th>
                                                        <th align="left"><?= TXT_EMAIL ?></th>
                                                        <th width="5%" align="center" style="text-align:center;"><?= TXT_STATUS ?></th>
                                                        <th width="5%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody >
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $StatusClass = ($db->f('IsPassed') > 0) ? 'badge-success' : 'badge-danger';
                                                $Status = ($db->f('IsPassed') == 1) ? TXT_PASS : TXT_FAIL;
                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td ><?= $db->f('RequestNo') ?></td>
                                                                        <td ><?= $db->f('CourseName') ?></td>
                                                                        <td ><?= $db->f('RegID') ?></td>
                                                                        <td ><?= $db->f('SubmitName') ?></td>
                                                                        <td ><?= $db->f('Email') ?></td>
                                                                        <td align="center" class=""><span class="badge <?= $StatusClass ?>"><?= $Status ?></span></td>
                                                                        <td align="center">
                                                                        <a href="javascript:;" data-href="AllQuickViewDetails.php?<?php echo EncodeUrl('Action=TestDetails&RecordID=' . $db->f('TableID')); ?>" class="iconhoverbox quickview"><i class="icon-eye"></i></a>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if ($pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}
if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingnewslettercontact') {
    $TableName = "tblnewslettercontact";
    $refresh_div = 'resultDiv';
    $sql = "select A.*,B.Title" . LANG_SEP_DB . " as Category from  $TableName A 
inner join  tblnewslettercontactcategory B on B.TableID=A.CategoryID
order by B.Title" . LANG_SEP_DB . " ASC ";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                 <thead>
                                                      <tr>
                                                        <th width="4%" align="center" ><?= SNO ?></th>
                                                        <th><?= TXT_CATEGORY ?></th>
                                                        <th><?= TXT_NAME ?></th>
                                                        <th><?= TXT_EMAIL ?></th>
                                                        <th><?= TXT_MOBILE ?></th>
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                      </tr>
                                                    </thead>
                                                <tbody >
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $Status = ($db->f('Active') == 1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
                                                $StatusClass = ($db->f('Active') == 1) ? 'badge-success' : 'badge-danger';
                                                ?>
                                                                    <tr id="listItem_<?= $db->f('TableID') ?>">
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td ><?= $db->f('Category') ?></td>
                                                                        <td ><?= $db->f('FullName') ?></td>
                                                                        <td ><?= $db->f('Email') ?></td>
                                                                        <td ><?= $db->f('MobileNumber') ?></td>
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('TableID') . "&Trigger=edit") ?>" class="iconhoverbox" title="<?= TXT_EDIT_RECORD ?>"> <i class="icon-pencil"></i> </a>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                            } ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    if ($pagination->tot_pages > 1) {
        ?>
                                                <tr>
                                                    <td colspan="11">
                                                        <center>
                                                              <?php echo $page_links; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
    }
}
if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingnewsletter') {
    //start search

    $refresh_div = 'resultDiv';

    $sql = "select *  from tblnewsletters   
	  where 1 " . $whereCond . " order by Title, TableID DESC ";

    /*$start = isset($_REQUEST['start']) && is_numeric($_REQUEST['start']) ? $_REQUEST['start'] : 1;
    $pagination = new pagination($sql, $pagelimit, $start, $refresh_div,'FormObject');
    $sql = $pagination->get_query();
    $page_links = $pagination->get_linksDashoard();*/
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                <thead>

                                                  <tr>
                                                    <th width="4%" align="center"><?= SNO ?></a></th>
                                                    <th align="left"><?= TXT_TITLE ?></th>
                                                        <th width="8%" align="center"><?= TXT_ACTIVE_USER ?></th>
                                                        <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                $Status = ($db->f('Active') == 1) ? TXT_ACTIVE : TXT_IN_ACTIVE;
                                                $StatusClass = ($db->f('Active') == 1) ? 'badge-success' : 'badge-danger';
                                                ?>
                                                                    <tr>
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td align="left"><?= $db->f('Title') ?></td>
                                                                        <td align="center" class=""><span class="badge <?= $StatusClass ?>"><?= $Status ?></span></td>

                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('TableID') . "&Trigger=edit") ?>" class="iconhoverbox" title="<?= TXT_EDIT_RECORD ?>"> <i class="icon-pencil"></i> </a>
                                                                         <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                             &nbsp;&nbsp;
                                                                                             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring('tblnewsletters') ?>" data-id="<?= encodeencriptstring($db->f('TableID')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>
                                                                         <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                            }
                                            ?>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }

    /*if($pagination->tot_pages > 1)
    {
        ?>
        <tr>
            <td colspan="11">
                <center>
                      <?php echo $page_links;?>
                </center>
            </td>
        </tr>
        <?php
    }*/
}

if (isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingcampaigns') {
    //start search
    $refresh_div = 'resultDiv';

    $sql = "select A.*,B.Title" . LANG_SEP_DB . " as NewletterTitle,C.Title" . LANG_SEP_DB . " as ContactCategory  from tblnewslettercampaigns A
		inner join tblnewsletters B on B.TableID=A.NewsLetterID
		inner join tblnewslettercontactcategory C on C.TableID=A.ContactCategoryID
	  where 1   order by Title ";
    $db->query($sql);
    $RecordCount = 0;
    if ($db->num_rows() > 0) {
        ?>
                                            <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                <thead>
                                                  <tr>
                                                    <th width="4%" align="center"><?= SNO ?></a></th>
                                                    <th align="left"><?= TXT_TITLE ?></th>
                                                    <th align="left"><?= TXT_NEWSLETTER ?></th>
                                                    <th align="left"><?= TXT_CONTACT_CATEGORY ?></th>
                                                    <th align="center" style="text-align:center;"><?= TXT_START_DATE ?></th>
                                                    <th align="center" style="text-align:center;"><?= TXT_TOTAL ?></th>
                                                    <th align="center" style="text-align:center;"><?= TXT_SENT ?></th>
                                                    <th align="center" style="text-align:center;"><?= TXT_VIEWED ?></th>
                                                    <th width="10%" align="center" style="text-align:center;"><?= TXT_ACTION ?></th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                            <?php
                                            while ($db->next_Record()) {
                                                $RecordCount++;
                                                // $Status = ($db->f('Active')==1)?TXT_ACTIVE:TXT_IN_ACTIVE;
                                                // $StatusClass =   ($db->f('Active')==1)?'badge-success':'badge-danger';
                                                $Total = $db->f('TotalContact');
                                                $Sent = getCountRecord("tblemailsentlog", "CampaignID", $db->f('TableID'));
                                                $Viewed = getCountRecord("tblemailsentlog", "CampaignID", $db->f('TableID') . " AND IsViewed=1");
                                                $GrandTotal += $Total;
                                                $GrandSent += $Sent;
                                                $GrandViewed += $Viewed;
                                                ?>
                                                                    <tr>
                                                                        <td class="line-height" align="center"><?= $RecordCount ?></td>
                                                                        <td align="left"><?= $db->f('Title') ?></td>
                                                                        <td align="left"><?= $db->f('NewletterTitle') ?></td>
                                                                        <td align="left"><?= $db->f('ContactCategory') ?></td>
                                                                        <td align="center"><?= onlydateshortformat($db->f('CampaignStartDate')) ?></td>
                                                                        <td align="center"><?= $Total ?></td>
                                                                        <td align="center"><?= $Sent ?></td>
                                                                        <td align="center"><?= $Viewed ?></td>
                                                                        <td align="center">
                                                                            <a href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&RecordID=" . $db->f('TableID') . "&Trigger=edit") ?>" class="iconhoverbox" title="<?= TXT_EDIT_RECORD ?>"> <i class="icon-pencil"></i> </a>
                                                                         <?php if ($CheckDeletePermissioon == 1) { ?>
                                                                                             &nbsp;&nbsp;
                                                                                             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM; ?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED; ?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION; ?>" data-action="<?= encodeencriptstring('DeleteRecord') ?>" data-table="<?= encodeencriptstring('tblcampaigns') ?>" data-id="<?= encodeencriptstring($db->f('TableID')) ?>"  title="<?= TXT_DELETE_RECORD ?>"> <i class="icon-trash txt-danger"></i> </a>
                                                                         <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                            }
                                            ?>

                                                <tfoot>
                                                <tr>
                                                    <th ></th>
                                                    <th ></th>
                                                    <th ></th>
                                                    <th ></th>
                                                    <th align="right" style="text-align:<?= ALIGN_MENT ?>"><?= TXT_GRAND_TOTAL ?></th>
                                                    <th align="center" style="text-align:center"><?= $GrandTotal ?></th>
                                                    <th align="center" style="text-align:center"><?= $GrandSent ?></th>
                                                    <th align="center" style="text-align:center"><?= $GrandViewed ?></th>
                                                    <td ></td>
                                                </tr>
                                                <tfoot>
                                                </tbody>
                                            </table>
                                            <?php
    }
    if ($RecordCount == 0) {
        echo '<div class="norecordfound">' . DSB_NO_RECORDS . '</div>';
    }
} ?>

 

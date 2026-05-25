<?php
require_once 'ajax.php'; 
$CheckDeletePermissioon = CheckModulePermission($UserRecordGetting['TableID'],$_REQUEST['SubLinkID'],"DeletePermissions");
if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listing')
{
//start search
/*$Active = $FullName = $UserName = $Email = $DepartmentID = $RoleID = '';
if(isset($_REQUEST['Active']))
	$Active = $_REQUEST['Active'];
if(isset($_REQUEST['FullName']))
	$FullName = $_REQUEST['FullName'];
if(isset($_REQUEST['UserName']))
	$UserName = $_REQUEST['UserName'];
if(isset($_REQUEST['Email']))
	$Email = $_REQUEST['Email'];
if(isset($_REQUEST['DepartmentID']))
	$DepartmentID = $_REQUEST['DepartmentID']; 
if(isset($_REQUEST['RoleID']))
	$RoleID = $_REQUEST['RoleID'];*/
$whereCond ='';

    if(isset($_POST['ProductName']) && $_POST['ProductName']!='')
    {
        $whereCond .=' and p.ProductName LIKE "%'.$_POST['ProductName'].'%"';
    }

    if(isset($_POST['StoreID']) && $_POST['StoreID'] > 0)
    {
        $whereCond .=' and p.StoreID = "'.$_POST['StoreID'].'"';
    }
    if(isset($_POST['url']) && $_POST['url'] != "")
    {
        $whereCond .=' and p.url = "'.$_POST['url'].'"';
    }
    if(isset($_POST['discount']) && $_POST['discount'] != "")
    {
        $whereCond .=' and p.discount = "'.$_POST['discount'].'"';
    }
    if(isset($_POST['endDate']) && $_POST['endDate'] != "")
    {
        $whereCond .=' and p.endDate = "'.$_POST['endDate'].'"';
    }
    if(isset($_POST['startDate']) && $_POST['startDate'] != "")
    {
        $whereCond .=' and p.startDate = "'.$_POST['startDate'].'"';
    }
    if(isset($_POST['CreatedBy']) && $_POST['CreatedBy'] > 0)
    {
        $whereCond .=' and p.CreatedBy = "'.$_POST['CreatedBy'].'"';
    }
    if(isset($_POST['ModifiedBy']) && $_POST['ModifiedBy'] > 0)
    {
        $whereCond .=' and p.ModifiedBy = "'.$_POST['ModifiedBy'].'"';
    }
    if(isset($_POST['active']) && $_POST['active'] > -1)
    {
        if($_POST['active'] == 0)
            $whereCond .=' and p.Active = 0';
        if($_POST['active'] == 1)
            $whereCond .=' and p.Active = 1';
        if($_POST['active'] == 2)
            $whereCond .=' and p.Active = 2';
    }
    if(isset($_POST['feature']) && $_POST['feature'] > 0)
    {
        if($_POST['feature'] ==1)
            $whereCond .=' and p.featured = 1';
        if($_POST['feature'] == 0)
            $whereCond .=' and p.featured = 0';
    }
$TableName = "tblproduct";
$refresh_div = 'resultDiv';

//$sql="select * from  $TableName order by FromDate DESC";
$sql = "SELECT * , p.`TableID` AS id ,p.Active AS active , s.name as storeName  FROM $TableName p 
INNER JOIN `tblstore` s ON (p.`StoreID` = s.`TableID`) 
INNER JOIN  `tblsystemusers` u ON (u.`TableID` = p.`CreatedBy` ) where 1 $whereCond order  by p.SEQUENCE ASC";
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
         <thead>
         <tr>
             <th align="center" ><?=SNO?></th>
             <th align="center"> storeName</th>
             <th align="center">Name</th>
             <th align="center" >Code</th>
             <th align="center">TrackingURL</th>
<!--             <th align="right" style="text-align:right;">Logo</th>-->
             <th align="center" >Init</th>
             <th align="center" >Expire</th>
<!--             <th align="center" >Date</th>-->
             <th align="center" >Status</th>
             <th align="center" >Add By</th>
<!--             <th align="center" >Update By</th>-->
             <th align="center" ><?=TXT_ACTION?></th>
         </tr>
            </thead>
        <tbody data-tablename="<?= encodeencriptstring($TableName) ?>">
	<?php
	while($db->next_Record())
	{
		$RecordCount++;
		$Status = ($db->f('active')==1)?TXT_ACTIVE:TXT_IN_ACTIVE;
        $StatusClass =   ($db->f('active')==1)?'badge-success':'badge-danger';
//        <td align="right"><?=($db->f('logo')!="")?"Yes" : "No"<!--</td>-->
		?>
        <tr id="listItem_<?= $db->f('id')?>">
            <td class="line-height" align="center"><?=$RecordCount?></td>
            <td align="center"><?=$db->f('storeName')?></td>
            <td align="center"><?=$db->f('ProductName')?></td>
            <td align="center"><?=$db->f('productCode')?></td>
            <td align="center"><?=($db->f('trackingLink')!="")?"Yes" : "No"?></td>

            <td align="center"><?=onlydateshortformat($db->f('startDate'))?></td>
            <td align="center"><?=onlydateshortformat($db->f('endDate'))?></td>
<!--            <td align="center"> onlydateshortformat($db->f('CreatedDateTime'))?></td>-->
            <td align="center" class=""><span class="badge <?=$StatusClass?>" id="<?=$db->f('id')?>" onclick="UpdateActive('<?=$Status?>' ,<?=$db->f('id')?>)"><?=$Status?></span></td>
            <td align="center"><?=$db->f('FullName')?></td>
<!--            <td align="center">$db->f('FullName')</td>-->
            <td align="center">
                <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&RecordID=".$db->f('id')."&Trigger=edit")?>" class="iconhoverbox" title="<?=TXT_EDIT_RECORD?>"> <i class="icon-pencil"></i> </a>
                <?php if($CheckDeletePermissioon==1) { ?>
                    &nbsp;&nbsp;
                    <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM;?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED;?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION;?>" data-action="<?=encodeencriptstring('DeleteRecord')?>" data-table="<?=encodeencriptstring($TableName)?>" data-id="<?=encodeencriptstring($db->f('id'))?>"  title="<?=TXT_DELETE_RECORD?>"> <i class="icon-trash txt-danger"></i> </a>
                <?php } ?>
            </td>

        </tr>

	<?php
	}?>
    	</tbody>
    </table>
    <?php
}
	if($RecordCount==0)
	{
		echo '<div class="norecordfound">'.DSB_NO_RECORDS.'</div>';
	}
	
	if(isset($pagination) && $pagination->tot_pages > 1)
	{
		?>
		<tr>
			<td colspan="11">
				<center>
					  <?php echo isset($page_links) ? $page_links : '';?>
				</center>
			</td>
		</tr>
		<?php
	}
}
if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listinggallery')
{
 
$TableName = "tblsystemimages"; 
$refresh_div = 'resultDiv';

$sql="select * from  $TableName where TypeID='".$_REQUEST['TypeID']."' AND ParentID='".$_REQUEST['ParentID']."' order by Sequence ASC";
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
         <thead>
              <tr>
                <th width="4%" align="center" ><?=SNO?></th> 
                <th align="left"><?=IMAGES?></th> 
            	<th width="10%" align="center" style="text-align:center;"><?=TXT_ACTION?></th> 
              </tr>
            </thead> 
        <tbody data-tablename="<?=encodeencriptstring("$TableName")?>" >
	<?php
	while($db->next_Record())
	{
		$RecordCount++;
		/*$BannerImage = "-";
		if($db->f('BannerImage')!='')
		{ 
			$BannerImage = GallaryImageHtml('../'.FILES_FOLDER.'/'.DOCUMENT_FOLDER.'/'.$db->f('BannerImage'));
		}*/
		
		?>
		<tr id="listItem_<?=$db->f('TableID')?>">
			<td class="line-height" align="center"><?=$RecordCount?></td>
			<td align="left"><img src="<?='../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/thumbnail_'.$db->f('FileName')?>" height="80" /></td>  
            <td align="center"> 
             <?php if($CheckDeletePermissioon==1) { ?>
             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM;?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED;?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION;?>" data-action="<?=encodeencriptstring('DeleteRecord')?>" data-table="<?=encodeencriptstring($TableName)?>" data-id="<?=encodeencriptstring($db->f('TableID'))?>"  title="<?=TXT_DELETE_RECORD?>"> <i class="icon-trash txt-danger"></i> </a>
             <?php } ?>
            </td>
              
		</tr>
	<?php
	}?>
    	</tbody>
    </table>
    <?php
}
	if($RecordCount==0)
	{
		echo '<div class="norecordfound">'.DSB_NO_RECORDS.'</div>';
	}
	
	if($pagination->tot_pages > 1)
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
	}
}
if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingvideogallery')
{
 
$TableName = "tblsystemvideos"; 
$refresh_div = 'resultDiv';

$sql="select * from  $TableName where TypeID='".$_REQUEST['TypeID']."' AND ParentID='".$_REQUEST['ParentID']."' order by Sequence ASC";
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
         <thead>
              <tr>
                <th width="4%" align="center" ><?=SNO?></th> 
                <th align="left"><?=IMAGES?></th> 
            	<th width="10%" align="center" style="text-align:center;"><?=TXT_ACTION?></th> 
              </tr>
            </thead> 
        <tbody data-tablename="<?=encodeencriptstring("$TableName")?>" >
	<?php
	while($db->next_Record())
	{
		$RecordCount++;
		$BannerImage = "-";
		if($db->f("VideoType") == 2)
		{  
			$Thumnbanil = '<video  preload="metadata" width="200" height="100">
							  <source src="'.RESOURCES_DOMAIN.'/'.FILES_FOLDER."/".UPLOAD_VIDEOS.'/'.$db->f('FileName').'" type="video/mp4">
							</video>';
		}
		else
		{
			$v_Value = PareYouTubeLink($db->f('FileName'));
			//$Thumnbanil = '<iframe width="200" height="100" src="http://www.youtube.com/embed/'.$v_Value.'?rel=0&amp;wmode=transparent"></iframe>';
			$Thumnbanil = '<img src="http://img.youtube.com/vi/'.$v_Value.'/mqdefault.jpg" height="100" />';
		}
		
		?>
		<tr id="listItem_<?=$db->f('TableID')?>">
			<td class="line-height" align="center"><?=$RecordCount?></td>
			<td align="left"><?=$Thumnbanil?></td>  
            <td align="center"> 
             <?php if($CheckDeletePermissioon==1) { ?>
             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM;?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED;?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION;?>" data-action="<?=encodeencriptstring('DeleteRecord')?>" data-table="<?=encodeencriptstring($TableName)?>" data-id="<?=encodeencriptstring($db->f('TableID'))?>"  title="<?=TXT_DELETE_RECORD?>"> <i class="icon-trash txt-danger"></i> </a>
             <?php } ?>
            </td>
              
		</tr>
	<?php
	}?>
    	</tbody>
    </table>
    <?php
}
	if($RecordCount==0)
	{
		echo '<div class="norecordfound">'.DSB_NO_RECORDS.'</div>';
	}
	
	if($pagination->tot_pages > 1)
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
	}
}

if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingannouncement')
{
$TableName = "tblannouncement"; 
$refresh_div = 'resultDiv';

$sql="select * from  $TableName order by AnnouncementDate DESC";
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>  
	<table id="datable_1" class="table table-hover w-100 display pb-30">
         <thead>
              <tr>
                <th width="4%" align="center" ><?=SNO?></th> 
                <th align="left"><?=TXT_TITLE_ENGLISH?></th> 
                <th align="right" style="text-align:right;"><?=TXT_TITLE_ARABIC?></th> 
                <th  align="center" style="text-align:center;"><?=TXT_NEWS_DATE?></th>  
            	<th width="8%" align="center"><?=TXT_ACTIVE_USER?></th>   
            	<th width="10%" align="center" style="text-align:center;"><?=TXT_ACTION?></th> 
              </tr>
            </thead> 
        <tbody >
	<?php
	while($db->next_Record())
	{
		$RecordCount++;
		$Status = ($db->f('Active')==1)?TXT_ACTIVE:TXT_IN_ACTIVE;
        $StatusClass =   ($db->f('Active')==1)?'badge-success':'badge-danger';
		?>
		<tr>
			<td class="line-height" align="center"><?=$RecordCount?></td>
			<td align="left"><?=$db->f('Title')?></td> 
			<td align="right"><?=$db->f('TitleAr')?></td> 
			<td align="center"><?=onlydateshortformat($db->f('AnnouncementDate'))?></td>  
            <td align="center" class=""><span class="badge <?=$StatusClass?>"><?=$Status?></span></td>
            <td align="center">
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&RecordID=".$db->f('TableID')."&Trigger=edit")?>" class="iconhoverbox" title="<?=TXT_EDIT_RECORD?>"> <i class="icon-pencil"></i> </a>
             <?php if($CheckDeletePermissioon==1) { ?>
             &nbsp;&nbsp;
             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM;?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED;?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION;?>" data-action="<?=encodeencriptstring('DeleteRecord')?>" data-table="<?=encodeencriptstring($TableName)?>" data-id="<?=encodeencriptstring($db->f('TableID'))?>"  title="<?=TXT_DELETE_RECORD?>"> <i class="icon-trash txt-danger"></i> </a>
             <?php } ?>
            </td>
              
		</tr>
	<?php
	}?>
    	</tbody>
    </table>
    <?php
}
	if($RecordCount==0)
	{
		echo '<div class="norecordfound">'.DSB_NO_RECORDS.'</div>';
	}
	
	if($pagination->tot_pages > 1)
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
	}
}
if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingevents')
{
$TableName = "tblevents"; 
$refresh_div = 'resultDiv';

$sql="select * from  $TableName order by Sequence";
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
         <thead>
              <tr>
                <th width="4%" align="center" ><?=SNO?></th> 
                <th align="left"><?=TXT_TITLE_ENGLISH?></th> 
                <th align="right" style="text-align:right;"><?=TXT_TITLE_ARABIC?></th> 
                <th  align="center" style="text-align:center;"><?=TXT_FROM_DATE?></th>  
                <th  align="center" style="text-align:center;"><?=TXT_TO_DATE?></th>  
            	<th width="8%" align="center"><?=TXT_ACTIVE_USER?></th>   
            	<th width="8%" align="center"><?=TXT_IMAGE_GALLERY?></th>   
            	<th width="8%" align="center"><?=TXT_VIDEO_GALLERY?></th>   
            	<th width="10%" align="center" style="text-align:center;"><?=TXT_ACTION?></th> 
              </tr>
            </thead> 
        <tbody data-tablename="<?=encodeencriptstring("$TableName")?>">
	<?php
	while($db->next_Record())
	{
		$RecordCount++;
		$Status = ($db->f('Active')==1)?TXT_ACTIVE:TXT_IN_ACTIVE;
        $StatusClass =   ($db->f('Active')==1)?'badge-success':'badge-danger';
		?>
		<tr id="listItem_<?=$db->f('TableID')?>">
			<td class="line-height" align="center"><?=$RecordCount?></td>
			<td align="left"><?=$db->f('Title')?></td> 
			<td align="right"><?=$db->f('TitleAr')?></td> 
			<td align="center"><?=onlydateshortformat($db->f('FromDate'))?></td>  
			<td align="center"><?=onlydateshortformat($db->f('ToDate'))?></td>  
            <td align="center" class=""><span class="badge <?=$StatusClass?>"><?=$Status?></span></td> 
            <td align="center"> 
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=PageGallery&ParentID=".$db->f('TableID')."&TypeID=".EVENT_MEDIA_TYPE."&TableName=".$TableName)?>" class="iconhoverbox" > <i class="icon-link"></i> </a>
            </td>
            <td align="center"> 
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=PageVideo&ParentID=".$db->f('TableID')."&TypeID=".EVENT_MEDIA_TYPE."&TableName=".$TableName)?>" class="iconhoverbox" > <i class="icon-camera"></i> </a>
            </td>
            <td align="center">
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&RecordID=".$db->f('TableID')."&Trigger=edit")?>" class="iconhoverbox" title="<?=TXT_EDIT_RECORD?>"> <i class="icon-pencil"></i> </a>
             <?php if($CheckDeletePermissioon==1) { ?>
             &nbsp;&nbsp;
             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM;?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED;?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION;?>" data-action="<?=encodeencriptstring('DeleteRecord')?>" data-table="<?=encodeencriptstring($TableName)?>" data-id="<?=encodeencriptstring($db->f('TableID'))?>"  title="<?=TXT_DELETE_RECORD?>"> <i class="icon-trash txt-danger"></i> </a>
             <?php } ?>
            </td>
              
		</tr>
	<?php
	}?>
    	</tbody>
    </table>
    <?php
}
	if($RecordCount==0)
	{
		echo '<div class="norecordfound">'.DSB_NO_RECORDS.'</div>';
	}
	
	if($pagination->tot_pages > 1)
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
	}
}

if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingpublication')
{
$TableName = "tblpublications"; 
$refresh_div = 'resultDiv';

$sql="select A.*,B.Title".LANG_SEP_DB." as Category from  $TableName A 
inner join  tblpublicationcategory B on B.TableID=A.CategoryID
order by A.Sequence";
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
         <thead>
              <tr>
                <th width="4%" align="center" ><?=SNO?></th> 
                <th><?=TXT_CATEGORY?></th> 
                <th align="left"><?=TXT_TITLE_ENGLISH?></th> 
                <th align="right" style="text-align:right;"><?=TXT_TITLE_ARABIC?></th> 
            	<th width="8%" align="center"><?=TXT_ACTIVE_USER?></th>   
            	<th width="8%" align="center"><?=TXT_IMAGE_GALLERY?></th>   
            	<th width="8%" align="center"><?=TXT_VIDEO_GALLERY?></th>   
            	<th width="10%" align="center" style="text-align:center;"><?=TXT_ACTION?></th> 
              </tr>
            </thead> 
        <tbody data-tablename="<?=encodeencriptstring("$TableName")?>">
	<?php
	while($db->next_Record())
	{
		$RecordCount++;
		$Status = ($db->f('Active')==1)?TXT_ACTIVE:TXT_IN_ACTIVE;
        $StatusClass =   ($db->f('Active')==1)?'badge-success':'badge-danger';
		?>
		<tr id="listItem_<?=$db->f('TableID')?>">
			<td class="line-height" align="center"><?=$RecordCount?></td>
			<td ><?=$db->f('Category')?></td> 
			<td align="left"><?=$db->f('Title')?></td> 
			<td align="right"><?=$db->f('TitleAr')?></td> 
            <td align="center" class=""><span class="badge <?=$StatusClass?>"><?=$Status?></span></td> 
            <td align="center"> 
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=PageGallery&ParentID=".$db->f('TableID')."&TypeID=".PUBLICATION_MEDIA_TYPE."&TableName=".$TableName)?>" class="iconhoverbox" > <i class="icon-link"></i> </a>
            </td>
            <td align="center"> 
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=PageVideo&ParentID=".$db->f('TableID')."&TypeID=".PUBLICATION_MEDIA_TYPE."&TableName=".$TableName)?>" class="iconhoverbox" > <i class="icon-camera"></i> </a>
            </td>
            <td align="center">
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&RecordID=".$db->f('TableID')."&Trigger=edit")?>" class="iconhoverbox" title="<?=TXT_EDIT_RECORD?>"> <i class="icon-pencil"></i> </a>
             <?php if($CheckDeletePermissioon==1) { ?>
             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM;?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED;?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION;?>" data-action="<?=encodeencriptstring('DeleteRecord')?>" data-table="<?=encodeencriptstring($TableName)?>" data-id="<?=encodeencriptstring($db->f('TableID'))?>"  title="<?=TXT_DELETE_RECORD?>"> <i class="icon-trash txt-danger"></i> </a>
             <?php } ?>
            </td>
              
		</tr>
	<?php
	}?>
    	</tbody>
    </table>
    <?php
}
	if($RecordCount==0)
	{
		echo '<div class="norecordfound">'.DSB_NO_RECORDS.'</div>';
	}
	
	if($pagination->tot_pages > 1)
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
	}
}
if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingcourses')
{
$TableName = "tblcourses"; 
$refresh_div = 'resultDiv';

$sql="select A.*,B.Title".LANG_SEP_DB." as Category from  $TableName A 
inner join  tblcoursecategory B on B.TableID=A.CategoryID
order by A.Sequence";
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30 sort-table">
         <thead>
              <tr>
                <th width="4%" align="center" ><?=SNO?></th> 
                <th><?=TXT_CATEGORY?></th> 
                <th align="left"><?=TXT_TITLE_ENGLISH?></th> 
                <th align="right" style="text-align:right;"><?=TXT_TITLE_ARABIC?></th> 
            	<th width="8%" align="center"><?=TXT_ACTIVE_USER?></th>   
            	<th width="8%" align="center"><?=TXT_IMAGE_GALLERY?></th>   
            	<th width="8%" align="center"><?=TXT_VIDEO_GALLERY?></th>   
            	<th width="10%" align="center" style="text-align:center;"><?=TXT_ACTION?></th> 
              </tr>
            </thead> 
        <tbody data-tablename="<?=encodeencriptstring("$TableName")?>">
	<?php
	while($db->next_Record())
	{
		$RecordCount++;
		$Status = ($db->f('Active')==1)?TXT_ACTIVE:TXT_IN_ACTIVE;
        $StatusClass =   ($db->f('Active')==1)?'badge-success':'badge-danger';
		?>
		<tr id="listItem_<?=$db->f('TableID')?>">
			<td class="line-height" align="center"><?=$RecordCount?></td>
			<td ><?=$db->f('Category')?></td> 
			<td align="left"><?=$db->f('Title')?></td> 
			<td align="right"><?=$db->f('TitleAr')?></td> 
            <td align="center" class=""><span class="badge <?=$StatusClass?>"><?=$Status?></span></td> 
            <td align="center"> 
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=PageGallery&ParentID=".$db->f('TableID')."&TypeID=".COURSE_MEDIA_TYPE."&TableName=".$TableName)?>" class="iconhoverbox" > <i class="icon-link"></i> </a>
            </td>
            <td align="center"> 
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=PageVideo&ParentID=".$db->f('TableID')."&TypeID=".COURSE_MEDIA_TYPE."&TableName=".$TableName)?>" class="iconhoverbox" > <i class="icon-camera"></i> </a>
            </td>
            <td align="center">
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&RecordID=".$db->f('TableID')."&Trigger=edit")?>" class="iconhoverbox" title="<?=TXT_EDIT_RECORD?>"> <i class="icon-pencil"></i> </a>
             <?php if($CheckDeletePermissioon==1) { ?>
             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM;?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED;?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION;?>" data-action="<?=encodeencriptstring('DeleteRecord')?>" data-table="<?=encodeencriptstring($TableName)?>" data-id="<?=encodeencriptstring($db->f('TableID'))?>"  title="<?=TXT_DELETE_RECORD?>"> <i class="icon-trash txt-danger"></i> </a>
             <?php } ?>
            </td>
              
		</tr>
	<?php
	}?>
    	</tbody>
    </table>
    <?php
}
	if($RecordCount==0)
	{
		echo '<div class="norecordfound">'.DSB_NO_RECORDS.'</div>';
	}
	
	if($pagination->tot_pages > 1)
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
	}
}
?>


<script>

    const UpdateActive = (Active , id) => {
        // let active;
        if(Active =="No")
            Active =  1;
        else
            Active  = 0;
        $.post('ajax/ajax_status_update.php',{ProductStatusUpdate : Active, id : id},function (data , status){
            if(data == "updated"){
                if(Active == 1) {
                    $('#' + id).attr("class", "badge badge-success");
                    $('#' + id).attr("onclick", "UpdateActive('Yes' ,"+id+")");
                    $('#' + id).html("Yes");
                }
                else {
                    $('#' + id).attr("class", "badge badge-danger");
                    $('#' + id).attr("onclick", "UpdateActive('No' , "+id+")");
                    $('#' + id).html("No");
                }
            }
        })
    }
</script>

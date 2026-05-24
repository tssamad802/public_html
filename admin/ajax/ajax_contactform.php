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
/*$whereCond =''; 

if($FullName!='')
{
	$whereCond .= ' and (A.FullName LIKE "%'.$FullName.'%" )';
}
if($Active != '')
{
	$whereCond .= ' and A.Active = "'.$Active.'"';
}

if($UserName != '')
{
	$whereCond .= ' and A.UserName = "'.$UserName.'"';
}

if($Email != '')
{
	$whereCond .= ' and A.Email = "'.$Email.'"';
}
 

if($RoleID != '')
{
	$whereCond .= ' and A.RoleID = "'.$RoleID.'"';
}*/
$TableName = "tblsubscriber"; 
$FormName = "ContactForm"; 
$FormAction = "AllFormDetails"; 
$refresh_div = 'resultDiv';

$sql="select * from  $TableName order by id DESC";
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30">
         <thead>
              <tr>
                <th width="4%" align="center" ><?=SNO?></th>
                <th align="left">IP</th>
                <th align="left"><?=TXT_EMAIL?></th> 
            	<th align="left">Date</th>
				<!-- <th width="10%" align="center" style="text-align:center;"><?=TXT_ACTION?></th>				 -->
              </tr>
            </thead> 
        <tbody>
	<?php
	while($db->next_Record())
	{
		$RecordCount++; 
		// $Status = ($db->f('Active')==1)?TXT_ACTIVE:TXT_IN_ACTIVE;
        // $StatusClass =   ($db->f('Active')==1)?'badge-success':'badge-danger';
		?>
		<tr>
			<td class="line-height" align="center"><?=$RecordCount?></td>
            <td align="left"><?=$db->f('IP')?></td>
            <td align="left"><?=$db->f('email')?></td>
            <td align="left"><?=$db->f('CreateAt')?></td>
		</tr>
	<?php } ?>
	
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
order by B.Title".LANG_SEP_DB." ASC, A.Sequence ASC";
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
order by B.Title".LANG_SEP_DB." ASC, A.Sequence ASC";
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
            	<th width="8%" align="center" style="text-align:center;"><?=TXT_ASESSMENT_TEST?></th>   
            	<th width="8%" align="center" style="text-align:center;"><?=TXT_IMAGE_GALLERY?></th>   
            	<th width="8%" align="center" style="text-align:center;"><?=TXT_VIDEO_GALLERY?></th>   
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
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=AssessmentTest&ParentID=".$db->f('TableID'))?>" class="iconhoverbox" > <i class="icon-question"></i> </a>
            </td>
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

if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listingcoursesassestmenttest')
{
$TableName = "tblcoursequestion"; 
$refresh_div = 'resultDiv';

$sql="select A.*,B.Title".LANG_SEP_DB." as Course from  $TableName A 
inner join  tblcourses B on B.TableID=A.CourseID
where A.CourseID='".$_REQUEST['CourseID']."' order by A.Sequence ASC";
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
            	<th width="8%" align="center"><?=TXT_ACTIVE_USER?></th>    
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
            <td align="center">
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecordQuestion&RecordID=".$db->f('TableID')."&Trigger=edit&ParentID=".$_REQUEST['CourseID'])?>" class="iconhoverbox" title="<?=TXT_EDIT_RECORD?>"> <i class="icon-pencil"></i> </a>
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
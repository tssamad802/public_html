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
$TableName = "tblbanners"; 
$refresh_div = 'resultDiv';

$sql="select * from  $TableName order by TableID DESC";
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30">
         <thead>
              <tr>
                <th width="4%" align="center" ><?=SNO?></th> 
                <th width="8%"><?=TXT_TITLE_ENGLISH1?></th> 
				<th width="8%"><?=TXT_TITLE_ENGLISH2?></th> 
				<th width="8%"><?=TXT_TITLE_ENGLISH3?></th> 
				<th width="8%"><?=TXT_TITLE_ENGLISH4?></th> 
            	<th width="8%" align="center"><?=TXT_ACTIVE_USER?></th>   
            	<th width="10%" align="center" style="text-align:center;"><?=TXT_ACTION?></th> 
              </tr>
            </thead> 
        <tbody>
	<?php
	while($db->next_Record())
	{
		$RecordCount++;
		$Status = ($db->f('Active')==1)?TXT_ACTIVE:TXT_IN_ACTIVE;
        $StatusClass =   ($db->f('Active')==1)?'badge-success':'badge-danger';
		?>
		<tr>
			<td class="line-height" align="center"><?=$RecordCount?></td>
			<td align="left"><?=$db->f('Title1'.LANG_SEP_DB)?></td> 
			<td align="left"><?=$db->f('Title2'.LANG_SEP_DB)?></td> 
			<td align="left"><?=$db->f('Title3'.LANG_SEP_DB)?></td> 
			<td align="left"><?=$db->f('Title4'.LANG_SEP_DB)?></td> 
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

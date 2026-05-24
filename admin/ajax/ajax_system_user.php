<?php

require_once 'ajax.php'; 

//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1); 
//error_reporting(E_ALL);

$CheckDeletePermissioon = CheckModulePermission($UserRecordGetting['TableID'],$_REQUEST['SubLinkID'],"DeletePermissions");
if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listing')
{
//start search
$Active = $FullName = $UserName = $Email = $DepartmentID = $RoleID = '';
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
	$RoleID = $_REQUEST['RoleID'];
$whereCond =''; 

//echo $FullName.'<br/>';
//echo $UserName.'<br/>';
//echo $Email.'<br/>';
//echo $DepartmentID.'<br/>';
//echo $RoleID.'<br/>';

if($FullName!='')
{
	$whereCond .= ' where (A.FullName LIKE "%'.$FullName.'%" )';
	//echo 'Fullname is not empty';
}
if($Active != '')
{
	$whereCond .= ' where A.Active = "'.$Active.'"';
	//echo 'Active is not empty';
}

if($UserName != '')
{
	$whereCond .= ' where A.UserName = "'.$UserName.'"';
	//echo 'Username is not empty';
}

if($Email != '')
{
	$whereCond .= ' where A.Email = "'.$Email.'"';
	//echo 'Email is not empty';
}
 

if($RoleID != '')
{
	$whereCond .= ' where A.RoleID = "'.$RoleID.'"';
	//echo 'RoleID is not empty';
}
 
$refresh_div = 'resultDiv';

//echo $RoleID;

$sql="select A.*,B.RoleName as Role  from tblsystemusers A
		inner join tblroles B on B.TableID=A.RoleID ".$whereCond." order by A.FullName ";
	  
//echo $sql;

$start = isset($_REQUEST['start']) && is_numeric($_REQUEST['start']) ? $_REQUEST['start'] : 1;
$pagination = new pagination($sql, $pagelimit, $start, $refresh_div,'FormObject');
$sql = $pagination->get_query();
//$page_links = $pagination->get_linksDashoard();
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30">
         <thead>
              <tr>
                <th width="4%" align="center" ><?=SNO?></th> 
                <th  align="left"><?=TXT_ROLE?></th>
                <th  align="left"><?=TXT_NAME?></th> 
                <th  align="left"><?=TXT_USERNAME?></th>  
                <th  align="left"><?=TXT_EMAIL?></th>  
                <th width="8%" align="center"><?=TXT_ACTIVE_USER?></th> 
                <th width="8%" align="center"><?=TXT_PERMISSION?></th>
                <th width="10%" align="center" style="text-align:center"><?=TXT_ACTION?></th> 
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
			<td><?=$db->f('Role')?></td> 
			<td><?=$db->f('FullName')?></td> 
			<td><?=$db->f('UserName')?></td>  
			<td><?=$db->f('Email')?></td> 
            <td align="center" class=""><span class="badge <?=$StatusClass?>"><?=$Status?></span></td> 
            <td align="center"> 
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=Permission&RecordID=".$db->f('TableID'))?>" class="iconhoverbox" title="Edit User Permission"> <i class="icon-lock"></i> </a>
            </td>
            <td align="center">
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&RecordID=".$db->f('TableID')."&Trigger=edit")?>" class="iconhoverbox" title="<?=TXT_EDIT_RECORD?>"> <i class="icon-pencil"></i> </a>
             <?php if($db->f('TableID') > 1 && $CheckDeletePermissioon==1) { ?>
             &nbsp;&nbsp;
             <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM;?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED;?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION;?>" data-action="<?=encodeencriptstring('DeleteRecord')?>" data-table="<?=encodeencriptstring('tblsystemusers')?>" data-id="<?=encodeencriptstring($db->f('TableID'))?>"  title="<?=TXT_DELETE_RECORD?>"> <i class="icon-trash txt-danger"></i> </a>
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
 
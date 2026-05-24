<?php

require_once 'ajax.php'; 
$CheckDeletePermissioon = CheckModulePermission($UserRecordGetting['TableID'],$_REQUEST['SubLinkID'],"DeletePermissions");
if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listing')
{
//start search
$TableName = "tblpages"; 
$refresh_div = 'resultDiv';

$sql="select * from  ".$TableName." order by TableID DESC";

// $start = isset($_REQUEST['start']) && is_numeric($_REQUEST['start']) ? $_REQUEST['start'] : 1;
// $pagination = new pagination($sql, $pagelimit, $start, $refresh_div,'FormObject');
// $sql = $pagination->get_query();
// $page_links = $pagination->get_linksDashoard();
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
            	<th width="10%" align="center"><?=TXT_ACTIVE_USER?></th>
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
			<td><?=$db->f('Title')?></td>
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
 
<?php
require_once 'ajax.php';
$CheckDeletePermissioon = CheckModulePermission($UserRecordGetting['TableID'],$_REQUEST['SubLinkID'],"DeletePermissions");
if(isset($_REQUEST['FireAction']) && $_REQUEST['FireAction'] == 'listing')
{
//start search
$Active = isset($_REQUEST['Active']) ? $_REQUEST['Active'] : '';
$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
$whereCond = '';
if($q!='')
{
	$whereCond .= ' and (RoleName LIKE "%'.$q.'%" )';
}
if($Active != '')
{
	$whereCond .= ' and Active = "'.$Active.'"';
}


$refresh_div = 'resultDiv';



if($_REQUEST['TableName']!='')
{

if($_REQUEST['SubLinkID']==5)
{
  $sql="select A.*,B.Title as ParentName  from ".$_REQUEST['TableName']." A 
  left join ".$_REQUEST['TableName']." B on B.TableID=A.ParentID
    where 1 ".$whereCond." order by Sequence ";
}
else
{
	$sql="select *  from ".$_REQUEST['TableName']."  
	  where 1 ".$whereCond." order by Sequence ";
}




/*$start = isset($_REQUEST['start']) && is_numeric($_REQUEST['start']) ? $_REQUEST['start'] : 1;
$pagination = new pagination($sql, $pagelimit, $start, $refresh_div,'FormObject');
$sql = $pagination->get_query();
$page_links = $pagination->get_linksDashoard();*/
$db->query($sql);
$RecordCount=0;
if($db->num_rows() > 0)
{
?>
	<table id="datable_1" class="table table-hover w-100 display pb-30"> <!-- $_REQUEST['SubLinkID']==3?'':'sort-table' -->
        <thead>
          <tr>
            <th width="4%" align="center"><?=TXT_S_NO?></th>
                <?php 
                if($_REQUEST['SubLinkID']==5)
                {
                  ?>
                  <th align="left">Parent</th>
                  <?php
                }
                ?>
                <th align="left">Title</th>

              <?php
              if($_REQUEST['SubLinkID']==38)
              {
                  ?>
                  <th align="left">Show In Home</th>
                  <?php
              }
              if($_REQUEST['SubLinkID']==32)
              {
                  ?>
                  <th align="left">NetwordID</th>
                  <th align="left">NetDeepLinkCode</th>
                  <?php
              }
              ?>
              <?php
              if($_REQUEST['SubLinkID']==26)
              {
                  ?>
                  <th align="left">Country Tag</th>
                  <th align="left">CountryKeyword</th>
                  <th align="left">Currency</th>
                  <?php
              }
              ?>

            	<th width="8%" align="center"><?=TXT_ACTIVE_USER?></th>
            <th width="10%" align="center" style="text-align:center;"><?=TXT_ACTION?></th>
          </tr>
        </thead>
            <tbody data-tablename="<?=encodeencriptstring($_REQUEST['TableName'])?>">
	<?php
    while($db->next_Record())
    {
        $RecordCount++;
        $Status = ($db->f('Active')==1)?TXT_YES:TXT_NO;
        $StatusClass =   ($db->f('Active')==1)?'badge-success':'badge-danger';
        $Status1 = ($db->f('ShowHome')==1)?TXT_YES:TXT_NO;
        $StatusClass1 =   ($db->f('ShowHome')==1)?'badge-success':'badge-danger';

        ?> 
        <tr id="listItem_<?=$db->f('TableID')?>">
            <td class="line-height" align="center"><?=$RecordCount?></td>
            	<?php 
                if($_REQUEST['SubLinkID']==5)
                {
                  ?>
                  <td align="left"><?=($db->f('ParentName')=="")?'-':$db->f('ParentName')?></td>
                  <?php
                }
                ?>
            <td align="left"><?=$db->f('Title')?></td>
            <?php
            if($_REQUEST['SubLinkID']==38){ ?>
                  <td align="left"><span class="badge <?=$StatusClass1?>"><?=$Status1?></span></td>
                <?php }
                if($_REQUEST['SubLinkID']==32)
                {
                ?>
                <td align="left"><?=($db->f('NetID')=="")?'-':$db->f('NetID')?></td>
                <td align="left"><?=($db->f('NetDeepLinkCode')=="")?'-':$db->f('NetDeepLinkCode')?></td>
                <?php
                }
            ?>
            <?php
            if($_REQUEST['SubLinkID']==26)
            {
                ?>
                <td align="left"><?=($db->f('CountryTag')=="")?'-':$db->f('CountryTag')?></td>
                <td align="left"><?=($db->f('CountryKeyword')=="")?'-':$db->f('CountryKeyword')?></td>
                <td align="left"><?=($db->f('Currency')=="")?'-':$db->f('Currency')?></td>
                <?php
            }
            ?>

            	<td align="center" class=""><span class="badge <?=$StatusClass?>" id="<?=$db->f('TableID')?>" onclick="UpdateActive('<?=$Status?>' , <?=$db->f('TableID')?> , '<?=$_REQUEST['TableName']?>')"><?=$Status?></span></td>
            <td align="center">
           	 <a href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&RecordID=".$db->f('TableID')."&Trigger=edit&TableName=".$_REQUEST['TableName'])?>" class="iconhoverbox"> <i class="icon-pencil"></i> </a>
             <?php if($CheckDeletePermissioon==1) { ?>
                <a class="deleterecord iconhoverbox" href="#" data-action_title="<?php echo TXT_DELETE_CONFIRM;?>" data-action_msg="<?php echo TXT_SELECTED_RECORD_DELETED;?>" data-message="<?php echo TXT_RECORD_DELETE_ACTION;?>" data-action="<?=encodeencriptstring('DeleteRecord')?>" data-table="<?=encodeencriptstring($_REQUEST['TableName'])?>" data-id="<?=encodeencriptstring($db->f('TableID'))?>"> <i class="icon-trash txt-danger"></i> </a>
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
if($RecordCount==0)
{
	echo '<div class="norecordfound">'.DSB_NO_RECORDS.'</div>';
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
}
?>
<script>
    const UpdateActive = (Active , id , TableName) => {
        // let active;
        if(Active =="No")
            Active =  1;
        else
            Active  = 0;
        $.post('ajax/ajax_status_update.php',{MasterStatusUpdate : Active, id : id , TableName : TableName},function (data , status){
            if(data == "updated"){
                if(Active == 1) {
                    $('#' + id).attr("class", "badge badge-success");
                    $('#' + id).attr("onclick", "UpdateActive('Yes' , "+id+" , '<?=$_REQUEST['TableName']?>')");
                    $('#' + id).html("Yes");
                }
                else {
                    $('#' + id).attr("class", "badge badge-danger");
                    $('#' + id).attr("onclick", "UpdateActive('No' , "+id+" , '<?=$_REQUEST['TableName']?>')");
                    $('#' + id).html("No");
                }

            }
        })
    }
</script>
<script>



    const UpdateActive = (Active , id) => {
        // let active;
        if(Active =="No")
            Active =  1;
        else
            Active  = 0;
        $.post('ajax/ajax_status_update.php',{StoreStatusUpdate : Active, id : id},function (data , status){
            if(data == "updated"){
                if(Active == 1) {
                    $('#' + id).attr("class", "badge badge-success");
                    $('#' + id).attr("onclick", "UpdateActive('Yes' , "+id+")");
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
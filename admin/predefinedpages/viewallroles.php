<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
	die("Direct Access Not Allowed");
}
?>
<div class="hk-pg-wrapper"> 

<!-- Container -->
<div class="container"> 
    <!-- Title -->
    <div class="headergap"></div> 
         
    <!-- /Title -->
		<?php
if(!isset($_REQUEST['PageType']))
{
	checkPermission("ViewPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
?>

    	<div class="hk-pg-header mb-0 headerboxdesign">
             
                <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?></h4>
             
            <div class="d-flex mb-0"> 
                 <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=ADD_ROLE?></a>
            </div>
        </div>
        
    
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap" id="resultDiv">
                                
                            </div>
                            <script type="text/javascript"> 
								SimpleAjax('ajax_roles.php?<?=EncodeUrl("FireAction=listing&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
							</script>    
                        </div>
                    </div>
                </section>
                
                
            </div>
        </div>
        <!-- /Row -->
         
<?php include("deletepopupfile.php") ?>
<!-- Modal HTML -->
<?php } 
else if(isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='ManageRecord')
{
	$FetchData['Active'] = ACTIVE;
	$RecordID = 0;
	if(isset($_REQUEST['RecordID']))
	{
		checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblroles");
	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}
	?>
    	<div class="hk-pg-header mb-0 headerboxdesign">
            <div>
                <h4 class="hk-pg-title"  id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?> > <?=($RecordID > 0)?EDIT_ROLE:ADD_ROLE;?></h4>
            </div>
            <div class="d-flex mb-0"> 
                <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>
         
    <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
	<input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
    <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditRole')?>" />
    <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
    <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
    <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
    <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" />
    
    <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-row">
                                <div class="col-md-4 mb-10 formtitleAr">
                                    <label ><?=TXT_ROLE?> <span>*</span></label>
                                    <input type="text" name="Title" class="form-control" value="<?=($RecordID > 0)?$FetchData['RoleName']:'';?>"  required />
                                    <div class="invalid-feedback">
                                        <?=ENTER_ROLE?>
                                    </div>
                                </div>
								<div class="col-md-4 mb-10 formtitleAr">
                                    <label ><?=TXT_ROLE_AR?> <span>*</span></label>
                                    <input type="text" name="TitleAr" class="form-control" value="<?=($RecordID > 0)?$FetchData['RoleNameAr']:'';?>"   />
                                    <div class="invalid-feedback">
                                        <?=ENTER_ROLE?>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-10 formtitleAr">
                                    <label><?=TXT_ACTIVE_USER?> <span>*</span></label>
                                    <table cellpadding="10">
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-8 ml-20">
                                                    <input id="Yes" name="Active" class="custom-control-input" <?=($FetchData['Active']==1)?'checked="checked"':''?>   type="radio" value="1">
                                                    <label class="custom-control-label" for="Yes"><?=TXT_YES?></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-8 ml-20">
                                                    <input id="No" name="Active" class="custom-control-input" <?=($FetchData['Active']==0)?'checked="checked"':''?>  type="radio"  value="0">
                                                    <label class="custom-control-label" for="No"><?=TXT_NO?></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                
                            </div>
                      		
                            
                       
                            <div class="formbuttonrightside">	
                                <button class="btn btn-danger" type="reset"><?=RESET?></button>
                                <button class="btn btn-primary" type="submit"><?=SUBMIT?></button>
                            </div> 
                        </div>
                    </div>
                </section>
                
                
            </div>
        </div>
    </form>
    
    
     
    
    <?php
}else if(isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='Permission')
{
	checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	?> 
    
    	<div class="hk-pg-header mb-0 headerboxdesign">
             
                <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?> (<?=TXT_PERMISSION?> : <?=getFieldDataByID("RoleName","TableID",$_REQUEST['RecordID'],"tblroles")?>)</h4>
             
            <div class="d-flex mb-0">  
            <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div> 
    
    
    <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
    	 
    						<form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
							<input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('RolePermission')?>" /> 
    						<input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
    						<input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
                            <input type="hidden" name="RecordID" value="<?=encodeencriptstring($_REQUEST['RecordID'])?>" />
                             
                            <div class="table-responsive">
                            <table class="table table-success table-bordered mb-0">
                                <thead  class="thead-success">
                                    <tr>
                                        <td align="right" colspan="10"> &nbsp; <?=TXT_SELECTALL?> <input type="checkbox" id="select-all">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="5%" align="center"><?=SNO?></td>
                                        <td ><?=TXT_MODULE?></td>
                                        <td width="15%" align="center"><input type="checkbox" id="checkbox-111" name="SelectAllCheckBox" value="" onclick="SelectAll('checkbox-111', 'ViewPermissions');"><br><?=TXT_VIEW?></td>
                                        <td width="15%" align="center"><input type="checkbox" id="checkbox-112" name="SelectAllCheckBox" value="" onclick="SelectAll('checkbox-112', 'AddPermissions');"><br><?=TXT_ADD?></td>
                                        <td width="15%" align="center"><input type="checkbox" id="checkbox-113" name="SelectAllCheckBox" value="" onclick="SelectAll('checkbox-113', 'EditPermissions');"><br><?=TXT_EDIT?></td> 
                                        <td width="15%" align="center"><input type="checkbox" id="checkbox-114" name="SelectAllCheckBox" value="" onclick="SelectAll('checkbox-114', 'DeletePermissions');"><br><?=TXT_DELETE?></td> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        /// Master Link Permission Query
                                        $MasterLinkPermission="Select TableID, MenuName  from tblmasterlinks where Active=1 order By Sequence";
                                        $db->query($MasterLinkPermission);
                                        while($db->next_record())
                                        {
                                        ?>
            
                                    <tr>
                                        <td colspan="2" ><?=$db->f(1)?></td>
                                        <td class="tableheading"><?=TXT_SELECTALL?> <input type="checkbox" id="select-all-view<?=$db->f(0)?>" class="checkboxpage"></td>
                                        <td class="tableheading"><?=TXT_SELECTALL?> <input type="checkbox" id="select-all-add<?=$db->f(0)?>" class="checkboxpage"></td>
                                        <td class="tableheading"><?=TXT_SELECTALL?> <input  type="checkbox" id="select-all-edit<?=$db->f(0)?>" class="checkboxpage"></td>  
                                        <td class="tableheading"><?=TXT_SELECTALL?> <input  type="checkbox" id="select-all-delete<?=$db->f(0)?>" class="checkboxpage"></td> 
                                    </tr>
                                        <?php
                                            echo AddSublinkUserPermission($db->f(0),$ParentID=0,$_REQUEST['RecordID'],1,$Counter=0);
                                        }
                                        ?>
                                      
                                </tbody>
                            </table>
        				</div>
                        
                        <div class="formbuttonrightside">	
                            <button class="btn btn-danger" type="reset"><?=RESET?></button>
                            <button class="btn btn-primary" type="submit"><?=SUBMIT?></button>
                        </div>    
    				</form>
               </div>
           </div>
        </section>
    </div>
</div>     
    

<script type="text/javascript">
$( document ).ready(function() {
	$('#select-all').click(function(event) {  
		if(this.checked) {
			$(':checkbox').each(function() {
				this.checked = true;                        
			});
		}
		else{
			 $(':checkbox').each(function() {
				this.checked = false;                        
			});
		}
	});
	
	$('.checkboxpage').click(function() {
		var id = $(this).attr('id');
		if( $(this).is(":checked") ) { 
			$("."+id).prop("checked", true); 
		}
		else{
			$("."+id).prop("checked", false); 
		}
	});

});
function SelectAll(SelectLink, elementname)
{ 
	if($('#'+SelectLink).hasClass('Checked')==true)
	{
		$('input[name^='+elementname+']').removeAttr('checked').each(function()
		{
			this.checked = 0;
		});
		$('#'+SelectLink).removeClass('Checked');
	}
	else
	{
		$('input[name^='+elementname+']').each(function()
		{
			this.checked = 1;
		});
		$('#'+SelectLink).addClass('Checked');
	}
	return false;
}
</script>

    
	<?php
}
?>        

    </div>
    <!-- /Container -->
</div>
       
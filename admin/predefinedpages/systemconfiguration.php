<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
	die("Direct Access Not Allowed");
}
checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
 
?>

<div class="hk-pg-wrapper"> 

<!-- Container -->
<div class="container"> 
    <!-- Title -->
    <div class="headergap"></div> 
   <div class="hk-pg-header mb-0 headerboxdesign"> 
      <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?></h4>
   </div>
    
    
    <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
	<input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
    <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('EditSystemUserconfiguration')?>" />
    <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
    <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" /> 
    	<div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-row ltr">
                            	<?php 
								$FetchConfigValues="select * from tblwebsiteconfiguration where TableID NOT IN('20')";
								$db->query($FetchConfigValues);  
								while($db->next_Record())
								{
									if($db->f('TableID') == 19){
										$unbltbldet = FetchRecordByID('20','TableID','tblwebsiteconfiguration');
										$unbltype = $unbltbldet['Value'];
										$unbltitle = $unbltbldet['Title'.LANG_SEP_DB];
									?>
									
									<div class="col-md-4 mb-10">
                                        <label><?=$unbltitle?></label>
										<select name="PostData[20]" class="form-control selectunblk" onchange="unblockchange()">
										<option value="0" <?=($unbltype==0)?'selected=selected':'';?>><?=TXT_BY_ADMIN?></option>
										<option value="1" <?=($unbltype==1)?'selected=selected':'';?>><?=TXT_AUTOMATIC?></option>
										</select>
                                    </div>
									
									<div class="col-md-4 mb-10 unblocktime" <?=($unbltype==0)?'style="display:none;"':'';?>>
                                        <label><?=$db->f('Title'.LANG_SEP_DB)?></label>
                                        <input type="<?=$db->f('FieldType')?>" min="1" name="PostData[<?=$db->f('TableID')?>]" value="<?=clearTextForField($db->f('Value'))?>"  class="form-control unblocktimemin" <?=($unbltype==1)?'required':'';?>  /> 
                                    </div>
									
									<?php }
										else{
									?>
                                    <div class="col-md-4 mb-10">
                                        <label><?=$db->f('Title')?></label> 
                                        <input type="<?=$db->f('FieldType')?>" <?=($db->f('FieldType')=='number')?'min="1"':'';?> name="PostData[<?=$db->f('TableID')?>]" value="<?=clearTextForField($db->f('Value'))?>"  class="form-control"  <?=($db->f('FieldType')=='number')?'required':'';?> /> 
                                    </div>
                                    <?php
										}
								}
								?>
                                 
                            </div>
                            
                                    <div class="formbuttonrightside">	
                                        <button class="btn btn-danger" type="reset">Reset</button>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div> 
                                    
                                    
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
    
    
    
</div>
</div>     
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
         
        
    	<div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                        	
                            <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
							<input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('EditChangePassword')?>" /> 
                            <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
                            <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" /> 
                            <input type="hidden" name="PasswordStrength" id="PasswordStrength" value="" /> 
                      
                            <div class="form-row">
                                <div class="col-md-4 mb-10 formtitleAr">
                                    <label ><?=OLD_PSWD?> <span>*</span></label>
                    				<input type="password" name="OldPassword" value="<?=$FetchData['FullName']?>" required class="form-control" /> 
                                    <div class="invalid-feedback">
                                       <?=OLD_PSWD_ER?>
                                    </div>
                                </div> 
                                <div class="col-md-4 mb-10 formtitleAr">
                                    <label><?=NEW_PSWD?> <span>*</span></label> 
                                    <input type="password" name="Password" value="" class="form-control" required  id="password" />
                                    <div class="progress" style="display:none;">
                                        <div class="progress-bar-danger" id="passwordprogressbar">
                                           <span id="result" class="short">short</span>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                       <?=NEW_PSWD_ER?>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-10 formtitleAr">
                                    <label><?=CONFIRM_PSWD?> <span>*</span></label> 
                                    <input type="password" name="CPassword" value="" class="form-control"  required  id="CPassword" />
                                    <div class="invalid-feedback">
                                        <?=CONFIRM_NEW_PSWD?>
                                    </div>
                                    <div id="passwordnotmatch"></div>
                                </div> 
                                
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
</div>




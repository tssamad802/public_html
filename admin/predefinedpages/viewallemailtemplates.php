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
        <?php
if(!isset($_REQUEST['PageType']))
{
	checkPermission("ViewPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
?>

        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?></h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=TXT_ADD_EMAILTEMPLATE?></a>
            </div>
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap" id="resultDiv">
								<div class="norecordfound"><?=TXT_PLEASE_WAIT_DATA_LOAD?></div>			
                            </div>
                            <script type="text/javascript"> 
								SimpleAjax('ajax_emailtemplate.php?<?=EncodeUrl("FireAction=listing&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
							</script>    
                        </div>
                    </div>
                </section>


            </div>
        </div>
        <!-- /Row -->


        <!-- Modal HTML -->

        <?php include("deletepopupfile.php") ?>

        <?php
}
else if(isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='ManageRecord')
{
	
	
	$FetchData['Active'] = ACTIVE; 
	$Brief_Description_English=BRIEF_DESCRIPTION_LENGTH_ENGLISH;
	$Brief_Description_Arabic=BRIEF_DESCRIPTION_LENGTH_ARABIC;
	$RemoveData = 1;
	if(isset($_REQUEST['RecordID']))
	{
		$RemoveData = 0;
		checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblemailtemplates");
		$Brief_Description_English=BRIEF_DESCRIPTION_LENGTH_ENGLISH-strlen(clearTextForField($FetchData['BriefDescription']));
		$Brief_Description_Arabic=BRIEF_DESCRIPTION_LENGTH_ARABIC-strlen(clearTextForField($FetchData['BriefDescriptionAr']));
	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}
	?>


        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?>
                (<?=($RecordID > 0)?TXT_EDIT_EMAILTEMPLATE:TXT_ADD_EMAILTEMPLATE;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditEmailtemplate')?>" />
            <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
            <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
            <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
            <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" />
            <input type="hidden" name="PasswordStrength" id="PasswordStrength" value="" />

            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_EMAILTEMPLATE_INFORMATION?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="col-md-4 mb-10">
                                                <label ><?=TXT_TITLE_ENGLISH?>  <span>*</span></label>
                                                <input type="text" name="Title" class="form-control" value="<?=$FetchData['Title']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>

                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label ><?=TXT_TITLE_ARABIC?>  <span>*</span></label>
                                                <input type="text" name="TitleAr" class="form-control" value="<?=$FetchData['TitleAr']?>" dir="rtl" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>
                                            
											
											<div class="col-md-4 mb-10">
                                                <label ><?=TXT_MAILTO?>  </label>
                                                <input type="text" name="SendTo" class="form-control" value="<?=$FetchData['SendTo']?>" dir="ltr"  />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_MAILTO?>
                                                </div> 
                                            </div>	

                                        </div>
										
										<div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label ><?=TXT_SUBJECT_ENGLISH?>  <span>*</span></label>
                                                <input type="text" name="Subject" class="form-control" value="<?=$FetchData['Subject']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_SUBJECT_ENGLISH?>
                                                </div> 
                                            </div>

                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label ><?=TXT_SUBJECT_ARABIC?>  <span>*</span></label>
                                                <input type="text" name="SubjectAr" class="form-control" value="<?=$FetchData['SubjectAr']?>" dir="rtl" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_SUBJECT_ENGLISH?>
                                                </div> 
                                            </div>
                                            


                                        </div>
										
										
                                       
										
										<div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label ><?=TXT_THANK_YOU_MSG_ENGLISH?>  <span>*</span></label>
                                                <input type="text" name="SubmitFormMessage" class="form-control" value="<?=$FetchData['SubmitFormMessage']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_THANK_YOU_MSG_ENGLISH?>
                                                </div> 
                                            </div>

                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label ><?=TXT_THANK_YOU_MSG_ARABIC?>  <span>*</span></label>
                                                <input type="text" name="SubmitFormMessageAr" class="form-control" value="<?=$FetchData['SubmitFormMessageAr']?>" dir="rtl" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_THANK_YOU_MSG_ARABIC?>
                                                </div> 
                                            </div>
                                            


                                        </div>
                                        
                                        
                                                                                
                                      
                                    <div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label><?=TXT_MESSAGE_ENGLISH?></label> 
                                            <textarea class="tinymce" name="Message" required><?php echo clearTextForField($FetchData['Message'])?></textarea>
                                            <div class="invalid-feedback">
                                                <?=ERROR_MESSAGE_ENGLISH?>
                                            </div>
                                        </div>
                                          
                                    </div>
                                     
                                     
                                     <div class="form-row">
                                        <div class="col-md-12 mb-12 mt-12">
                                            <label><?=TXT_MESSAGE_ARABIC?></label> 
                                            <textarea class="tinymcear" name="MessageAr"  required><?php echo clearTextForField($FetchData['MessageAr'])?></textarea>
                                            <div class="invalid-feedback">
                                                <?=ERROR_MESSAGE_ENGLISH?>
                                            </div>
                                        </div>
                                          
                                    </div> 
                                        

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





        <script type="application/javascript">
       
	   RemoveData(<?=$RemoveData?>);
		function RemoveData(value)
		{
			if(value==1)
			setTimeout(function(){$('.singleDatePicker').val('');}, 500);
		}
        </script>
         
        
        </div>


        <?php
}

?>
    </div>
</div> 


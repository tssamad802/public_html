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
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=TXT_ADD_BANNER?></a>
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
								SimpleAjax('ajax_banner.php?<?=EncodeUrl("FireAction=listing&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
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
		$FetchData = FetchRecordByID($RecordID,"TableID","tblbanners");
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
                (<?=($RecordID > 0)?TXT_EDIT_BANNER:TXT_ADD_BANNER;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditBanner')?>" />
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
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_BANNER_INFORMATION?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="col-md-4 mb-10">
                                                <label ><?=TXT_TITLE_ENGLISH1?>  <span>*</span></label>
                                                <input type="text" name="Title1" class="form-control" value="<?=$FetchData['Title1']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>

                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label ><?=TXT_TITLE_ARABIC1?>  <span>*</span></label>
                                                <input type="text" name="Title1Ar" class="form-control" value="<?=$FetchData['Title1Ar']?>" dir="rtl" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>
											
											 <div class="col-md-4 mb-10">
                                                <label ><?=TXT_LINK_ENGLISH1?>  <span>*</span></label>
                                                <input type="text" name="Link1" class="form-control" value="<?=$FetchData['Link1']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_LINK_ENGLISH?>
                                                </div> 
                                            </div>
											
											</div>
										
										<div class="form-row">
											
                                            <div class="col-md-6 mb-10">
                                            <label ><?=TXT_BANNER_IMAGE1.' ('.MAIN_PAGE_BANNER_WIDTH1.'x'.MAIN_PAGE_BANNER_HEIGHT1.')';?></label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?=TXT_UPLOAD?></span>
                                                    </div>
                                                    <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span>  
                                                    <input type="file" name="IconFile1"  class="cropimages" imagewidth="<?=MAIN_PAGE_BANNER_WIDTH1?>"  imageheight="<?=MAIN_PAGE_BANNER_HEIGHT1?>"  cropinput="1"   /> 
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?=TXT_REMOVE?></a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div > 
                                            	
                                            	<div class="image_file_preview1 image_file_preview_result">
                                                	<img src="" />
                                                    <input type="hidden" name="ImageCropData1" />
                                                </div>
                                                
												<?php
                                                if($FetchData['IconFile1']!='')
                                                 echo GallaryImageHtml('../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/cropthumb_'.$FetchData['IconFile1']);
                                                ?>
                                            </div> 
                                        </div>


                                        </div>
										
										<div class="form-row">
                                            <div class="col-md-4 mb-10">
                                                <label ><?=TXT_TITLE_ENGLISH2?>  <span>*</span></label>
                                                <input type="text" name="Title2" class="form-control" value="<?=$FetchData['Title2']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>

                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label ><?=TXT_TITLE_ARABIC2?>  <span>*</span></label>
                                                <input type="text" name="Title2Ar" class="form-control" value="<?=$FetchData['Title2Ar']?>" dir="rtl" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>
											
											 <div class="col-md-4 mb-10">
                                                <label ><?=TXT_LINK_ENGLISH2?>  <span>*</span></label>
                                                <input type="text" name="Link2" class="form-control" value="<?=$FetchData['Link2']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_LINK_ENGLISH?>
                                                </div> 
                                            </div>
											
											</div>
										
										<div class="form-row">
											
                                            <div class="col-md-6 mb-10">
                                            <label ><?=TXT_BANNER_IMAGE2.' ('.MAIN_PAGE_BANNER_WIDTH2.'x'.MAIN_PAGE_BANNER_HEIGHT2.')';?></label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?=TXT_UPLOAD?></span>
                                                    </div>
                                                    <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span> 
                                                    <input type="file" name="IconFile2"  class="cropimages" imagewidth="<?=MAIN_PAGE_BANNER_WIDTH2?>"  imageheight="<?=MAIN_PAGE_BANNER_HEIGHT2?>"  cropinput="2"   /> 
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?=TXT_REMOVE?></a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div > 
                                            	
                                            	<div class="image_file_preview2 image_file_preview_result">
                                                	<img src="" />
                                                    <input type="hidden" name="ImageCropData2" />
                                                </div>
												<?php
                                                if($FetchData['IconFile2']!='')
                                                 echo GallaryImageHtml('../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/cropthumb_'.$FetchData['IconFile2']);
                                                ?>
                                            </div> 
                                        </div>


                                        </div>
										
										<div class="form-row">
                                            <div class="col-md-4 mb-10">
                                                <label ><?=TXT_TITLE_ENGLISH3?>  <span>*</span></label>
                                                <input type="text" name="Title3" class="form-control" value="<?=$FetchData['Title3']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>

                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label ><?=TXT_TITLE_ARABIC3?>  <span>*</span></label>
                                                <input type="text" name="Title3Ar" class="form-control" value="<?=$FetchData['Title3Ar']?>" dir="rtl" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>
											
											 <div class="col-md-4 mb-10">
                                                <label ><?=TXT_LINK_ENGLISH3?>  <span>*</span></label>
                                                <input type="text" name="Link3" class="form-control" value="<?=$FetchData['Link3']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_LINK_ENGLISH?>
                                                </div> 
                                            </div>
											
											</div>
										
										<div class="form-row">
											
                                            <div class="col-md-6 mb-10">
                                            <label ><?=TXT_BANNER_IMAGE3.' ('.MAIN_PAGE_BANNER_WIDTH3.'x'.MAIN_PAGE_BANNER_HEIGHT3.')';?></label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?=TXT_UPLOAD?></span>
                                                    </div>
                                                    <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span> 
                                                    <input type="file" name="IconFile3"  class="cropimages" imagewidth="<?=MAIN_PAGE_BANNER_WIDTH3?>"  imageheight="<?=MAIN_PAGE_BANNER_HEIGHT3?>"  cropinput="3"   /> 
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?=TXT_REMOVE?></a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div > 
                                            	
                                            	<div class="image_file_preview3 image_file_preview_result">
                                                	<img src="" />
                                                    <input type="hidden" name="ImageCropData3" />
                                                </div>
                                                
												<?php
                                                if($FetchData['IconFile3']!='')
                                                 echo GallaryImageHtml('../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/cropthumb_'.$FetchData['IconFile3']);
                                                ?>
                                            </div> 
                                        </div>


                                        </div>
										
										<div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label><?=TXT_BRIEF_ENGLISH?> (<span id="RemainingCount"><?= $Brief_Description_English?></span> <?=TXT_BRIEF_DESC_CHAR_LEFT?>)</label>
                                                <textarea  name="BriefDescription" class="form-control" dir="ltr" rows="3" onkeyup="limiter(<?=BRIEF_DESCRIPTION_LENGTH_ENGLISH ?>, this, 'RemainingCount');" required maxlength="<?=BRIEF_DESCRIPTION_LENGTH_ENGLISH?>"><?=clearTextForField($FetchData['BriefDescription'])?></textarea>  
                                                <div class="invalid-feedback">
                                                    <?=ERROR_BRIEF_ENGLISH?>
                                                </div>  
                                            </div>

                                            
                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label><?=TXT_BRIEF_ARABIC?> (<span id="RemainingCountAr"><?=$Brief_Description_Arabic?></span> <?=TXT_BRIEF_DESC_CHAR_LEFT?>)</label>
                                                <textarea  name="BriefDescriptionAr" class="form-control" rows="3" onkeyup="limiter(<?=BRIEF_DESCRIPTION_LENGTH_ARABIC ?>, this, 'RemainingCountAr');" dir="rtl" required maxlength="<?=BRIEF_DESCRIPTION_LENGTH_ARABIC?>"><?=clearTextForField($FetchData['BriefDescriptionAr'])?></textarea>  
                                                <div class="invalid-feedback">
                                                    <?=ERROR_BRIEF_ARABIC?>
                                                </div>  
                                            </div>
 

                                        </div>
										
										<div class="form-row">
                                            <div class="col-md-4 mb-10">
                                                <label ><?=TXT_TITLE_ENGLISH4?>  <span>*</span></label>
                                                <input type="text" name="Title4" class="form-control" value="<?=$FetchData['Title4']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>

                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label ><?=TXT_TITLE_ARABIC4?>  <span>*</span></label>
                                                <input type="text" name="Title4Ar" class="form-control" value="<?=$FetchData['Title4Ar']?>" dir="rtl" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>
											
											 <div class="col-md-4 mb-10">
                                                <label ><?=TXT_LINK_ENGLISH4?>  <span>*</span></label>
                                                <input type="text" name="Link4" class="form-control" value="<?=$FetchData['Link4']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_LINK_ENGLISH?>
                                                </div> 
                                            </div>
											
											</div>
										
										<div class="form-row">
											
                                            <div class="col-md-6 mb-10">
                                            <label ><?=TXT_BANNER_IMAGE4.' ('.MAIN_PAGE_BANNER_WIDTH4.'x'.MAIN_PAGE_BANNER_HEIGHT4.')';?></label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?=TXT_UPLOAD?></span>
                                                    </div>
                                                    <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span> 
                                                    <input type="file" name="IconFile4"  class="cropimages" imagewidth="<?=MAIN_PAGE_BANNER_WIDTH4?>"  imageheight="<?=MAIN_PAGE_BANNER_HEIGHT4?>"  cropinput="4"   /> 
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?=TXT_REMOVE?></a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div > 
                                            	
                                            	<div class="image_file_preview4 image_file_preview_result">
                                                	<img src="" />
                                                    <input type="hidden" name="ImageCropData4" />
                                                </div>
                                                
                                                
												<?php
                                                if($FetchData['IconFile4']!='')
                                                 echo GallaryImageHtml('../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/cropthumb_'.$FetchData['IconFile4']);
                                                ?>
                                            </div> 
                                        </div>


                                        </div>
										
										
										
                                        <div class="form-row"> 

                                        
                                        <div class="col-md-6 mb-10 formtitleAr">
                                                <label><?=TXT_ACTIVE_USER?> <span>*</span></label> 
                                                <table cellpadding="10">
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8  <?=TXT_MARGIN_LEFT?>">
                                                                <input id="Yes" name="Active"
                                                                    class="custom-control-input"
                                                                    <?=($FetchData['Active']==1)?'checked="checked"':''?>
                                                                    type="radio" value="1">
                                                                <label class="custom-control-label"
                                                                    for="Yes"><?=TXT_YES?></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 ml-20">
                                                                <input id="No" name="Active"
                                                                    class="custom-control-input"
                                                                    <?=($FetchData['Active']==0)?'checked="checked"':''?>
                                                                    type="radio" value="0">
                                                                <label class="custom-control-label"
                                                                    for="No"><?=TXT_NO?></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>

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

 
        <?php
}
?>
    </div>
</div> 


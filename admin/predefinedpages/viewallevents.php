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
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=TXT_ADD_EVENT?></a>
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
								SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listingevents&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
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
		$FetchData = FetchRecordByID($RecordID,"TableID","tblevents");
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
                (<?=($RecordID > 0)?TXT_EDIT_EVENT:TXT_ADD_EVENT;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditEvents')?>" />
            <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
            <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
            <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
            <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" />

            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_EVENT_INFORMATION?></div>
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
                                                <label ><?=TXT_FROM_DATE?>  <span>*</span></label>
                                                <input type="text" name="FromDate" class="form-control singleDatePicker" value="<?=($FetchData['FromDate']=="0000-00-00")?'':$FetchData['FromDate']?>" readonly="readonly"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_FROM_DATE?>
                                                </div> 
                                            </div>


                                        </div>
                                        
                                        <div class="form-row">  
                                        	
                                            <div class="col-md-4 mb-10">
                                                <label ><?=TXT_TO_DATE?>  <span>*</span></label>
                                                <input type="text" name="ToDate" class="form-control singleDatePicker" value="<?=($FetchData['ToDate']=="0000-00-00")?'':$FetchData['ToDate']?>" readonly="readonly"   />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TO_DATE?>
                                                </div> 
                                            </div>
                                            
                                            <div class="col-md-2 mb-10 formtitleAr">
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
                                            
                                            
                                        <div class="col-md-3 mb-10 mt-30">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="ShowHome" id="ShowHome" <?=($FetchData['ShowHome']==1)?'checked=""':''?> value="1" />
                                                <label class="custom-control-label" for="ShowHome"><?=TXT_SHOW_HOME_PAGE?></label>
                                            </div> 
                                        </div>
                                		
                                        
                                        <div class="col-md-3 mb-10 mt-30">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="ShowMenu" id="ShowMenu" <?=($FetchData['ShowMenu']==1)?'checked=""':''?> value="1" />
                                                <label class="custom-control-label" for="ShowMenu"><?=TXT_SHOW_MAIN_MENU?></label>
                                            </div> 
                                        </div>
                                            
                                        </div>
                                        <div class="form-row">  

										<div class="col-md-6 mb-10">
                                            <label ><?=TXT_BANNER_IMAGE?></label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?=TXT_UPLOAD?></span>
                                                    </div>
                                                    <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span>
                                                    <input type="file" name="BannerImage"  class="cropimages" imagewidth="<?=INNER_PAGE_BANNER_WIDTH?>"  imageheight="<?=INNER_PAGE_BANNER_HEIGHT?>"  cropinput="1"  /> 
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
                                                if($FetchData['BannerImage']!='')
                                                 echo GallaryImageHtml('../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/cropthumb_'.$FetchData['BannerImage']);
                                                ?>
                                            </div> 
                                        </div>
                                        
                                        
                                        <div class="col-md-6 mb-10">
                                            <label ><?=TXT_THUMBNAIL_IMAGE?> (<?=THUMBNAIL_EVENT_WIDTH?>X<?=THUMBNAIL_EVENT_HEIGHT?>)</label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?=TXT_UPLOAD?></span>
                                                    </div>
                                                    <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span>
                                                    <input type="file" name="ThumbnailImage"  class="cropimages" imagewidth="<?=THUMBNAIL_EVENT_WIDTH?>"  imageheight="<?=THUMBNAIL_EVENT_HEIGHT?>"  cropinput="2"   /> 
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
                                                if($FetchData['ThumbnailImage']!='')
                                                 echo GallaryImageHtml(DOMAINNAME.'/'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/cropthumb_'.$FetchData['ThumbnailImage']);
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
                                        <div class="col-md-12 mb-12">
                                            <label><?=TXT_DESCRIPTION_ENGLISH?></label> 
                                            <textarea class="tinymce" name="Description" required><?php echo clearTextForField($FetchData['Description'])?></textarea>
                                            <div class="invalid-feedback">
                                                <?=ERROR_DESCRIPTION_ENGLISH?>
                                            </div>
                                        </div>
                                          
                                    </div>
                                     
                                     
                                     <div class="form-row">
                                        <div class="col-md-12 mb-12 mt-12">
                                            <label><?=TXT_DESCRIPTION_ARABIC?></label> 
                                            <textarea class="tinymcear" name="DescriptionAr"  required><?php echo clearTextForField($FetchData['DescriptionAr'])?></textarea>
                                            <div class="invalid-feedback">
                                                <?=ERROR_DESCRIPTION_ARABIC?>
                                            </div>
                                        </div>
                                          
                                    </div> 
                                        

                                    </div>
                                </div>
                                
                                
                                


                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_SEO?></div>
                                    <div class="card-body">
                                        

                                        <div class="form-row">
                                            <div class="col-md-12 mb-10">
                                                <label><?=TXT_PAGE_URL?></label>
                                                <?php if($RecordID > 0) { ?>	 
                                                <input type="text" name="URLKeyword" value="<?=$FetchData['URLKeyword']?>" required class="form-control" /> 
                                                <div class="invalid-feedback">
                                                    <?=ERROR_PAGE_URL?>
                                                </div>
                                                <?php } else { ?>
                                                <p><?=TXT_SEO_LINK_GENERATE?></p>
                                                <?php } ?>
                                            </div> 
                                             
                                        </div>
                                        
 
                                        
                                        <div class="form-row">
                                            <div class="col-md-6 mb-12">
                                                <label><?=TXT_META_ENGLISH?></label> 
                                                <input type="text" name="MetaTitle" dir="ltr" value="<?=$FetchData['MetaTitle']?>"  class="form-control" />  
                                            </div> 
                                            <div class="col-md-6 mb-12 formtitleAr">
                                                <label><?=TXT_META_ARABIC?></label> 
                                                <input type="text" name="MetaTitleAr" dir="rtl" value="<?=$FetchData['MetaTitleAr']?>"  class="form-control" />  
                                            </div> 
                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="col-md-6 mb-12">
                                                <label><?=TXT_META_DESCRIPTION_ENGLISH?></label>  
                                                <textarea  name="MetaDescription" dir="ltr" class="form-control" rows="3"><?=clearTextForField($FetchData['MetaDescription'])?></textarea> 
                                            </div> 
                                            <div class="col-md-6 mb-12 formtitleAr">
                                                <label><?=TXT_META_DESCRIPTION_ARABIC?></label>  
                                                <textarea  name="MetaDescriptionAr" dir="rtl" class="form-control" rows="3"><?=clearTextForField($FetchData['MetaDescriptionAr'])?></textarea> 
                                            </div> 
                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="col-md-6 mb-12">
                                                <label><?=TXT_META_KEYWORD_ENGLISH?></label>  
                                                <textarea  name="MetaKeywords" dir="ltr" class="form-control" rows="3"><?=clearTextForField($FetchData['MetaKeywords'])?></textarea> 
                                            </div> 
                                            <div class="col-md-6 mb-12 formtitleAr">
                                                <label><?=TXT_META_KEYWORD_ARABIC?></label>  
                                                <textarea  name="MetaKeywordsAr" dir="rtl" class="form-control" rows="3"><?=clearTextForField($FetchData['MetaKeywordsAr'])?></textarea> 
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
          

        <?php
}
else if(isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='PageGallery')
{
	checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	?>
 
        <div class="hk-pg-header mb-0 headerboxdesign">
            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?> (<?=TXT_IMAGE_GALLERY?> :
                <?=getFieldDataByID("Title".LANG_SEP_DB,"TableID",$_REQUEST['ParentID'],$_REQUEST['TableName'])?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div> 
        <?php include("imagesgallery.php") ?>
        <?php include("deletepopupfile.php") ?>
        
        <?php
}
else if(isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='PageVideo')
{
	checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	?>
 
        <div class="hk-pg-header mb-0 headerboxdesign">
            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?> (<?=TXT_VIDEO_GALLERY?> :
                <?=getFieldDataByID("Title".LANG_SEP_DB,"TableID",$_REQUEST['ParentID'],$_REQUEST['TableName'])?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div> 
        <?php include("videogallery.php") ?>
        <?php include("deletepopupfile.php") ?>
        
        <?php
}
?>
    </div>
</div> 


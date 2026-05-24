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
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=TXT_ADD_VIDEO?></a>
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
								SimpleAjax('ajax_videopop.php?<?=EncodeUrl("FireAction=listing&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
							</script>    
                        </div>
                    </div>
                </section>


            </div>
        </div>
        <!-- /Row -->


        <!-- Modal HTML -->

        <?php include("deletepopupfile.php") ?>
		<div class="modal fade" id="Videogallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"   style="z-index: 9999;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="width:100%"> 
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
					<div id="videoGal">
					
					</div>
                	
           			</div>
                         
                </div>
            </div>
		<script>
		function showVideogallery(type,url,format){
			
			var videopath = '<?=RESOURCES_DOMAIN."/".FILES_FOLDER."/".UPLOAD_VIDEOS."/";?>';
			if(type == 2)
			{
				$("#videoGal").html('<video width="100%" height="345" controls><source src="'+videopath+url+'" type="video/'+format+'"></video>');
			}
			else{
				$("#videoGal").html('<iframe width="100%" height="345" src="https://www.youtube.com/embed/'+url+'"></iframe>');
			}
			$("#Videogallery").modal();
		}
		</script>

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
		$FetchData = FetchRecordByID($RecordID,"TableID","tbllandingpopupcampaign");
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
                (<?=($RecordID > 0)?TXT_EDIT_VIDEO:TXT_ADD_VIDEO;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditVideoGal')?>" />
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
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_VIDEOGALLERY_INFORMATION?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="col-md-4 mb-10">
                                                <label ><?=TXT_TITLE_ENGLISH1?>  <span>*</span></label>
                                                <input type="text" name="Title1" class="form-control" value="<?=$FetchData['Title']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>

                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label ><?=TXT_TITLE_ARABIC1?>  <span>*</span></label>
                                                <input type="text" name="Title1Ar" class="form-control" value="<?=$FetchData['TitleAr']?>" dir="rtl" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>

											
											</div>
										
										<div class="form-row"> 
                                              
                                        <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=TXT_VIDEO_TYPE?> <span>*</span></label> 
                                                <table cellpadding="10">
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 <?=TXT_MARGIN_LEFT?>">
                                                                <input id="Yes" name="VideoType" class="custom-control-input" <?=($FetchData['VideoType']==1 || $_REQUEST['Trigger'] != 'edit')?'checked="checked"':'';?>
                                                                type="radio" value="1" onclick="DataDisplay(1)">
                                                                <label class="custom-control-label" for="Yes"><?=TXT_YOUTUBE?></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 ml-20">
                                                                <input id="No" name="VideoType"
                                                                    class="custom-control-input" 
                                                                    type="radio" value="2"  onclick="DataDisplay(2)" <?=($FetchData['VideoType']==2)?'checked="checked"':'';?>>
                                                                <label class="custom-control-label"
                                                                    for="No"><?=TXT_FILE_UPLOAD?></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>

											
                                            <div class="col-md-8 mb-10 youtube">
                                                <label ><?=TXT_YOUTUBE?>  <span>*</span></label>
                                                <input type="text" name="FileName" class="form-control" value="<?=($FetchData['VideoType']==1)?$FetchData['FileName']:'';?>" dir="ltr"   /> 
                                            </div>
                                            
                                            
											
                                            <div class="col-md-8 mb-10 fileupload" style="display:none">
                                            <label ><?=TXT_FILE_UPLOAD?>  <span>*</span></label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?=TXT_UPLOAD?></span>
                                                    </div>
                                                    <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span>
                                                    <input type="file" name="Video"   /> 
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?=TXT_REMOVE?></a>
                                                    </span>
                                                </div>
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
                                                                <input id="Yes1" name="Active"
                                                                    class="custom-control-input"
                                                                    <?=($FetchData['Active']==1)?'checked="checked"':''?>
                                                                    type="radio" value="1">
                                                                <label class="custom-control-label"
                                                                    for="Yes1"><?=TXT_YES?></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 ml-20">
                                                                <input id="No1" name="Active"
                                                                    class="custom-control-input"
                                                                    <?=($FetchData['Active']==0)?'checked="checked"':''?>
                                                                    type="radio" value="0">
                                                                <label class="custom-control-label"
                                                                    for="No1"><?=TXT_NO?></label>
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

		<?php if($_REQUEST['Trigger'] == 'edit'){ ?>
		
		<div class="row">
			<div class="col-xl-12">
				<section class="hk-sec-wrapper"> 
					<div class="row">
						<div class="col-sm">
							<div class="card mt-20">
								<div class="card-header card-header-action tabdesignbox"><?=TXT_VIDEO?></div>
							 </div>
							<?php
							$format = ($FetchData['VideoType']==2)?explode(".",$FetchData['FileName'])[1]:0;
							$url = ($FetchData['VideoType']==1)?explode("watch?v=",$FetchData['FileName'])[1]:$FetchData['FileName'];
							$videopath = RESOURCES_DOMAIN."/".FILES_FOLDER."/".UPLOAD_VIDEOS."/";
							
							if(($FetchData['VideoType']==1))
							{
								echo '<iframe width="100%" height="345" src="https://www.youtube.com/embed/'.$url.'"></iframe>';
							}
							else
							{
								echo '<video width="100%" height="345" controls><source src="'.$videopath.$url.'" type="video/'.$format.'"></video>';
							}
							
							?>							 
							<script type="text/javascript"> 
								SimpleAjax('ajax_imagepop.php?<?=EncodeUrl("FireAction=listinggallery&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&TypeID=".$_REQUEST['TypeID']."&ParentID=".$_REQUEST['ParentID'])?>','searchfrm','resultDiv');
							</script>    
						</div>
					</div>


				</section> 
			</div>
		</div> 
		
		<?php } ?>
 
        
        <script type="application/javascript">
       
	   RemoveData(<?=$RemoveData?>);
		function RemoveData(value)
		{
			if(value==1)
			setTimeout(function(){$('.singleDatePicker').val('');}, 500);
		}
        </script>
		<script>
		function DataDisplay(value)
		{
			if(value==1)
			{
				$('.youtube').show();
				$('.fileupload').hide();
			}
			else
			{
				$('.youtube').hide();
				$('.fileupload').show();
			}
			
		}
		
		$( document ).ready(function() {
			DataDisplay(<?=$FetchData['VideoType']?>);
		});
		
		</script>
         
        <div class="modal fade" id="uploadimageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"   style="z-index: 9999;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="width:100%"> 
                <div class="modal-header">
                        <h5 class="modal-title">Crop & Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>  
                			<div style="position:relative; width:100%; height:100%">
                        		<div id="image_demo" style="width:100%;"></div> 
                       		</div> 
                       <button class="btn btn-success crop_image">Crop</button>  
           			</div>
                         
                </div>
            </div>
        </div>


        <?php
}
?>
    </div>
</div> 


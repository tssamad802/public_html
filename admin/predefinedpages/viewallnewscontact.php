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
            	<a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add&import=1")?>"><?=TXT_IMPORT_CONTACT?></a> &nbsp;
                
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=TXT_ADD_CONTACT?></a>
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
								SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listingnewslettercontact&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
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
	if(isset($_REQUEST['RecordID']))
	{ 
		checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblnewslettercontact"); 
	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}
	?>


        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?>
                (<?=($RecordID > 0)?TXT_EDIT_CONTACT:TXT_ADD_CONTACT;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



    <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
    <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
    <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditNewsContact')?>" />
    <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
    <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
    <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
    <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" />
    <input type="hidden" name="MasterTable" value="<?=encodeencriptstring($_REQUEST['TableName'])?>" />
    
    <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-row">
                            	<?php if($_REQUEST['import']==0) { ?>
                                
                                <div class="col-md-12 mb-10">
                                    <label ><?=TXT_CATEGORY?> <span>*</span></label>
                                    <select name="CategoryID" class="form-control select2" required>
                                    	<option value=""><?=TXT_SELECT_CATEGORY?></option>
                                        <?=fillcombocontrol($FetchData['CategoryID'],"TableID","Title","tblnewslettercontactcategory where Active=1","Title")?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?=ERROR_SELECT_CATEGORY?>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-4 mb-10">
                                    <label ><?=TXT_NAME?> <span>*</span></label>
                                    <input type="text" name="FullName" class="form-control" value="<?=$FetchData['FullName']?>"  required />
                                    <div class="invalid-feedback">
                                        <?=TXT_NAME_ER?>
                                    </div> 
                                </div>  
                                
                                <div class="col-md-4 mb-10">
                                    <label ><?=TXT_EMAIL?> <span>*</span></label>
                                    <input type="email" name="Email" class="form-control" value="<?=$FetchData['Email']?>"  required />
                                    <div class="invalid-feedback">
                                        <?=TXT_EMAIL_ER?>
                                    </div> 
                                </div>   
                                
                                <div class="col-md-4 mb-10">
                                    <label ><?=TXT_MOBILE?>  <span>*</span></label>
                                    <input type="text" name="MobileNumber" class="form-control" value="<?=$FetchData['MobileNumber']?>" required maxlength="10" onkeypress="return numberswithdescimal(event, false)" onpaste="return false" />
                                    <div class="invalid-feedback">
                                        <?=TXT_MOBILE_ER?>
                                    </div> 
                                   
                                </div> 
                                <?php 
								} 
								else if($_REQUEST['import']==1)
								{
									?>
                                    <input type="hidden" value="1" name="ImportData" />
                                    <div class="col-md-4 mb-10">
                                        <label ><?=TXT_CATEGORY?> <span>*</span></label>
                                        <select name="CategoryID" class="form-control select2" required>
                                            <option value=""><?=TXT_SELECT_CATEGORY?></option>
                                            <?=fillcombocontrol($FetchData['CategoryID'],"TableID","Title","tblnewslettercontactcategory where Active=1","Title")?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?=ERROR_SELECT_CATEGORY?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-10">
                                        <label ><?=TXT_IMPORT_CONTACT_FILE?> (<a href="images/sample.xlsx" download><?=TXT_DOWNLOAD_SAMPLE?></a>) <span>*</span></label>
                                        <input type="file" name="FileUpload" class="form-control" required />
                                        <div class="invalid-feedback">
                                           <?=ERROR_IMPORT_CONTACT?>
                                        </div>  
                                        
                                    </div>
                                    <?php
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
else if(isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='AssessmentTest')
{
	checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	?>
 
        <div class="hk-pg-header mb-0 headerboxdesign">
            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?> (<?=TXT_ASESSMENT_TEST?> :
                <?=getFieldDataByID("Title".LANG_SEP_DB,"TableID",$_REQUEST['ParentID'],'tblcourses')?>)</h4>

            <div class="d-flex mb-0"> 
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
                    &nbsp;&nbsp;
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecordQuestion&Trigger=add&ParentID=".$_REQUEST['ParentID'])?>"><?=TXT_ADD_ASESSMENT_TEST?></a> 
            </div>
        </div>  
        
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap" id="resultDiv">
								<div class="norecordfound"><?=TXT_PLEASE_WAIT_DATA_LOAD?></div>			
                            </div>
                            <script type="text/javascript"> 
								SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listingcoursesassestmenttest&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&ParentID=".$_REQUEST['ParentID'])?>','searchfrm','resultDiv');
							</script>    
                        </div>
                    </div>
                </section>


            </div>
        </div>

        <?php include("deletepopupfile.php") ?>
        
        <?php
}
else if(isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='ManageRecordQuestion')
{
	$FetchData['Active'] = ACTIVE;
	$CounterData = 1; 
	if(isset($_REQUEST['RecordID']))
	{ 
		checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblcoursequestion"); 
	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}
	?>


        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?> - <?=getFieldDataByID("Title".LANG_SEP_DB,"TableID",$_REQUEST['ParentID'],'tblcourses')?>
                (<?=($RecordID > 0)?TXT_EDIT_ASESSMENT_TEST:TXT_ADD_ASESSMENT_TEST;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&ParentID=".$_REQUEST['ParentID']."&PageType=AssessmentTest")?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditAssessmentTest')?>" />
            <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
            <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
            <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
            <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" /> 
            <input type="hidden" name="ParentID" value="<?=encodeencriptstring($_REQUEST['ParentID'])?>" />

            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_ASESSMENT_INFORMATION?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                        	
                                            
                                            <div class="col-md-4 mb-20">
                                                <label ><?=TXT_TITLE_ENGLISH?>  <span>*</span></label>
                                                <input type="text" name="Title" class="form-control" value="<?=$FetchData['Title']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>

                                            <div class="col-md-4 mb-20 formtitleAr">
                                                <label ><?=TXT_TITLE_ARABIC?>  <span>*</span></label>
                                                <input type="text" name="TitleAr" class="form-control" value="<?=$FetchData['TitleAr']?>" dir="rtl" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ARABIC?>
                                                </div> 
                                            </div>
											
                                            <div class="col-md-4 mb-10 formtitleAr">
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


                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_QUESTION_OPTION?></div>
                                    <div class="card-body">
                                        

                                        <div class="form-row">
                                            
                                            <?php
											$sql="select * from tblcoursequestionoption where QuestionID='".$RecordID."' order by Sequence ASC";
											$db->query($sql);
											if($db->num_rows() > 0)
											{ 
												$CountRow=0;
												while($db->next_Record())
												{ 
													$CounterData = $db->f('TableID');
													$CountRow++;
													//$Selectecheckbox ($db->f('CorrectAnswer')==1)?'checked="checked"':'';
											?>
                                            		<input type="hidden" value="<?=encodeencriptstring($db->f('TableID'))?>" name="OptionID[<?=$db->f('TableID')?>]" />
                                                    <div class="col-md-4 mb-20">
                                                        <label ><?=TXT_TITLE_ENGLISH?>  <span>*</span></label>
                                                        <input type="text" name="OptionTitle[<?=$db->f('TableID')?>]" class="form-control" value="<?=$db->f('Title')?>" dir="ltr"  required />
                                                        <div class="invalid-feedback">
                                                           <?=ERROR_TITLE_ENGLISH?>
                                                        </div> 
                                                    </div>
        
                                                    <div class="col-md-4 mb-20 formtitleAr">
                                                        <label ><?=TXT_TITLE_ARABIC?>  <span>*</span></label>
                                                        <input type="text" name="OptionTitleAr[<?=$db->f('TableID')?>]" class="form-control" value="<?=$db->f('TitleAr')?>" dir="rtl" required />
                                                        <div class="invalid-feedback">
                                                           <?=ERROR_TITLE_ARABIC?>
                                                        </div> 
                                                    </div>
                                                    
                                                    
                                                    <div class="col-md-2 mb-20 formtitleAr">
                                                        <label><?=($CountRow==1)?TXT_CORRECT_ANSWER.' <span>*</span>':'';?>  </label>
                                                        <div class="custom-control custom-radio mb-10 mt-8">
                                                         <input  name="CorrectAnswer[<?=$db->f('TableID')?>]" class="radiobtnwith singleselect" type="checkbox" value="1"  <?=($db->f('CorrectAnswer')==1)?'checked="checked"':''?> />
                                                        </div> 
                                                        <div class="invalid-feedback">
                                                           <?=ERROR_TITLE_ENGLISH?>
                                                        </div> 
                                                    </div>
                                                    
                                                    
                                                    <div class="col-md-2 mb-20 formtitleAr">
                                                        <label ><?=($CountRow==1)?TXT_ACTIVE_USER.' <span>*</span>':'';?></label>
                                                        <table cellpadding="10">
                                                            <tr>
                                                                <td>
                                                                    <div class="custom-control custom-radio mb-10 mt-8  <?=TXT_MARGIN_LEFT?>">
                                                                        <input id="Yes<?=$db->f('TableID')?>" name="OptionActive[<?=$db->f('TableID')?>]"
                                                                            class="custom-control-input"
                                                                            <?=($db->f('Active')==1)?'checked="checked"':''?>
                                                                            type="radio" value="1">
                                                                        <label class="custom-control-label"
                                                                            for="Yes<?=$db->f('TableID')?>"><?=TXT_YES?></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control custom-radio mb-10 mt-8 ml-20">
                                                                        <input id="No<?=$db->f('TableID')?>" name="OptionActive[<?=$db->f('TableID')?>]"
                                                                            class="custom-control-input"
                                                                            <?=($db->f('Active')==0)?'checked="checked"':''?>
                                                                            type="radio" value="0">
                                                                        <label class="custom-control-label"
                                                                            for="No<?=$db->f('TableID')?>"><?=TXT_NO?></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>  
                                                    </div>
                                            <?php
												}
											}
											else
											{
												?> 
                                                <div class="col-md-4 mb-20">
                                                    <label ><?=TXT_TITLE_ENGLISH?>  <span>*</span></label>
                                                    <input type="text" name="OptionTitle[1]" class="form-control" value="" dir="ltr"  required />
                                                    <div class="invalid-feedback">
                                                       <?=ERROR_TITLE_ENGLISH?>
                                                    </div> 
                                                </div>
    
                                                <div class="col-md-4 mb-20 formtitleAr">
                                                    <label ><?=TXT_TITLE_ARABIC?>  <span>*</span></label>
                                                    <input type="text" name="OptionTitleAr[1]" class="form-control" value="" dir="rtl" required />
                                                    <div class="invalid-feedback">
                                                       <?=ERROR_TITLE_ARABIC?>
                                                    </div> 
                                                </div>
                                                
                                                
                                                <div class="col-md-2 mb-20 formtitleAr">
                                                    <label ><?=TXT_CORRECT_ANSWER?>  <span>*</span></label>
                                                    <div class="custom-control custom-radio mb-10 mt-8">
                                                     <input  name="CorrectAnswer[1]" class="radiobtnwith singleselect" type="checkbox" value="1" checked="checked" />
                                                    </div> 
                                                    <div class="invalid-feedback">
                                                       <?=ERROR_TITLE_ENGLISH?>
                                                    </div> 
                                                </div>
                                                
                                                
                                                <div class="col-md-2 mb-20 formtitleAr">
                                                    <label ><?=TXT_REMOVE?></label>  
                                                </div>
                                                <?php
											}
											?>
                                             
                                        </div>
                                        
                                        
                                        <div class="form-row addrowdata">
                                        
                                        </div>
                                        
                                        
                                        <div class="form-row">
                                            <div class="col-md-4 mb-20">
                                                <a href="javascript:void(0);" onclick="AddOptions()" style="font-size:40px">
                                                    <i class="ion ion-md-add-circle"></i>
                                                </a>
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
<style>
.radiobtnwith{
	width:30px;
	height:30px;
}
</style>
<script>
		SingleSelectCheck();			
var counterdata = <?=$CounterData?>;
function AddOptions()
{
	counterdata++;
	var htmldata  = '<div class="col-md-4 mb-20 removminus'+counterdata+'">'+
						'<label ><?=TXT_TITLE_ENGLISH?>  <span>*</span></label>'+
						'<input type="text" name="OptionTitle['+counterdata+']" class="form-control" value="" dir="ltr"  required />'+
						'<div class="invalid-feedback">'+
						   '<?=ERROR_TITLE_ENGLISH?>'+
						'</div> '+
					'</div>';
					
		htmldata  += '<div class="col-md-4 mb-20 removminus'+counterdata+'">'+
						'<label ><?=TXT_TITLE_ARABIC?>  <span>*</span></label>'+
						'<input type="text" name="OptionTitleAr['+counterdata+']" class="form-control" value="" dir="rtl"  required />'+
						'<div class="invalid-feedback">'+
						   '<?=ERROR_TITLE_ARABIC?>'+
						'</div> '+
					'</div>';
					
		htmldata  += '<div class="col-md-2 mb-20 formtitleAr removminus'+counterdata+'">'+
						'<label >&nbsp;</label>'+
						'<div class="custom-control custom-radio mb-10 mt-8">'+
						' <input  name="CorrectAnswer['+counterdata+']" class="radiobtnwith singleselect" type="checkbox" value="1"  />'+
						'</div>'+
						'<div class="invalid-feedback">'+
						   '<?=ERROR_TITLE_ENGLISH?>'+
						'</div>'+
					'</div>';
					
		htmldata  += '<div class="col-md-2 mb-20 formtitleAr removminus'+counterdata+'">'+
						'<label >&nbsp;</label>'+
						'<div class="custom-control custom-radio" style="margin-top:-15px;">'+
						'<a href="javascript:void(0);" onclick="RemoveField('+counterdata+')" style="font-size:40px"><i class="ion ion-ios-remove-circle"></i></a>'+
						'</div>'+
						'<div class="invalid-feedback">'+
						   '<?=ERROR_TITLE_ENGLISH?>'+
						'</div>'+
					'</div>';
		$('.addrowdata').append(htmldata);
		SingleSelectCheck();			
}
function SingleSelectCheck()
{
	$('.singleselect').on('change', function() {
	   $('.singleselect').prop("checked", false);
        $(this).prop('checked', true);
     });
}

</script>


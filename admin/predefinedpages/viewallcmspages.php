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
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=TXT_ADDPAGE?></a>
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
								SimpleAjax('ajax_pages.php?<?=EncodeUrl("FireAction=listing&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
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
		$FetchData = FetchRecordByID($RecordID,"TableID","tblpages");
		$Brief_Description_English=BRIEF_DESCRIPTION_LENGTH_ENGLISH-strlen(clearTextForField($FetchData['BriefDescription']));
	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}
	?>


        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?>
                (<?=($RecordID > 0)?TXT_EDITPAGE:TXT_ADDPAGE;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditCmspage')?>" />
            <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
            <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
            <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
            <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" />
			<input type="hidden" name="TableName" value="<?=encodeencriptstring('tblpages')?>" id="TableName">
			<input type="hidden" name="ActionAjax" value="<?=encodeencriptstring('ajaxsearch')?>" id="ActionAjax">
            <input type="hidden" name="PasswordStrength" id="PasswordStrength" value="" />

            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_PAGE_INFORMATION?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="col-md-4 mb-10">
                                                <label ><?=TXT_PAGETYPE?>  <span>*</span></label>
                                                 <select name="PageType" id="PageType" class="form-control custom-select select2" onchange="ShowHidePageFields(this.value);" required>
													<option value=""><?=TXT_SELECT_PAGETYPE?></option>
													<?php
													foreach($PageType as $key => $value)
													{
														$selected = ($key == $FetchData['PageType'])?' selected="selected"':'';
													?>
													<option value="<?php echo $key;?>"<?php echo $selected;?>><?php echo $value;?></option>
													<?php
													}
													?>
													</select>
                                                <div class="invalid-feedback">
                                                   <?=ERROR_PAGETYPE?>
                                                </div> 
                                            </div>
											<div class="col-md-4 mb-10">
                                                <label ><?=TXT_TITLE_ENGLISH?>  <span>*</span></label>
                                                <input type="text" name="Title" class="form-control" value="<?=$FetchData['Title']?>" dir=""  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div> 
                                            </div>

											
											 <div class="col-md-4 mb-10">
                                                <label ><?=TXT_TITLE_MENU?>  <span>*</span></label>
                                                <input type="text" name="MenuTitle" class="form-control" value="<?=$FetchData['MenuTitle']?>" dir="" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_MENU_ENGLISH?>
                                                </div> 
                                            </div>

											 <div class="col-md-4 mb-10 nolinkhide">
                                                <label ><?=TXT_TITLE_BANNER?></label>
                                                <input type="text" name="BannerTitle" class="form-control" value="<?=$FetchData['BannerTitle']?>" dir="" />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_BANNER_ENGLISH?>
                                                </div> 
                                            </div>

											<div class="col-md-4 mb-10 extlinkonly">
                                                <label ><?=TXT_TITLE_EXTERNALLINK?>  <span>*</span></label>
                                                <input type="text" name="ExternalLink" class="form-control extlinkonlyin" value="<?=$FetchData['ExternalLink']?>" />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_EXTERNALLINK?>
                                                </div> 
                                            </div>
											
											
											
											
                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label ><?=TXT_PARENTPAGE?>  <span>*</span></label>
												<!--<input type="hidden" name="ParentTableID" id="ParentTableID" value="<?php echo $FetchData['ParentTableID'];?>" />
												<input value="<?=clearTextForField(getFieldDataByID("Title".LANG_SEP_DB,"TableID",$FetchData['ParentTableID'],"tblpages"))?>" type="text" name="ParentTitle" id="tags" class="form-control">-->
												
												<select name="ParentTableID" id="ParentTableID" class="form-control custom-select select2">
													<option value=""><?=TXT_SELECT_PARENTPAGE?></option>
													<?php
													echo fillcombocontrolWhereField($FetchData['ParentTableID'],"TableID","Title","Active",1,"tblpages","Title","asc");
													
													?>
													</select>
												
                                                <div class="invalid-feedback">
                                                   <?=ERROR_PARENT_PAGE?>
                                                </div> 
                                            </div>


                                        </div>
                                        <div class="form-row"> 
                                             
                                            <div class="col-md-3 mb-10 formtitleAr">
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
                                                <input type="checkbox" class="custom-control-input" name="ShowInNav" id="ShowInNav" <?=($FetchData['ShowInNav']==1)?'checked=""':''?> value="1" />
                                                <label class="custom-control-label" for="ShowInNav"><?=TXT_SHOW_INNAV?></label>
                                            </div> 
                                        </div>
										 <div class="col-md-3 mb-10 mt-30">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="ShowInFooterNav1" id="ShowInFooterNav1" <?=($FetchData['ShowInFooterNav1']==1)?'checked=""':''?> value="1" />
                                                <label class="custom-control-label" for="ShowInFooterNav1"><?=TXT_SHOW_FOOTER1?></label>
                                            </div> 
                                        </div>
										 <div class="col-md-3 mb-10 mt-30">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="ShowInFooterNav2" id="ShowInFooterNav2" <?=($FetchData['ShowInFooterNav2']==1)?'checked=""':''?> value="1" />
                                                <label class="custom-control-label" for="ShowInFooterNav2"><?=TXT_SHOW_FOOTER2?></label>
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

                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="col-md-6 mb-12">
                                                <label><?=TXT_META_DESCRIPTION_ENGLISH?></label>  
                                                <textarea  name="MetaDescription" dir="ltr" class="form-control" rows="3"><?=clearTextForField($FetchData['MetaDescription'])?></textarea> 
                                            </div> 

                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="col-md-6 mb-12">
                                                <label><?=TXT_META_KEYWORD_ENGLISH?></label>  
                                                <textarea  name="MetaKeywords" dir="ltr" class="form-control" rows="3"><?=clearTextForField($FetchData['MetaKeywords'])?></textarea> 
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
		
		function ShowHidePageFields(val)
		{
			$(".filetype").hide();
			$(".extlinkonly").hide();
			$(".extlinkonlyin").removeAttr("required");
			$(".nolinkhide").show();
			$(".nolinkvalid").attr("required","required");
			$(".useotherhide").show();
			$(".useothervalid").attr("required","required");
			if(val == 3)
			{
				$(".nolinkhide").hide();
				$(".nolinkvalid").removeAttr("required");
				$(".useotherhide").hide();
				$(".useothervalid").removeAttr("required");
			}
			/* if(val == 9 || val == 10 || val == 11 || val == 12 ||val == 13)
			{
				$(".useotherhide").hide();
				$(".useothervalid").removeAttr("required");
			} */
			if(val == 4)
			{
				$(".extlinkonly").show();
				$(".extlinkonlyin").attr("required","required");
				$(".nolinkhide").hide();
				$(".nolinkvalid").removeAttr("required");
				$(".useotherhide").hide();
				$(".useothervalid").removeAttr("required");
			}
			if(val == 8)
			{
				$(".filetype").show();
			}
		}
		$(document).ready(function() {
		<?php if($FetchData['PageType'] > 0){?>
		ShowHidePageFields(<?php echo $FetchData['PageType'];?>);
		<?php }?>
		});
		
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
else if(isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='Permission')
{
	checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	?>


        <div class="hk-pg-header mb-0 headerboxdesign">
            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?> (<?=TXT_PERMISSION?> :
                <?=getFieldDataByID("FullName","TableID",$_REQUEST['RecordID'],"tblsystemusers")?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>





        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">

                            <form class="needs-validation" enctype="multipart/form-data" method="post" action=""
                                novalidate>
                                <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                                <input type="hidden" name="ActionFlag"
                                    value="<?=encodeencriptstring('SystemUserPermission')?>" />
                                <input type="hidden" name="actionpage"
                                    value="<?=encodeencriptstring($_REQUEST['action'])?>" />
                                <input type="hidden" name="SubLinkID"
                                    value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
                                <input type="hidden" name="RecordID"
                                    value="<?=encodeencriptstring($_REQUEST['RecordID'])?>" />

                                <div class="table-responsive">
                                    <table class="table table-success table-bordered mb-0">
                                        <thead class="thead-success">
                                            <tr>
                                                <td align="right" colspan="10"> &nbsp; <?=TXT_SELECTALL?> <input type="checkbox"
                                                        id="select-all">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="5%" align="center"><?=SNO?></td>
                                                <td><?=TXT_MODULE?></td>
                                                <td width="15%" align="center"><input type="checkbox" id="checkbox-111"
                                                        name="SelectAllCheckBox" value=""
                                                        onclick="SelectAll('checkbox-111', 'ViewPermissions');"><br><?=TXT_VIEW?>
                                                </td>
                                                <td width="15%" align="center"><input type="checkbox" id="checkbox-112"
                                                        name="SelectAllCheckBox" value=""
                                                        onclick="SelectAll('checkbox-112', 'AddPermissions');"><br><?=TXT_ADD?>
                                                </td>
                                                <td width="15%" align="center"><input type="checkbox" id="checkbox-113"
                                                        name="SelectAllCheckBox" value=""
                                                        onclick="SelectAll('checkbox-113', 'EditPermissions');"><br><?=TXT_EDIT?>
                                                </td>
                                                <td width="15%" align="center"><input type="checkbox" id="checkbox-114"
                                                        name="SelectAllCheckBox" value=""
                                                        onclick="SelectAll('checkbox-114', 'DeletePermissions');"><br><?=TXT_DELETE?>
                                                </td>
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
                                                <td colspan="2"><?=$db->f(1)?></td>
                                                <td class="tableheading"><?=TXT_SELECTALL?> <input type="checkbox"
                                                        id="select-all-view<?=$db->f(0)?>" class="checkboxpage"></td>
                                                <td class="tableheading"><?=TXT_SELECTALL?> <input type="checkbox"
                                                        id="select-all-add<?=$db->f(0)?>" class="checkboxpage"></td>
                                                <td class="tableheading"><?=TXT_SELECTALL?> <input type="checkbox"
                                                        id="select-all-edit<?=$db->f(0)?>" class="checkboxpage"></td>
                                                <td class="tableheading"><?=TXT_SELECTALL?> <input type="checkbox"
                                                        id="select-all-delete<?=$db->f(0)?>" class="checkboxpage"></td>
                                            </tr>
                                            <?php
                                            echo AddSublinkUserPermission($db->f(0),$ParentID=0,$_REQUEST['RecordID'],2,$Counter=0);
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
        $(document).ready(function() {
            $('#select-all').click(function(event) {
                if (this.checked) {
                    $(':checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });

            $('.checkboxpage').click(function() {
                var id = $(this).attr('id');
                if ($(this).is(":checked")) {
                    $("." + id).prop("checked", true);
                } else {
                    $("." + id).prop("checked", false);
                }
            });

        });

        function SelectAll(SelectLink, elementname) {
            if ($('#' + SelectLink).hasClass('Checked') == true) {
                $('input[name^=' + elementname + ']').removeAttr('checked').each(function() {
                    this.checked = 0;
                });
                $('#' + SelectLink).removeClass('Checked');
            } else {
                $('input[name^=' + elementname + ']').each(function() {
                    this.checked = 1;
                });
                $('#' + SelectLink).addClass('Checked');
            }
            return false;
        }
        </script>
        <?php
}
?>
    </div>
</div>
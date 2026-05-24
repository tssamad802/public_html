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
if(!isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='')
{
	checkPermission("ViewPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
?>

    	<div class="hk-pg-header mb-0 headerboxdesign">

                <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?></h4>

            <div class="d-flex mb-0">

                 <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add&TableName=".$_REQUEST['TableName'])?>"><?=TXT_ADD_MASTER_RECORD?></a>
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
								SimpleAjax('ajax_masterdata.php?<?=EncodeUrl("FireAction=listing&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&TableName=".$_REQUEST['TableName'])?>','searchfrm','resultDiv');
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
	if($_REQUEST['RecordID'] > 0)
	{
		checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID",$_REQUEST['TableName']);
	}
	else
	{
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
	}
	$PageName = FetchSubLinkMenuName($_REQUEST['SubLinkID']);
	?>


    <div class="hk-pg-header mb-0 headerboxdesign">
                <h4 class="hk-pg-title"  id="titleheading"><?=$PageName?> >
				<?php  echo ($RecordID > 0)?TXT_EDIT." ".$PageName:TXT_ADD." ".$PageName; ?>
                </h4>
            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&TableName=".$_REQUEST['TableName'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



    <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
    <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
    <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddMasterData')?>" />
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
                                <div class="col-md-4 mb-10">
                                    <label >Parent Category  <span>*</span></label>
                                    <input type="text" name="<?=($RecordID==0)?'Title[]':'Title'?>" class="form-control" value="<?=$FetchData['Title']?>" dir="ltr"  required />
                                    <div class="invalid-feedback">
                                       <?=ERROR_TITLE_ENGLISH?>
                                    </div>

                                </div>



                                <div class="col-md-4 mb-10">
                                    <label><?=TXT_ACTIVE_USER?> <span>*</span></label>
                                    <table cellpadding="10">
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-10">
                                                    <input id="Yes" name="Active" class="custom-control-input" <?=($FetchData['Active']==1)?'checked="checked"':''?>   type="radio" value="1">
                                                    <label class="custom-control-label" for="Yes"><?=TXT_YES?></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-8 ml-20 mr-20">
                                                    <input id="No" name="Active" class="custom-control-input" <?=($FetchData['Active']==0)?'checked="checked"':''?>  type="radio"  value="0">
                                                    <label class="custom-control-label" for="No"><?=TXT_NO?></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>



                                </div>

                            </div>


                            <div class="form-row">
                                    <?php if($RecordID==0) { ?>
                                    <div class="col-md-4 mb-10">
                                        <div class="makemastercopies">
                                        </div>
                                    </div>
                                    <?php } ?>



                                    <?php if($RecordID==0) { ?>
                                    <div class="col-md-4 mb-10">
                                        <div class="makemastercopiesarabic">
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <?php if($RecordID==0) { ?>
                                    <div class="col-md-4 mb-10  mt-10">
                                        <div class="makemasfileupload">
                                        </div>
                                    </div>
                                    <?php } ?>
                           </div>

wait karo sub set kr k data hu

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


    <div class="hk-pg-header mb-0 headerboxdesign">
        <h4 class="hk-pg-title"  id="titleheading">Sub Category</h4>
        <div class="d-flex mb-0">
            <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&TableName=".$_REQUEST['TableName'])?>"><?=TXT_BACK?></a>
        </div>
    </div>


    <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
        <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
        <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddMasterDataBySubCategory')?>" />
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
                                <div class="col-md-4 mb-10">
                                    <label >Sub Category <span>*</span></label>
                                    <input type="text" name="subCategory" class="form-control" value="<?=$FetchData['Title']?>" dir="ltr"  required />
                                    <div class="invalid-feedback">
                                        <?=ERROR_TITLE_ENGLISH?>
                                    </div>

                                </div>


                                <div class="col-md-4 mb-10">
                                    <label >Parent Category<span>*</span></label>
                                    <select class="form-control custom-select select2" name="CreatedBy">
                                        <option>Parrent Category</option>
                                        <?php
                                        echo fillcombocontrol(0,"TableID","Title","tblcategory","TableID");
                                        ?>
                                    </select>

                                </div>

                                <div class="col-md-4 mb-10">
                                    <label><?=TXT_ACTIVE_USER?> <span>*</span></label>
                                    <table cellpadding="10">
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-10">
                                                    <input id="Yes" name="Active" class="custom-control-input" <?=($FetchData['Active']==1)?'checked="checked"':''?>   type="radio" value="1">
                                                    <label class="custom-control-label" for="Yes"><?=TXT_YES?></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio mb-10 mt-8 ml-20 mr-20">
                                                    <input id="No" name="Active" class="custom-control-input" <?=($FetchData['Active']==0)?'checked="checked"':''?>  type="radio"  value="0">
                                                    <label class="custom-control-label" for="No"><?=TXT_NO?></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>



                                </div>



                            </div>


                            <div class="form-row">
                                <?php if($RecordID==0) { ?>
                                    <div class="col-md-4 mb-10">
                                        <div class="makemastercopies">
                                        </div>
                                    </div>
                                <?php } ?>



                                <?php if($RecordID==0) { ?>
                                    <div class="col-md-4 mb-10">
                                        <div class="makemastercopiesarabic">
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if($RecordID==0) { ?>
                                    <div class="col-md-4 mb-10  mt-10">
                                        <div class="makemasfileupload">
                                        </div>
                                    </div>
                                <?php } ?>
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

<script>
$( document ).ready(function() {
	var masterpluscounter = 0;
	$('.addplussigndata').click(function(){
		masterpluscounter++;
		var anchorlink = '<a href="javascript:void(0);" onclick="RemoveField('+masterpluscounter+')" class="minussign"><i class="ion ion-ios-close-circle-outline"></i></a>';
		var htmltext = '<div class="otheplusbox removminus'+masterpluscounter+'">'+
						   '<label >'+window.TxtEnglish+' <span>*</span> '+anchorlink+'</label>'+
						   '<input type="text" name="Title[]" class="form-control" value="" dir="ltr"  required />'+
						   '<div class="invalid-feedback">'+
							   ''+window.TxtEnglishERROR+''+
						   '</div>';
                       '</div>';

		var htmltextarabic = '<div class="otheplusbox removminus'+masterpluscounter+'">'+
						   '<label >'+window.TxtArabic+' <span>*</span> '+anchorlink+'</label>'+
						   '<input type="text" name="TitleAr[]" class="form-control" value="" dir="rtl"  required />'+
						   '<div class="invalid-feedback">'+
							   ''+window.TxtArabicERROR+''+
						   '</div>';
                       '</div>';

		var fileupload = '<div class="otheplusbox removminus'+masterpluscounter+'">'+
                                   '<label><?=TXT_THUMBNAIL_IMAGE?> (<?=HOME_PAGE_THUMBNAIL_WIDTH?>X<?=HOME_PAGE_THUMBNAIL_HEIGHT?>)</label>'+
                                   '<div class="form-group">'+
                                        '<div class="fileinput fileinput-new input-group" data-provides="fileinput">'+
                                            '<div class="input-group-prepend">'+
                                                '<span class="input-group-text"><?=TXT_UPLOAD?></span>'+
                                            '</div>'+
                                            '<div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>'+
                                            '<span class="input-group-append">'+
                                                    '<span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span>'+
                                            '<input type="file" name="ThumbnailImage[]"  class="cropimages" imagewidth="<?=HOME_PAGE_THUMBNAIL_WIDTH?>"  imageheight="<?=HOME_PAGE_THUMBNAIL_HEIGHT?>"  cropinput="'+masterpluscounter+'"   />'+
                                            '</span>'+
                                            '<a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?=TXT_REMOVE?></a>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div > <div class="image_file_preview'+masterpluscounter+' image_file_preview_result"><img src="" /><input type="hidden" name="ImageCropData'+masterpluscounter+'" /></div>'+
                                    '</div>'+
                                '</div>';
		$('.makemastercopies').append(htmltext);
		$('.makemastercopiesarabic').append(htmltextarabic);
		$('.makemasfileupload').append(fileupload);
		cropimages();
	});

});
</script>


    <?php
}
?>

    </div>
    <!-- /Container -->
</div>

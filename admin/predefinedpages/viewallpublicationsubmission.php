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
								SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listingpublicationsubmission&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
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
		$FetchData = FetchRecordByID($RecordID,"id","tblpolicy");

	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}

	?>


        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?>
                (<?=TXT_UPDATE_PUBLICATION;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id ?>" value="<?= $token_value ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditPublicationForm')?>" />
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
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_SUBMIT_FORM_INFORMATION?></div>
                                    <div class="card-body">
                                        
                                        	 <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label > Title  <span>*</span></label>
                                            <input type="text" name="Title" id="Title" class="form-control" value="<?=$FetchData['Title']?>" dir="ltr"  required />
                                            <div class="invalid-feedback">
                                                <?=ERROR_TITLE_ENGLISH?>
                                               </div>
                                             </div>
                                       </div>

                                       <div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label>Description </label>
                                            <textarea class="tinymce" name="Description" required><?php echo clearTextForField($FetchData['Description'])?></textarea>
                                            <div class="invalid-feedback">
                                                <?=ERROR_DESCRIPTION_ENGLISH?>
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
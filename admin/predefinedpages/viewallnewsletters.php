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
                 <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=TXT_ADD_NEWSLETTER?></a>
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
								SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listingnewsletter&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
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
		$FetchData = FetchRecordByID($RecordID,"TableID","tblnewsletters");
	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}
	?>
    	<div class="hk-pg-header mb-0 headerboxdesign">
                <h4 class="hk-pg-title"  id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?> > <?=($RecordID > 0)?TXT_EDIT_NEWSLETTER:TXT_ADD_NEWSLETTER;?></h4>
            <div class="d-flex mb-0"> 
                <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>
         
    <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
    <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditNewsLetter')?>" />
    <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
    <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
    <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
    <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
    <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" />
    
    <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-row">
                                <div class="col-md-4 mb-10">
                                    <label ><?=TXT_TITLE?> <span>*</span></label>
                                    <input type="text" name="Title" class="form-control" value="<?=$FetchData['Title']?>"  required />
                                    <div class="invalid-feedback">
                                        <?=ERROR_TITLE?>
                                    </div>
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
                      		
                            <div class="form-row">
                                <div class="col-md-12 mb-12">
                                    <label><?=TXT_NEWSLETTER_CONTENT?></label> 
                        			<textarea class="tinymce" name="EmailContent" required><?php echo clearTextForField($FetchData['EmailContent'])?></textarea>
                                    <div class="invalid-feedback">
                                        <?=ERROR_NEWSLETTER_CONTENT?>
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
    <!-- /Container -->
</div>
       
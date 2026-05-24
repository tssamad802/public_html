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
                 <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=TXT_SCHEDULE_CAMPAIGN?></a>
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
								SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listingcampaigns&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
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
	$RemoveData = 1; 
	$FetchData['ReplyToEmail'] = $website_config['SMTPUserName']; 
	$FetchData['SenderName'] = $website_config['FromName']; 
	if($_REQUEST['RecordID'] > 0)
	{
		checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblnewslettercampaigns");
		$RemoveData = 0;
	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}
	?>
    	<div class="hk-pg-header mb-0 headerboxdesign">
                <h4 class="hk-pg-title"  id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?> > <?=($RecordID > 0)?TXT_EDIT_CAMPAIGN:TXT_ADD_CAMPAIGN;?></h4>
            <div class="d-flex mb-0"> 
                <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>
         
    <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
    <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
    <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditCampaign')?>" />
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
                            	<div class="card-header card-header-action tabdesignbox"><?=TXT_NEWSLETTER_DETAILS?></div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-10">
                                            <label ><?=TXT_TITLE?> <span>*</span></label>
                                            <input type="text" name="Title" class="form-control" value="<?=$FetchData['Title']?>"  required />
                                            <div class="invalid-feedback">
                                                <?=ERROR_TITLE?>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-10">
                                            <label><?=TXT_NEWSLETTER?> <span>*</span></label>
                                            <select name="NewsLetterID" class="form-control select2" required>
                                                <option value=""><?=TXT_SELECT_NEWSLETTER?></option>
                                                <?=fillcombocontrol($FetchData['NewsLetterID'],"TableID","Title","tblnewsletters where Active=1","Title")?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?=ERROR_SELECT_NEWSLETTER?>
                                            </div>  
                                        </div>
                                        
                                        <div class="col-md-4 mb-10">
                                            <label><?=TXT_CONTACT_CATEGORY?> <span>*</span></label>
                                            <select name="ContactCategoryID" class="form-control select2" required>
                                                <option value="" ><?=TXT_SELECT_CATEGORY?></option>
                                                <?=fillcombocontrol($FetchData['ContactCategoryID'],"TableID","Title","tblnewslettercontactcategory where Active=1","Sequence")?>
                                                 
                                            </select>
                                            <div class="invalid-feedback">
                                                <?=ERROR_SELECT_CATEGORY?>
                                            </div>  
                                        </div>
                                       
                                        
                            		</div>
                                 </div>
                             </div>
                             
                             <div class="card">
                            	<div class="card-header card-header-action tabdesignbox"><?=TXT_EMAIL_DETAILS?></div>
                                <div class="card-body">
                                    <div class="form-row">
                                    	<div class="col-md-12 mb-10">
                                            <label><?=TXT_EMAIL_SUBJECT?> <span>*</span></label>
                                            <input type="text" name="Subject" class="form-control" value="<?=$FetchData['Subject']?>"  required />
                                            <div class="invalid-feedback">
                                                <?=ERROR_EMAIL_SUBJECT?>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-12 mb-10">
                                            <label><?=TXT_REPLY_TO_EMAIL?> <span>*</span></label>
                                            <input type="email" name="ReplyToEmail" class="form-control" value="<?=$FetchData['ReplyToEmail']?>"  required />
                                            <div class="invalid-feedback">
                                                <?=ERROR_REPLY_TO_EMAIL?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 mb-10">
                                            <label><?=TXT_SENDER_NAME?> <span>*</span></label>
                                            <input type="text" name="SenderName" class="form-control" value="<?=$FetchData['SenderName']?>"  required />
                                            <div class="invalid-feedback">
                                                <?=ERROR_SENDER_NAME?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                             </div>   
                             
                            <div class="card">
                            	<div class="card-header card-header-action tabdesignbox"><?=TXT_CAMPAIGN_EXECUSION_SETTING?></div>
                                <div class="card-body">         
                                        <div class="form-row"> 
                                            
                                            
                                            <div class="col-md-4 mb-10">
                                                <label><?=TXT_NUMBER_OF_EMAIL_PER_HRS?><span>*</span></label>
                                                <select name="EveryHourEmail" class="form-control" required>
                                                    <option value=""><?=TXT_SELECT_EMAIL_COUNT?></option>
                                                    <?php
                                                        foreach($NumberOfEmailPerHrs  as $PerHrs)
                                                        {
                                                            $everyhrsselectedbox = ($FetchData['EveryHourEmail']==$PerHrs)?'selected="selected"':'';
                                                            echo '<option value="'.$PerHrs.'" '.$everyhrsselectedbox.'>'.$PerHrs.'</option>';
                                                        }
                                                    ?>
                                                </select> 
                                            </div>
                                             
                                          
                                        <div class="col-md-4 mb-10">
                                            <label><?=TXT_COMMENCEMENT_DATE?> <span>*</span></label>
                                            <input type="text" name="CampaignStartDate" class="form-control featuredate" value="<?=$FetchData['CampaignStartDate']?>"  required readonly="readonly" />
                                            <div class="invalid-feedback">
                                                <?=ERROR_COMMENCEMENT_DATE?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-10">
                                            <label><?=TXT_START_TIME?> <span>*</span></label>
                                            <select name="FromTime" id="FromTime" class="form-control" onchange="ChooseTime(this.value,1)" required>
                                                <option value=""><?=TXT_START_TIME?></option>
                                                <?php
                                                    foreach($Time  as $key => $TimeData)
                                                    {
                                                        $fromtimeselectedbox = ($FetchData['FromTime']==$key)?'selected="selected"':'';
                                                        echo '<option value="'.$key.'" '.$fromtimeselectedbox.'>'.$TimeData.'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?=ERROR_START_TIME?>
                                            </div>
                                        </div>
                                        
                                        
                                         
                                        
                                        <div class="col-md-4 mb-10">
                                            <label><?=TXT_END_TIME?> <span>*</span></label>
                                            <select name="ToTime" id="ToTime" class="form-control" onchange="ChooseTime(this.value,2)" required>
                                                <option value=""><?=TXT_END_TIME?></option>
                                                <?php
                                                    foreach($Time  as $key => $TimeData)
                                                    {
                                                        $totimeselectedbox = ($FetchData['ToTime']==$key)?'selected="selected"':'';
                                                        echo '<option value="'.$key.'" '.$totimeselectedbox.'>'.$TimeData.'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?=ERROR_END_TIME?>
                                            </div>
                                        </div>
                                         
                                           
                                        <div class="col-md-12 mb-10">
                                            <label><?=TXT_EXCEPTION_DAYS?> <span>*</span></label>
                                            <select name="ExceptionDays[]" class="form-control select2" multiple="multiple" >
                                                <?php
                                                    foreach($ExceptionEmail as $Days)
                                                    {
                                                        $expeselectedbox = (in_array($Days,explode(",",$FetchData['ExceptionDays'])))?'selected="selected"':'';
                                                        echo '<option value="'.$Days.'" '.$expeselectedbox.'>'.$Days.'</option>';
                                                    }
                                                ?>
                                            </select> 
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
    
<script>     
function ChooseTime(value,type)
{
	var ToTime = $("#ToTime option:selected").val();
	var FromTime = $("#FromTime option:selected" ).val();
	if(value > 0)
	{
		$.ajax({ 
			url: "ajax_functions.php?SetTime=ShowTime&Time="+value+"&Type="+type+"&ToTime="+ToTime+'&FromTime='+FromTime, 
			success:function(msg){ 
				if(type==1)
				$("#ToTime").html(msg);  
				if(type==2)
				$("#FromTime").html(msg);  
			}
	   });
	}
}

</script>
      
    <?php
}
?>        

    </div>
    <!-- /Container -->
</div>
       
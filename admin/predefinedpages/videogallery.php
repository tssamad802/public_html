<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
	die("Direct Access Not Allowed");
}
?>

<form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditVideo')?>" />
            <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
            <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
            <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
            <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" />
            <input type="hidden" name="ParentID" value="<?=encodeencriptstring($_REQUEST['ParentID'])?>" />
            <input type="hidden" name="TypeID" value="<?=encodeencriptstring($_REQUEST['TypeID'])?>" />  

            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=VIDEOS?></div>
                                    <div class="card-body">

                                        
                                        <div class="form-row"> 
                                              
                                        <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=TXT_VIDEO_TYPE?> <span>*</span></label> 
                                                <table cellpadding="10">
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 <?=TXT_MARGIN_LEFT?>">
                                                                <input id="Yes" name="VideoType" class="custom-control-input"  checked="checked"
                                                                type="radio" value="1" onclick="DataDisplay(1)">
                                                                <label class="custom-control-label" for="Yes"><?=TXT_YOUTUBE?></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 ml-20">
                                                                <input id="No" name="VideoType"
                                                                    class="custom-control-input" 
                                                                    type="radio" value="2"  onclick="DataDisplay(2)">
                                                                <label class="custom-control-label"
                                                                    for="No"><?=TXT_FILE_UPLOAD?></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>

											
                                            <div class="col-md-8 mb-10 youtube">
                                                <label ><?=TXT_YOUTUBE?>  <span>*</span></label>
                                                <input type="text" name="FileName" class="form-control" value="<?=$FetchData['Title']?>" dir="ltr"   /> 
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


<div class="row">
    <div class="col-xl-12">
        <section class="hk-sec-wrapper"> 
            <div class="row">
                <div class="col-sm">
                    <div class="card mt-20">
                        <div class="card-header card-header-action tabdesignbox"><?=TXT_VIDEO_GALLERY?></div>
                        <div class="card-body"> 
                            <div class="table-wrap" id="resultDiv">
                                <div class="norecordfound"><?=TXT_PLEASE_WAIT_DATA_LOAD?></div>			
                            </div>
                        </div>
                     </div>   
                    <script type="text/javascript"> 
                        SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listingvideogallery&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&TypeID=".$_REQUEST['TypeID']."&ParentID=".$_REQUEST['ParentID'])?>','searchfrm','resultDiv');
                    </script>    
                </div>
            </div>


        </section> 
    </div>
</div> 

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
</script>
 

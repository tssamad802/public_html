<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
	die("Direct Access Not Allowed");
}
?>

<div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper"> 
                <div class="row">
                    <div class="col-sm">
                        <form action="ajax_functions.php" class="dropzone" id="remove_link">
                            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditSystemImages')?>" />
                            <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
                            <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
                            <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
                            <input type="hidden" name="ParentID" value="<?=encodeencriptstring($_REQUEST['ParentID'])?>" />
                            <input type="hidden" name="TypeID" value="<?=encodeencriptstring($_REQUEST['TypeID'])?>" />  
                            <div class="fallback">
                                <input name="GalleryImages" type="file" multiple accept="image/x-png,image/jpg,image/jpeg" />
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
 </div>               


<div class="row">
    <div class="col-xl-12">
        <section class="hk-sec-wrapper"> 
            <div class="row">
                <div class="col-sm">
                    <div class="card mt-20">
                        <div class="card-header card-header-action tabdesignbox"><?=TXT_IMAGE_GALLERY?></div>
                        <div class="card-body"> 
                            <div class="table-wrap" id="resultDiv">
                                <div class="norecordfound"><?=TXT_PLEASE_WAIT_DATA_LOAD?></div>			
                            </div>
                        </div>
                     </div>   
                    <script type="text/javascript"> 
                        SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listinggallery&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&TypeID=".$_REQUEST['TypeID']."&ParentID=".$_REQUEST['ParentID'])?>','searchfrm','resultDiv');
                    </script>    
                </div>
            </div>


        </section> 
    </div>
</div> 
 
<script type="text/javascript">

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone", { 
       maxFilesize: 5, 
       acceptedFiles: "image/jpeg,image/png,image/jpg",
       init: function() {
            this.on('success', function(){
                if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                        location.reload();
                }
            });
        }
    }); 
</script>
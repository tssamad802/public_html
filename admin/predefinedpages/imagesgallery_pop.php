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
                    <div class="card mt-20">
                        <div class="card-header card-header-action tabdesignbox"><?=TXT_IMAGE_GALLERY?></div>
                        <div class="card-body"> 
                            <div class="table-wrap" id="resultDiv">
                                <div class="norecordfound"><?=TXT_PLEASE_WAIT_DATA_LOAD?></div>			
                            </div>
                        </div>
                     </div>   
                    <script type="text/javascript"> 
                        SimpleAjax('ajax_imagepop.php?<?=EncodeUrl("FireAction=listinggallery&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&TypeID=".$_REQUEST['TypeID']."&ParentID=".$_REQUEST['ParentID'])?>','searchfrm','resultDiv');
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
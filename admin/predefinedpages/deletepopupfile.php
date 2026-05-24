<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
	die("Direct Access Not Allowed");
}
?>
<div class="modal fade" id="DeletePopupBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true" style="z-index:9999;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width:100%">
            <div class="modal-header">
                <h5 class="modal-title">Delete Record</h5>
            </div>
            <div class="modal-body">
                <p class="content"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger deletebtn">Delete</button>
            </div>
        </div>
    </div>
</div>
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
<!--                            <div class="table-wrap" id="resultDiv">-->
<!--								<div class="norecordfound">--><?//=TXT_PLEASE_WAIT_DATA_LOAD?><!--</div>-->
<!--                            </div>-->
                            <center>
                                <div class="col-md-4">
                                    <select class="form-control custom-select select2" name="StoreID" id="StoreID" onchange="deeplinkGenerate()">
                                        <option>Select Stores</option>
                                        <?php
                                        echo fillcombocontrol(0,"TableID","name","tblstore where Active=1","Sequence");
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <span style="display: inline-block; font-weight: bold">Destination URL : </span>
                                    <input type="text" name="url" id="url" class="form-control" value="" style="display: inline-block"  onkeyup="deeplink()"/>
                                </div>
                                <div class="col-md-10">
                                    <span style="font-weight: bold">Deep Link URL : </span>
                                    <input type="text" name="trckinglink" id="trckinglink" class="form-control" value="" readonly />
                                    <br>
                                    <button onclick="copyText()" id="btn" class="btn btn-info">Copy DeepLink</button>
                                </div>
                            </center>
                        </div>
                    </div>
                </section>


            </div>
        </div>
        <!-- /Row -->


        <!-- Modal HTML -->

        <div class="modal fade" id="show_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true" style="z-index:9999">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" id="SetData" style="width:100%; padding:10px;">

                </div>
            </div>
        </div>


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
		$FetchData = FetchRecordByID($RecordID,"TableID","tblsportscomplex");
	}
	else
	{
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
	}
	?>


        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?>
                (<?=TXT_UPDATE_SPORT_COMPLEX;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditSportsComplex')?>" />
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

                                        	<div class="table-responsive">
                                                <table class="table table-info table-bordered mb-0">
                                                    <thead class="thead-info">
                                                        <tr>
                                                            <th width="200"><?=TXT_REQUEST_NO?></th>
                                                            <td scope="row"><?=$FetchData['RequestNo']?></td>
                                                            <th width="200"><?=TXT_NAME?></th>
                                                            <td scope="row"><?=$FetchData['FullName']?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?=TXT_GENDER?></th>
                                                            <td scope="row"><?=($FetchData['Gender']==1)?TXT_MALE:TXT_FEMALE?></td>
                                                            <th><?=TXT_EMAIL?></th>
                                                            <td scope="row"><?=$FetchData['Email']?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?=TXT_MOBILE?></th>
                                                            <td scope="row"><?=$FetchData['MobileNo']?></td>
                                                            <th><?=TXT_NATIONALITY?></th>
                                                            <td scope="row"><?=getFieldDataByID("Nationality".LANG_SEP_DB,"TableID",$FetchData['NationalityID'],"tblcountries")?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?=TXT_STATUS?></th>
                                                            <td scope="row"><?=$FetchData['Status']==0?'-':getFieldDataByID("Title".LANG_SEP_DB,"TableID",$FetchData['Status'],"tblsportcomplexstatus")?></td>
                                                            <th><?=TXT_SUBMIT_DATETIME?></th>
                                                            <td scope="row"><?=onlydatetimeformat($FetchData['CreatedDateTime'])?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?=TXT_MESSAGE?></th>
                                                            <td scope="row" colspan="3"><?=$FetchData['Message']?></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                        </div>


                                    </div>
                                </div>

                                <?php
									$sql="select A.*,B.FullName".LANG_SEP_DB." as Name, C.Title".LANG_SEP_DB." as StatusName  from  tblsportcomplexremarks A  
									inner join  tblsystemusers B on B.TableID=A.CreatedBy 
									inner join  tblsportcomplexstatus C on C.TableID=A.StatusID
									where RequestID='".$RecordID."' order by A.TableID DESC";
									$db->query($sql);
									if($db->num_rows() > 0)
									{
										?>
                                        <div class="card">
                                        	<div class="card-header card-header-action tabdesignbox"><?=TXT_VIEW_REMARKS?></div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                	<div class="table-responsive">
                                                        <table class="table table-info table-bordered mb-0">
                                                            <thead class="thead-info">
                                                                <tr>
                                                                    <th width="10"><?=SNO?></th>
                                                                    <th><?=TXT_REMARKS?></th>
                                                                    <th><?=TXT_STATUS?></th>
                                                                    <th><?=TXT_SUBMIT_BY?></th>
                                                                    <th><?=TXT_SUBMIT_DATETIME?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            	<?php
																while($db->next_Record())
																{
																	$RecordCount++;
																	?>
                                                                    <tr>
                                                                        <td align="center"><?=$RecordCount?></td>
                                                                        <td><?=clearTextForFieldTextarea($db->f('Remarks'))?></td>
                                                                        <td><?=$db->f('StatusName')?></td>
                                                                        <td><?=$db->f('Name')?></td>
                                                                        <td><?=onlydatetimeformat($db->f('CreatedDateTime'))?></td>
                                                                    </tr>
                                                                    <?php
																}
																?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
									}
								?>



                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_SUBMIT_REMARKS?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="col-md-6 mb-12">
                                                <label><?=TXT_REMARKS?> <span>*</span></label>
                                                <textarea name="Remarks"  class="form-control" rows="3" required></textarea>
                                                <div class="invalid-feedback">
                                                   <?=ERROR_REMARKS?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-12">
                                                <label><?=TXT_STATUS?> <span>*</span></label>
                                                <select name="StatusID" class="form-control" required>
                                                	<option value=""><?=TXT_SELECT_STATUS?></option>
                                                    <?php
													echo fillcombocontrol("","TableID","Title".LANG_SEP_DB,"tblsportcomplexstatus where Active=1","Sequence");
													?>
                                                </select>
                                                <div class="invalid-feedback">
                                                   <?=ERROR_SELECT_STATUS?>
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
<script>
    let url = "";
    const deeplinkGenerate = () => {
        let storeID = $("#StoreID").val();
        $.post("ajax/ajax_deep_link.php" , {storeID : storeID} , function (data) {
            // data = eval('(function(){return'+data+';})()');
            // let myJson = JSON.stringify(data);
            let myJson = JSON.parse(data);
            console.log(myJson);
            // $('#trckinglink').val(myJson[0]);
            $('#trckinglink').val(myJson[0]+myJson[1]);
            url = $('#trckinglink').val();
        })
    }

    const deeplink = () => {
        $('#trckinglink').val(url+$('#url').val());
    }

    const copyText = () => {
        const input = document.getElementById("trckinglink");
        const btn = document.getElementById("btn");
        input.select();
        document.execCommand("copy");
        btn.innerHTML = "Copied!";
    }
</script>
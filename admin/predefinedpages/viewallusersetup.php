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
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=ADD_SYSTEMUSER?></a>
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
								SimpleAjax('ajax_system_user.php?<?=EncodeUrl("FireAction=listing&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
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
	$FetchData['PerPageRecord'] = 500;
	$RecordID = 0;
	if(isset($_REQUEST['RecordID']))
	{
		checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblsystemusers");
	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}
	?>


        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?>
                (<?=($RecordID > 0)?EDIT_SYSTEMUSER:ADD_SYSTEMUSER;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditSystemUser')?>" />
            <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
            <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
            <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
            <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" />
            <input type="hidden" name="PasswordStrength" id="PasswordStrength" value="" />

            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_PERSONALINFO?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=TXT_ROLE?><span>*</span></label>
                                                <select name="RoleID" class="form-control custom-select" required>
                                                    <option value=""><?=SELECT_ROLE?></option>
                                                    <?=fillcombocontrol($FetchData['RoleID'],"TableID","RoleName","tblroles Where Active='".ACTIVE."'","RoleName")?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?=SELECT_ROLE_ER?>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=TXT_NAME?> <span>*</span></label>
                                                <input type="text" name="FullName"
                                                    value="<?=($RecordID > 0)?$FetchData['FullName']:'';?>" required
                                                    class="form-control" />
                                                <div class="invalid-feedback">
                                                    <?=TXT_NAME_ER?>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=TXT_EMAIL?> <span>*</span></label>
                                                <input type="email" name="Email"
                                                    value="<?=($RecordID > 0)?$FetchData['Email']:'';?>" required
                                                    class="form-control" />
                                                <div class="invalid-feedback">
                                                    <?=TXT_EMAIL_ER?>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=TXT_MOBILE?></label>
                                                <input type="text" name="MobileNo" onpaste="return false"
                                                    value="<?=($RecordID > 0)?$FetchData['MobileNo']:'';?>"
                                                    class="form-control"
                                                    onkeypress="return numberswithdescimal(event, false)" />
                                                <div class="invalid-feedback">
                                                    <?=TXT_MOBILE_ER?>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=TXT_ACTIVE_USER?> <span>*</span></label>

                                                <table cellpadding="10">
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 ml-20">
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

                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_LOFIN_CRED?></div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=TXT_USERNAME?> <span>*</span></label>
                                                <input type="text" name="UserName"
                                                    value="<?=($RecordID > 0)?$FetchData['UserName']:'';?>"
                                                    class="form-control" <?=($RecordID > 0)?'readonly="readonly"':'';?>
                                                    <?=($RecordID > 0)?'':'required';?>
                                                    onblur="CheckAvailable(this.value)" />
                                                <div id="username"></div>
                                                <div class="invalid-feedback">
                                                    <?=TXT_USERNAME_ER?>
                                                </div>

                                            </div>

                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=PASSWORD?> <span>*</span></label>
                                                <input type="password" name="Password" value="" class="form-control"
                                                    id="password" <?=($RecordID > 0)?'':'required';?> />
                                                <div class="invalid-feedback">
                                                    <?=ENTER_PASSWORD?>
                                                </div>
                                                <div class="progress" style="display:none;">
                                                    <div class="progress-bar-danger" id="passwordprogressbar">
                                                        <span id="result" class="short"><?=TXT_SHORT?></span>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <label><?=CONFIRM_PSWD?> <span>*</span></label>
                                                <input type="password" name="CPassword" value="" class="form-control"
                                                    id="CPassword" <?=($RecordID > 0)?'':'required';?> />
                                                <div class="invalid-feedback">
                                                    <?=TXT_PSWD_CONFIRMER?>
                                                </div>
                                                <div id="passwordnotmatch"></div>
                                            </div>


                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-4 mb-10 formtitleAr">
                                                <div class="custom-control custom-checkbox  mt-20">
                                                    <input class="custom-control-input" id="SendEmail" type="checkbox"
                                                        name="SendEmail" value="1">
                                                    <label class="custom-control-label"
                                                        for="SendEmail"><?=TXT_SEND_CRED?></label>
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
        function CheckAvailable(values) {
            jQuery.ajax({
                type: "GET",
                url: "ajax_functions.php?ActionFlag=CheckUserName&Username=" + values,
                cache: false,
                success: function(data) {
                    $('#username').html(data);
                }
            });
        }
        </script>

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
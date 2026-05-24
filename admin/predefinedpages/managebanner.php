<?php

$dataobject['Active'] = ACTIVE;
$Brief_Description_Character_Left_ENGLISH=SLIDER_BRIEF_DESCRIPTION_ENGLISH;
$Brief_Description_Character_Left_ARABIC=SLIDER_BRIEF_DESCRIPTION_ARABIC;

if(count($_POST) > 0)
{
	$dataobject = $_REQUEST;
}
else if ($_REQUEST['trigger']=='edit')
{
	$dataobject = FetchRecordByID($_REQUEST['RecordID'],'TableID','tblbanners');
	$Brief_Description_Character_Left_ENGLISH=SLIDER_BRIEF_DESCRIPTION_ENGLISH-strlen($dataobject['BriefDescription']);
	$Brief_Description_Character_Left_ARABIC=SLIDER_BRIEF_DESCRIPTION_ARABIC-strlen($dataobject['BriefDescriptionAr']);
}
?>
<!-- page title and buttons -->
<h1 class="fleft"><?php PrintTitle($_REQUEST['action'],$db)?></h1>
<a class="btn-addnew fright" href="home.php?<?php echo EncodeUrl("action=viewallbanners");?>">Go Back</a>
<div class="clearfix"></div>
<!-- page title and buttons -->
<!-- data -->
<div class="data-listing FormBox">
    <form name="formobject" method="post" onSubmit="return ValidateBanners();" enctype="multipart/form-data">
        <input type="hidden" name="ValidateBannerflag">
        <input type="hidden" name="TableID" id="TableID" value="<?php echo $dataobject['TableID'];?>" />
        <input type="hidden" name="OldFileName" value="<?php echo $dataobject['FileName'];?>" />
        <input type="hidden" name="OldFileNameC" value="<?php echo $dataobject['FileNameC'];?>" />
        <input type="hidden" name="OldFileNameAr" value="<?php echo $dataobject['FileNameAr'];?>" />
        <input type="hidden" name="OldFileNameCAr" value="<?php echo $dataobject['FileNameCAr'];?>" />

        <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
            <tr>
                <td width="12%" valign="top"><strong>Category</strong> <span class="Mandatory">*</span></td>
                <td valign="top">
                    <?php if($dataobject['CategoryID'] > 0){?>
                    <input type="hidden" name="CategoryID" value="<?php echo $dataobject['CategoryID'];?>" />
                    <?php }?>
                    <select name="CategoryID" class="DropDown" onchange="ShowHideLinkSize(this)"
                        <?php if($dataobject['CategoryID'] > 0){?> disabled="disabled" <?php }?>>
                        <option value="-1">Select Category</option>
                        <?php
				foreach($BannersCatAr as $key => $row)
				{
				?>
                        <option filedimetion="<?php echo $row['IconW'];?>px x <?php echo $row['IconH'];?>px"
                            value="<?php echo $key;?>" <?php if($dataobject['CategoryID']==$key){?> selected="selected"
                            <?php }?>><?php echo $row['Title'];?></option>
                        <?php
				}
				?>
                    </select>
                    <?php if($ErrorFields['CategoryID'] != ''){?>
                    <span class="errorbox"><?php echo $ErrorFields['CategoryID'];?></span>
                    <?php }?>
                </td>

                <td valign="top"><strong>URL</strong></td>
                <td valign="top">
                    <input value="<?php echo clearTextForField($dataobject['URL']);?>" type="text" name="URL"
                        class="TextField">
                    <?php if($ErrorFields['URL'] != ''){?>
                    <span class="errorbox"><?php echo $ErrorFields['URL'];?></span>
                    <?php }?>
                </td>
                <td valign="top"><strong>URL (Arabic)</strong></td>
                <td valign="top">
                    <input value="<?php echo clearTextForField($dataobject['URLAr']);?>" type="text" name="URLAr"
                        class="TextField">
                    <?php if($ErrorFields['URLAr'] != ''){?>
                    <span class="errorbox"><?php echo $ErrorFields['URLAr'];?></span>
                    <?php }?>
                </td>
            </tr>

            <tr>
                <td valign="top"><strong>Status</strong> <span class="Mandatory">*</span></td>
                <td valign="top">
                    <select name="Active" class="DropDown">
                        <option value="-1">Select Status</option>
                        <option value="<?=ACTIVE?>" <?php if($dataobject['Active']==ACTIVE){?> selected="selected"
                            <?php }?>>Active</option>
                        <option value="<?=INACTIVE?>" <?php if($dataobject['Active']==INACTIVE){?> selected="selected"
                            <?php }?>>InActive</option>
                    </select>
                    <?php if($ErrorFields['Active'] != ''){?>
                    <span class="errorbox"><?php echo $ErrorFields['Active'];?></span>
                    <?php }?>
                </td>
                <td valign="top"><strong>Text Color</strong> <span class="Mandatory">*</span></td>
                <td valign="top">
                    <select name="TextColor" class="DropDown">
                        <option value="-1">Text Color</option>
                        <option value="1" <?php if($dataobject['TextColor']==1){?> selected="selected" <?php }?>>White
                        </option>
                        <option value="2" <?php if($dataobject['TextColor']==2){?> selected="selected" <?php }?>>Black
                        </option>
                    </select>
                    <?php if($ErrorFields['TextColor'] != ''){?>
                    <span class="errorbox"><?php echo $ErrorFields['TextColor'];?></span>
                    <?php }?>
                </td>
            </tr>

            <!--      <tr class="Category_1"--><?php //if($dataobject['CategoryID'] != 1){?>
            <!-- style="display:none"--><?php //}?>
            <!--      	<td valign="top"><strong>Banner (English)</strong> <span class="Mandatory">*</span></td>-->
            <!--        <td valign="top">-->
            <!--        	<input type="file" name="FileName" />-->
            <!--            --><?php //if($ErrorFields['FileName'] != ''){?>
            <!--            <span class="errorbox">--><?php //echo $ErrorFields['FileName'];?>
            <!--</span>-->
            <!--            --><?php //}?>
            <!--        </td>-->
            <!--        -->
            <!--        <td valign="top"><strong>Banner (Arabic)</strong> <span class="Mandatory">*</span></td>-->
            <!--        <td valign="top">-->
            <!--        	<input type="file" name="FileNameAr" />-->
            <!--            --><?php //if($ErrorFields['FileNameAr'] != ''){?>
            <!--            <span class="errorbox">--><?php //echo $ErrorFields['FileNameAr'];?>
            <!--</span>-->
            <!--            --><?php //}?>
            <!--        </td>-->
            <!--        <td valign="top">-->
            <!--        	<strong>(png, jpg & gif only)</strong><br /><span id="linksize">--><?php //echo $BannersCatAr[$dataobject['CategoryID']]['IconW'].'px x '.$BannersCatAr[$dataobject['CategoryID']]['IconH'].'px';?>
            <!--</span>-->
            <!--        </td>-->
            <!--      </tr>-->

            <!--	  <tr class="Category_2"--><?php //if($dataobject['CategoryID'] != 2){?>
            <!-- style="display:none"--><?php //}?>
            <!--      	<td valign="top"><strong>Certificate (English)</strong> <span class="Mandatory">*</span></td>-->
            <!--        <td valign="top">-->
            <!--        	<input type="file" name="FileNameC" />-->
            <!--            --><?php //if($ErrorFields['FileNameC'] != ''){?>
            <!--            <span class="errorbox">--><?php //echo $ErrorFields['FileNameC'];?>
            <!--</span>-->
            <!--            --><?php //}?>
            <!--        </td>-->
            <!--        -->
            <!--        <td valign="top"><strong>Certificate (Arabic)</strong> <span class="Mandatory">*</span></td>-->
            <!--        <td valign="top">-->
            <!--        	<input type="file" name="FileNameCAr" />-->
            <!--            --><?php //if($ErrorFields['FileNameCAr'] != ''){?>
            <!--            <span class="errorbox">--><?php //echo $ErrorFields['FileNameCAr'];?>
            <!--</span>-->
            <!--            --><?php //}?>
            <!--        </td>-->
            <!--        <td valign="top">-->
            <!--        	<strong>(png, jpg & gif only)</strong><br /><span id="linksize">--><?php //echo $BannersCatAr[2]['IconW'].'px x '.$BannersCatAr[2]['IconH'].'px';?>
            <!--</span>-->
            <!--        </td>-->
            <!--      </tr>-->

            </tr>
            <tr class="Category_1" <?php if($dataobject['CategoryID'] != 1){?> style="display:none" <?php }?>>
                <td valign="top"><strong>Heading (English)</strong> </td>
                <td valign="top">
                    <input value="<?php echo clearTextForField($dataobject['Heading1']);?>" type="text" name="Heading1"
                        class="TextField">
                </td>
                <td valign="top"><strong>Heading (Arabic)</strong> </td>
                <td valign="top">
                    <input value="<?php echo clearTextForField($dataobject['Heading1Ar']);?>" type="text"
                        name="Heading1Ar" class="TextField">
                </td>

            </tr>


            <tr class="Category_1" <?php if($dataobject['CategoryID'] != 1){?> style="display:none" <?php }?>>
                <td valign="top"><strong>Brief Description (English)</strong></td>
                <td colspan="6">
                    <textarea name="BriefDescription" style="width:93%;" rows="5" class=""
                        onkeyup="limiter(<?= SLIDER_BRIEF_DESCRIPTION_ENGLISH ?>, this, 'RemainingCount');"><?php echo clearTextForField($dataobject['BriefDescription'])?></textarea>
                    <br />
                    <span id="RemainingCount">
                        <?= $Brief_Description_Character_Left_ENGLISH ?>
                    </span> characters left
                    <?php if($ErrorFields['BriefDescription'] != ''){?>
                    <span class="errorbox"><?php echo $ErrorFields['BriefDescription'];?></span>
                    <?php }?>
                </td>
            </tr>

            <tr class="Category_1" <?php if($dataobject['CategoryID'] != 1){?> style="display:none" <?php }?>>
                <td valign="top"><strong>Brief Description (Arabic)</strong></td>
                <td colspan="6">
                    <textarea name="BriefDescriptionAr" style="width:93%;" rows="5" class=""
                        onkeyup="limiter(<?= SLIDER_BRIEF_DESCRIPTION_ARABIC ?>, this, 'RemainingCount1');"><?php echo clearTextForField($dataobject['BriefDescriptionAr'])?></textarea>
                    <br />
                    <span id="RemainingCount1">
                        <?= $Brief_Description_Character_Left_ARABIC ?>
                    </span> characters left
                    <?php if($ErrorFields['BriefDescriptionAr'] != ''){?>
                    <span class="errorbox"><?php echo $ErrorFields['BriefDescriptionAr'];?></span>
                    <?php }?>
                </td>
            </tr>


            <tr>
                <td></td>
                <td align="left" colspan="10">
                    <input class="formElementButton" type="reset" name="Reset" value="Reset">
                    <input class="formElementButton" type="Submit" name="Save" value="Submit">
                </td>
            </tr>
        </table>
    </form>
</div>
<script language="javascript">
function ShowHideLinkSize(val) {

    var sObj = $(val);
    var obj = $('#linksize');
    obj.html('');

    var element = $(val).find('option:selected');

    var val = sObj.attr("value");

    $('.Category_1').hide();
    $('.Category_2').hide();
    $('.Category_' + val).show();

    if (val == '-1' || val == '') {} else {
        var dimension = element.attr('filedimetion');
        obj.html(dimension);
    }
}

<
?
php
if ($dataobject['ShortLinkType'] > 0) {
    ?
    >
    ShowHideFileAttr( < ? php echo $dataobject['ShortLinkType']; ? > ); <
    ?
    php
} ? >
</script>
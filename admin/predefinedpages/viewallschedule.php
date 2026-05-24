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

        <div id="displaysearch" style="display: none">
        <div class="hk-pg-header mb-0 headerboxdesign">
                    <h4 class="hk-pg-title" id="titleheading">Search</h4>
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form name="searchfrm" id="searchfrm" enctype="multipart/form-data" method="post" onsubmit="return SimpleAjax('ajax_schedule.php?<?=EncodeUrl("FireAction=listing&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv')" >
                                <div class="form-row">
                                    <div class="col-md-6 mb-10">
                                        <label > Product Name  <span>*</span></label>
                                        <input type="text" name="ProductName" class="form-control" value=""  />
                                    </div>

                                    <div class="col-md-6 mb-10">
                                        <label >Store Name<span>*</span></label>
                                        <select class="form-control custom-select select2" name="StoreID">
                                            <option>All</option>
                                            <?php
                                            echo fillcombocontrol(0,"TableID","name","tblstore","Sequence");
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-10">
                                        <label > Product Url  <span>*</span></label>
                                        <input type="text" name="url" class="form-control"  />
                                    </div>

                                    <div class="col-md-6 mb-10">
                                        <label >Discount<span>*</span></label>
                                        <input type="text" name="discount" class="form-control" value=""  />
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-10">
                                        <label > Inital Date  <span>*</span></label>
                                        <input type="text" name="startDate" class="form-control" value=""  />
                                    </div>

                                    <div class="col-md-6 mb-10">
                                        <label >Expire Date<span>*</span></label>
                                        <input type="text" name="endDate" class="form-control" value=""  />
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-10">
                                        <label >Add By<span>*</span></label>
                                        <select class="form-control custom-select select2" name="CreatedBy">
                                            <option>All</option>
                                            <?php
                                            echo fillcombocontrol(0,"TableID","FullName","tblsystemusers ","TableID");
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-10">
                                        <label >Updated By<span>*</span></label>
                                        <select class="form-control custom-select select2" name="ModifiedBy">
                                            <option>All</option>
                                            <?php
                                            echo fillcombocontrol(0,"TableID","FullName","tblsystemusers ","TableID");
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-10">
                                        <label >Status<span>*</span></label> <br>
                                        <div class="form-control">
                                            <span>Enable</span>
                                            <input type="radio" name="active"  value="1"  />
                                            <span>Disable</span>
                                            <input type="radio" name="active"  value="2" />
                                            <span>Delete</span>
                                            <input type="radio" name="active"  value="0"  />
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-10">
                                        <label>Feature</label>
                                        <div class="form-control">
                                            <span>Yes</span>
                                            <input type="radio" name="feature"  value="1"  />
                                            <span>No</span>
                                            <input type="radio" name="feature"  value="0"  />
                                        </div>
                                    </div>

                                </div>

                                <div class="formbuttonrightside">
                                    <button class="btn btn-danger" type="reset"><?=RESET?></button>
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>






                            </form>
                        </div>
                    </div>
                </section>


            </div>
        </div>
    </div>
    <!-- /Row -->


    <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?></h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm" href="javascript:;" onclick="$('#displaysearch').slideToggle();">Search</a>
                &nbsp;&nbsp;
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>"><?=TXT_ADD_PRODUCT?></a>
            </div>
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a href="#" onclick="download_table_as_csv('datable_1');">Download as CSV</a>
                            <div class="table-wrap" id="resultDiv">
								<div class="norecordfound"><?=TXT_PLEASE_WAIT_DATA_LOAD?></div>
                            </div>
                            <script type="text/javascript">
								SimpleAjax('ajax_schedule.php?<?=EncodeUrl("FireAction=listing&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
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
	$Brief_Description_English=BRIEF_DESCRIPTION_LENGTH_ENGLISH;
	$Brief_Description_Arabic=BRIEF_DESCRIPTION_LENGTH_ARABIC;
	$RemoveData = 1;
	if(isset($_REQUEST['RecordID']))
	{
		$RemoveData = 0;
		checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblproduct");
		$Brief_Description_English=BRIEF_DESCRIPTION_LENGTH_ENGLISH-strlen(clearTextForField($FetchData['BriefDescription']));
		$Brief_Description_Arabic=BRIEF_DESCRIPTION_LENGTH_ARABIC-strlen(clearTextForField($FetchData['BriefDescriptionAr']));
	}
	else
	{ 
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']); 
	}
	$selectedtype = ($_REQUEST['Trigger'] == 'edit')?$FetchData['ParentID']:0;
	?>


        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?>
                (<?=($RecordID > 0)?TXT_EDIT_PRODUCT:TXT_ADD_PRODUCT;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm"
                    href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditSchedule')?>" />
            <input type="hidden" name="Trigger" value="<?=encodeencriptstring($_REQUEST['Trigger'])?>" />
            <input type="hidden" name="actionpage" value="<?=encodeencriptstring($_REQUEST['action'])?>" />
            <input type="hidden" name="SubLinkID" value="<?=encodeencriptstring($_REQUEST['SubLinkID'])?>" />
            <input type="hidden" name="RecordID" value="<?=encodeencriptstring($RecordID)?>" />
            <input type="hidden" name="ActionAjax" id="ActionAjax" value="<?=encodeencriptstring('GetPopItems')?>" />
            <input type="hidden" name="PasswordStrength" id="PasswordStrength" value="" />

            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_ANNOUNCEMENT_INFORMATION?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Store Name<span>*</span></label>
                                                <select class="form-control custom-select select2" name="StoreID" id="StoreID" onchange="getStoreDomain()">
                                                    <option>Select Name</option>
                                                    <?php
                                                    echo fillcombocontrol($FetchData['StoreID'],"TableID","name","tblstore","Sequence");
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label > Product Name  <span>*</span></label>
                                                <input type="text" name="ProductName" id="ProductName" onkeyup="<?=($FetchData['ProductName']!='') ? '' : 'BuildURL()'?>" class="form-control" value="<?=$FetchData['ProductName']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label >Product URL </label>
                                                <input type="url" name="url" id="url" class="form-control" value="<?=$FetchData['url']?>" dir="ltl"  readonly/>
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Product Tracking Url<span>*</span></label>
                                                <input type="url" name="trackingLink" class="form-control" value="<?=$FetchData['trackingLink']?>" required />
                                            </div>
                                        </div>


                                        <div class="form-row">

                                            <div class="col-md-6 mb-10">
                                                <label>Product Landing Url <span>*</span></label>
                                                <input type="url" name="landingLink"  class="form-control" value="<?=$FetchData['landingLink']?>"  required />
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label>Product Classification</label>
                                                <select id="couponClassification" name="ProductClassification" class="form-control" onchange="showProductCode();">
                                                    <option value="code" >Code</option>
                                                    <option value="offer" >Offer</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row" id="couponCode">
                                            <div class="col-md-6 mb-10">
                                                <label> Product Code  <span>*</span></label>
                                                <input type="text" name="productCode"  class="form-control" value="<?=$FetchData['productCode']?>" dir="ltl" required  id="couponCodeAttr"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-10 formtitleAr">
                                                <label>Product Status <span>*</span></label>
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
                                            <div class="col-md-3 mb-10 formtitleAr">
                                                <label>Product Cut-Price <span>*</span></label>
                                                <table cellpadding="10">
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8  <?=TXT_MARGIN_LEFT?>">
                                                                <input id="Yes2" name="CutPrice"
                                                                       class="custom-control-input"
                                                                    <?=($FetchData['CutPrice']==1)?'checked="checked"':''?>
                                                                       type="radio" value="1">
                                                                <label class="custom-control-label"
                                                                       for="Yes2"><?=TXT_YES?></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 ml-20">
                                                                <input id="No2" name="CutPrice"
                                                                       class="custom-control-input"
                                                                    <?=($FetchData['CutPrice']==0)?'checked="checked"':''?>
                                                                       type="radio" value="0">
                                                                <label class="custom-control-label"
                                                                       for="No2"><?=TXT_NO?></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-row">

                                            <div class="col-md-6 mb-10">
                                                <label >Product Logo</label>
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><?=TXT_UPLOAD?></span>
                                                        </div>
                                                        <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                        <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span>
                                                        <input type="file" name="logo"    />
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?=TXT_REMOVE?></a>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div >
                                                    <div class="image_file_preview1 image_file_preview_result">
                                                        <img src="" />
                                                        <input type="hidden" name="ImageCropData1" />
                                                    </div>
                                                    <?php
                                                    if($FetchData['logo']!='')
                                                        echo GallaryImageHtml('../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/'.$FetchData['logo']);
                                                    ?>
                                                </div>
                                            </div>


                                            <div class="col-md-6 mb-10 mt-30">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="ShowHome" id="ShowHome" <?=($FetchData['ShowHome']==1)?'checked=""':''?> value="1" />
                                                    <label class="custom-control-label" for="ShowHome"><?=TXT_SHOW_HOME_PAGE?></label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Product Category</label>
                                                <select name="CategoryID[]" class="form-control select2"  multiple="multiple" >
                                                    <?php
                                                    $sql="select A.TableID,A.Title,B.Title as ParentName  from tblcategory A 
                                                          left join tblcategory B on B.TableID=A.ParentID
                                                            where A.Active=1 order by A.Sequence ";
                                                    $db->query($sql);
                                                    while($db->next_Record())
                                                    {
                                                        $CategoryArray = explode(",",$FetchData['CategoryID']);
                                                        $OptionData = ($db->f('ParentName')=="")?$db->f('Title'):$db->f('ParentName').' -> '.$db->f('Title');
                                                        $seletedtvalue = (in_array($db->f('TableID'),$CategoryArray))?'selected':'';

                                                        ?>
                                                        <option value="<?=$db->f('TableID')?>" <?=$seletedtvalue?> > <?=$OptionData?></option>
                                                        <?php
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label >Product Type <span>*</span></label>
                                                <select name="ProductTypeID[]" class="form-control select2" multiple="multiple" >
                                                    <?php
                                                    $sql="select *  from tblcoupontype where 1 order by Sequence ";
                                                    $db->query($sql);
                                                    while($db->next_Record())
                                                    {
                                                        $CategoryArray = explode(",",$FetchData['ProductTypeID']);
                                                        $OptionData = $db->f('Title');
                                                        $seletedtvalue = (in_array($db->f('TableID'),$CategoryArray))?'selected':'';

                                                        ?>
                                                        <option value="<?=$db->f('TableID')?>" <?=$seletedtvalue?> > <?=$OptionData?></option>
                                                        <?php
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Product Sitewide <span>*</span></label>
                                                <select class="form-control custom-select select2" name="sitewide" id="sitewide">
                                                    <option value="">Select</option>
                                                    <option value="featured">Featured</option>
                                                    <option value="sitewide">Sitewide</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Discount </label>
                                                <input type="text" name="discount" class="form-control" value="<?=$FetchData['discount']?>"  />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Product Tag <span>*</span></label>
                                                <select class="form-control custom-select select2" name="ProductTagID">
                                                    <option>Select Tag</option>
                                                    <?php
                                                    echo fillcombocontrol($FetchData['ProductTagID'],"TableID","Title","tblcoupontag where Active=1","Sequence");
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Country<span>*</span></label>
                                                <select name="CountryID" class="form-control custom-select select2" required>
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    echo fillcombocontrol($FetchData['CountryID'],"TableID","Title","tblcountry where Active=1","Sequence");
                                                    ?>
                                                </select>

                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Start Date <span>*</span></label>
                                                <input type="text" name="startDate" class="form-control singleDatePicker" value="<?=($FetchData['startDate']=="0000-00-00")?'':$FetchData['startDate']?>" readonly="readonly"  required />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_ANNOUNCEMENT_DATE?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label >Expire Date <span>*</span></label>
                                                <input type="text" name="endDate" class="form-control singleDatePicker" value="<?=($FetchData['endDate']=="0000-00-00")?'':$FetchData['endDate']?>" readonly="readonly"  required />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_ANNOUNCEMENT_DATE?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Up Votes<span>*</span></label>
                                                <input type="text" name="upVotes" class="form-control" value="<?=$FetchData['upVotes']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label >Down Votes  <span>*</span></label>
                                                <input type="text" name="downVotes" class="form-control" value="<?=$FetchData['downVotes']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label >Old Price <span>*</span></label>
                                                <input type="text" name="OldPrice" class="form-control" value="<?=$FetchData['OldPrice']?>"  />
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >New Price<span>*</span></label>
                                                <input type="text" name="NewPrice" class="form-control" value="<?=$FetchData['NewPrice']?>" dir="ltr"   />
                                            </div>
                                        </div>



                                        <div class="form-row">
                                            <div class="col-md-12 mb-12">
                                                <label>Product Description </label>
                                                <textarea class="tinymce" name="description" required><?php echo clearTextForField($FetchData['description'])?></textarea>
                                                <div class="invalid-feedback">
                                                    <?=ERROR_DESCRIPTION_ENGLISH?>
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                </div>
            </div>


            <div class="card">
                <div class="card-header card-header-action tabdesignbox"><?=TXT_SEO?></div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-12 mb-10">
                            <label><?=TXT_PAGE_URL?></label>
                            <?php if($RecordID > 0) { ?>
                                <input type="text" name="URLKeyword" id="URLKeyword"  value="<?=$FetchData['URLKeyword']?>" readonly class="form-control" />
                                <div class="invalid-feedback">
                                    <?=ERROR_PAGE_URL?>
                                </div>
                            <?php } else { ?>
                                <p><?=TXT_SEO_LINK_GENERATE?></p>
                            <?php } ?>
                        </div>

                    </div>



                    <div class="form-row">
                        <div class="col-md-6 mb-12">
                            <label><?=TXT_META_ENGLISH?></label>
                            <input type="text" name="MetaTitle" dir="ltr" value="<?=$FetchData['MetaTitle']?>"  class="form-control" />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-12">
                            <label><?=TXT_META_DESCRIPTION_ENGLISH?></label>
                            <textarea  name="MetaDescription" dir="ltr" class="form-control" rows="3"><?=clearTextForField($FetchData['MetaDescription'])?></textarea>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-12">
                            <label><?=TXT_META_KEYWORD_ENGLISH?></label>
                            <textarea  name="MetaKeywords" dir="ltr" class="form-control" rows="3"><?=clearTextForField($FetchData['MetaKeywords'])?></textarea>
                        </div>
                    </div>

                    <div class="formbuttonrightside">
                        <button class="btn btn-danger" type="reset"><?=RESET?></button>
                        <button class="btn btn-primary" type="submit"><?=SUBMIT?></button>
                    </div>


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
         
        <div class="modal fade" id="uploadimageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"   style="z-index: 9999;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="width:100%"> 
                <div class="modal-header">
                        <h5 class="modal-title">Crop & Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>  
                			<div style="position:relative; width:100%; height:100%">
                        		<div id="image_demo" style="width:100%;"></div> 
                       		</div> 
                       <button class="btn btn-success crop_image">Crop</button>  
           			</div>
                         
                </div>
            </div>
        </div>


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
    const showProductCode=() =>
    {
        if($('#couponClassification').val() == "offer") {
            $('#couponCode').css('display', 'none');
            $('#couponCodeAttr').removeAttr("required");
        }
        else {
            $('#couponCode').css('display', 'block');
            $('#couponCodeAttr').attr("required");
        }
    }
    $('#sitewide').val('<?=$FetchData['sitewide']?>');
    let url;
    const BuildURL = () => {
        let name = $('#ProductName').val();
        // url = url.split(' ');
        name = name.replaceAll(" ", "-");
        $('#URLKeyword').val(name);
        $('#url').val(url+name);
    }


    const getStoreDomain = () =>
    {
        let StoreID = $('#StoreID').val();
        $.post('ajax/ajax_getStore.php' , {StoreID: StoreID} , function (data){
            $('#url').val("<?=DOMAINNAME?>/product/"+data+"-");
            url = $('#url').val();
        })
    }

    <?php if($FetchData['ProductClassification']!="" && $FetchData['ProductClassification']!=null){ ?>
        $('#couponClassification').val('<?=$FetchData['ProductClassification']?>');
    $('#couponCode').css('display', 'none');
    $('#couponCode').val('');
    $('#couponCodeAttr').removeAttr("required");
    <?php } ?>
</script>
<script type="text/javascript">
    // Quick and simple export target #table_id into a csv
function download_table_as_csv(table_id, separator = ',') {
    // Select rows from table_id
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
    // Construct csv
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length; j++) {
            // Clean innertext to remove multiple spaces and jumpline (break csv)
            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
            // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
            data = data.replace(/"/g, '""');
            // Push escaped string
            row.push('"' + data + '"');
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join('\n');
    // Download it
    var filename = 'export_' + table_id + '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
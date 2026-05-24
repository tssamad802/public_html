About Store
<?php

//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1); 
//error_reporting(E_ALL);

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

<style type="text/css">
    
    .loader-div {
        float: right;
    }
    
</style>

<div id="displaysearch" style="display: none">
    <div class="hk-pg-header mb-0 headerboxdesign" >

        <h4 class="hk-pg-title" id="titleheading">Search</h4>

    </div>

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <form name="searchfrm" id="searchfrm" enctype="multipart/form-data" method="post" onsubmit="return SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listingstore&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');">
                            <div class="form-row">
                                <div class="col-md-6 mb-10">
                                    <label > Name  <span>*</span></label>
                                    <input type="text" name="name" class="form-control" value=""  />
                                </div>

                                <div class="col-md-6 mb-10">
                                    <label >Country</label>
                                    <select class="form-control custom-select select2" name="CountryID">
                                        <option>All</option>
                                        <?php
                                        echo fillcombocontrol(0,"TableID","Title","tblcountry ","Sequence");
                                        ?>
                                    </select>
                                </div>
                            </div>




                            <div class="form-row">
                                <div class="col-md-6 mb-10">
                                    <label >Url </label>
                                    <input type="text" name="url" class="form-control" value=""  />
                                </div>

                                <div class="col-md-6 mb-10">
                                    <label >Domain</label>
                                    <input type="text" name="domain" class="form-control" value=""  />
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-10">
                                    <label >Avg Discount</label>
                                    <input type="text" name="discount" class="form-control" value=""  />
                                </div>

                                <div class="col-md-6 mb-10">
                                    <label>Network</label>
                                    <select class="form-control custom-select select2" name="NetworkID">
                                        <option>All</option>
                                        <?php
                                        echo fillcombocontrol(0,"TableID","Title","tblnetwork","Sequence");
                                        ?>
                                    </select>
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
                                        <input type="radio" name="active"  value="0" />
                                        <span>Delete</span>
                                        <input type="radio" name="active"  value="2"  />
                                    </div>
                                </div>

                                <!--<div class="col-md-6 mb-10">-->
                                <!--    <label>Feature</label>-->
                                <!--    <div class="form-control">-->
                                <!--        <span>Yes</span>-->
                                <!--        <input type="radio" name="feature"  value="1"  />-->
                                <!--        <span>No</span>-->
                                <!--        <input type="radio" name="feature"  value="0"  />-->
                                <!--    </div>-->
                                <!--</div>-->

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




        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?></h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm" href="javascript:;" onclick="$('#displaysearch').slideToggle();">Search</a>
                &nbsp;&nbsp;
                <a class="btn btn-primary btn-sm"
                   href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&PageType=ManageRecord&Trigger=add")?>">Add Store</a>

            </div>
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12" >
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm" >
                        <a href="#" onclick="download_table_as_csv('datable_1');">Download as CSV</a>
                        <span class="float-right loader-div">Stores loading...  <img class="img-loader-stores" style="width: 20px;" src="../admin/images/preloader-stores.gif" /></span>
                                                       
                          <div class="table-wrap" id="resultDiv"></div>

                                <script type="text/javascript">
                                    SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=listingstore&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>','searchfrm','resultDiv');
                                </script>
                        
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
else if(isset($_REQUEST['PageType']) && $_REQUEST['PageType']=='SortRecord')
        {
            checkPermission("ViewPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
            ?>


            <div class="hk-pg-header mb-0 headerboxdesign">

                <h4 class="hk-pg-title" id="titleheading">Sorting</h4>
                <div class="d-flex mb-0">
                    <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
                </div>

            </div>

            <!-- Row -->
            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap" id="resultDiv">
                                    <div class="norecordfound"><?=TXT_PLEASE_WAIT_DATA_LOAD?></div>
                                </div>

                                <script type="text/javascript">
                                    SimpleAjax('ajax_news.php?<?=EncodeUrl("FireAction=sortstore&action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID']."&RecordID=".$_REQUEST["RecordID"])?>','searchfrm','resultDiv');
                                </script>
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
	$Brief_Description_English=BRIEF_DESCRIPTION_LENGTH_ENGLISH;
	$Brief_Description_Arabic=BRIEF_DESCRIPTION_LENGTH_ARABIC;
	$RemoveData = 1;
	if(isset($_REQUEST['RecordID']))
	{
		$RemoveData = 0;
		checkPermission("EditPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblstore");
		$Brief_Description_English=BRIEF_DESCRIPTION_LENGTH_ENGLISH-strlen(clearTextForField($FetchData['BriefDescription']));
		$Brief_Description_Arabic=BRIEF_DESCRIPTION_LENGTH_ARABIC-strlen(clearTextForField($FetchData['BriefDescriptionAr']));
	}
	else
	{
		checkPermission("AddPermissions",$UserRecordGetting['TableID'],$_REQUEST['SubLinkID']);
	}
	?>


        <div class="hk-pg-header mb-0 headerboxdesign">

            <h4 class="hk-pg-title" id="titleheading"><?=FetchSubLinkMenuName($_REQUEST['SubLinkID'])?>
                (<?=($RecordID > 0)?TXT_EDIT_ANNOUNCEMENT:TXT_ADD_ANNOUNCEMENT;?>)</h4>

            <div class="d-flex mb-0">
                <a class="btn btn-primary btn-sm" href="<?="index.php?".EncodeUrl("action=".$_REQUEST['action']."&SubLinkID=".$_REQUEST['SubLinkID'])?>"><?=TXT_BACK?></a>
            </div>
        </div>



        <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <input type="hidden" name="ActionFlag" value="<?=encodeencriptstring('AddEditStore')?>" />
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
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_ANNOUNCEMENT_INFORMATION?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label > Store Name  <span>*</span></label>
                                                <input type="text" name="name" id="name" class="form-control" value="<?=$FetchData['name']?>" dir="ltr" onkeyup="getStoreName();" required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label>Store Domain <span>*</span></label>
                                                <input type="text" name="domain" id="DomainName"  onkeyup="<?=($FetchData['domain']!='') ? '' : 'BuildURL()'?>" class="form-control" value="<?=$FetchData['domain']?>"  required />
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label >Store URL <span>*</span></label>
                                                <input type="text" name="url" id="url" class="form-control" value="<?=$FetchData['url']?>" dir="ltl" readonly />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Store Date<span>*</span></label>
                                                <input type="text" name="storeDate" class="form-control singleDatePicker" value="<?=($FetchData['storeDate']=="0000-00-00")?'':$FetchData['storeDate']?>" readonly="readonly"  required />
                                                <div class="invalid-feedback">
                                                   <?=ERROR_ANNOUNCEMENT_DATE?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label> Store Website URL  <span>*</span></label>
                                                <input type="text" name="webUrl"  class="form-control" value="<?=$FetchData['webUrl']?>" dir="ltl" required  />

                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label> Store Tracking URL </label>
                                                <input type="text" name="trackingUrl"  class="form-control" value="<?=$FetchData['trackingUrl']?>" />

                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10 formtitleAr">
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
                                            <div class="col-md-6 mb-10">
                                             <label >Store Logo</label>
                                             <div class="form-group">
                                                 <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?=TXT_UPLOAD?></span>
                                                    </div>
                                                    <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?=TXT_SELECT_FILE?></span><span class="fileinput-exists"><?=TXT_CHANGE?></span>
                                                        <input type="file" name="logo"  imagewidth="<?=INNER_PAGE_BANNER_WIDTH?>"  imageheight="<?=INNER_PAGE_BANNER_HEIGHT?>"  cropinput="1"  />
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?=TXT_REMOVE?></a>
                                                    </span>
                                                </div>
                                               </div>
                                            </div>
                                                <div class="col-md-6 mb-10">
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

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="ShowHome" id="ShowHome" <?=($FetchData['ShowHome']==1)?'checked=""':''?> value="1" />
                                                    <label class="custom-control-label" for="ShowHome"><?=TXT_SHOW_HOME_PAGE?></label>
                                                </div>
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
                                            <div class="col-md-6 mb-10 formtitleAr">
                                                <label >Store Category <span>*</span></label>
                                                <select name="CategoryID[]" class="form-control select2" multiple="multiple" >
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
                                                    }

                                                   //echo fillcombocontrol($FetchData['CategoryID'],"TableID","Title","tblcategory where Active=1","Sequence");
                                                    ?>
                                                </select>

                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label>H1</label>
                                                <input type="text" name="H1" class="form-control" value="<?=$FetchData['H1']?>" dir="ltr"   />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label>H2</label>
                                                <input type="text" name="H2" class="form-control" value="<?=$FetchData['H2']?>" dir="ltr"   />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Store Network <span>*</span></label>
                                                <select name="NetworkID" class="form-control custom-select select2"  >
                                                    <option value="">Select Network</option>
                                                    <?php
                                                    echo fillcombocontrol($FetchData['NetworkID'],"TableID","Title","tblnetwork where Active=1","Sequence");
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

<!--                                        <div class="form-row">-->
<!--                                            <div class="col-md-6 mb-10">-->
<!--                                                <label > Store Id Active Network  <span>*</span></label>-->
<!--                                                <input type="text" name="storeIDActiveNetwork" class="form-control" value="--><?//=$FetchData['storeIDActiveNetwork']?><!--" dir="ltr"  required />-->
<!--                                                <div class="invalid-feedback">-->
<!--                                                    --><?//=ERROR_TITLE_ENGLISH?>
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label > Store Impression Code  <span>*</span></label>
                                                <textarea name="impressionCode" class="form-control" cols="5"><?=$FetchData['impressionCode']?></textarea>
<!--                                                <input type="text" name="impressionCode" class="form-control" value="--><?//=$FetchData['impressionCode']?><!--" required />-->
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>

                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label > Store Avg Discount  <span>*</span></label>
                                                <input type="text" name="discount" class="form-control" value="<?=$FetchData['discount']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label > Store fb url<span></span></label>
                                                <input type="url" name="fbUrl" class="form-control" value="<?=$FetchData['fbUrl']?>" />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label >Similar Store</label>
                                                <select name="SimilarStore[]" class="form-control select2" multiple="multiple" >
                                                    <?php
                                                    $sql="select * from tblstore where Active=1 order by Sequence ";
                                                    $db->query($sql);
                                                    while($db->next_Record())
                                                    {
                                                        $CategoryArray = explode(",",$FetchData['SimilarStoreID']);
                                                        $OptionData = $db->f('name');
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
                                                <label > Store Total Votes  <span>*</span></label>
                                                <input type="number" name="votes" class="form-control" max="5000" value="<?=$FetchData['votes']?>"  required />
                                                <div class="invalid-feedback">
                                                    Please Input and maximum value is 5000
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label > Store Rating  <span>*</span></label>
                                                <input type="text" name="rating" class="form-control" max="5" value="<?=$FetchData['rating']?>" dir="ltr"  required />
                                                <div class="invalid-feedback">
                                                    Please Input and maximum value is 5
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label>Store Featured <span>*</span></label>
                                                <table cellpadding="10">
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8  <?=TXT_MARGIN_LEFT?>">
                                                                <input id="Yess" name="featured"
                                                                       class="custom-control-input"
                                                                    <?=($FetchData['featured']==1)?'checked="checked"':''?>
                                                                       type="radio" value="1">
                                                                <label class="custom-control-label"
                                                                       for="Yess"><?=TXT_YES?></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 ml-20">
                                                                <input id="Noo" name="featured"
                                                                       class="custom-control-input"
                                                                    <?=($FetchData['featured']==0)?'checked="checked"':''?>
                                                                       type="radio" value="0">
                                                                <label class="custom-control-label"
                                                                       for="Noo"><?=TXT_NO?></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label > Store Banner  <span>*</span></label>
                                                <textarea name="storeAdd" class="form-control" cols="5"><?=$FetchData['storeAdd']?></textarea>
                                                <!--  <input type="text" name="storeAdd" class="form-control" value="--><?//=$FetchData['storeAdd']?><!--"/>-->
                                                <div class="invalid-feedback">
                                                    <?=ERROR_TITLE_ENGLISH?>
                                                </div>
                                            </div>
                                        </div>

                                            </div>


                                            <div class="col-md-6 mb-10">
                                                  <label>About Store </label>
                                                       <textarea class="tinymce"  name="aboutStore"  required ><?=clearTextForField($FetchData['about'])?></textarea>
                                                           <div class="invalid-feedback">
                                                             <?=ERROR_BRIEF_ENGLISH?>
                                                          </div>
                                            </div>


                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12 mb-12">
                                                <label>Store Description </label>
                                                <textarea class="tinymce" name="description" required> <?=clearTextForField($FetchData['description'])?></textarea>
                                                <div class="invalid-feedback">
                                                    <?=ERROR_DESCRIPTION_ENGLISH?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header card-header-action tabdesignbox"><?=TXT_SEO?></div>
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="col-md-12 mb-10">
                                                <label><?=TXT_PAGE_URL?></label>
                                                <input type="text" name="URLKeyword" id="URLKeyword" value="<?=$FetchData['URLKeyword']?>" readonly  class="form-control" />
                                                <div class="invalid-feedback">
                                                    <?=ERROR_PAGE_URL?>
                                                </div>

                                            </div>
                                        </div>



                                        <div class="form-row">
                                            <div class="col-md-6 mb-12">
                                                <label><?=TXT_META_ENGLISH?></label>
                                                <input type="text" name="MetaTitle" dir="ltr" value="<?=$FetchData['MetaTitle']?>" id="MetaTitle" class="form-control" />
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
			setTimeout(function(){$('.singleDatePicker').val('');$('.featuredate').val('');}, 500);
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
    let replacement= "-";
    const BuildURL = () => {
        let url = $('#DomainName').val();
//        var n = url.lastIndexOf('.');
        url = url.replaceAll('.', '-'); 
        $('#url').val("<?=RESOURCES_DOMAIN?>/store/"+url);
        $('#URLKeyword').val(url);
    }
</script>
<script type="text/javascript">
    const getStoreName = () => 
    {
    let storeName = $('#name').val();
    let title = "50% Off " + storeName + " Coupon Codes & Promotion Codes";
    $('#MetaTitle').val(title);
}

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
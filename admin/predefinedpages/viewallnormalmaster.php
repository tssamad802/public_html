<?php
if (!isset($RUNFILE_FROM_INDEX_PAGE)) {
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
        if (!isset($_REQUEST['PageType']) && $_REQUEST['PageType'] == '') {
            checkPermission("ViewPermissions", $UserRecordGetting['TableID'], $_REQUEST['SubLinkID']);
            ?>

            <div class="hk-pg-header mb-0 headerboxdesign">

                <h4 class="hk-pg-title" id="titleheading"><?= FetchSubLinkMenuName($_REQUEST['SubLinkID']) ?></h4>

                <div class="d-flex mb-0">

                    <a class="btn btn-primary btn-sm"
                        href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&PageType=ManageRecord&Trigger=add&TableName=" . $_REQUEST['TableName']) ?>"><?= TXT_ADD_MASTER_RECORD ?></a>
                </div>
            </div>


            <!-- Row -->
            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <a href="#" onclick="download_table_as_csv('datable_1');">Download as CSV</a>

                                <div class="table-wrap" id="resultDiv"></div>
                                <script type="text/javascript">
                                    SimpleAjax('ajax_masterdata.php?<?= EncodeUrl("FireAction=listing&action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&TableName=" . $_REQUEST['TableName']) ?>', 'searchfrm', 'resultDiv');
                                </script>
                            </div>
                        </div>
                    </section>


                </div>
            </div>
            <!-- /Row -->

            <?php include("deletepopupfile.php") ?>
            <!-- Modal HTML -->
        <?php } else if (isset($_REQUEST['PageType']) && $_REQUEST['PageType'] == 'ManageRecord') {
            $FetchData['Active'] = ACTIVE;
            $RecordID = 0;
            if ($_REQUEST['RecordID'] > 0) {
                checkPermission("EditPermissions", $UserRecordGetting['TableID'], $_REQUEST['SubLinkID']);
                $RecordID = $_REQUEST['RecordID'];
                $FetchData = FetchRecordByID($RecordID, "TableID", $_REQUEST['TableName']);
            } else {
                checkPermission("AddPermissions", $UserRecordGetting['TableID'], $_REQUEST['SubLinkID']);
            }
            $PageName = FetchSubLinkMenuName($_REQUEST['SubLinkID']);
            ?>


                <div class="hk-pg-header mb-0 headerboxdesign">
                    <h4 class="hk-pg-title" id="titleheading"><?= $PageName ?> >
                    <?php echo ($RecordID > 0) ? TXT_EDIT . " " . $PageName : TXT_ADD . " " . $PageName; ?>
                    </h4>
                    <div class="d-flex mb-0">
                        <a class="btn btn-primary btn-sm"
                            href="<?= "index.php?" . EncodeUrl("action=" . $_REQUEST['action'] . "&SubLinkID=" . $_REQUEST['SubLinkID'] . "&TableName=" . $_REQUEST['TableName']) ?>"><?= TXT_BACK ?></a>
                    </div>
                </div>



                <form class="needs-validation" enctype="multipart/form-data" method="post" action="" novalidate>
                    <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                    <input type="hidden" name="ActionFlag" value="<?= encodeencriptstring('AddMasterData') ?>" />
                    <input type="hidden" name="Trigger" value="<?= encodeencriptstring($_REQUEST['Trigger']) ?>" />
                    <input type="hidden" name="actionpage" value="<?= encodeencriptstring($_REQUEST['action']) ?>" />
                    <input type="hidden" name="SubLinkID" value="<?= encodeencriptstring($_REQUEST['SubLinkID']) ?>" />
                    <input type="hidden" name="RecordID" value="<?= encodeencriptstring($RecordID) ?>" />
                    <input type="hidden" name="MasterTable" value="<?= encodeencriptstring($_REQUEST['TableName']) ?>" />
                    <div class="row">
                        <div class="col-xl-12">
                            <section class="hk-sec-wrapper">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-10">
                                                <label>Title <span>*</span></label>
                                                <input type="text" name="<?= ($RecordID == 0) ? 'Title[]' : 'Title' ?>" id="Title"
                                                    onkeyup="<?= ($FetchData['Title'] != '') ? '' : 'BuildURL()' ?>"
                                                    class="form-control" value="<?= $FetchData['Title'] ?>" dir="ltr"
                                                    id="DomainName" <?php if ($FetchData['Title'] == "") { ?>onkeyup='BuildURL();'
                                                <?php } ?> required />
                                                <div class="invalid-feedback">
                                                    Please enter title
                                                </div>
                                            </div>

                                        <?php if ($_REQUEST['SubLinkID'] == 26) { ?>
                                                <div class="col-md-4 mb-10">
                                                    <label>Country Tag <span>*</span></label>
                                                    <input type="text" name="CountryTag" class="form-control"
                                                        value="<?= $FetchData['CountryTag'] ?>" required />
                                                    <div class="invalid-feedback">
                                                        Please enter title
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-10">
                                                    <label>Country Keyword <span>*</span></label>
                                                    <input type="text" name="CountryKeyword" class="form-control"
                                                        value="<?= $FetchData['CountryKeyword'] ?>" required />
                                                    <div class="invalid-feedback">
                                                        Please enter title
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-10">
                                                    <label>Country Currency Symbol <span>*</span></label>
                                                    <input type="text" name="Currency" class="form-control"
                                                        value="<?= $FetchData['Currency'] ?>" required />
                                                    <div class="invalid-feedback">
                                                        Please Enter Currency
                                                    </div>
                                                </div>
                                        <?php } ?>

                                        <?php if ($_REQUEST['SubLinkID'] == 37) { ?>
                                                <div class="col-md-8 mb-10">
                                                    <label>URL <span>*</span></label>
                                                    <input type="text" name="URL" id="URL" readonly class="form-control"
                                                        value="<?= $FetchData['URL'] ?>" required />
                                                </div>
                                        <?php } ?>

                                        <?php if ($_REQUEST['SubLinkID'] == 5) { ?>
                                                <div class="col-md-6 mb-10">
                                                    <label>Parent Category <span>*</span></label>
                                                    <select name="ParentID" class="form-control select2">
                                                        <option value="">Select Category</option>
                                                    <?= fillcombocontrol($FetchData['ParentID'], "TableID", "Title", "tblcategory where ParentID=0 AND TableID!=$RecordID ", "Title") ?>
                                                    </select>
                                                </div>
                                        <?php } ?>

                                        <?php if ($_REQUEST['SubLinkID'] == 38) { ?>

                                                <!--  <div class="col-md-6 ">
                                        <label >Coupon Logo</label>
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><?= TXT_UPLOAD ?></span>
                                                </div>
                                                <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                <span class="input-group-append">
                                                            <span class=" btn btn-primary btn-file"><span class="fileinput-new"><?= TXT_SELECT_FILE ?></span><span class="fileinput-exists"><?= TXT_CHANGE ?></span>
                                                        <input type="file" name="logo"  class="" imagewidth="<?= INNER_PAGE_BANNER_WIDTH ?>"  imageheight="<?= INNER_PAGE_BANNER_HEIGHT ?>"  cropinput="1"  />
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?= TXT_REMOVE ?></a>
                                                    </span>
                                            </div>
                                        </div>
                                        <div >
                                            <div class="image_file_preview1 image_file_preview_result">
                                                <img src="" />
                                                <input type="hidden" name="ImageCropData1" />
                                            </div>
                                            <?php
                                            if ($FetchData['logo'] != '')
                                                echo GallaryImageHtml('../' . FILES_FOLDER . '/' . BANNER_FOLDER . '/' . $FetchData['logo']);
                                            ?>
                                        </div>
                                    </div> -->



                                                <div class="col-md-4">
                                                    <label>ShowHome <span>*</span></label>
                                                    <table cellpadding="10">
                                                        <tr>
                                                            <td>
                                                                <div class="custom-control custom-radio mb-10 mt-10">
                                                                    <input id="Yes1" name="ShowHome" class="custom-control-input"
                                                                    <?= ($FetchData['ShowHome'] == 1) ? 'checked="checked"' : '' ?>
                                                                        type="radio" value="1">
                                                                    <label class="custom-control-label"
                                                                        for="Yes1"><?= TXT_YES ?></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-radio mb-10 mt-8 ml-20 mr-20">
                                                                    <input id="No1" name="ShowHome" class="custom-control-input"
                                                                    <?= ($FetchData['ShowHome'] == 0) ? 'checked="checked"' : '' ?>
                                                                        type="radio" value="0">
                                                                    <label class="custom-control-label"
                                                                        for="No1"><?= TXT_NO ?></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6 col-lg-6">
                                                    <label>Tag Date <span>*</span></label>
                                                    <input type="text" name="tagDate" class="form-control singleDatePicker"
                                                        value="<?= ($FetchData['tagDate'] == "0000-00-00") ? '' : $FetchData['tagDate'] ?>"
                                                        readonly="readonly" required />
                                                    <div class="invalid-feedback">
                                                    <?= ERROR_ANNOUNCEMENT_DATE ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-6">
                                                    <label>Page URL<span>*</span></label>
                                                    <input type="text" name="URLKeyword" class="form-control" id="URLKeyword"
                                                        value="<?= $FetchData['URLKeyword'] ?>" />
                                                </div>

                                                <div class="col-md-12 mb-12">
                                                    <label>Coupon Description </label>
                                                    <textarea class="tinymce" name="description"
                                                        required><?php echo clearTextForField($FetchData['description']) ?></textarea>
                                                    <div class="invalid-feedback">
                                                    <?= ERROR_DESCRIPTION_ENGLISH ?>
                                                    </div>
                                                </div>

                                                <!--                                    </div>-->

                                        <?php } ?>

                                        <?php if ($_REQUEST['SubLinkID'] == 32) { ?>
                                                <div class="col-md-4 mb-10">
                                                    <label>Network ID <span>*</span></label>
                                                    <input type="text" name="NetID" class="form-control"
                                                        value="<?= $FetchData['NetID'] ?>" required />
                                                    <div class="invalid-feedback">
                                                        Please enter title
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-10">
                                                    <label>NetDeepLinkCode </label>
                                                    <input type="text" name="NetDeepLinkCode" class="form-control"
                                                        value="<?= $FetchData['NetDeepLinkCode'] ?>" />
                                                    <div class="invalid-feedback">
                                                        Please enter title
                                                    </div>
                                                </div>
                                        <?php } ?>

                                            <div class="col-md-4 mb-10">
                                                <label><?= TXT_ACTIVE_USER ?> <span>*</span></label>
                                                <table cellpadding="10">
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-10">
                                                                <input id="Yes" name="Active" class="custom-control-input"
                                                                <?= ($FetchData['Active'] == 1) ? 'checked="checked"' : '' ?>
                                                                    type="radio" value="1">
                                                                <label class="custom-control-label"
                                                                    for="Yes"><?= TXT_YES ?></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-radio mb-10 mt-8 ml-20 mr-20">
                                                                <input id="No" name="Active" class="custom-control-input"
                                                                <?= ($FetchData['Active'] == 0) ? 'checked="checked"' : '' ?>
                                                                    type="radio" value="0">
                                                                <label class="custom-control-label" for="No"><?= TXT_NO ?></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>

                                        </div>


                                        <div class="form-row">
                                        <?php if ($RecordID == 0) { ?>
                                                <div class="col-md-4 mb-10">
                                                    <div class="makemastercopies">
                                                    </div>
                                                </div>
                                        <?php } ?>
                                        </div>
                                        <?php
                                        if ($_REQUEST['SubLinkID'] != 5 && $_REQUEST['SubLinkID'] != 32 && $_REQUEST['SubLinkID'] != 26 && $_REQUEST['SubLinkID'] != 38 && $_REQUEST['SubLinkID'] != 37) {
                                            ?>
                                            <div class="form-row">
                                            <?php if ($RecordID == 0) { ?>
                                                    <div class="col-md-6 mb-10">
                                                        <a href="javascript:void(0);" class="addplussign"
                                                            style="display:block;color:#000;font-size:30px;">
                                                            <i class="ion ion-md-add-circle-outline"></i>
                                                        </a>
                                                    </div>
                                            <?php } ?>
                                            </div>
                                    <?php } ?>

                                    <?php if ($_REQUEST['SubLinkID'] == 5 || $_REQUEST['SubLinkID'] == 37) { ?>
                                            <div class="card">
                                                <div class="card-header card-header-action tabdesignbox"><?= TXT_SEO ?></div>
                                                <div class="card-body">


                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-10">
                                                            <label><?= TXT_PAGE_URL ?></label>

                                                            <input type="text" name="URLKeyword" id="URLKeyword"
                                                                value="<?= $FetchData['URLKeyword'] ?>" id="URLKeyword" readonly
                                                                class="form-control" />
                                                            <div class="invalid-feedback">
                                                            <?= ERROR_PAGE_URL ?>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-12">
                                                            <label><?= TXT_META_ENGLISH ?></label>
                                                            <input type="text" name="MetaTitle" dir="ltr"
                                                                value="<?= $FetchData['MetaTitle'] ?>" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-12">
                                                            <label><?= TXT_META_DESCRIPTION_ENGLISH ?></label>
                                                            <textarea name="MetaDescription" dir="ltr" class="form-control"
                                                                rows="3"><?= clearTextForField($FetchData['MetaDescription']) ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-12">
                                                            <label><?= TXT_META_KEYWORD_ENGLISH ?></label>
                                                            <textarea name="MetaKeywords" dir="ltr" class="form-control"
                                                                rows="3"><?= clearTextForField($FetchData['MetaKeywords']) ?></textarea>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                    <?php } ?>


                                        <div class="formbuttonrightside">
                                            <button class="btn btn-danger" type="reset"><?= RESET ?></button>
                                            <button class="btn btn-primary" type="submit"><?= SUBMIT ?></button>
                                        </div>
                                    </div>
                                </div>
                            </section>


                        </div>
                    </div>
                </form>

                <script>
                    $(document).ready(function () {
                        var masterpluscounter = 0;
                        $('.addplussigndata').click(function () {
                            masterpluscounter++;
                            var anchorlink = '<a href="javascript:void(0);" onclick="RemoveField(' + masterpluscounter + ')" class="minussign"><i class="ion ion-ios-close-circle-outline"></i></a>';
                            var htmltext = '<div class="otheplusbox removminus' + masterpluscounter + '">' +
                                '<label >' + window.TxtEnglish + ' <span>*</span> ' + anchorlink + '</label>' +
                                '<input type="text" name="Title[]" class="form-control" value="" dir="ltr"  required />' +
                                '<div class="invalid-feedback">' +
                                '' + window.TxtEnglishERROR + '' +
                                '</div>';
                            '</div>';

                            var htmltextarabic = '<div class="otheplusbox removminus' + masterpluscounter + '">' +
                                '<label >' + window.TxtArabic + ' <span>*</span> ' + anchorlink + '</label>' +
                                '<input type="text" name="TitleAr[]" class="form-control" value="" dir="rtl"  required />' +
                                '<div class="invalid-feedback">' +
                                '' + window.TxtArabicERROR + '' +
                                '</div>';
                            '</div>';

                            var fileupload = '<div class="otheplusbox removminus' + masterpluscounter + '">' +
                                '<label><?= TXT_THUMBNAIL_IMAGE ?> (<?= HOME_PAGE_THUMBNAIL_WIDTH ?>X<?= HOME_PAGE_THUMBNAIL_HEIGHT ?>)</label>' +
                                '<div class="form-group">' +
                                '<div class="fileinput fileinput-new input-group" data-provides="fileinput">' +
                                '<div class="input-group-prepend">' +
                                '<span class="input-group-text"><?= TXT_UPLOAD ?></span>' +
                                '</div>' +
                                '<div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>' +
                                '<span class="input-group-append">' +
                                '<span class=" btn btn-primary btn-file"><span class="fileinput-new"><?= TXT_SELECT_FILE ?></span><span class="fileinput-exists"><?= TXT_CHANGE ?></span>' +
                                '<input type="file" name="ThumbnailImage[]"  class="cropimages" imagewidth="<?= HOME_PAGE_THUMBNAIL_WIDTH ?>"  imageheight="<?= HOME_PAGE_THUMBNAIL_HEIGHT ?>"  cropinput="' + masterpluscounter + '"   />' +
                                '</span>' +
                                '<a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput"><?= TXT_REMOVE ?></a>' +
                                '</span>' +
                                '</div>' +
                                '</div>' +
                                '<div > <div class="image_file_preview' + masterpluscounter + ' image_file_preview_result"><img src="" /><input type="hidden" name="ImageCropData' + masterpluscounter + '" /></div>' +
                                '</div>' +
                                '</div>';
                            $('.makemastercopies').append(htmltext);
                            $('.makemastercopiesarabic').append(htmltextarabic);
                            $('.makemasfileupload').append(fileupload);
                            cropimages();
                        });

                    });
                </script>
            <?php
        }
        ?>

    </div>
    <!-- /Container -->
</div>
<script>
    let url = "<?= RESOURCES_DOMAIN ?>/type/";
    const BuildURL = () => {
        let name = $('#Title').val();
        // url = url.split(' ');
        console.log(url)
        name = name.replaceAll(" ", "-");
        name = name.replaceAll("&", "_");
        $('#URL').val(url + "" + name);
        $('#URLKeyword').val(name);
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
<?php
session_start();
include_once("../classes/commonfunctions.php");
DecodeUrl();
//load dashboard language files
if($_SERVER['HTTP_REFERER'] == '' || $_SERVER['HTTP_X_REQUESTED_WITH'] == '')
{
	die("Direct Access Not Allowed");
}

if($_REQUEST['Action']=="TestDetails")
{
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblsubmittest");
		$CourseData = FetchRecordByID($FetchData['CourseID'],"TableID","tblcourses");
		$LoginData = FetchRecordByID($FetchData['UserID'],"TableID","tbluserregistration");
	?>
    <div class="modal-header" style="padding-left:0; padding-right:0">
        <h5 class="modal-title"><?=TXT_REQUEST_NO.' '.$FetchData['RequestNo'].' ('.$CourseData['Title'.LANG_SEP_DB].')'?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>


    <div class="card">
       <div class="card-header card-header-action tabdesignbox"><?=TXT_COURSE_AND_TEST_DETAILS?></div>
        <div class="card-body">
            <div class="form-row">
                <div class="table-responsive">
                    	<table class="table table-info table-bordered mb-0">
                            <thead class="thead-info">
                                <tr>
                                    <th width="200"><?=TXT_COURSE?></th>
                                    <td scope="row"><?=$CourseData['Title'.LANG_SEP_DB]?></td>
                                </tr>
                                <tr>
                                    <th><?=TXT_PASSING_PERCETAGE?></th>
                                    <td scope="row"><?=$FetchData['PassingPercentage']?>%</td>
                                </tr>
                                <tr>
                                    <th><?=TXT_SUBMIT_DATETIME?></th>
                                    <td scope="row"><?=onlydatetimeformat($FetchData['SubmitDateTime'])?></td>
                                </tr>
                                <tr>
                                    <th><?=TXT_STATUS?></th>
                                    <td scope="row"><span class="badge <?=($FetchData['IsPassed']==1)?'badge-success':'badge-danger'?>"><?=($FetchData['IsPassed']==1)?TXT_PASS:TXT_FAIL?></span></td>
                                </tr>
                            </thead>
                    	</table>

                    	<table class="table table-info table-bordered mb-0">
                            <thead class="thead-info">
                                <tr>
                                    <th><?=SNO?></th>
                                    <th><?=TXT_QUESTION?></th>
                                    <th><?=TXT_CORRECT_ANSWER?></th>
                                    <th><?=TXT_SUBMIT_ANSWER?></th>
                                    <th align="center"><?=TXT_MARKS?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql="select C.Title".LANG_SEP_DB." as CourseName,D.Title".LANG_SEP_DB." as CorrectAnswerData,E.Title".LANG_SEP_DB." as SubmitAnswerData,B.IsMarks from  tblsubmittest A 
                            inner join tblsubmittestanswer B on B.ParentID=A.TableID
                            inner join tblcoursequestion C on C.TableID=B.QuestionID
                            inner join tblcoursequestionoption D on D.TableID=B.CorrectQuestionID
                            inner join tblcoursequestionoption E on E.TableID=B.SubmitAnswerID
                            Where B.ParentID='".$RecordID."' AND A.UserID='".$FetchData['UserID']."' order by B.TableID";
                            $db->query($sql);
							while($db->next_Record())
							{
								$RecordCount++;
								$TotalMarks += $db->f('IsMarks');
								?>
                                <tr>
                                	<td><?=$RecordCount?></td>
                                	<td><?=$db->f('CourseName')?></td>
                                	<td><?=$db->f('CorrectAnswerData')?></td>
                                	<td><?=$db->f('SubmitAnswerData')?></td>
                                	<td align="center"><?=$db->f('IsMarks')?></td>
                                </tr>
                                <?php
							}
							?>
                                <tr>
                                	<td  colspan="4" align="<?=ALIGN_MENT?>"><?=TXT_OBTAINED_MARKS?></td>
                                	<td align="center"><?=$TotalMarks?></td>
                                </tr>
                                <tr>
                                	<td  colspan="4" align="<?=ALIGN_MENT?>"><?=TXT_TOTAL_MARKS?></td>
                                	<td align="center"><?=$RecordCount?></td>
                                </tr>
                                <tr>
                                	<td  colspan="4" align="<?=ALIGN_MENT?>"><?=TXT_PERCENTAGE?></td>
                                	<td align="center"><?=($TotalMarks * 100) / $RecordCount?>%</td>
                                </tr>
                            </tbody>
                    	</table>
                    </div>

                </div>


            </div>
        </div>



	<div class="card">
       <div class="card-header card-header-action tabdesignbox"><?=TXT_REGISTER_NO.' ('.$LoginData['RegID'].')'?></div>
        <div class="card-body">
            <div class="form-row">
                <div class="table-responsive">
                    <table class="table table-info table-bordered mb-0">
                        <thead class="thead-info">
                            <tr>
                                <th width="200"><?=TXT_NAME?></th>
                                <td scope="row"><?=$LoginData['FullName']?></td>
                            </tr>
                            <tr>
                                <th><?=TXT_GENDER?></th>
                                <td scope="row"><?=($LoginData['Gender']==1)?TXT_MALE:TXT_FEMALE?></td>
                            </tr>
                            <tr>
                                <th><?=TXT_DOB?></th>
                                <td scope="row"><?=onlydateshortformat($LoginData['DOB'])?></td>
                            </tr>

                            <tr>
                                <th><?=TXT_EMAIL?></th>
                                <td scope="row"><?=$LoginData['Email']?></td>
                            </tr>
                            <tr>
                                <th><?=TXT_MOBILE?></th>
                                <td scope="row"><?=$LoginData['Mobile']?></td>
                            </tr>

                            <tr>
                                <th><?=TXT_NATIONALITY?></th>
                                <td scope="row"><?=getFieldDataByID("Nationality".LANG_SEP_DB,"TableID",$LoginData['NationalityID'],"tblcountries")?></td>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
      </div>


	<?php
    $videoLog="select A.ViewCounter,A.LastViewDateTime, B.VideoType, B.FileName from  tblwatchvideosfortest A 
    inner join tblsystemvideos B on B.TableID=A.VideoID AND B.TypeID=4
    Where A.CourseID='".$FetchData['CourseID']."' AND A.UserID='".$FetchData['UserID']."' order by A.TableID DESC";
    $db->query($videoLog);
	if($db->num_rows() > 0)
	{
    ?>

      <div class="card">
       <div class="card-header card-header-action tabdesignbox"><?=TXT_VIDEO_WATHC_LOG?></div>
        <div class="card-body">
            <div class="form-row">
                <div class="table-responsive">
                    <table class="table table-info table-bordered mb-0">
                        <thead class="thead-info">
                            <tr>
                                <th width="5"><?=SNO?></th>
                                <th><?=VIDEOS?></th>
                                <th width="5"><?=TXT_SEEN?></th>
                                <th  width="150" align="center" style="text-align:center"><?=TXT_LAST_SEEN?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
						while($db->next_Record())
						{
							$VideoCount++;
							$v_Value = PareYouTubeLink($db->f('FileName'));
							$videoUrl = 'http://www.youtube.com/embed/'.$v_Value.'?rel=0&amp;wmode=transparent&autoplay=1';
							$imageUrl = 'http://img.youtube.com/vi/'.$v_Value.'/hqdefault.jpg';
								?>
                                <tr>
                                	<td align="center"><?=$VideoCount?></td>
                                	<td><img src="<?=$imageUrl?>" height="100" /></td>
                                	<td align="center"><?=$db->f('ViewCounter')?></td>
                                	<td align="center"><?=onlydatetimeformat($db->f('LastViewDateTime'))?></td>
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

}



    else if($_REQUEST['Action']=="StoreDetail")
    {

        $RecordID = $_REQUEST['RecordID'];
        $FetchData = FetchRecordByID($RecordID,"TableID","tblstore");

        $NetworkData = FetchRecordByID($FetchData['NetworkID'],"TableID","tblnetwork");

        $LoginData = FetchRecordByID($FetchData['CreatedBy'],"TableID","tbluserregistration_log");

        $CountryData = FetchRecordByID($FetchData['CountryID'],"TableID","tblcountry");

        $TotalCoupon = FetchTotal($RecordID , "StoreID" ,'tblcoupon');
        $CategoryData = array();
        $CategoryID = explode(',' , $FetchData['CategoryID']);
        foreach ($CategoryID as $data)
            $CategoryData[] = FetchRecordByID($data, "TableID", "tblcategory");
    ?>

    <div class="modal-header" style="padding-left:0; padding-right:0">
        <h5 class="modal-title">StoreData</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>


    <div class="card">
        <div class="card-header card-header-action tabdesignbox">Store Details</div>
        <div class="card-body">
            <div class="form-row">
                <div class="table-responsive">
                    <table class="table table-info table-bordered mb-0">
                        <thead class="thead-info">
                        <tr>
                            <th width="200">Store Name</th>
                            <td scope="row"><?=$FetchData['name']?></td>
                        </tr>
                        <tr>
                            <th>Store Domain</th>
                            <td scope="row"><?=$FetchData['domain']?></td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td scope="row"><?=$CountryData['Title']?></td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td scope="row"><?php foreach ($CategoryData as $data) print_r($data['Title']." , ");?></td>
                        </tr>
                        <tr>
                            <th>Avg Discount</th>
                            <td scope="row"><?=$FetchData['discount']?></td>
                        </tr>
                        <tr>
                            <th>Featured</th>
                            <td scope="row"><?=($FetchData['featured']==1)?'Yes':'No'?></td>
                        </tr>
                        <tr>
                            <th>Active</th>
                            <td scope="row"><?=($FetchData['Active']==1)?'Yes':'No'?></td>
                        </tr>
                        <tr>
                            <th>Impression Code</th>
                            <td scope="row"><?=$FetchData['impressionCode']?></td>
                        </tr>
                        <tr>
                            <th>Network Name</th>
                            <td scope="row"><?=$NetworkData['Title']?></td>
                        </tr>
                        <tr>
                            <th>Network ID</th>
                            <td scope="row"><?=$NetworkData['NetID']?></td>
                        </tr>
                        <tr>
                            <th>CreatedBy</th>
                            <td scope="row"><?=$LoginData['FullName']?></td>
                        </tr>
                        <tr>
                            <th>DateTime</th>
                            <td scope="row"><?=$FetchData['CreatedDateTime']?></td>
                        </tr>
<!--                        <tr>-->
<!--                            <th>StoreIDActiveNetwork</th>-->
<!--                            <td scope="row">--><?//=$FetchData['storeIDActiveNetwork']?><!--</td>-->
<!--                        </tr>-->
                        <tr>
                            <th>Web URL</th>
                            <td scope="row"><?=$FetchData['webUrl']?></td>
                        </tr>
                        <tr>
                            <th>Treacking URL</th>
                            <td scope="row"><?=$FetchData['trackingUrl']?></td>
                        </tr>
                        <tr>
                            <th>Fb URL</th>
                            <td scope="row"><?=$FetchData['fbUrl']?></td>
                        </tr>
                        <tr>
                            <th>About</th>
                            <td scope="row"><?=$FetchData['about']?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td scope="row"><?=$FetchData['description']?></td>
                        </tr>
                        <tr>
                            <th>Total Coupon</th>
                            <td scope="row"><?=(is_array($TotalCoupon) && !empty($TotalCoupon) ? array_values($TotalCoupon)[0] : ($TotalCoupon > 0 ? $TotalCoupon : '0'))?></td>
                        </tr>

                        </thead>
                    </table>


                </div>

            </div>


        </div>
    </div>



    <div class="card">
        <div class="card-header card-header-action tabdesignbox"><?=TXT_REGISTER_NO.' ('.$LoginData['RegID'].')'?></div>
        <div class="card-body">
            <div class="form-row">
                <div class="table-responsive">
                    <table class="table table-info table-bordered mb-0">
                        <thead class="thead-info">
                        <tr>
                            <th width="200"><?=TXT_NAME?></th>
                            <td scope="row"><?=$LoginData['FullName']?></td>
                        </tr>
                        <tr>
                            <th><?=TXT_GENDER?></th>
                            <td scope="row"><?=($LoginData['Gender']==1)?TXT_MALE:TXT_FEMALE?></td>
                        </tr>
                        <tr>
                            <th><?=TXT_DOB?></th>
                            <td scope="row"><?=onlydateshortformat($LoginData['DOB'])?></td>
                        </tr>

                        <tr>
                            <th><?=TXT_EMAIL?></th>
                            <td scope="row"><?=$LoginData['Email']?></td>
                        </tr>
                        <tr>
                            <th><?=TXT_MOBILE?></th>
                            <td scope="row"><?=$LoginData['Mobile']?></td>
                        </tr>

                        <tr>
                            <th><?=TXT_NATIONALITY?></th>
                            <td scope="row"><?=getFieldDataByID("Nationality".LANG_SEP_DB,"TableID",$LoginData['NationalityID'],"tblcountries")?></td>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>


<?php

}

    else  if($_REQUEST['Action']=="CouponDetail")
    {
    $RecordID = $_REQUEST['RecordID'];
    $FetchData = FetchRecordByID($RecordID,"TableID","tblcoupon");
    $NetworkID = $FetchData['NetworkID'] ?? 0;
    $StoreID = $FetchData['StoreID'] ?? 0;
    $CreatedBy = $FetchData['CreatedBy'] ?? 0;
    $CouponTypeID = $FetchData['CouponTypeID'] ?? 0;
    $CouponTagID = $FetchData['CouponTagID'] ?? 0;
    $CountryID = $FetchData['CountryID'] ?? 0;
    $NetworkData = $NetworkID ? FetchRecordByID($NetworkID,"TableID","tblnetwork") : [];
    $StoreData = $StoreID ? FetchRecordByID($StoreID,"TableID","tblstore") : [];
//    $CountryData = FetchRecordByID($FetchData['CountryID'],"TableID","tblcountry");
    $LoginData = $CreatedBy ? FetchRecordByID($CreatedBy,"TableID","tbluserregistration_log") : [];
    $CouponTypeData = $CouponTypeID ? FetchRecordByID($CouponTypeID,"TableID","tblcoupontype") : [];
    $CouponTagData = $CouponTagID ? FetchRecordByID($CouponTagID,"TableID","tblcoupontag") : [];
    $CountryData = $CountryID ? FetchRecordByID($CountryID,"TableID","tblcountry") : [];
//    $CategoryData = array();
//    $CategoryID = explode(',' , $FetchData['CategoryID']);
//    foreach ($CategoryID as $data)
//        $CategoryData[] = FetchRecordByID($data, "TableID", "tblcategory");

    ?>
    <div class="modal-header" style="padding-left:0; padding-right:0">
        <h5 class="modal-title">CouponData</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>


    <div class="card">
        <div class="card-header card-header-action tabdesignbox">Coupon Details</div>
        <div class="card-body">
            <div class="form-row">
                <div class="table-responsive">
                    <table class="table table-info table-bordered mb-0">
                        <thead class="thead-info">
                        <tr>
                            <th width="200">Coupon Name</th>
                            <td scope="row"><?=$FetchData['CouponName']?></td>
                        </tr>
                        <tr>
                            <th>Store Name</th>
                            <td scope="row"><?=$StoreData['name'] ?? ''?></td>
                        </tr>

                        <tr>
                            <th>URL</th>
                            <td scope="row"><?=$FetchData['url']?></td>
                        </tr>
                        <tr>
                            <th>Featured</th>
                            <td scope="row"><?=($FetchData['featured']==1)?'Yes':'No'?></td>
                        </tr>
                        <tr>
                            <th>Active</th>
                            <td scope="row"><?=($FetchData['Active']==1)?'Yes':'No'?></td>
                        </tr>
<!--                        <tr>-->
<!--                            <th>Category</th>-->
<!--                            <td scope="row">--><?php //foreach ($CategoryData as $data) print_r($data['Title']." , ");?><!--</td>-->
<!--                        </tr>-->
                        <tr>
                            <th>Coupon Code</th>
                            <td scope="row"><?=$FetchData['couponCode']?></td>
                        </tr>
                        <tr>
                            <th>Impression Code</th>
                            <td scope="row"><?=$FetchData['impression']?></td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td scope="row"><?=$FetchData['discount']?></td>
                        </tr>
                        <tr>
                            <th>Inital Date</th>
                            <td scope="row"><?=onlydatetimeformat($FetchData['startDate'])?></td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td scope="row"><?=onlydatetimeformat($FetchData['endDate'])?></td>
                        </tr>
                        <tr>
                            <th>upVotes</th>
                            <td scope="row"><?=$FetchData['upVotes']?></td>
                        </tr>
                        <tr>
                            <th>downVotes</th>
                            <td scope="row"><?=$FetchData['downVotes']?></td>
                        </tr>
                        <tr>
                            <th>Coupon Type</th>
                            <td scope="row"><?=$CouponTypeData['Title'] ?? ''?></td>
                        </tr>
                        <tr>
                            <th>Coupon Tag</th>
                            <td scope="row"><?=$CouponTagData['Title'] ?? ''?></td>
                        </tr>
                        <tr>
                            <th>Network ID</th>
                            <td scope="row"><?=$NetworkData['NetID'] ?? ''?></td>
                        </tr>
                        <tr>
                            <th>Network Name</th>
                            <td scope="row"><?=$NetworkData['Title'] ?? ''?></td>
                        </tr>
                        <tr>
                            <th>CreatedBy</th>
                            <td scope="row"><?=$LoginData['FullName'] ?? ''?></td>
                        </tr>
                        <tr>
                            <th>DateTime</th>
                            <td scope="row"><?=$FetchData['CreatedDateTime']?></td>
                        </tr>
                        <tr>
                            <th>Web URL</th>
                            <td scope="row"><?=$FetchData['webUrl']?></td>
                        </tr>
                        <tr>
                            <th>Treacking URL</th>
                            <td scope="row"><?=$FetchData['trackingLink']?></td>
                        </tr>
                        <tr>
                            <th>Fb URL</th>
                            <td scope="row"><?=$FetchData['fbUrl']?></td>
                        </tr>
                        <tr>
                            <th>Landing Link</th>
                            <td scope="row"><?=$FetchData['landingLink']?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td scope="row"><?=$FetchData['description']?></td>
                        </tr>


                        </thead>
                    </table>


                </div>

            </div>


        </div>
    </div>



    <div class="card">
        <div class="card-header card-header-action tabdesignbox"><?=TXT_REGISTER_NO.' ('.($LoginData['RegID'] ?? '').')'?></div>
        <div class="card-body">
            <div class="form-row">
                <div class="table-responsive">
                    <table class="table table-info table-bordered mb-0">
                        <thead class="thead-info">
                        <tr>
                            <th width="200"><?=TXT_NAME?></th>
                            <td scope="row"><?=$LoginData['FullName'] ?? ''?></td>
                        </tr>
                        <tr>
                            <th><?=TXT_GENDER?></th>
                            <td scope="row"><?= (($LoginData['Gender'] ?? '') == 1) ? TXT_MALE : TXT_FEMALE ?></td>
                        </tr>
                        <tr>
                            <th><?=TXT_DOB?></th>
                            <td scope="row"><?=onlydateshortformat($LoginData['DOB'] ?? '')?></td>
                        </tr>

                        <tr>
                            <th><?=TXT_EMAIL?></th>
                            <td scope="row"><?=$LoginData['Email'] ?? ''?></td>
                        </tr>
                        <tr>
                            <th><?=TXT_MOBILE?></th>
                            <td scope="row"><?=$LoginData['Mobile'] ?? ''?></td>
                        </tr>

                        <tr>
                            <th><?=TXT_NATIONALITY?></th>
                            <td scope="row"><?=($LoginData['NationalityID'] ?? '') !== '' ? getFieldDataByID("Nationality".LANG_SEP_DB,"TableID",$LoginData['NationalityID'],"tblcountries") : ''?></td>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>


<?php

}
?>



<style>
.databox{
	transform: scale(0.5);
}
ul{
	list-style:none;
	padding:0;
	margin:0;
}
table, table tr, table tr td{
	padding:0;
	margin:0;
}
/*video::-webkit-media-controls {
  display: none;
}
video::-webkit-media-controls-play-button {}

video::-webkit-media-controls-volume-slider {}

video::-webkit-media-controls-mute-button {}

video::-webkit-media-controls-timeline {}

video::-webkit-media-controls-current-time-display {}
video{background:#000; padding:0; margin:0}*/
</style>

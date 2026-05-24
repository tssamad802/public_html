<?php
if (!isset($RUNFILE_FROM_INDEX_PAGE)) {
    die("Direct Access Not Allowed");
}


// $Query="select count(TableID) as stores , (select count(TableID)  from tblstore where Active = 1) as enableStores ,
//         (select count(TableID) from tblstore where Active = 0) as disableStores from tblstore";

$Query = "select count(*) as stores , (SELECT count(*) FROM tblstore s INNER JOIN `tblcountry` c ON (s.`CountryID` = c.`TableID`) 
INNER JOIN `tblsystemusers` u ON (u.`TableID` = s.`CreatedBy`) 
INNER JOIN tblnetwork n ON (n.`TableID` = s.`NetworkID`) where s.Active = 1) as enableStores , (SELECT count(*) FROM tblstore s INNER JOIN `tblcountry` c ON (s.`CountryID` = c.`TableID`) 
INNER JOIN `tblsystemusers` u ON (u.`TableID` = s.`CreatedBy`) 
INNER JOIN tblnetwork n ON (n.`TableID` = s.`NetworkID`) where s.Active = 0) as disableStores from tblstore s 
INNER JOIN `tblcountry` c ON (s.`CountryID` = c.`TableID`) 
INNER JOIN `tblsystemusers` u ON (u.`TableID` = s.`CreatedBy`)
INNER JOIN tblnetwork n ON (n.`TableID` = s.`NetworkID`) 
where s.active IN(1,0)";

// echo "<script>console.log(" . json_encode($Query) . ");</script>";

$db->query($Query);
while ($db->next_record()) {
    $TotalStore = $db->f('stores');
    $TotalEnable = $db->f('enableStores');
    $TotalDisable = $db->f('disableStores');
}
$Query = "SELECT COUNT(*) AS TotalCoupon ,
    (SELECT COUNT(*) FROM `tblcoupon` c 
INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`) 
INNER JOIN  `tblsystemusers` u ON (u.`TableID` = c.`CreatedBy` ) WHERE c.Active = 1) AS EnableCoupon , 
    (SELECT COUNT(*) FROM `tblcoupon` c 
INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`) 
INNER JOIN  `tblsystemusers` u ON (u.`TableID` = c.`CreatedBy` ) where c.Active = 0) AS DisableCoupon ,
     (SELECT COUNT(*) FROM `tblcoupon` c 
INNER JOIN `tblstore` s ON (c.`StoreID` = s.`TableID`) 
INNER JOIN  `tblsystemusers` u ON (u.`TableID` = c.`CreatedBy` ) where c.featured = 1) AS featured FROM tblcoupon";


$db->query($Query);
while ($db->next_record()) {
    $TotalCoupon = $db->f('TotalCoupon');
    $TotalEnableCoupon = $db->f('EnableCoupon');
    $TotalDisableCoupon = $db->f('DisableCoupon');
    $Featured = $db->f('featured');
}

$Query = "SELECT COUNT(*) AS TotalProduct  ,
(SELECT COUNT(*) FROM tblproduct p 
INNER JOIN `tblstore` s ON (p.`StoreID` = s.`TableID`) 
INNER JOIN  `tblsystemusers` u ON (u.`TableID` = p.`CreatedBy` ) WHERE p.Active = 1) AS EnableProduct  , 
(SELECT COUNT(*) FROM tblproduct p 
INNER JOIN `tblstore` s ON (p.`StoreID` = s.`TableID`) 
INNER JOIN  `tblsystemusers` u ON (u.`TableID` = p.`CreatedBy` ) WHERE p.Active = 0) AS DisableProduct  ,
(SELECT COUNT(*) FROM `tblproduct`p INNER JOIN `tblstore` s ON (p.`StoreID` = s.`TableID`) 
INNER JOIN  `tblsystemusers` u ON (u.`TableID` = p.`CreatedBy` ) WHERE p.featured = 1) AS featured FROM tblproduct";

$db->query($Query);
while ($db->next_record()) {
    $TotalProduct = $db->f('TotalProduct');
    $TotalEnableProduct = $db->f('EnableProduct');
    $TotalDisableProduct = $db->f('DisableProduct');
    $FeaturedProduct = $db->f('featured');
}

$Query = "SELECT COUNT(*) AS TotalNetwork  ,
(SELECT COUNT(*)  FROM `tblnetwork` WHERE Active = 1) AS EnableNetwork  , 
(SELECT COUNT(*) FROM `tblnetwork` WHERE Active = 0) AS DisableNetwork  FROM `tblnetwork`";
$db->query($Query);
while ($db->next_record()) {
    $TotalNetwork = $db->f('TotalNetwork');
    $TotalEnableNetwork = $db->f('EnableNetwork');
    $TotalDisableNetwork = $db->f('DisableNetwork');
}

$Query = "SELECT COUNT(*) AS TotalCategory  ,
(SELECT COUNT(*)  FROM `tblcategory` WHERE Active = 1) AS EnableCategory , 
(SELECT COUNT(*) FROM `tblcategory` WHERE Active = 0) AS DisableCategory  FROM tblcategory";
$db->query($Query);
while ($db->next_record()) {
    $TotalCategory = $db->f('TotalCategory');
    $TotalEnableCategory = $db->f('EnableCategory');
    $TotalDisableCategory = $db->f('DisableCategory');
}

//$Query = "SELECT COUNT(*) Total , (SELECT COUNT(*) FROM tblstore s INNER JOIN tblnetwork n ON(s.`NetworkID` = n.`TableID`)
//            WHERE s.Active = 1) AS enabled ,  (SELECT COUNT(*) FROM tblstore s
//            INNER JOIN tblnetwork n ON(s.`NetworkID` = n.`TableID`) WHERE s.Active = 0) AS disabled
//            FROM tblstore s INNER JOIN tblnetwork n ON(s.`NetworkID` = n.`TableID`)";
$Query = "SELECT COUNT(*) Total , (SELECT COUNT(*) FROM tblnetwork WHERE Active = 1) AS enabled ,  (SELECT COUNT(*) FROM tblnetwork 
            WHERE Active = 0) AS disabled FROM tblnetwork";
$db->query($Query);
$networks = '';
while ($db->next_record()) {
    $networks .= '<div  style="background-color: #fff ; border: 1px solid;"><h4>Total Network ' . $db->f('Total') . '</h4><p style="color: green"> Enable ' . $db->f('enabled') . '</p><p style="color: red"> Disable ' . $db->f('disabled') . '</p></div>';
}

$Query = "SELECT TableID FROM `tblnetwork`";
$db->query($Query);
$NetworkTableID = array();
while ($db->next_record())
    $NetworkTableID[] = $db->f('TableID');

foreach ($NetworkTableID as $value) {
    $Query = "SELECT n.`Title` , n.Active as active , (SELECT COUNT(*) FROM tblstore s INNER JOIN tblnetwork n ON(s.`NetworkID` = n.`TableID`)
            WHERE s.Active = 1 AND n.`TableID` = $value) AS enabled ,
            (SELECT COUNT(*) FROM tblstore s INNER JOIN tblnetwork n ON(s.`NetworkID` = n.`TableID`)
            WHERE s.Active = 0 AND n.`TableID` = $value) AS disabled FROM tblstore s
            INNER JOIN tblnetwork n ON(s.`NetworkID` = n.`TableID`)
            WHERE n.`TableID` = $value GROUP BY n.`TableID`";
    $db->query($Query);


    $data = '';
    while ($db->next_record()) {
        $color = ($db->f('active') == 0) ? "red" : "black";
        $data .= '<div  style="background-color: #fff ; border: 1px solid;"><h4 style="color: ' . $color . '">' . $db->f('Title') . '</h4><p style="color: green"> Enable ' . $db->f('enabled') . '</p><p style="color: red"> Disable ' . $db->f('disabled') . '</p></div>';
    }
}

?>
<style>
    p {
        font-weight: bold;
    }

    h4 {
        /*color: #3F57DD;*/
        font-family: Arial;
        font-weight: bold;
    }
</style>
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">


        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <!--                --><?//=WEB_SESSION; ?>
            </div>
        </div>
    </div>

    <section class="results m-t-30">

        <div class="container">

            <div class="row">
                <div class="col-md-4" style="background-color: #fff ; border: 1px solid;">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Total Stores <?= $TotalStore ?></h4>
                            <p style="color: green">Enable Stores <?= $TotalEnable ?></p>
                            <p style="color: red">Disable Stores <?= $TotalDisable ?></p>
                        </div>
                        <div class="col-md-12" style="background-color: #fff ; border: 1px solid">
                            <h4>Total Coupon <?= $TotalCoupon ?></h4>
                            <p style="color: green">Enable Coupon <?= $TotalEnableCoupon ?></p>
                            <p style="color: red">Disable Coupon <?= $TotalDisableCoupon ?></p>
                            <p style="color: cornflowerblue">Featured Coupon <?= $Featured ?></p>
                        </div>

                        <div class="col-md-12" style="background-color: #fff ; border: 1px solid">
                            <h4>Total Product <?= $TotalProduct ?></h4>
                            <p style="color: green">Enable Product <?= $TotalEnableProduct ?></p>
                            <p style="color: red">Disable Product <?= $TotalDisableProduct ?></p>
                            <p style="color: cornflowerblue"> Featured Product <?= $FeaturedProduct ?></p>
                        </div>

                        <div class="col-md-12" style="background-color: #fff ; border: 1px solid">
                            <h4>Total Network <?= $TotalNetwork ?></h4>
                            <p style="color: green">Enable Network <?= $TotalEnableNetwork ?></p>
                            <p style="color: red">Disable Network <?= $TotalDisableNetwork ?></p>
                        </div>

                        <div class="col-md-12" style="background-color: #fff ; border: 1px solid">
                            <h4>Total Category <?= $TotalCategory ?></h4>
                            <p style="color: green">Enable Category <?= $TotalEnableCategory ?></p>
                            <p style="color: red">Disable Category <?= $TotalDisableCategory ?></p>
                        </div>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Networks</h3>
                            <?= $networks ?>
                            <?= $data ?>
                        </div>
                        <!--        </div>-->
                    </div>

                </div>
                <!-- /Row -->

            </div>
        </div><!-- /Container -->

        <style>
            .firsetbox .iconsandtext {
                border-bottom: 1px solid #f9e7e7
            }

            .firsetbox .textbar {
                color: #b26d6d;
            }

            .textbar {
                text-transform: uppercase;
                font-size: 20px;
                display: flex;
                align-items: center;
                min-height: 40px;
                text-align: center;
            }

            .textbar span {
                text-align: center;
                display: block;
                width: 100%;
            }

            .firsetbox {
                border: 1px solid #f9e7e7;
                border-radius: 10px;
            }

            .texttureboxbg {
                background: url(images/textturebox.png) repeat-x;
                border-radius: 10px;
                margin-bottom: 10px;
                text-align: center;
            }

            .firsetbox {
                background: rgba(254, 235, 235, 0.8);
            }

            .iconsandtext {
                display: flex;
                align-items: center;
                min-height: 80px;
            }

            .firsetbox .iconsandtext {
                background: url(images/videoicon.png) 95% 10px no-repeat;
            }

            .firsetbox .iconsandtext span {
                color: #b26d6d;
            }

            .iconsandtext span {
                text-align: center;
                display: block;
                width: 100%;
            }

            .secondbox {
                border: 1px solid #d6eef0;
                border-radius: 10px;
            }

            .secondbox .iconsandtext {
                border-bottom: 1px solid #d6eef0;
            }

            .secondbox {
                background: rgba(234, 250, 254, 0.8);
            }

            .secondbox .iconsandtext {
                background: url(images/imageicon.png) 95% 10px no-repeat;
            }

            .secondbox .iconsandtext span {
                color: #8cc1bf;
            }

            .secondbox .textbar {
                color: #8cc1bf;
            }

            .thirdbox {
                border: 1px solid #d5c9f4;
                border-radius: 10px;
            }

            .thirdbox .iconsandtext {
                border-bottom: 1px solid #d5c9f4;
            }

            .thirdbox {
                background: rgba(247, 234, 254, 0.8);
            }

            .thirdbox .iconsandtext {
                background: url(images/signageicon.png) 95% 10px no-repeat;
            }

            .thirdbox .iconsandtext span {
                color: #8370b3;
            }

            .thirdbox .textbar {
                color: #8370b3;
            }

            .fourbox {
                border: 1px solid #e2e6ca;
                border-radius: 10px;
            }

            .fourbox .iconsandtext {
                border-bottom: 1px solid #e2e6ca;
            }

            .fourbox {
                background: rgba(251, 254, 234, 0.8);
            }

            .fourbox .iconsandtext {
                background: url(images/deviceicon.png) 95% 10px no-repeat;
            }

            .fourbox .iconsandtext span {
                color: #b69d76;
            }

            .fourbox .textbar {
                color: #b69d76;
            }

            .activedevice {
                border: 1px solid #bde8e3;
                border-radius: 10px;
                background: #def8f5;
                color: #6b6b6b;
                text-align: center;
                margin-bottom: 15px;
            }

            .inactivedevice {
                border: 1px solid #f0d3d4;
                border-radius: 10px;
                background: #ffeced;
                color: #6b6b6b;
                text-align: center;
                margin-bottom: 15px;
            }

            .activedevice .devicename {
                margin: 0 5px;
                padding: 10px 0;
                border-bottom: 1px solid #bde8e3;
                font-size: 16px;
            }

            .inactivedevice .devicename {
                margin: 0 5px;
                padding: 10px 0;
                border-bottom: 1px solid #f0d3d4;
                font-size: 16px;
            }

            .deviceicons {
                margin: 10px 0px;
            }

            .campaignname {
                margin: 10px 0px;
                font-size: 14px;
            }

            .activedevice .upsignbox {
                height: 64px;
                background: url(images/upsign.png) no-repeat top center;
            }

            .signdatetime {
                margin: 10px 0px;
                font-size: 16px;
            }

            .inactivedevice .upsignbox {
                height: 64px;
                background: url(images/downsign.png) no-repeat top center;
            }
        </style>
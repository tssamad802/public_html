<?php

if (!isset($RUNFILE_FROM_INDEX_PAGE)) {
    die("Direct Access Not Allowed");
}
$randomnumber = rand(100, 1000);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $_SERVER['HTTP_HOST'] ?></title>
    <!-- vector map CSS -->
    <link href="vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />



    <!-- Bootstrap Dropzone CSS -->
    <link href="vendors/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css"/>


    <!-- Toggles CSS -->
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">

    <!-- select2 CSS -->
    <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Data Table CSS -->
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

    <!-- Lightgallery CSS -->
    <link href="vendors/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">

    <!-- Toggles CSS -->
    <!--    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">-->
    <!--    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">-->

    <!-- Toastr CSS -->
    <link href="vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">

    <!-- bxslider CSS -->
    <link href="dist/css/jquery.bxslider.css" rel="stylesheet" type="text/css">

    <!-- croppie CSS -->
    <link href="dist/css/croppie.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <!-- Daterangepicker CSS -->
    <link href="vendors/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />

    <link href="css/style<?= LANG_SEP_DB ?>.css" rel="stylesheet" type="text/css" />

    <link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Jasny-bootstrap  JavaScript -->
    <script src="vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <!-- Slimscroll JavaScript -->
    <script src="dist/js/jquery.slimscroll.js"></script>

    <!-- Fancy Dropdown JS -->
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="dist/js/feather.min.js"></script>

    <!-- Counter Animation JavaScript -->
    <script src="vendors/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="vendors/jquery.counterup/jquery.counterup.min.js"></script>

    <!-- EChartJS JavaScript -->
    <script src="vendors/echarts/dist/echarts-en.min.js"></script>

    <!-- Sparkline JavaScript -->
    <script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>

    <!-- Vector Maps JavaScript -->
    <script src="vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="dist/js/vectormap-data.js"></script>

    <!-- Owl JavaScript -->
    <script src="vendors/owl.carousel/dist/owl.carousel.min.js"></script>

    <!-- Toastr JS -->
    <script src="vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>

    <!--sorting table -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>



    <!-- Dropzone JavaScript -->
    <script src="vendors/dropzone/dist/dropzone.js"></script>

    <!--<script src="dist/js/printdiv.js"></script>-->


    <script src="dist/js/dashboard-data.js"></script>

    <script src="dist/js/validation-data.js"></script>

    <script src="dist/js/common.js"></script>

    <script type="application/javascript">
    window.NoRecordFound = "<?php echo DSB_NO_RECORDS; ?>";
    </script>


    <script type="text/javascript">
    //var windowwidth = $(window).width();
    window.DomainName = "<?php echo DOMAINNAME; ?>";
    window.Confirm = "<?php echo TXT_PROCEEED_ACTION; ?>";
    window.Cancel = "<?php echo TXT_CANCEL_ACTION; ?>";
    window.Direction = "left";
    window.MenuName = "Menu";
    window.PasswordLength = "<?= $website_config['PasswordLength'] ?>";
    window.idlevalmin = "<?= $website_config['InactivePeriod'] ?>";
    window.PasswordValidate = "Sorry, the password does not match";
    window.EnglishFieldValidation = "Please enter title";
    window.TxtActive = "Active";
    window.TxtInActive = "Inactive";
    window.TxtEnglish = "<?= TXT_TITLE_ENGLISH ?>";
    //window.TxtArabic = "<?//=TXT_TITLE_ARABIC ?>//";
    window.TxtEnglishERROR = "<?= ERROR_TITLE_ENGLISH ?>";
    //window.TxtArabicERROR = "<?//=ERROR_TITLE_ARABIC ?>//";

    // var showPreloader = false;
    // $(".preloader-it").show();
    
    // if($("#couponSorting").length == 0) {
    //   var showPreloader = true;
    //   $(".preloader-it").hide();
    // }

    </script>

</head>

<body>

    <?php
    $hkverticalnav = '';
    if (isset($_SESSION[WEB_SESSION . '_userid']) && $_SESSION[WEB_SESSION . '_userid'] != '') {
        $hkverticalnav = "hk-vertical-nav";
    }
    ?>
    <div id="printdivbox" style="display:none"></div>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->
    <div class="hk-wrapper <?= $hkverticalnav ?>">
        <?php
        if (isset($_SESSION[WEB_SESSION . '_userid']) && $_SESSION[WEB_SESSION . '_userid'] != '') {
            checkActiveAdminUser();
            ?>
                        <!--<div id="inlinevideocontentss" style="display:none">
            <div class="countdown countdownbox"></div>
            <div class="staylogbox"><a href="index.php"><?= TXT_STAY_LOGIN ?></a></div>
        </div>-->

                        <div id="myModal" class="modal">
                          <!-- Modal content -->
                          <div class="modal-content">
                            <span class="close">&times;</span>
                            <div class="countdown countdownbox"></div>
                           <div class="staylogbox"><a onclick="stoptimer()"><?= TXT_STAY_LOGIN ?></a></div>
                          </div>

                        </div>

                        <nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar">
                            <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><span
                                    class="feather-icon"><i data-feather="menu"></i></span></a>
                            <a class="navbar-brand" href="index.php">
                                <img class="brand-img" src="images/admin.jpg" height="45" alt="brand" />
                            </a>
                            <ul class="navbar-nav hk-navbar-content">

                                <li class="nav-item dropdown dropdown-authentication">
                                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <div class="media">
                                            <div class="media-img-wrap">
                                                <div class="avatar">
                                                    <img src="dist/img/avatar12.jpg" alt="user" class="avatar-img rounded-circle">
                                                </div>
                                                <span class="badge badge-success badge-indicator"></span>
                                            </div>
                                            <div class="media-body">
                                                <span><?= $UserRecordGetting['FullName'] ?><i class="zmdi zmdi-chevron-down"></i></span>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                    if (CheckModulePermission($UserRecordGetting['TableID'], 45, "EditPermissions") == 1) {
                                        $changepasswordurl = 'index.php?' . EncodeUrl('action=changepassword&SubLinkID=45');
                                        $changepasswordonclick = '';
                                    } else {
                                        $changepasswordurl = "javascript:;";
                                        $changepasswordonclick = 'onClick="alert(\'' . TXT_PERMISSION_ERROR . '\')"';
                                    }
                                    ?>
                                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX"
                                        data-dropdown-out="flipOutX">
                                        <a class="dropdown-item" href="<?= $changepasswordurl ?>" <?= $changepasswordonclick ?>><i
                                                class="dropdown-icon zmdi zmdi-account"></i><span><?= CHANGE_PASS ?></span></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"><i class="dropdown-icon zmdi zmdi-settings"></i><span><?= LAST_LOGIN ?>:
                                                <?= date("jS F Y g:i:s a", strtotime($UserRecordGetting['LastloginDateTime'])) ?>
                                            </span></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout.php"><i
                                                class="dropdown-icon zmdi zmdi-power"></i><span><?= LOGOUT ?></span></a>
                                    </div>
                                </li>
                            </ul>
                        </nav>



                        <nav class="hk-nav hk-nav-dark" id="navbarbox">
                            <a href="javascript:void(0);" style="background:none" id="hk_nav_close" class="hk-nav-close"><span
                                    class="feather-icon"><i data-feather="x"></i></span></a>
                            <div class="nicescroll-bar">
                                <div class="navbar-nav-wrap">
                                    <ul class="navbar-nav flex-column">

                                        <?php
                                        $MasterLinkMenu = "Select TableID, MenuName,IconClass,MenuNameAr from tblmasterlinks where Active=1 order By Sequence";
                                        $db->query($MasterLinkMenu);
                                        while ($db->next_record()) {
                                            $attopenattr = '';
                                            $openmenuclass = '';
                                            $openmenuactiveclass = '';
                                            if (isset($_REQUEST['SubLinkID'])) {
                                                $GetMasterLink = getFieldDataByID("MasterLinkID", "TableID", $_REQUEST['SubLinkID'], "tblsublinks");
                                                if ($GetMasterLink == $db->f(0)) {
                                                    $attopenattr = 'aria-expanded="true"';
                                                    $openmenuclass = 'show';
                                                    $openmenuactiveclass = 'active';
                                                }
                                            }
                                            ?>
                                                        <?php
                                                            $masterLinkId = (int) $db->f('TableID');
                                                            $sublinkTree = buildAdminNavSublinkTree($masterLinkId);
                                                            $sublinkNavHtml = renderAdminNavSublinkTreeHtml($sublinkTree, $UserRecordGetting['TableID']);
                                                            ?>
                                                        <li class="nav-item <?= $openmenuactiveclass ?>">
                                                            <?php if ($sublinkNavHtml !== '') { ?>
                                                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                                                data-target="#mainopen<?= $masterLinkId ?>" <?= $attopenattr ?>>
                                                                <span class="feather-icon"><i data-feather="<?= $db->f(2) ?>"></i></span>
                                                                <span class="nav-link-text"><?= $db->f('MenuName' . LANG_SEP_DB) ?></span>
                                                            </a>
                                                            <?php } else { ?>
                                                            <span class="nav-link">
                                                                <span class="feather-icon"><i data-feather="<?= $db->f(2) ?>"></i></span>
                                                                <span class="nav-link-text"><?= $db->f('MenuName' . LANG_SEP_DB) ?></span>
                                                            </span>
                                                            <?php } ?>
                                                            <?php
                                                            if ($sublinkNavHtml !== '') {
                                                                ?>
                                                                            <ul id="mainopen<?= $masterLinkId ?>"
                                                                                class="nav flex-column collapse collapse-level-1 <?= $openmenuclass ?>">
                                                                                <li class="nav-item">
                                                                                    <ul class="nav flex-column">
                                                                                        <?= $sublinkNavHtml ?>
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                            <?php } ?>
                                                        </li>
                                        <?php } ?>

                                    </ul>



                                </div>
                            </div>
                        </nav>

                        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>


                        <?php
        }

        include_once($currentpage . ".php");
        ?>
        <div class="clearfix"></div>
        <?php
        if ($currentpage != "login") { ?>
                        <div class="footerbox">
                            <?= FOOTER_TEXT ?>
                        </div>
                        <?php
        }
        ?>
    </div>

    <?php

    //if($_SERVER['HTTP_HOST']=="192.168.0.173")
//{
//echo '<pre>';
//print_r($_REQUEST);
//echo '</pre>';
//}
    ?>




    <!-- <script src="customjs/formvalidation.js"></script>-->
    <?php
    if (isset($_SESSION['Message']['Msg'])) {
        echo '<script>';
        echo 'showweballmessages("' . $_SESSION['Message']['Msg'] . '","' . $_SESSION['Message']['Type'] . '");';
        echo '</script>';
        unset($_SESSION['Message']);
    }
    ?>




<div class="croppopupbox">

    <div class="bodyboxpopup">
        <div class="popup-header">
            <h5 class="modal-title"><?= TXT_UPLOAD_AND_CROP ?></h5>
            <button type="button" class="close closecropbtn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <div class="cropcodybox">
             <div id="image_demo"style="width:100%;"></div>
             <button class="btn btn-success crop_image"  data-value=""  style="display:block; width:100%"><?= TXT_FOOTER_TEXTCROP_BTN ?></button>
        </div>

    </div>

</div>



    <!-- Tinymce JavaScript -->
    <script src="vendors/tinymce/tinymce.min.js"></script>
    <!-- Tinymce Wysuhtml5 Init JavaScript -->
    <script src="dist/js/tinymce-data.js"></script>



    <!-- Select2 JavaScript -->
    <script src="vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="dist/js/select2-data.js"></script>



    <!-- Gallery JavaScript -->
    <script src="vendors/lightgallery/dist/js/lightgallery-all.min.js"></script>
    <script src="dist/js/froogaloop2.min.js"></script>
    <script src="dist/js/gallery-data.js"></script>



    <!-- Daterangepicker JavaScript -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/daterangepicker/daterangepicker.js"></script>
    <script src="dist/js/daterangepicker-data.js"></script>
    <!-- js slider JavaScript -->
    <script src="dist/js/jquery.bxslider.min.js?v=<?= rand(0, 100) ?>"></script>
    <!-- signage slider option -->

    <!-- Init JavaScript -->
    <script src="dist/js/init.js"></script>

    <script src="js/adminpanelscripts.js"></script>


    <script src="dist/js/croppie.js"></script>


    <?php if (isset($_SESSION[WEB_SESSION . '_userid'])) { ?>
                    <script type="text/javascript">
                    $(document).ready(function() {


                        var idleval = 1000 * 60 * window.idlevalmin;
                        ! function(n) {
                            "use strict";
                            n.fn.idle = function(e) {
                                var t, i, o = {
                                        idle: 6e4,
                                        events: "mousemove keydown mousedown touchstart",
                                        onIdle: function() {},
                                        onActive: function() {},
                                        onHide: function() {},
                                        onShow: function() {},
                                        keepTracking: !0,
                                        startAtIdle: !1,
                                        recurIdleCall: !1
                                    },
                                    c = e.startAtIdle || !1,
                                    d = !e.startAtIdle || !0,
                                    l = n.extend({}, o, e),
                                    u = null;
                                return n(this).on("idle:stop", {}, function() {
                                    n(this).off(l.events), l.keepTracking = !1, t(u, l)
                                }), t = function(n, e) {
                                    return c && (e.onActive.call(), c = !1), clearTimeout(n), e.keepTracking ? i(e) :
                                        void 0
                                }, i = function(n) {
                                    var e, t = n.recurIdleCall ? setInterval : setTimeout;
                                    return e = t(function() {
                                        c = !0, n.onIdle.call()
                                    }, n.idle)
                                }, this.each(function() {
                                    u = i(l), n(this).on(l.events, function() {
                                        u = t(u, l)
                                    }), (l.onShow || l.onHide) && n(document).on(
                                        "visibilitychange webkitvisibilitychange mozvisibilitychange msvisibilitychange",
                                        function() {
                                            document.hidden || document.webkitHidden || document.mozHidden ||
                                                document.msHidden ? d && (d = !1, l.onHide.call()) : d || (d = !
                                                    0, l.onShow.call())
                                        })
                                })
                            }
                        }(jQuery);

                        // <-- THIS IS THE JS SOURCE CODE OF Jquery.Idle --------

                        // $(document).idle({
                        //     onIdle: function() {
                        // 		timerlogout();
                        //     },
                        //     idle: idleval
                        // })
                    });
                    </script>
    <?php } ?>
    <?php if (isset($_REQUEST['messageshow'])) { ?>
                    <script>
                    showweballmessages("<?= $_REQUEST['messageshow'] ?>", 0)
                    </script>
    <?php } ?>


    <script>
    // function timerlogout() {
    //     var timer2 = "61";
    //     interval = setInterval(function() {


    //         var timer = timer2;
    //         //by parsing integer, I avoid all extra string processing
    //         var seconds = parseInt(timer, 10);
    //         --seconds;
    //         seconds = (seconds < 0) ? 59 : seconds;
    //         seconds = (seconds < 10) ? '0' + seconds : seconds;
    //         $('.countdown').html(seconds + 's');
    // 		if (seconds == 60)
    // 		{
    // 			var modal = document.getElementById("myModal");
    // 			modal.style.display = "block";
    // 		}
    //         timer2 = seconds;
    //         if (seconds == 0) {
    //             window.location.href = 'logout.php';
    //         }
    //     }, 1000);
    // }
    </script>

<script>
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
    stoptimer();
  /* modal.style.display = "none";
  location.reload(); */
}
window.onclick = function(event) {
  if (event.target == modal) {
      stoptimer();
    /* modal.style.display = "none";
    location.reload(); */
  }
}
function stoptimer(){
    modal.style.display = "none";
    clearInterval(interval);
}


</script>

</body>

</html>
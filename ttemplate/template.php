<?php
if(!isset($RUNFILE_FROM_INDEX_PAGE))
{
    die("Direct Access Not Allowed");
}
$rand = rand(1,100);
$backgroundImage = ($_REQUEST['option'] == 'sport-complex-form')?'background-image: url(images/sport-bg.png) !important;':'';
?>
<!DOCTYPE HTML>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta name='ir-site-verification-token' value='-909494478' />
    <meta name='linkapprove-verification' content='40280de3-68f0-44ed-8ffb-8e43fe3880a7' />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo RESOURCES_DOMAIN;?>/assets/images/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="shortcut icon" href="<?php echo RESOURCES_DOMAIN;?>/assets/img/favicon.png" />

    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title><?php echo $meta_data['Title'];?></title>

    <meta name="keywords" content="<?php echo $meta_data['Keywords'];?>" />

    <meta name="description" content="<?php echo $meta_data['Description'];?>" />

    <?php echo $meta_data['Others'];?>

    <meta content="Federal Authority" name="classification" />

    <meta content="<?php echo $_SESSION["LANGUAGE"];?>-gb" name="language" />

    <meta name="Language" content="<?php echo $_SESSION['LANGUAGE'];?>" />

    <!-- Custom CSS -->
    <link rel="shortcut icon" href="#">
    <link href="<?php echo RESOURCES_DOMAIN;?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo RESOURCES_DOMAIN;?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo RESOURCES_DOMAIN;?>/assets/css/animate.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo RESOURCES_DOMAIN;?>/assets/css/animsition.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo RESOURCES_DOMAIN;?>/owl.carousel/assets/owl.carousel.css" rel="stylesheet" type="text/css">
    <!-- Theme styles -->
    <link href="<?php echo RESOURCES_DOMAIN;?>/assets/css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="<?php echo RESOURCES_DOMAIN;?>/assets/css/style.css" rel="stylesheet" type="text/css">
    
     <link href="<?php echo RESOURCES_DOMAIN;?>/assets/css/font-awesome.all.min.css" rel="stylesheet" type="text/css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />-->

  
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->
    
     <script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/assets/js/html5shiv3_7_0.js"></script>
     
    <script src="https://kit.fontawesome.com/5a776f6cb5.js" crossorigin="anonymous" defer></script>
    <script language="javascript">
        window.DomainName = "<?php echo DOMAINNAME;?>";
    </script>


    <script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/assets/js/jquery.min.js"></script>
    

    
    <script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/assets/js/jquery-ui.js"></script>
    <script src="<?=RESOURCES_DOMAIN?>/include/common.js"></script>
    <script type="application/javascript">

        function SearchResult() {
            console.log("ok ok ")
            window.location = "<?=RESOURCES_DOMAIN?>/search/html?q="+$("#search_store").val();
        }

        $( document ).ready(function() {
            quickview();
        });
        function quickview()
        {
            $('.quickview').click(function(){
                var url = $(this).data('href');
                // var trackurl = $(this).data('data-tracking');
                // if(trackurl!='') {
                //     window.open(trackurl);
                // }
                $.ajax({
                    url: url,
                    type: "POST",
                    contentType: false,
                    cache: false,
                    //async: false,
                    processData:false,
                    success: function(data)
                    {
                        $('#SetData').html(data);
                    },
                    beforeSend: function(){
                    },
                    error: function(m){
                        console.log();
                    },
                    complete: function(){
                    }
                });
                $('#show_details').modal('show');

            });
        }
    </script>
</head>

<body>
    
<meta name="google-adsense-account" content="ca-pub-8238402763428645">
<meta name="google-adsense-account" content="ca-pub-3842264704005331">

<div class="progress">
    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0"
         aria-valuemax="100" aria-label="loading progress"></div>
</div>
</div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"aria-hidden="true"></i></button>
                <h4 class="modal-title" id="myLargeModalLabel">Search Here</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" class="form-control control-search" placeholder="Type & hit enter...">
                    <span class="input-group-btn">
                            <button class="btn btn-defjault button_search" type="button"><i data-toggle="dropdown" class="icons icon-magnifier dropdown-toggle"></i></button>
                        </span>
                </div>

            </div>
        </div>
    </div>
</div>
 <!--End pushmenu -->
<div class="wrappage" style="<?=$backgroundImage  ?>">
    <header class="header">
        <div class="top-nav  navbar m-b-0 b-0">
            <div class="container">
                <div class="row">
                    <!-- LOGO -->
                    <div class="topbar-left col-sm-3 col-xs-6">
                        <a href="<?=RESOURCES_DOMAIN?>" class="logo" aria-label="grab discount codes logo"> <img src="<?=RESOURCES_DOMAIN?>/assets/images/logo.png" alt="" class="img-responsive" style="width: auto !important;" fetchpriority="high"> </a>
                    </div>


 
                    <!-- End Logo container-->
                    <div class="menu-extras col-sm-9 col-xs-6">
                        <ul class="nav navbar-nav navbar-right pull-right">
                              <li>
<!--                            RESOURCES_DOMAIN/predefinedpages/search-->
                            <form class="app-search pull-left hidden-xs" action="" method="get">
                                
                              
                                    <div class="input-group search-width">
                                       <input class="form-control topsearchbox" placeholder="Search 20000+ stores coupon" name="q" id="search_store" aria-label="Search for coupons">
                                       
                                        <!--<button data-toggle="dropdown" aria-expanded="true" class="dropdown-toggle profile btn btn-success" value="" type="submit" title="search" onclick="SearchResult()"><i class="fas fa-search"></i></button>-->
                                    </div>
                               
                                
                                <!-- <li class="dropdown user-box"> -->
<!--                                    <input type="submit" value="Search" data-toggle="dropdown" aria-expanded="true" class="dropdown-toggle profile btn btn-success"> -->
                                <!-- </li> -->
                                <!--                                    <a href="" class="dropdown-toggle profile btn btn-default" data-toggle="dropdown" aria-expanded="true">-->
                                <!--                                        Search-->
                                <!--                                    </a>-->

                            </form>
                             </li>
                        </ul>
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle" href='', aria-label="navbar toggle">
                                <div class="lines"> <span></span> <span></span> <span></span> </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-custom shadow">
            <div class="container">
                <div id="navigation">
                    <!-- Navigation Menu-->
                    <?php
                        $finalnav = '';
                        $objPages->loadFrontNavigation(0,$CurrentLang,$CURRENT_ACTIVE_INDEX,'ShowInNav',$finalnav,0);
                        echo $finalnav;
                    ?>
                   
                   <style>
                   

    @media screen and (min-width:988px) and (max-width:4000px) {
        #couponarea {
            float:right;
           // margin-right:100px;
                 }
                }
                

                   </style>
            
                   
                    <ul class="navigation-menu" id="couponarea" style="padding:20px 0px 15px 15px">
                        <?php $objPages->loadTag(); ?>
                    </ul>
                </div>
            </div>

        </div>
    </header>
     <!--header -->
    <?php //echo $currentpage;

    $StoreName = include_once($currentpage.".php");
//    $store = "Store";
//    if($currentpage == "")

    ?>

    <div id="back-to-top">
        <i class="fa fa-long-arrow-up"></i>
    </div>

    <!--   Footer here -->
<!--    <footer id="footer">-->
<!--    </footer>-->
    <footer id="footer" class="footer-1">
        <div class="main-footer widgets-dark typo-light">
            <div class="container">
                <div class="row">

<!--                    <div class="col-xs-12 col-sm-6 col-md-3">-->
<!--                        <div class="widget subscribe no-box">-->
<!--                            <h4 class="widget-title">COMPANY NAME<span></span></h4>-->
<!--                            <p>About the company, little discription will goes here.. </p>-->
<!--                        </div>-->
<!--                    </div>-->
<?php
                                    $sql = "select * from tblwebsiteconfiguration  ";
                                    $db->query($sql);
                                    while($db->next_record()){
                                        if($db->f('Title')=='Facebook Link'){
                                            $Facebook = $db->f('Value');
                                        }
                                        if($db->f('Title')=='Twitter Link'){
                                            $Twitter = $db->f('Value');   
                                        }
                                        if($db->f('Title')=='Instagram Link'){
                                            $Instagram= $db->f('Value');
                                        }
                                    }
                                ?>

                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="widget no-box">
                            <h4 class="widget-title">Recently Added Stores <span></span></h4>
                            <ul class="thumbnail-widget">
                                <?php
                                    $sql = "select * from tblstore order by TableID desc limit 14 ";
                                    $db->query($sql);
                                    while($db->next_record()){
                                ?>
                                <li>
                                    <div class="thumb-content"><a href="<?=$db->f('url')?>"><?=$db->f('name')?> Coupon</a></div>
                                </li>
                               <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="widget no-box">
                            <h4 class="widget-title">Follow Us!<span></span></h4>
                            <ul class="thumbnail-widget">

                                <li>
                                    <div class="thumb-content"><a href="<?=$Facebook?>">Follow on Facebook</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$Twitter?>">Follow on Twitter</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$Instagram?>">Follow on Instagram</a></div>
                                </li>

                            </ul>
                            <h4><?=$StoreName[0]?> Coupon Alert!</h4>
                            <p>Don't miss a single <?=$StoreName[0]?> coupon. Receive coupons for <?=$StoreName[0]?> by email, subscribe now!</p>
                            <input type="text" placeholder="Name" class="form-control">
                            <input type="Email" placeholder="Email" id="email" class="form-control">
                            <button class="btn btn-primary" id="submit">Subscribe</button>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4">

                        <div class="widget no-box">
                            <h4 class="widget-title">Latest Searches<span></span></h4>

                            <ul class="thumbnail-widget">

                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?>  coupon code</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> promo code</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> discount code</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> christmas coupons</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> thanksgiving coupons</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> new year coupons</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> free shipping Code</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> voucher codes</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> gutscheincode</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> rabattcode</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> black friday coupon</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> cyber monday coupon</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> discount coupons</a></div>
                                </li>
                                <li>
                                    <div class="thumb-content"><a href="<?=$StoreName[1]?>"><?=$StoreName[0]?> helloween coupon codes</a></div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Copyright <?=$_SERVER['HTTP_HOST']?> © <span id="year"> </span>. All rights reserved.</p>
                        <p>This page contains information about <?=$StoreName[0]?> Coupon Codes,<?=$StoreName[0]?> Promo Codes & <?=$StoreName[0]?> Discount Coupons </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>


</div>


<div class="modal fade" id="show_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true" style="z-index:9999">
    <div class="modal-dialog modal-lg" role="document">
        <div id="SetData">
        </div>
    </div>
</div>

<script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
</script>

<script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/js/store.js"></script>
<script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/js/jquery.bxslider.js"></script>
<script type="text/javascript" src="<?php echo RESOURCES_DOMAIN;?>/js/jquery.colorbox-min.js"></script>
<script src="<?php echo RESOURCES_DOMAIN;?>/js/moment/min/moment.min.js"></script>
<script src="<?php echo RESOURCES_DOMAIN;?>/js/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo RESOURCES_DOMAIN;?>/js/daterangepicker-data.js"></script>

<script>
    $('#submit').click(function (){
        let email = $('#email').val();
        function validateEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

        if(validateEmail(email)) {
            $.post("https://<?=$_SERVER['HTTP_HOST']?>/predefinedpages/subscriber.php ", {email : email} , (data) => {
                console.log(data);
                $('#email').val()
                alert("Email Inserted Successfully")
            });
        }
        else
            alert("email is not valid");
    })
</script>

<?php
if(!isset($_REQUEST['option']) && !isset($_REQUEST['suboption']) && !$_SESSION['popupview'.LANG_SEP_DB]){
    //$_SESSION['popupview'.LANG_SEP_DB] = 1;
    $PopActive = 0;
    $SliderActive = 0;
    $currentdate = date('Y-m-d');
    $popQuery = "select Title,TypeID,ParentID,Repeatvideo,Videomute,Autoplay from tbllandingpopupsetting where '".$currentdate."' >= FromDate  and '".$currentdate."' <= ToDate  and Active=1 order by FromDate DESC limit 1";
    $db->query($popQuery);
    if($db->num_rows() > 0)
    {
        $db->next_Record();
        $ParentID = $db->f('ParentID');
        $Title = $db->f('Title');
        $Repeatvideo = $db->f('Repeatvideo');
        $Videomute = $db->f('Videomute');
        $Autoplay = $db->f('Autoplay');
        $popdet = FetchRecordByID($ParentID,'TableID','tbllandingpopupcampaign');
        $Active = $popdet['Active'];
        $VideoType = $popdet['VideoType'];

        $youtubeRepeat = 0;
        $youtubeautoplay = 0;
        $youtubemuted = 0;
        if($Repeatvideo==1)
        {
            $VideoRepeat = "loop";
            $youtubeRepeat = 1;
        }
        if($Videomute==1)
        {
            $Videomuted = "muted";
            $youtubemuted = 1;
        }
        if($Autoplay==1)
        {
            $Videoautoplay = "autoplay";
            $youtubeautoplay = 1;
        }

        if($Active == 1)
        {
            if($db->f('TypeID') == 1)
            {

                $PopActive = 1;
                $SliderActive = 1;
                $query = "select * from tblsystemimages where TypeID='6' and ParentID = '".$ParentID."' order by Sequence";
                $db1->query($query);

                $popitems = '<div class="bxsliderpopup">';
                while($db1->next_Record())
                {
                    $popitems .= '<a class="item"><img class="img-responsive" src="'.RESOURCES_DOMAIN."/".FILES_FOLDER.'/'.ORIGINAL_IMAGES.'/'.$db1->f("FileName").'" width="100%" class="bxitems" /></a>';
                }
                $popitems .= '</div>';
            }
            else if($popdet['VideoType'] == 1)
            {
                $PopActive = 1;
                $url = explode("watch?v=",$popdet['FileName'])[1];
                $playlist = ($youtubeRepeat==1)?'&playlist='.$url:'';
                $videocover = ($youtubeautoplay==1)?'<div class="youtubevideocover"></div>':'';
                $popitems = $videocover.'<iframe width="100%" height="345" src="https://www.youtube.com/embed/'.$url.'?controls=0&autoplay='.$youtubeautoplay.'&mute=0&loop='.$youtubeRepeat.'&rel=0'.$playlist.'" allow="autoplay"></iframe>';
                // $popitems = '<div class="youtubevideocover">&nbsp;</div><iframe width="100%" height="345" src="https://www.youtube.com/embed/'.$url.'?rel=0?version=3&mute='.$youtubemuted.'&autoplay='.$youtubeautoplay.'&controls=0&loop='.$youtubeRepeat.'&playlist='.$url.'"  frameborder="0"></iframe>';
            }
            else if($popdet['VideoType'] == 2)
            {
                $PopActive = 1;
                $format = explode(".",$popdet['FileName'])[1];
                $videopath = RESOURCES_DOMAIN."/".FILES_FOLDER."/".UPLOAD_VIDEOS."/";
                $popitems = '<video width="100%" height="345"   '.$Videoautoplay.' '.$VideoRepeat.' muted><source src="'.$videopath.$popdet['FileName'].'" type="video/'.$format.'"></video>';
            }
        }
    }
    ?>
    <div class="modal fade mainpagepop" id="ManiPagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"   style="z-index: 9999;">
        <div class="modal-dialog modal-lg modal-dialog-center mainpagemodel" style="top: 10% !important" role="document">
            <div class="modal-content" style="width:100%">
                <div class="modal-header">
                    <h5 class="modal-title"><?=$Title?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div>
                    <?=$popitems?>
                </div>

            </div>

        </div>
    </div>
<?php if($PopActive == 1 && $SliderActive == 1){ ?>
    <script>
        $("#ManiPagePop").modal('show');
        $('.bxsliderpopup').bxSlider({
            mode: 'horizontal',
            moveSlides: 1,
            slideMargin: 0,
            infiniteLoop: false,
            minSlides: 1,
            speed: 800,
            pager: true
        });
    </script>
<?php }
else if($PopActive == 1){ ?>
    <script>
        $("#ManiPagePop").modal();
    </script>
<?php if($VideoType == 1){ ?>
    <script>
        $('#ManiPagePop').on('hidden.bs.modal', function () {
            var srciframe = $("#ManiPagePop iframe").attr("src");
            var srciframe = srciframe.replace("autoplay=1", "autoplay=0");
            $("#ManiPagePop iframe").attr("src", srciframe);
        });
    </script>
    <?php
}
} ?>
<?php } ?>

</body>
<!-- <script src="--><?//=RESOURCES_DOMAIN?><!--/assets/js/jquery.min.js></script>-->
<script src="<?=RESOURCES_DOMAIN?>/assets/js/bootstrap.min.js"></script>
<script src="<?=RESOURCES_DOMAIN?>/assets/js/animsition.min.js"></script>
<script src="<?=RESOURCES_DOMAIN?>/owl.carousel/owl.carousel.min.js"></script>
<!-- Kupon js -->
<script src="<?=RESOURCES_DOMAIN?>/assets/js/kupon.js"></script>
</html>




<body>
		<head>
		<meta name='ir-site-verification-token' value='2004503' />
			<meta name="google-site-verification" content="aYq443uM8J2OS4K68_UjCBxb37eI_eEnBNjaLAQTXHo" />
						<!-- Event snippet for Coupon conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. --></head>
			<head>
					<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-610119705"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-610119705');
</script>
<head>
        <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PCH8ZPV');</script>
<!-- End Google Tag Manager -->
</head>
<head><!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-755628043"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-755628043');
</script>
</head>
<head><!-- Event snippet for Page view conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-755628043/K8qGCKuSkPYBEIvwp-gC'});
</script>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCH8ZPV"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-16545486865"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-16545486865');
</script>
<!-- Event snippet for Page view conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-16545486865/jK8KCNSN06saEJGwwNE9',
      'value': 1.0,
      'currency': 'PKR'
  });
</script>

</body>
</Head>
</head>
<!-- Event snippet for Page view conversion page -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126366732-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-126366732-1');
</script>
   </body>
   <Body><!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(92222043, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        ecommerce:"dataLayer"
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/92222043" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script type='text/javascript'>
(function () { 
var scriptProto = 'https:' == document.location.protocol ? 'https://' : 'http://'; 
var script = document.createElement('script');
script.type = 'text/javascript';
script.async = true;
script.src = scriptProto+'js.srvtrck.com/v1/js?api_key=561669403cb69199651893d9d8719a66&site_id=444bf279c7e9499e83bfd554e576f855';
(document.getElementsByTagName('head')[0] || document.body).appendChild(script); 
})();
</script>
</Body>
 </head>
      <head><!-- Event snippet for Page view conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-610119705/HJEBCNC0jOUDEJng9qIC'});
  </script>
<!-- Event snippet for Page view conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-610119705/HJEBCNC0jOUDEJng9qIC',
      'event_callback': callback
  });
  return false;
}
</script>
</head>
<head><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8238402763428645"
     crossorigin="anonymous"></script></head>
     <head><!-- Event snippet for Page view conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-755628043/K8qGCKuSkPYBEIvwp-gC',
      'event_callback': callback
  });
  return false;
<!-- Event snippet for Website traffic conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-610119705/xn4HCNqy3dgBEJng9qIC',
      'event_callback': callback
  });
  return false;
}
<!-- Event snippet for Page View conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-11456971805/6J5OCOPbnJsZEJ2Ijtcq'});
</script>
<!-- Event snippet for Page View conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-11456902395/cWm_CJ_RqpsZEPvpidcq'});
</script>
<!-- Event snippet for Page View conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-11456877889/lwRXCNjop5sZEMGqiNcq'});
</script>
</script>

</script>
</head>
</script>
</script>
</head>
</script>
</head>
</html>
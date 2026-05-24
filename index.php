<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();

$_REQUEST['option'] = $_REQUEST['option'] ?? '';
$_REQUEST['url'] = $_REQUEST['url'] ?? '';
$_REQUEST['suboption'] = $_REQUEST['suboption'] ?? '';

$_SESSION['Frontendlanguage'] = $_SESSION['Frontendlanguage'] ?? 'en';
$_SESSION['LANGUAGE'] = $_SESSION['LANGUAGE'] ?? 'en';

include_once("classes/commonfunctions.php");        


if (isset($_REQUEST)) {
    //FilterString($_REQUEST);
}


if (!isset($_SESSION['Frontendlanguage']) || $_SESSION['Frontendlanguage'] == '')
    include_once(__DIR__ . "/lang/en.php");
else
    include_once(__DIR__ . "/lang/" . $_SESSION['Frontendlanguage'] . ".php");
//end for session and cookie for lang

//meta data
$meta_data = array();
$meta_data['Title'] = $website_config['MetaTitle'];
$meta_data['Description'] = $website_config['MetaDescription'];
$meta_data['Keywords'] = $website_config['MetaKeywords'];
$meta_data['Others'] = '';
//end meta data

// $_SESSION['TRA_LANG_SWITCH_CURL'] = genURLLangSwitch($_SESSION[TRA_FRONT_WEB_LANG]);//this is used to switch lang to avoid passing redirect link in url

//geneal objects for home page
$objNav = new DB_Sql();//this is used to get pages / navigation information
$objNav2 = new DB_Sql();//this is used to get pages / navigation information

$BreadCrumbs = array();//array for breadcrumb
$bannerImage = "";
$CURRENT_ACTIVE_INDEX = 0;
$RUNFILE_FROM_INDEX_PAGE = 'YES';
if (isset($_REQUEST['option']) && $_REQUEST['option'] != '') {

    if ($_REQUEST['option'] == 'search1') {
        $searchkeyword = $_GET['q'];
        $fdate = $_GET['fdate'];
        $tdate = $_GET['tdate'];
        $searchcat = $_GET['cat'];

        $searchkeyword = addslashes(addslashes(addslashes($searchkeyword)));
        $fdate = addslashes(addslashes(addslashes($fdate)));
        $tdate = addslashes(addslashes(addslashes($tdate)));

        $badWords = "(delete)|(update)|(union)|(insert)|(drop)|(http)|(iframe)|(frame)|(script)|(src)|(--)";

        $searchkeyword = eregi_replace($badWords, "", $searchkeyword);
        $fdate = eregi_replace($badWords, "", $fdate);
        $tdate = eregi_replace($badWords, "", $tdate);

        $searchkeyword = preg_replace("/[^0-9a-zA-Z ]/", "", $searchkeyword);
        $currentpage = "predefinedpages/pages_search";
    } else if ($_REQUEST['option'] == "policy") {
        $query = "select * from tblpages where URLKeyword='" . $_REQUEST['url'] . "'";
        $objNav->query($query);

        $currentpage = "predefinedpages/policy";
        if ($objNav->num_rows() > 0) {
            $objNav->next_record();
            $CatID = $objNav->f("TableID");
            //now fill meta data
            $meta_data['Title'] = $objNav->f("Title");
            $meta_data['Description'] = $objNav->f("MetaDescription");
            $meta_data['Keywords'] = $objNav->f("MetaKeywords");
            $meta_data['Others'] = $objNav->f("MetaOthers");

            if (file_exists(FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage"))) {
                $bannerImage = RESOURCES_DOMAIN . '/' . FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage");
            }
            $newsDate = $objNav->f("NewsDate");
            $newsTableID = $objNav->f("TableID");

            // $_SESSION['TRA_LANG_SWITCH_CURL'] = genURLLangSwitch($_SESSION[TRA_FRONT_WEB_LANG]).'news/'.$objNav->f("URLKeyword");
        }
    } else if ($_REQUEST['option'] == "products") {
        // $currentpage = "predefinedpages/product";
        $query = "select * from tblpages where URLKeyword='" . $_REQUEST['option'] . "'";
        // exit($query);
        $objNav->query($query);

        if ($objNav->num_rows() > 0) {
            $objNav->next_record();
            $currentpage = "predefinedpages/product";

            //now fill meta data
            $meta_data['Title'] = $objNav->f("Title");
            $meta_data['Description'] = $objNav->f("MetaDescription");
            $meta_data['Keywords'] = $objNav->f("MetaKeywords");
            $meta_data['Others'] = $objNav->f("MetaOthers");

        }
    } else if ($_REQUEST['option'] == STORE && $_REQUEST['url'] != '') {
        $query = "select * from tblstore where URLKeyword='" . $_REQUEST['url'] . "'";
        $objNav->query($query);
        if ($objNav->num_rows() > 0) {
            $objNav->next_record();
            $currentpage = "predefinedpages/store_detail";
            //now fill meta data
            $meta_data['Title'] = $objNav->f("MetaTitle");
            $meta_data['Description'] = $objNav->f("MetaDescription");
            $meta_data['Keywords'] = $objNav->f("MetaKeywords");
            $meta_data['Others'] = $objNav->f("MetaOthers");
            if (file_exists(FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage"))) {
                $bannerImage = RESOURCES_DOMAIN . '/' . FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage");
            }
            // $_SESSION['TRA_LANG_SWITCH_CURL'] = genURLLangSwitch($_SESSION[TRA_FRONT_WEB_LANG]).'eventdetails/'.$objNav->f("URLKeyword");
        }
    } else if ($_REQUEST['option'] == TAG && $_REQUEST['url'] != '') {
        $query = "select * from tblcoupontag where URLKeyword='" . $_REQUEST['url'] . "'";
        $objNav->query($query);
        if ($objNav->num_rows() > 0) {
            $objNav->next_record();
            $currentpage = "predefinedpages/couponTag";
            //now fill meta data
            $meta_data['Title'] = "coupons " . $objNav->f("Title") . ' ' . $_SERVER['HTTP_HOST'];
            //            if(file_exists(FILES_FOLDER.'/'.BANNER_FOLDER."/".TXT_THUMBNAIL_IMAGE_PATH.$objNav->f("BannerImage"))){
//                $bannerImage = RESOURCES_DOMAIN.'/'.FILES_FOLDER.'/'.BANNER_FOLDER."/".TXT_THUMBNAIL_IMAGE_PATH.$objNav->f("BannerImage");
        }
        //            // $_SESSION['TRA_LANG_SWITCH_CURL'] = genURLLangSwitch($_SESSION[TRA_FRONT_WEB_LANG]).'eventdetails/'.$objNav->f("URLKeyword");
//        }
    }
    //    else if($_REQUEST['option'] == STORE )
//    {
//        $currentpage = "predefinedpages/store";
//    }
    else if ($_REQUEST['option'] == CATEGORY_URL && $_REQUEST['url'] != "") {
        $query = "select * from tblcategory where URLKeyword='" . $_REQUEST['url'] . "'";
        $objNav->query($query);
        if ($objNav->num_rows() > 0) {
            $objNav->next_record();

            //now fill meta data
            $meta_data['Title'] = $objNav->f("MetaTitle");
            $meta_data['Description'] = $objNav->f("MetaDescription");
            $meta_data['Keywords'] = $objNav->f("MetaKeywords");
            $meta_data['Others'] = $objNav->f("MetaOthers");
            $currentpage = "predefinedpages/coupon_category";
        }
        // 		else
// 			$currentpage = "predefinedpages/coupon_category";
    } else if ($_REQUEST['option'] == COUPON) {
        $query = "select * from tblstore where URLKeyword='" . $_REQUEST['option'] . "'";
        $objNav->query($query);
        if ($objNav->num_rows() > 0) {
            $objNav->next_record();
            $currentpage = "predefinedpages/coupon";

            //now fill meta data
            $meta_data['Title'] = $objNav->f("MetaTitle");
            $meta_data['Description'] = $objNav->f("MetaDescription");
            $meta_data['Keywords'] = $objNav->f("MetaKeywords");
            $meta_data['Others'] = $objNav->f("MetaOthers");
            if (file_exists(FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage"))) {
                $bannerImage = RESOURCES_DOMAIN . '/' . FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage");
            }
            // $_SESSION['TRA_LANG_SWITCH_CURL'] = genURLLangSwitch($_SESSION[TRA_FRONT_WEB_LANG]).'eventdetails/'.$objNav->f("URLKeyword");
        }
    } else if ($_REQUEST['option'] == "expire-coupon") {
        $currentpage = "predefinedpages/expireCoupon";
    } else if ($_REQUEST['option'] == TYPE && $_REQUEST['url'] != "") {
        //        $currentpage = "predefinedpages/coupon";
        $query = "select * from tblcoupontype where URLKeyword='" . $_REQUEST['url'] . "'";
        $objNav->query($query);
        if ($objNav->num_rows() > 0) {
            $objNav->next_record();
            //now fill meta data
            $meta_data['Title'] = $objNav->f("Title");
            $meta_data['Description'] = $objNav->f("MetaDescription");
            $meta_data['Keywords'] = $objNav->f("MetaKeywords");
            $meta_data['Others'] = $objNav->f("MetaOthers");
            $currentpage = "predefinedpages/coupon";
        } else if ($_REQUEST['url'] == "") {
            $currentpage = "predefinedpages/coupon";
        }
    } else if ($_REQUEST['option'] == STORE || $_REQUEST['url'] != "") {
        $currentpage = "predefinedpages/coupon_detail";
        //        $query = "select * from tblstore where URLKeyword='".$_REQUEST['option']."'";
//        $objNav->query($query);
//        if($objNav->num_rows() > 0)
//        {
//            $objNav->next_record();
////            $currentpage = "predefinedpages/store_detail";
//            $currentpage = "predefinedpages/coupon_detail";
//
//            //now fill meta data
//            $meta_data['Title'] = $objNav->f("MetaTitle");
//            $meta_data['Description'] = $objNav->f("MetaDescription");
//            $meta_data['Keywords'] = $objNav->f("MetaKeywords");
//            $meta_data['Others'] = $objNav->f("MetaOthers");
//            if(file_exists(FILES_FOLDER.'/'.BANNER_FOLDER."/".TXT_THUMBNAIL_IMAGE_PATH.$objNav->f("BannerImage"))){
//                $bannerImage = RESOURCES_DOMAIN.'/'.FILES_FOLDER.'/'.BANNER_FOLDER."/".TXT_THUMBNAIL_IMAGE_PATH.$objNav->f("BannerImage");
//            }
//            // $_SESSION['TRA_LANG_SWITCH_CURL'] = genURLLangSwitch($_SESSION[TRA_FRONT_WEB_LANG]).'eventdetails/'.$objNav->f("URLKeyword");
//        }
    } else if ($_REQUEST['option'] == CATEGORY) {
        $currentpage = "predefinedpages/category";
        $query = "select * from tblpages where URLKeyword='" . $_REQUEST['url'] . "'";
        $objNav->query($query);
        if ($objNav->num_rows() > 0) {
            $objNav->next_record();
            $currentpage = "predefinedpages/category";

            //now fill meta data
            $meta_data['Title'] = $objNav->f("MetaTitle");
            $meta_data['Description'] = $objNav->f("MetaDescription");
            $meta_data['Keywords'] = $objNav->f("MetaKeywords");
            $meta_data['Others'] = $objNav->f("MetaOthers");
            if (file_exists(FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage"))) {
                $bannerImage = RESOURCES_DOMAIN . '/' . FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage");
            }
            // $_SESSION['TRA_LANG_SWITCH_CURL'] = genURLLangSwitch($_SESSION[TRA_FRONT_WEB_LANG]).'eventdetails/'.$objNav->f("URLKeyword");
        }
    } else {
        $query = "select * from tblpages where URLKeyword = '" . $_REQUEST['option'] . "'";

        $objNav->query($query);

        if ($objNav->num_rows() > 0) {

            $objNav->next_record();

            if (file_exists(FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage"))) {
                $bannerImage = RESOURCES_DOMAIN . '/' . FILES_FOLDER . '/' . BANNER_FOLDER . "/" . TXT_THUMBNAIL_IMAGE_PATH . $objNav->f("BannerImage");
            }
            if ($objNav->f("ShowInLeftNav"))
                $CURRENT_ACTIVE_INDEX = $objNav->f("TableID");
            else
                $CURRENT_ACTIVE_INDEX = ($objNav->f("ParentTableID") > 0) ? $objNav->f("ParentTableID") : $objNav->f("TableID");

            $physiclapage = $PageTypeArPages[$objNav->f("PageType")];

            if ($physiclapage != '') {
                $currentpage = "predefinedpages/" . $physiclapage;
            } else {
                $currentpage = "predefinedpages/page_articles";
            }

            //for bread
            $objPages->generateBreadCrumb($objNav, $_SESSION['TRA_FRONT_WEB_LANG'] ?? 'en', $BreadCrumbs);
            $BreadCrumbs[] = clearTextForField($objNav->f("MenuTitle"));

            //now fill meta data
            $meta_data['Title'] = $objNav->f("MetaTitle");
            $meta_data['Description'] = $objNav->f("MetaDescription");
            $meta_data['Keywords'] = $objNav->f("MetaKeywords");
            $meta_data['Others'] = $objNav->f("MetaOthers");

            $pageTemplate = $_REQUEST['option'];

        } else if ($_REQUEST['option'] == '404') {
            $currentpage = "predefinedpages/page_404";
        }
        //}
    }
    if ($currentpage == '') {
        //header('HTTP/1.0 404 Not Found');
        redirect(($_SESSION['TRA_FRONT_WEB_LANG'] ?? 'en') . '/404.html');
        //redirect user to no page found
    }
} else if (isset($_REQUEST['option']) && $_REQUEST['option'] == 'sitemap.xml') {
    $currentpage = 'sitemap.xml';
} else if (isset($_REQUEST['option']) && $_REQUEST['option'] == 'robots.txt') {
    $currentpage = 'robots.txt';
} else {
    $currentpage = 'home';
}

if (!file_exists($currentpage . ".php")) {
    $currentpage = 'home';
}

if ($bannerImage == "") {

    $bannerImage = RESOURCES_DOMAIN . '/' . FILES_FOLDER . '/' . BANNER_FOLDER . "/default-banner.jpg";
}

$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['PageURL'] = $current_link;
$pageTemplate = '';
$_SESSION['PageTemplate'] = ($pageTemplate != '') ? 'pages' : (isset($_REQUEST['option']) ? $_REQUEST['option'] : '');
//$_SESSION['PageTemplate']=$_REQUEST['option'];
$_SESSION['PageTitle'] = $objNav->f("Title");
$_SESSION['PageID'] = $objNav->f("TableID");


$_SESSION['FeedBackMessage'] = $website_config['FeedBackMessage' . LANG_SEP_DB] ?? '';

include_once("template.php");

?>
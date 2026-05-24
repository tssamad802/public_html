<?php
// error_reporting(E_ALL);
error_reporting(E_ALL);

/**
 *
 *
 *
 * @File   							Application constants
 * @Purpose    						This File will declare all the constants being used in the application
 * @Author   	  					Shehzad Asghar Saddiq
 * @Creation Date    				2nd May , 2010
 * @Last Modified    				2nd May , 2010
 *
 *
 *
 **/
//define("WEB_SESSION",session_id());
//define("WEB_SESSION_FRONT",session_id().'::F');
define("WEB_SESSION", "ADMIN");
define("WEB_SESSION_FRONT", "FRONT");

define("PREDEFINED_SALT_VALUE","sdfjh24h2k34h234");

/*****************			Application Access URLs					*******************************/
define('DATABASE_HOST', 'localhost');
define('DATABASE_NAME', 'coupon');       // must exist in phpMyAdmin
define('DATABASE_USER', 'root'); // must exist in MySQL
define('DATABASE_PASSWORD', '');

define("DOMAINNAME", ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);
define("DOMAINNAME_ADMIN",DOMAINNAME."/admin");
define("APPLICATION_TITLE","Grabdiscountcodes Admin");
define("RESOURCES_DOMAIN",DOMAINNAME."/public_html");
define("BASE_URL", "c:/xampp/htdocs/Counpon");
define("EVENTS_URL","event");
define("STORE_URL","store");
define("TAG" , "tag");
define("FILES_FOLDER","files");
define("DEFAULT_IMAGES_FOLDER","images");
define('ROOT_DIR', dirname(__FILE__));
//User Account Status
define("INACTIVE",0);
define("ACTIVE",1);
define("TXT_ACTIVE","Yes");
define("TXT_IN_ACTIVE","No");

require_once("pagination.class.php");
require_once("pagesmanagement.class.php");
require_once("resize-class.php");
$objPages = new pagesmanagementclass();
$website_config = generateConfigData();//generate config data for the website.

define("SMTP_HOST",$website_config['SMTPHost']);
define("SMTP_PORT",$website_config['SMTPPORT']);
define("SMTP_USER",$website_config['SMTPUserName']);
define("SMTP_PASSWORD",$website_config['SMTPPassword']);
define("FROMEMAIL",$website_config['SMTPUserName']);
define("FROMNAME",$website_config['SMTPUserName']);

define("BANNER_FOLDER","banners");
define("DOCUMENT_FOLDER","Documents");
define("IMAGE_GALLERY_FOLDER","imagegallery");
define("VIDEO_GALLERY_FOLDER","videogallery");
define("SLIDER_BRIEF_DESCRIPTION_ENGLISH",110);

define("SLIDER_BRIEF_DESCRIPTION_ARABIC",200);
define("THUMBNAIL_IMAGES","mediaimage");
define("UPLOAD_VIDEOS","mediavideos");

define("ORIGINAL_IMAGES","originalimages");
define("BRIEF_DESCRIPTION_LENGTH_ENGLISH",200);
define("BRIEF_DESCRIPTION_LENGTH_ARABIC",250);
$AllowedImageExtension = array("image/jpeg","image/jpg","image/png");
$AllowedFileExtension = array("application/pdf","application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document");
$AllowedExcel = array("application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
$AllowedVideoExtension = array("video/mp4");
define("VIDEO_UPLOAD_SIZE",10);//MB
define("MAX_FILE_SIZE_MB",3); // MB
define("MAX_FILE_SIZE_FOR_BOOK",10); // MB
define("INNER_PAGE_BANNER_WIDTH",1920);
define("INNER_PAGE_BANNER_HEIGHT",370);
define("THUMBNAIL_WIDTH",260);
define("THUMBNAIL_HEIGHT",160);
define("NEWS_MEDIA_TYPE",2);
define("EVENT_MEDIA_TYPE",3);
define("COURSE_MEDIA_TYPE",4);
define("PUBLICATION_MEDIA_TYPE",5);
define("PAGE_MEDIA_TYPE",1);
define("FRONT_EVENT_TYPE",3);
define("MAIN_PAGINATION_COUNT_BANNER_WIDTH1",900);
define("MAIN_PAGE_BANNER_WIDTH1",900);
define("NEWS_URL","news");
define("PRODUCT_URL","products");

define("MAIN_PAGE_BANNER_HEIGHT1",600);
define("MAIN_PAGE_BANNER_WIDTH2",900);
define("MAIN_PAGE_BANNER_HEIGHT2",600);
define("MAIN_PAGE_BANNER_WIDTH3",900);
define("MAIN_PAGE_BANNER_HEIGHT3",600);
define("MAIN_PAGE_BANNER_WIDTH4",900);
define("MAIN_PAGE_BANNER_HEIGHT4",1200);
define("HOME_PAGE_THUMBNAIL_WIDTH",350);
define("HOME_PAGE_THUMBNAIL_HEIGHT",250);
define("HOME_PAGE_COURSE_THUMBNAIL_WIDTH",780);
define("HOME_PAGE_COURSE_THUMBNAIL_HEIGHT",530);
define("HOME_PAGE_YOUTUBE_VIDEO",1);
define("TXT_SUBSCRIPTION_TYPE_TEXT","Subscrption Request from website");
define("TXT_REGISTERFORM_SUBMISSION","New User Registration from website");
define("COURSE_URL","course");
define("STORE","store");
define("CONTACTUS","contact-us");
//define("STORE_DETAIL","store-detail");
define("COUPON","coupon");
define("TYPE","type");
define("CATEGORY","category");
define("ANNOUNCEMENT_URL","anouncement");
//define("CATEGORY","category");
define("CATEGORY_URL","category");
define("COUPON_URL","coupon");
define("PUBLICATION_URL","publications");
define("PUBLICATION_DETAIL_URL","publication");
define("PAGINATION_COUNT",24);
define("PAGINATION_COUNT_SEARCH",24);
$PageType = array(1 => "Article", 2 => "Products" ,3 => "No Link", 4 => "External Link", 5 => "Category", 6 => "Contact Us",7=>"Store",8=>"Coupon", 9=>"policy");
$PageTypeArPages = array(1 => "page_articles" ,2 => "product", 5 => "category", 6 => "contact-us",7=>"store" , 8=>"coupon",9=>"page_register",10=>"page_activateuser",11=>"page_login",12=>"page_dashboard",13=>"page_complaint",14=>"page_suggestions",15=>"page_sports_complex_application_form",16=>"page_publications_form",17=>"page_forgotpass",18=>"page_resetpass",19=>"page_changepass",20=>"page_search",21=>"page_book_categories",22=>"page_publication_category",23=>"page_publications",24=>"page_publication_details",25=>"page_virtual_course_categories");
define("TXT_THUMBNAIL_IMAGE_PATH","cropthumb_");
define("THUMBNAIL_EVENT_WIDTH",500);
define("THUMBNAIL_EVENT_HEIGHT",355);
$GenderType = array(1 => "Male", 2 => "Female");
$GenderTypeAr = array(1 => "الذكر", 2 => "أنثى");
$PassPercentage = array(40,45,50,55,60,65,70,75,80,85,90,95,100);

$SearchPage = array(1 => "Announcement", 2 => "News", 3 => "Event", 4 => "Publications", 5 => "Library",6 =>"Courses",7 =>"Page");
$SearchPageAr = array(1 => "Announcement", 2 => "News", 3 => "Event", 4 => "Publications", 5 => "Library",6 =>"Courses",7 =>"Page");
$SearchPageURL = array(1 => ANNOUNCEMENT_URL, 2 => NEWS_URL, 3 => EVENTS_URL, 4 => PUBLICATION_URL, 5 => "Library",6 =>COURSE_URL,7 =>"");
define("BOOK_CATEGORIES_URL","books");
$NumberOfEmailPerHrs = array(100,200,300,400,500,600,700,800,900,1000);
$Time = array(1=>"12:00 AM", 2=>"1:00 AM", 3=>"2:00 AM", 4=>"3:00 AM", 5=>"4:00 AM", 6=>"5:00 AM", 7=>"6:00 AM", 8=>"7:00 AM", 9=>"8:00 AM", 10=>"9:00 AM", 11=>"10:00 AM", 12=>"11:00 AM", 13=>"12:00 PM", 14=>"1:00 PM", 15=>"2:00 PM", 16=>"3:00 PM", 17=>"4:00 PM", 18=>"5:00 PM", 19=>"6:00 PM", 20=>"7:00 PM", 21=>"8:00 PM", 22=>"9:00 PM", 23=>"10:00 PM", 24=>"11:00 PM");
$ExceptionEmail = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
define("BOOK_DETAIL_URL","book-detail");
define("COURSES_CATEGORIES_URL","courses");
?>
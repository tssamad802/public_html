/*Validation Init*/
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
	'use strict';
	window.addEventListener('load', function() {
	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	formvalidtecalss();
	Passwordstrong();
	quickview();

	if($('.cropimages').length > 0)
		cropimages();

	var masterpluscounter = 0;
	$('.addplussign').click(function(){
		masterpluscounter++;
		var anchorlink = '<a href="javascript:void(0);" onclick="RemoveField('+masterpluscounter+')" class="minussign"><i class="ion ion-ios-close-circle-outline"></i></a>';
		var htmltext = '<div class="otheplusbox removminus'+masterpluscounter+'">'+
						   '<label >'+window.TxtEnglish+' <span>*</span> '+anchorlink+'</label>'+
						   '<input type="text" name="Title[]" class="form-control" value="" dir="ltr"  required />'+
						   '<div class="invalid-feedback">'+
							   ''+window.TxtEnglishERROR+''+
						   '</div>';
                       '</div>';

		var htmltextarabic = '<div class="otheplusbox removminus'+masterpluscounter+'">'+
						   '<label >'+window.TxtArabic+' <span>*</span> '+anchorlink+'</label>'+
						   '<input type="text" name="TitleAr[]" class="form-control" value="" dir="rtl"  required />'+
						   '<div class="invalid-feedback">'+
							   ''+window.TxtArabicERROR+''+
						   '</div>';
                       '</div>';
		$('.makemastercopies').append(htmltext);
		$('.makemastercopiesarabic').append(htmltextarabic);
	});

	}, false);
})();

function RemoveField(value)
{
	if(value > 0)
	{
		$('.removminus'+value).remove();
	}
}


function cropimages()
{
	var cropinput = 0;

	  $('.cropimages').click(function(event){
		  	var imagewidth = parseInt($(this).attr('imagewidth'));
		  	var imageheight =  parseInt($(this).attr('imageheight'));
			cropinput =  parseInt($(this).attr('cropinput'));
			var boundarywidth = imagewidth+80;
			var boundaryheight= imageheight+50;
			$('.crop_image').attr('data-value',cropinput);
			$image_crop = $('#image_demo').croppie({
					enableExif: true,
					viewport: {
					  width:imagewidth,
					  height:imageheight,
					  type:'square'
					},
					boundary:{
					  width:boundarywidth,
					  height:boundaryheight
					}
			  });

	  });

	  $('.cropimages').on('change', function(){
		   $('.cr-image').attr('src','');
			var reader = new FileReader();
			reader.onload = function (event) {
			  $image_crop.croppie('bind', {
				url: event.target.result
			  }).then(function(){
				console.log('jQuery bind complete');
			  });
			}
			reader.readAsDataURL(this.files[0]);
		 	$('.croppopupbox').show();

	  });

	  $('.crop_image').click(function(event){
		$image_crop.croppie('result', {
		  type: 'canvas',
		  size: 'viewport'
		}).then(function(response){
		 	 $('.croppopupbox').hide();
			 var datacropinput =  parseInt($('.crop_image').attr('data-value'));
			// alert(datacropinput);
			 console.log(response);
				//$('.image_file_preview'+cropinput).show();
				$('.image_file_preview'+datacropinput+' img').attr('src', response);
				$('input[name="ImageCropData'+datacropinput+'"').val(response);
		  		$('#image_demo').croppie('destroy');
			})
	  });

	  $('.closecropbtn').click(function(event){
		  	$('#image_demo').croppie('destroy');
		 	$('.croppopupbox').hide();
	  });
}


function ShowScreen()
{
	$(".preloader-it").show();
}
function HideScreen()
{
	$(".preloader-it").hide();
}

function formvalidtecalss(newwformdata)
{

	var forms = (newwformdata== null)?document.getElementsByClassName('needs-validation'):document.getElementsByClassName(newwformdata);
	// Loop over them and prevent submission
	var validation = Array.prototype.filter.call(forms, function(form) {
	form.addEventListener('submit', function(e) {

	if (form.checkValidity() === false) {
			e.preventDefault();
			e.stopPropagation();
	}
	else
	{
			ShowScreen();
			e.preventDefault();
		if ($('.tinymce').length > 0 || $('.tinymcear').length > 0)
			tinyMCE.triggerSave();

			var formData = new FormData($(this)[0]);

			$.ajax({
				type: "POST",
				url: "ajax_functions.php",
				data: formData,
				dataType:"json",
				success: function(msg){

					if(msg.error != '')
					{
						HideScreen();
						showweballmessages(msg.error,1);
					}
					else if(msg.setdata != '')
					{
						HideScreen();
						$(msg.muntipledivdata).html(msg.html);

						if($('.dataManager'+msg.viewdata).length > 0)
						{
							$('.dataManager'+msg.viewdata).val(msg.DataManager);
						}
						else
						{
							$('.hideposttextfiled').append('<input type="hidden" name="DataManager['+msg.viewdata+']['+msg.optiontype+']" class="dataManager'+msg.viewdata+' removeclass'+msg.viewdata+'" value="'+msg.DataManager+'" />');
						}


						if(msg.optiontype==1)
						{
							if($('.dataAnimation'+msg.viewdata).length > 0)
							{
								$('.dataAnimation'+msg.viewdata).val(msg.BannerSpeed+','+msg.BannerEffect);
							}
							else
							{
								$('.hideposttextfiled').append('<input type="hidden" name="DataAnimation['+msg.viewdata+']['+msg.optiontype+']" class="dataAnimation'+msg.viewdata+' removeclass'+msg.viewdata+'" value="'+msg.BannerSpeed+','+msg.BannerEffect+'" />');
							}
						}


						if(msg.optiontype==2)
						{

							if($('.dataChooseOption'+msg.viewdata).length > 0)
							{
								$('.dataChooseOption'+msg.viewdata).val(msg.VideoOption);
							}
							else
							{
								$('.hideposttextfiled').append('<input type="hidden" name="ChooseVideo['+msg.viewdata+']['+msg.optiontype+']" class="dataChooseOption'+msg.viewdata+' removeclass'+msg.viewdata+'" value="'+msg.VideoOption+'" />');
							}

							if($('.dataChooseOptiondata'+msg.viewdata).length > 0)
							{
								$('.dataChooseOptiondata'+msg.viewdata).val(msg.VideoOptionData);
							}
							else
							{
								$('.hideposttextfiled').append('<input type="hidden" name="ChooseVideoOption['+msg.viewdata+']['+msg.optiontype+']" class="dataChooseOptiondata'+msg.viewdata+' removeclass'+msg.viewdata+'" value="'+msg.VideoOptionData+'" />');
							}
						}


						if(msg.optiontype==3)
						{
							if($('.dataTextOption'+msg.viewdata).length > 0)
							{
								$('.dataTextOption'+msg.viewdata).val(msg.TextOption);
							}
							else
							{
								$('.hideposttextfiled').append('<input type="hidden" name="TextOption['+msg.viewdata+']['+msg.optiontype+']" class="dataTextOption'+msg.viewdata+' removeclass'+msg.viewdata+'" value="'+msg.TextOption+'" />');
							}
						}
						if(msg.countdata > 1 && msg.optiontype==1)
						{
							$('#ShowModelBox').modal('hide');
							//alert($('.viewdata'+msg.viewdata).height()+' - '+$('.viewdata'+msg.viewdata).width());
								var bannerspeed = msg.BannerSpeed+'000';
								$('.bxslider'+msg.viewdata).bxSlider({
									mode:msg.BannerEffect,
									speed:1000,
									pause:bannerspeed,
									captions: false,
									auto: true,
									pager: false,
									controls:false
								});
						}

						$('#ShowModelBox').modal('hide');

					}
					else if(msg.success != '')
					{
						if(msg.ShowinPopup != '')
						{
							alert(msg.ShowinPopup);
						}
						if(msg.OpenInNewWindow != '')
						{
							window.open(msg.OpenInNewWindow);
						}
						if(msg.redirect != '')
						{
							window.location.href = msg.redirect;
						}
						else if(msg.selfredirect == 1)
						{
							 location.reload();
							 //$("html, body").animate({ scrollTop: 0 }, "slow");
						}

						if(msg.muntipledivdata != '')
						{
							HideScreen();
							$(msg.muntipledivdata).html(msg.html);
						}

						if(msg.hidedivbox != '')
						{
							HideScreen();
							$(msg.hidedivbox).hide();
						}


						if(msg.blanckdivbox != '')
						{
							HideScreen();
							$(msg.blanckdivbox).html(' ');
						}


					}
					else if(msg.closepopup != '')
					{
						$('#'+msg.divid).html(msg.html);
						HideScreen();
						$('#ShowModelBox').modal('hide');
					}
				},
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function(){
					ShowScreen();
				},
				error: function(m){
					HideScreen();
				},
				complete: function(){

				}
			});
	return this;
	}
		form.classList.add('was-validated');
	}, false);
	});

		return false;
}

function showweballmessages(msg,type)
{
	if(msg!='')
	{
		var displayclass = (type==1)?'jq-toast-danger':'jq-toast-success';
		$.toast().reset('all');
		$("body").removeAttr('class');
			$.toast({
				//heading: 'Notification!',
				text: msg,
				//position: 'top-right',
				loaderBg:'#00acf0',
				class: displayclass,
				hideAfter: 3000,
				stack: 6,
				showHideTransition: 'fade'
			});
		return false;
	}
}

//pagination and search function
function SimpleAjax(pageUrl,FormId,divId){
	var dataVar ='';
	var d = new Date();

	if(FormId != null){
		dataVar =  jQuery('#'+FormId).serialize();
	}
	ShowScreen();
	jQuery.ajax({
		type: "POST",
		url: 'ajax/'+pageUrl,
		//cache:false,
		//async: false,
		data:dataVar,
		success: function(msg){
			jQuery('#'+divId).empty();
			jQuery('#'+divId).html(msg);
			if($('#datable_1').length > 0)
			{
				datable_1();
			}

			if($('.sort-table').length > 0)
    		SortItemData()

			if($('.deleterecord').length > 0)
				confirmationDialog();

			quickview();

			if($(".iframe").length > 0)
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});

			if($(".imagegallery").length > 0)
				$(".imagegallery").colorbox({rel:'group', innerWidth:"75%", innerHeight:"75%"})

			/*if($('.deleterecord').length > 0)
				confirmationDialog(); */

			//if($('#my_table').length > 0)


			HideScreen();
		},
		beforeSend: function(){
			//ShowScreen();
		},
		error: function(m){
			HideScreen();
		},
		complete: function(){
			//tabletodiv();
		}
	});

	return false;
}


function SortItemData()
{
	var fixHelperModified = function (e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function (index) {
			$(this).width($originals.eq(index).width())
		});
		return $helper;
	};

	$(".sort-table tbody").sortable({
		helper: fixHelperModified,
		update: function (event, ui) {
			var tablename = $(this).data("tablename");
			var datadetail = $(this).sortable("serialize");
 			ShowScreen();

			$.ajax({
				type: "POST",
				url: "ajax_functions.php",
				data: datadetail + "&Action=SortRecords&tablename=" + tablename,
				cache: false,
				success: function (html) {
					HideScreen();
				},
				error: function (error) {
					HideScreen();
				}
			});
		}
	});

}

function quickview()
{

	$('.quickview').click(function(){
		var url = $(this).data('href');
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
				formvalidtecalss();

				$('.selectpicker').selectpicker("refresh");

			},
			beforeSend: function(){
			},
			error: function(m){

			},
			complete: function(){
			}
		});
		$('#show_details').modal('show');

	});
}
function datable_1()
{
	$('#datable_1').DataTable({
		responsive: true,
		autoWidth: false,
		"lengthMenu": [[100, 200, 500, -1], [100, 200, 500, "All"]],
		language: { search: "",
		searchPlaceholder: "Search",
		sLengthMenu: "_MENU_items"

		}
	});
	
	$('ul.pagination li').click(function (event) {
		if ($('.deleterecord').length > 0)
			confirmationDialog();
	});
	$("input[type=search]").keyup(function () {
		if ($('.deleterecord').length > 0)
			confirmationDialog();
	});


	$('.hk-gallery').lightGallery({  showThumbByDefault: false,hash: false});
}
 

function confirmationDialog()
{
	//delete a record
	$('.deleterecord').click(function(event){
			event.preventDefault();
			var action_title = $(this).data("action_title");
			var action_msg = $(this).data("action_msg");

			if(action_title == '' || typeof(action_title) == 'undefined')
			{
				action_title = 'confirm action';
			}

			var action = $(this).data("action");
			var id = $(this).data("id");
			var messagelabel = $(this).data("message");
			var tablename = $(this).data("table");

			var logoutuser = 0;
			if($(this).data("logoutuser") == 1)
			{
				var logoutuser = 1;
				$('#DeletePopupBox .deletebtn').html($(this).data("submitbtn"));
			}


			if(tablename == undefined)
				tablename='0';

				$('#DeletePopupBox .modal-title').html(action_title);
				$('#DeletePopupBox .content').html(messagelabel);
				$('#DeletePopupBox').modal('show');
				$('.deletebtn').click(function(event){
					 ShowScreen();

						$.ajax({
						  type: "POST",
						  url: "ajax_functions.php",
						  data: 'Trigger=delete&ActionFlag='+action+'&recordID='+id+'&tablename='+tablename+'&action_msg='+action_msg+'&logoutuser='+logoutuser,
						  dataType: "json",
						  cache: false,
						  success: function(msg){
							//HideScreen();
							if(msg.error != '')
							{
								showweballmessages(msg.error,1);
								HideScreen();
							}
							else if(msg.success != '')
							{
								if(msg.redirect != '')
								{
									window.location.href = msg.redirect;
								}
								else if(msg.selfredirect == 1)
								{
									 location.reload();
									 //$("html, body").animate({ scrollTop: 0 }, "slow");
								}

								if(msg.success != '')
								{
									HideScreen();
									//$('#'+msg.divtoplace).text(msg.success);
								}

							}

							$('#DeletePopupBox').modal('hide');
						  },
						  error: function(){
							HideScreen();
							showweballmessages(window.ErrorMsg,1);
							$('#DeletePopupBox').modal('hide');
						  }
						});
				});

		});
}

function Passwordstrong()
{
	$('#CPassword').keyup(function() {
		if($('#CPassword').val().length > 4)
		{
			if($('#password').val()!=$('#CPassword').val())
			{
				$('#passwordnotmatch').html(window.PasswordValidate);
			}
			else
			{
				$('#passwordnotmatch').html('');
			}
		}
	});


		$('#password').keyup(function() {
			$('.progress').show();
			$('#result').html(checkStrength($('#password').val()));

			if($('#CPassword').val()!='')
			{
				if($('#password').val()!=$('#CPassword').val())
				{
					$('#passwordnotmatch').html(window.PasswordValidate);
				}
				else
				{
					$('#passwordnotmatch').html('');
				}
			}
		});

	function checkStrength(password)
	{
		var strength = 0
		if (password.length < window.PasswordLength) {
		$('#result').removeClass();
		$('#result').addClass('short');
			$('#PasswordStrength').val(0);
			$("#passwordprogressbar").removeClass();
			$("#passwordprogressbar").addClass('progress-bar-danger');
			$('#passwordprogressbar').css('width','25%');
			return 'Too short';
		}
		if (password.length > window.PasswordLength+1) strength += 1
		// If password contains both lower and uppercase characters, increase strength value.
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
		// If it has numbers and characters, increase strength value.
		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
		// If it has one special character, increase strength value.
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		// If it has two special characters, increase strength value.
		if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		// Calculated strength value, we can return messages
		// If value is less than 2
			if (strength < 2) {
				$('#result').removeClass();
				$('#PasswordStrength').val(1);
				$('#result').addClass('weak');
				$("#passwordprogressbar").removeClass();
				$("#passwordprogressbar").addClass('progress-bar-warning');
				$('#passwordprogressbar').css('width','50%');
				return 'Weak'
			} else if (strength == 2) {
				$('#result').removeClass();
				$('#result').addClass('good');
				$('#PasswordStrength').val(2);
				$("#passwordprogressbar").removeClass();
				$("#passwordprogressbar").addClass('progress-bar-info');
				$('#passwordprogressbar').css('width','75%');
				return 'Good'
			} else {
				$('#result').removeClass();
				$('#result').addClass('strong');
				$('#PasswordStrength').val(3);
				$("#passwordprogressbar").removeClass();
				$("#passwordprogressbar").addClass('progress-bar-success');
				$('#passwordprogressbar').css('width','100%');
				return 'Strong'
			}
	}
}

function numberswithdescimal(e, decimal) {
	var key;
	var keychar;

	if (window.event) {
		key = window.event.keyCode;
	}
	else if (e) {
		key = e.which;
	}
	else {
		return true;
	}

	keychar = String.fromCharCode(key);

	if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
		return true;
	}
	else if ((("0123456789.").indexOf(keychar) > -1)) {
		return true;
	}
	/*else if (decimal && (keychar == ".")) {*/
	else if (decimal) {
		return true;
	}
	else {
		return false;
	}
}

function limiter(Limit, textarea, Counter)
{
	var tex = textarea.value;
	var len = tex.length;

	if(len > Limit)
	{
		tex = tex.substring(0, Limit);
		textarea.value = tex;
		return false;
	}
	document.getElementById(Counter).innerHTML = Limit-len;
}

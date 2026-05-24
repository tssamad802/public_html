function ChangeLanguage($lang) {
    $('.awe-page-loading').show();
    jQuery.ajax({
        type: "GET",
        url: window.DomainName + "/ajax_functions.php?actions=ChangeLanguage&SessionLang=" + $lang,
        cache: false,
        success: function(data) {
            $('.awe-page-loading').hide();
            window.location.reload();

        }
    });

    return false;
}

function Requiredfiledpass(formid) {
    $('#' + formid + ' .required').keyup(function() {
        if ($(this).val() == "") {
            $('#err_' + $(this).attr('name')).css('display', 'block');
        } else {
            $('#err_' + $(this).attr('name')).css('display', 'none');
        }

        if ($(this).hasClass("email") && !validateEmail($(this).val()) && $(this).val() != '') {
            $('#err_' + $(this).attr('name')).css('display', 'block');
        } else {
            $('#err_' + $(this).attr('name')).css('display', 'none');
        }

        if ($(this).hasClass("phoneNumber") && !($(this).val()) && $(this).val() != '') {
            $('#err_' + $(this).attr('name')).css('display', 'block');
        } else {
            $('#err_' + $(this).attr('name')).css('display', 'none');
        }
    });
}

function FormSubmiting(formid) {
    $('.awe-page-loading').show();
    event.preventDefault();
    var error = 0;
    var userName = $('#usrname');
    var userEmail = $('#Email');
    var userphone = $('#phone');
    Requiredfiledpass(formid);
    $('#' + formid + ' .required').each(function() {
        if ($(this).val() == "" || $(this).val() == "-1") {
            $('#err_' + $(this).attr('name')).css('display', 'block');
            error = 1;
        } else {
            $('#err_' + $(this).attr('name')).css('display', 'none');
        }
    });

    if ($('.email').val() == '' || !validateEmail($('.email').val())) {
        $('#err_' + $('.email').attr('name')).css('display', 'block');
        error = 1;
    }
    if ($('.phoneNumber').val() == '' || !validatePhone($('.phoneNumber').val())) {
        $('#err_' + $('.phoneNumber').attr('name')).css('display', 'block');
        error = 1;
    }

    if (error == 0) {
        var form = $('#' + formid);
        var formData = form.serialize();


        $.ajax({
            type: "POST",
            cache: false,
            url: "ajax_functions.php",
            dataType: "json",
            data: formData,
            success: function success(result) {
                var resultClass = '';

                if (result.success == 0) {
                    $(".alertBox").addClass('alert-danger');
                    $(".alertBox").removeClass('alert-success');
                    $.each(result, function(key, obj) {
                        $("#err_" + key).show();
                        $("#err_" + key).text('');
                        $("#err_" + key).text(obj);
                    });

                } else {
                    $(".alertBox").removeClass('alert-danger');
                    $(".alertBox").addClass('alert-success');
                    $('#' + formid).trigger("reset");
                }
                $(".alertBox").show();
                $(".formMsg").text('');
                $(".formMsg").text(result.successMsg);
                if (result.redirect != '' && result.redirect != undefined) {
                    window.location.href = result.redirect;
                }
                $('.awe-page-loading').hide();

            },
            error: function error() {}
        });
    } else {
        return false;
    }

}

function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test($email);
}

function validatePhone(txtPhone) {
    var filter = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
    if (filter.test(txtPhone) && txtPhone.length < 11) {
        return true;
    } else {
        return false;
    }
}


$(function() {
    $('.popularSlider').bxSlider({
        auto: true,
        autoControls: false,
        speed: 1000,
        slideSelector: 'a.item',
        minSlides: 1,
        maxSlides: 1,
        moveSlides: 1,
        pager: false,
        slideWidth: 780
    });
    if($(".topsearchbox").length > 0) {
        $(".topsearchbox")
            // don't navigate away from the field on tab when selecting an item
            .bind("keydown", function (event) {

                if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
                    event.preventDefault();
                }

            })
            .autocomplete({
                autoFocus: true,
                minLength: 0,
                source: function (request, response) {
                    $.ajax({
                        url: window.DomainName+"/ajax_functions.php",
                        dataType: "json",
                        data: {
                            q: request.term,
                            Action: 'ajaxsearchautocompele'
                        },
                        success: function (data) {
                            // console.log(data)
                            response(data);
                        }
                    });
                    /*response( $.ui.autocomplete.filter(
                          availableTags, extractLast( request.term ) ) );*/
                },
                focus: function () {
                    return false;
                },
                response: function (event, ui) {
                    if (ui.content.length == 0) {
                    //   $(this).css("background-color", "#f00");
                       $('#ParentTableID').val('');
                    } else {
                    //   $(this).css("background-color", "#363b43a1");
                       $(this).css("color", "#fff");
                    }
                },
                select: function (event, ui) {
                    this.value = ui.item.value;
                    //console.log(ui.item.Link);
                    if(ui.item.Link!=''){
                                            // window.open(ui.item.Link,'');//_blank    
                                          window.location.assign(ui.item.Link,'')
                                     }
                    //$('#DirectorID').val(ui.item.TableID);
                    return false;
                }
            });
    }
});

$(document).ready(function() {
    $(".img_gallery").colorbox({
        rel: 'img_gallery',
        innerWidth: "75%",
        innerHeight: "75%"
    });

    $(".img_video").colorbox({
        rel: 'img_video',
        iframe: true,
        innerWidth: 640,
        innerHeight: 390
    });
    $(".liveVideoPopup").colorbox({
        rel: 'liveVideoPopup',
        iframe: true,
        innerWidth: 640,
        innerHeight: 390
    });
    $(".youtubeArchivePopup").colorbox({
        rel: 'youtubeArchivePopup',
        iframe: true,
        innerWidth: 640,
        innerHeight: 390
    });


    //Example of preserving a JavaScript event for inline calls.
    $("#click").click(function() {
        $('#click').css({
            "background-color": "#ff0000",
            "color": "#fff",
            "cursor": "inherit"
        }).text("Open this window again and this message will still be here.");
        return false;
    });

    $('.owl-item.cloned').find('.popUpVideoIcon').attr('rel', '')

});


function SimpleAjax(pageUrl, FormId, divId) {
    $('.awe-page-loading').css('display', 'block');
    var dataVar = '';
    var d = new Date();

    if (FormId != null) {
        dataVar = jQuery('#' + FormId).serialize();
    }
    jQuery.ajax({
        type: "POST",
        url: pageUrl,
        data: dataVar,
        success: function(msg) {
            jQuery('#' + divId).empty();
            jQuery('#' + divId).html(msg);
            quickview();
        },
        beforeSend: function() {
            //ShowScreen();
        },
        error: function(m) {
            HideScreen();
            console.log(m);
        },
        complete: function() {
            //tabletodiv();
        }
    });
    $('.awe-page-loading').css('display', 'none');

    return false;
}
setTimeout(function() { $('.singleDatePicker').val(''); }, 3000);

function validateReg(FormID) {
    var error = 0;
    event.preventDefault();
    Requiredfiledpass(FormID);
    $('#' + FormID + ' .required').each(function() {
        if ($(this).val() == "") {
            $('#err_' + $(this).attr('name')).css('display', 'block');
            error = 1;
        } else {
            $('#err_' + $(this).attr('name')).css('display', 'none');
        }
    });
    if ($('.phoneNumber').val() != '') {
        $('#' + FormID + ' .phoneNumber').each(function() {
            if (!validatePhone($(this).val())) {
                $('#err_' + $(this).attr('name')).css('display', 'block');
                error = 1;
            } else {
                $('#err_' + $(this).attr('name')).css('display', 'none');
            }
        });
    }
    if (error == 0) {
        $('.awe-page-loading').show();
        var myform = document.getElementById(FormID);
        var fd = new FormData(myform);
        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            data: fd,
            url: window.DomainName + "/ajax_functions.php",
            dataType: "json",
            success: function success(result) {
                $(".errorfields").hide();
                $.each(result, function(key, obj) {
                    $("#err_" + key).show();
                    $("#err_" + key).text(obj);
                });
                if (result.success == 1) {
                    $('#' + FormID).trigger("reset");
                    $(".alertBox").show();
                    $(".formMsg").text(result.successMsg);
                    $(".progress").hide();
                    // scrolltodiv("acc-success");
                }
                $('.awe-page-loading').hide();
                if (result.closemodal == 1) {
                    $('#' + result.closemodalID).modal('hide');
                }
                if (result.redirect != '' && result.redirect != undefined) {
                    window.location.href = result.redirect;
                }
            },
            error: function error() {}
        });
    }
}


function validatepass() {
    $('.progress').show();
    $('#result').html(checkStrength($('#password').val()));
}

function checkStrength(password) {
    var strength = 0
    if (password.length < window.PasswordLength) {
        $('#result').removeClass();
        $('#result').addClass('short');
        $('#PasswordStrength').val(0);
        $("#passwordprogressbar").removeClass();
        $("#passwordprogressbar").addClass('progress-bar-danger');
        $('#passwordprogressbar').css('width', '25%');
        return 'Too short';
    }
    if (password.length > window.PasswordLength + 1) strength += 1
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
        $('#passwordprogressbar').css('width', '50%');
        return 'Weak'
    } else if (strength == 2) {
        $('#result').removeClass();
        $('#result').addClass('good');
        $('#PasswordStrength').val(2);
        $("#passwordprogressbar").removeClass();
        $("#passwordprogressbar").addClass('progress-bar-info');
        $('#passwordprogressbar').css('width', '75%');
        return 'Good'
    } else {
        $('#result').removeClass();
        $('#result').addClass('strong');
        $('#PasswordStrength').val(3);
        $("#passwordprogressbar").removeClass();
        $("#passwordprogressbar").addClass('progress-bar-success');
        $('#passwordprogressbar').css('width', '100%');
        return 'Strong'
    }
}

function validateform(FormID) {
    var error = 0;
    $('#' + FormID + ' .required').each(function() {
        if ($(this).val() == "") {
            $('#err_' + $(this).attr('name')).focus();
            error = 1;
        } else {}
    });
    if (error == 1) {
        return false;
    }
}

function scrolltodiv(divid) {
    $('html, body').animate({
        scrollTop: $("#" + divid).offset().top
    }, 1000);
}

function sharepublication(pubid) {
    $("#pub_id").val(pubid);
    $("#myModalShare").modal('show');
}

function SimpleAjaxDownload(pageUrl, FormId, divId) {
    $('.awe-page-loading').css('display', 'block');
    var dataVar = '';
    var d = new Date();

    if (FormId != null) {
        dataVar = jQuery('#' + FormId).serialize();
    }
    jQuery.ajax({
        type: "POST",
        url: pageUrl,
        data: dataVar,
        dataType: "json",
        success: function(result) {
            if (result.download == 1) {
                var link = document.createElement('a');
                link.href = result.Link;
                link.download = result.FileName;
                link.click();
            }
        },
        beforeSend: function() {
            //ShowScreen();
        },
        error: function(m) {
            HideScreen();
        },
        complete: function() {
            //tabletodiv();
        }
    });
    $('.awe-page-loading').css('display', 'none');

    return false;
}

function CourseVideoCheck(urls) {
    event.preventDefault();
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: urls,
        dataType: "json",
        success: function success(result) {
            if (result.success == 1) {
                $(".courseVideoPopup").colorbox({
                    rel: 'courseVideoPopup',
                    iframe: true,
                    innerWidth: 640,
                    innerHeight: 390
                });

            }

        },
        beforeSend: function() {
            //ShowScreen();
        },
        error: function(m) {},
        complete: function() {
            //tabletodiv();
        }
    });

    return false;
}
// $(function() {
//     var alert = $('div.alert[auto-close]');
//     alert.each(function() {
//         var that = $(this);
//         var time_period = that.attr('auto-close');
//         setTimeout(function() {
//             that.alert('close');
//         }, time_period);
//     });
// });

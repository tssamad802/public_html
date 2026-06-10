//failure and success messages
function showweballmessages(msg, type) {
  if (msg != "") {
    $(document).ready(function () {
      $.toast({
        heading: "Notification!",
        text: msg,
        position: "top-right",
        loaderBg: "#00acf0",
        class: "jq-toast-primary",
        hideAfter: 3500,
        stack: 6,
        showHideTransition: "fade",
      });
    });
  }
}

//pagination and search function
function SimpleAjax(pageUrl, FormId, divId) {
  var dataVar = "";
  var d = new Date();

  if (FormId != null) {
    dataVar = jQuery("#" + FormId).serialize();
  }
  ShowScreen();
  jQuery.ajax({
    type: "POST",
    url: "ajax/" + pageUrl,
    //cache:false,
    //async: false,
    data: dataVar,
    success: function (msg) {
      // alert(msg);
      jQuery("#" + divId).empty();
      jQuery("#" + divId).html(msg);

      if ($("#sortable_table").length > 0) {
        $("#sortable_table").DataTable({
          paging: false,
          searching: false,
          info: false,
          columnDefs: [
            {
              targets: "no-sort",
              orderable: false,
            },
          ],
        });
      }
      selectalloption();
      quickview();
      DateTimeFieldSet();

      if ($(".iframe").length > 0)
        $(".iframe").colorbox({ iframe: true, width: "80%", height: "80%" });

      if ($(".imagegallery").length > 0)
        $(".imagegallery").colorbox({
          rel: "group",
          innerWidth: "75%",
          innerHeight: "75%",
        });

      /*if($('.deleterecord').length > 0)
				confirmationDialog(); */

      //if($('#my_table').length > 0)

      HideScreen();
    },
    beforeSend: function () {
      //ShowScreen();
    },
    error: function (m) {
      HideScreen();
    },
    complete: function () {
      //tabletodiv();
    },
  });

  return false;
}

function confirmationDialog() {
  //delete a record
  $(".deleterecord").click(function (event) {
    event.preventDefault();

    var action_title = $(this).data("action_title");

    if (action_title == "" || typeof action_title == "undefined") {
      action_title = "confirm action";
    }

    var action = $(this).data("action");
    var id = $(this).data("id");
    var messagelabel = $(this).data("message");
    var tablename = $(this).data("table");
    if (tablename == undefined) tablename = "0";

    BootstrapDialog.show({
      title: action_title,
      message: messagelabel,
      buttons: [
        {
          label: window.Confirm,
          cssClass: "btn-danger",
          action: function (dialogItself) {
            ShowScreen();

            $.ajax({
              type: "POST",
              url: "ajax_functions.php",
              data:
                "Trigger=delete&Action=" +
                action +
                "&recordID=" +
                id +
                "&tablename=" +
                tablename,
              dataType: "json",
              cache: false,
              success: function (msg) {
                //HideScreen();
                if (msg.error != "") {
                  showweballmessages(msg.error, 1);
                  HideScreen();
                } else if (msg.success != "") {
                  if (msg.redirect != "") {
                    window.location.href = msg.redirect;
                  } else if (msg.selfredirect == 1) {
                    location.reload();
                    //$("html, body").animate({ scrollTop: 0 }, "slow");
                  }

                  if (msg.success != "") {
                    HideScreen();
                    //$('#'+msg.divtoplace).text(msg.success);
                  }
                }

                dialogItself.close();
              },
              error: function () {
                HideScreen();
                showweballmessages(window.ErrorMsg);
                dialogItself.close();
              },
            });
          },
        },
        {
          label: window.Cancel,
          action: function (dialogItself) {
            dialogItself.close();
          },
        },
      ],
    });
  });
}

$(document).ready(function () {
  //form validation
  formvalidation();

  //apply validair plugin to all forms
  $("form").not("#searchfrm").goValidate();

  var fixHelperModified = function (e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function (index) {
      $(this).width($originals.eq(index).width());
    });
    return $helper;
  };

  //sortable table
  if ($(".sorttables").length > 0) {
    $(".sorttables tbody").sortable({
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
          },
        });
      },
    });
  }

  //date reset on button reset
  $("button[type='reset']").click(function (event) {
    $(".validation").removeClass("showError");
    $(".filevalidation").removeClass("showError");
    $(".invalid").removeClass("invalid");
    $("form")
      .find("input:file")
      .each(function () {
        $("." + $(this).data("field")).attr("value", "");
      });
  });
});

function quickview() {
  $(".quickview").click(function () {
    var url = $(this).data("href");
    $.ajax({
      url: url,
      type: "POST",
      contentType: false,
      cache: false,
      //async: false,
      processData: false,
      success: function (data) {
        $("#SetData").html(data);
        $("#SetData").find("form").goValidate();

        $(".partissueandcancel li a").click(function () {
          var getactiveid = $(this).attr("data-value");
          $(".partissueandcancel li a").removeClass("active");
          $(this).addClass("active");
          $(".tabitemdisplay").hide();
          $("." + getactiveid).fadeIn();
        });

        $(".selectpicker").selectpicker("refresh");
      },
      beforeSend: function () {},
      error: function (m) {},
      complete: function () {},
    });

    $("#show_details").modal({
      show: "true",
    });
  });
}

function formvalidation() {
  $.fn.goValidate = function () {
    $form.submit(function (e) {
      ShowScreen();
      e.preventDefault();

      var formData = new FormData($(this)[0]);

      $.ajax({
        type: "POST",
        url: "ajax_functions.php",
        data: formData,
        dataType: "json",
        success: function (msg) {
          // console.log(msg.sql);
          if (msg.error != "") {
            HideScreen();
            showweballmessages(msg.error, 1);
          } else if (msg.setdata != "") {
            HideScreen();
            $(msg.muntipledivdata).html(msg.html);

            if ($(".dataManager" + msg.viewdata).length > 0) {
              $(".dataManager" + msg.viewdata).val(msg.DataManager);
            } else {
              $(".hideposttextfiled").append(
                '<input type="hidden" name="DataManager[' +
                  msg.viewdata +
                  "][" +
                  msg.optiontype +
                  ']" class="dataManager' +
                  msg.viewdata +
                  " removeclass" +
                  msg.viewdata +
                  '" value="' +
                  msg.DataManager +
                  '" />',
              );
            }

            if (msg.optiontype == 1) {
              if ($(".dataAnimation" + msg.viewdata).length > 0) {
                $(".dataAnimation" + msg.viewdata).val(
                  msg.BannerSpeed + "," + msg.BannerEffect,
                );
              } else {
                $(".hideposttextfiled").append(
                  '<input type="hidden" name="DataAnimation[' +
                    msg.viewdata +
                    "][" +
                    msg.optiontype +
                    ']" class="dataAnimation' +
                    msg.viewdata +
                    " removeclass" +
                    msg.viewdata +
                    '" value="' +
                    msg.BannerSpeed +
                    "," +
                    msg.BannerEffect +
                    '" />',
                );
              }
            }

            if (msg.optiontype == 2) {
              if ($(".dataChooseOption" + msg.viewdata).length > 0) {
                $(".dataChooseOption" + msg.viewdata).val(msg.VideoOption);
              } else {
                $(".hideposttextfiled").append(
                  '<input type="hidden" name="ChooseVideo[' +
                    msg.viewdata +
                    "][" +
                    msg.optiontype +
                    ']" class="dataChooseOption' +
                    msg.viewdata +
                    " removeclass" +
                    msg.viewdata +
                    '" value="' +
                    msg.VideoOption +
                    '" />',
                );
              }

              if ($(".dataChooseOptiondata" + msg.viewdata).length > 0) {
                $(".dataChooseOptiondata" + msg.viewdata).val(
                  msg.VideoOptionData,
                );
              } else {
                $(".hideposttextfiled").append(
                  '<input type="hidden" name="ChooseVideoOption[' +
                    msg.viewdata +
                    "][" +
                    msg.optiontype +
                    ']" class="dataChooseOptiondata' +
                    msg.viewdata +
                    " removeclass" +
                    msg.viewdata +
                    '" value="' +
                    msg.VideoOptionData +
                    '" />',
                );
              }
            }

            if (msg.optiontype == 3) {
              if ($(".dataTextOption" + msg.viewdata).length > 0) {
                $(".dataTextOption" + msg.viewdata).val(msg.TextOption);
              } else {
                $(".hideposttextfiled").append(
                  '<input type="hidden" name="TextOption[' +
                    msg.viewdata +
                    "][" +
                    msg.optiontype +
                    ']" class="dataTextOption' +
                    msg.viewdata +
                    " removeclass" +
                    msg.viewdata +
                    '" value="' +
                    msg.TextOption +
                    '" />',
                );
              }
            }
            if (msg.countdata > 1 && msg.optiontype == 1) {
              //alert($('.viewdata'+msg.viewdata).height()+' - '+$('.viewdata'+msg.viewdata).width());
              $(".bxslider" + msg.viewdata).bxSlider({
                mode: msg.BannerEffect,
                speed: 1000,
                pause: msg.BannerSpeed,
                captions: false,
                auto: true,
                pager: false,
                controls: false,
              });
            }

            $("#ShowModelBox").modal("hide");
          } else if (msg.success != "") {
            if (msg.ShowinPopup != "") {
              alert(msg.ShowinPopup);
            }
            if (msg.OpenInNewWindow != "") {
              window.open(msg.OpenInNewWindow);
            }
            if (msg.redirect != "") {  
              window.location.href = msg.redirect;
            } else if (msg.selfredirect == 1) {
              location.reload();
              //$("html, body").animate({ scrollTop: 0 }, "slow");
            }

            if (msg.muntipledivdata != "") {
              HideScreen();
              $(msg.muntipledivdata).html(msg.html);
            }

            if (msg.hidedivbox != "") {
              HideScreen();
              $(msg.hidedivbox).hide();
            }

            if (msg.blanckdivbox != "") {
              HideScreen();
              $(msg.blanckdivbox).html(" ");
            }
          } else if (msg.closepopup != "") {
            $("#" + msg.divid).html(msg.html);
            HideScreen();
            $("#" + msg.divid).selectpicker("refresh");
            $(".specialselectbox").removeClass("invalid");
            $("#ShowModelBox").modal("hide");
          }
        },
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
          //ShowScreen();
        },
        error: function (m) {
          HideScreen();
        },
        complete: function () {},
      });
      return this;

      return this;
    });
    return this;
  };
}

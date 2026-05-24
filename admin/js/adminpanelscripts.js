$(document).ready(function(){
	
	
	$( "#tags" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
		
		if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) 
		{
          	event.preventDefault();
        }
		
		
      })
	  .autocomplete({
		autoFocus:true,
        minLength: 0,
        source: function( request, response ) {
		  $.ajax({
			  url: "ajax_functions.php",
			  dataType: "json",
			  data: {
				q: request.term,
				ActionAjax:$('#ActionAjax').val(),
				tablename:$('#TableName').val()
			  },
			  success: function( data ) {
				response( data );
			  }
			});
		  /*response( $.ui.autocomplete.filter(
				availableTags, extractLast( request.term ) ) );*/
        },
        focus: function() {
          return false;
        },
		response: function( event, ui ) {
		  if(ui.content.length == 0)
		  {
			  $(this).css("background-color","#f00");
			  
			  $('#ParentTableID').val('');
		  }
		  else
		  {
			  $(this).css("background-color","#fff");
		  }
		},
        select: function( event, ui ) {
          this.value = ui.item.value;
		  $('#ParentTableID').val(ui.item.TableID);
          return false;
        }
      });
	  	
});

function changepopup(sel,selectedtype)
{
	$(".videosettings").hide();
	if(sel == 2)
	{
		$(".videosettings").show();
	}
	var TypeID = sel;
	$.ajax({
		  url: "ajax_functions.php",
		  dataType: "json",
		  data: {
			ActionAjax:$('#ActionAjax').val(),
			selectedtype:selectedtype,
			TypeID:TypeID
		  },
		  success: function( data ) {
			$("#popupitems").html( data );
		  }
		});
	
}

function showallimagegallery(ParentID,TypeID)
{

	$.ajax({
		  url: "ajax_functions.php",
		  dataType: "json",
		  data: {
			ActionAjax:$('#ActionAjax').val(),
			TypeID:TypeID,
			ParentID:ParentID
		  },
		  success: function( data ) {
			$("#sliderimages").html( data );
			$(".bxitems").hide();
			$("#allimagegallery").modal();
			
		  }
		});
	
	
}
$('#allimagegallery').on('shown.bs.modal', function (e) {
        var slider = $('.bxsliderbanner').bxSlider({
			mode: 'horizontal',
			moveSlides: 1,
			slideMargin: 0,
			infiniteLoop: false,
			minSlides: 1,
			speed: 800,
			pager: true
			});
		$(".bxitems").show();
		slider.reloadSlider();
});

function showAllformDet(table,formname,Action,TableID)
{
	$.ajax({
		  url: "ajax_functions.php",
		  dataType: "json",
		  data: {
			ActionAjax:Action,
			formname:formname,
			TableID:TableID,
			Table:table
		  },
		  success: function( data ) {
			$("#AllformDet").html( data );
			$("#formdetails").modal();
		  }
		});
	
}

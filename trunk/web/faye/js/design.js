function linkover(id1)
{  
        $('.topmenulinkactive').removeClass("topmenulinkactive").addClass("topmenulink"); 
        $('.'+id1).addClass("topmenulinkactive");

 }

 function linkoverleft(id1)
{  
        $('.leftmenulinkactive').removeClass("leftmenulinkactive").addClass("leftmenulink"); 
        $('.'+id1).addClass("leftmenulinkactive");

 }


function showBlocks (id1, id2, id3)
{

timer = setTimeout(function(){$(".hiddenbox").hide();$('#'+id3).removeClass("activebutton");},1000);

  if ($('#'+id1).css('display') =='none')
  
  {
       $('#'+id3).addClass("activebutton");
	   $('.hiddenbox').css('display','none');
	   $('#'+id1).css('display','block');
	   $("#"+id2).mouseover(function(){clearTimeout(timer);});
	   $("#"+id2).mouseleave(function(){$(".hiddenbox").hide();$('#'+id3).removeClass("activebutton");},1000);
  }
  else
  {
      $('#'+id1).css('display','none');
  }

}
function showbasket (id1)
{

  if ($('#'+id1).css('display') =='none')
  
  {
	   $('#'+id1).css('display','block');
	   $("#"+id1).mouseleave(function(){$('#'+id1).css('display','none');});
  }
  else
  {
      $('#'+id1).css('display','none');
  }

}

function showhiddenbox (id1, id2, id3)
{

  if ($('#'+id1).css('display') =='none')
  
  {
       $('#'+id3).addClass("activebutton");
	   $('.hiddenbox').css('display','none');
	   $('#'+id1).css('display','block');
	   $("#"+id2).mouseleave(function(){$(".hiddenbox").hide();$('#'+id3).removeClass("activebutton");},1000);
  }

}

function showbig (id1)
{

  if ($('.imgbig').css('display') =='none')
  
  {
       $('#'+id1).css('display','block');
	   $("#"+id1).mouseout(function(){$(".imgbig").css('display','none');});
  }

}

function showinput (id1)
{

  if ($('#'+id1).css('display') =='none')
  
  {

	   $('#'+id1).css('display','block');
	   
  }

  else
  {
      $('#'+id1).css('display','none');
  }
}

function showthumbs (id1)
{
$("#"+id1).fadeIn('fast');
}
function hidethumbs (id1)
{
$("#"+id1).fadeOut('fast');
}
function showthumb(id1,id2)
{
       $("#"+id1).fadeIn('fast');
	   $("#"+id2).mouseleave(function(){$("#"+id1).fadeOut('fast');});
}
function SetOpacity(elem, opacityAsInt)
{
    var opacityAsDecimal = opacityAsInt;
    
    if (opacityAsInt > 100)
        opacityAsInt = opacityAsDecimal = 100; 
    else if (opacityAsInt < 0)
        opacityAsInt = opacityAsDecimal = 0; 
    
    opacityAsDecimal /= 100;
    if (opacityAsInt < 1)
        opacityAsInt = 1; // IE7 bug, text smoothing cuts out if 0
    
    elem.style.opacity = (opacityAsDecimal);
    elem.style.filter  = "alpha(opacity=" + opacityAsInt + ")";
}
$(document).ready(function() {
	// DROP BOXES
	$('.dropdown').click(function(){
		$('.hiddendrop',this).toggle();
		
		var drop = $('.hiddendrop',this);
		
		$(document.body).click(function(e){
			var clicked = $(e.target);
			
			var z = clicked.parents('.dropdown');
			var y = drop.parents('.dropdown');
			
			if((z && y && z.get(0) == y.get(0)))return true;
			
			drop.hide();
		});
		
	});
	
	$('.dropdown .hiddendropbox a').click(function(e){
		e.preventDefault();
		var parent = $(this).parents('.dropdown');
		parent.find('p').html($(this).html());
		parent.find('.hiddendrop').hide();
		
		return false;
	});
	
});



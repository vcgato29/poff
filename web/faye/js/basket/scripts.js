(function($) { // remove product from basket SKELETON BAHEVIOUR 
   $.fn.removeProductFromBasket = function(settings) {
     var config = {'foo': 'bar'};
 
     if (settings) $.extend(config, settings);
     var link = settings['link'];
     var container = settings['container'];
     var loaderContainer = settings['loaderContainer'];
     var postCallback = settings['postCallback'];
     var loader = settings['loader'];
     var productID = settings['productID'] === undefined ? false : settings['productID'];
     
     this.each(function() {
    	 
    	loaderContainer.html(loader).css("background-image", 'url("")');
    	 
 		$.post(link, function(data){
			container.slideUp(700, function(){
				postCallback(data,container);
				basketDataChanged(data);
			});
		},'json');
    	 
     });
 
     return this;
   };
 
 })(jQuery);

//"Add to basket" button
(function($) { // remove product from basket SKELETON BAHEVIOUR 
	   $.fn.addProductToBasket = function(settings) {
	     
		 var config = {'messageBoxFunction': function(messageBox, data){messageBox.html(data.message);} };
		 settings = $.extend(config, settings);
		 
		 var messageBoxFunction = settings['messageBoxFunction'];
		   
	     this.each(function(i, elm) {
	    	$(elm).click(function(e){
	    		e.preventDefault();
	    		
	    		var link = $('a', this).attr('href');
	    		var addButton = $('.addbutton',this);
	    		var loader = $('.addbuttonloader', this);
	    		//var messageBox = $('.alertnormal', $(this).parentsUntil('.product'));
	    		var messageBox = $('a',this);
	    		var qty = $('input', $(this).parentsUntil('.product'));
	    		qty = qty.val() === undefined ? 1 : qty.val();
	    		
	    		addButton.hide();
	    		loader.show();
	    		
	    		$.post(link, {qty: qty} , function(data){
	    			addButton.show();
	    			loader.hide();
	    			
	    			basketDataChanged(data);
	    			
	    			messageBoxFunction(messageBox, data);
	    		},'json');
	    		
	    		return false;
	    	}); 	
	    	 
	     });
	 
	     return this;
	   };
	 
	 })(jQuery);



$(document).ready(function(){

//"delete from basket" button clicked
$('.remove').live('click',function(e){
	
	$(this).removeProductFromBasket( {
		link: $('a', this).attr('href'),
		container: $(this).parents('.box'),
		loaderContainer: $('.bottom',this),
		loader: '<img src="/faye/basket-loader.gif" />',
		postCallback: function(data,container){
			var id = $('.product_id',container).html();
			
			if(id){ // find all product_ID containers on page, then trigger a special event
				$('.product_' + id).find('.removefrombasket').trigger('remove');
			}
		}
	});

	return false;
});

//basket show/hide trigger
$('.basketbutton').live('click',function(e){
	$('#basket').toggle();
});


// hide on body click
$(document.body).click(function(e){
	var clicked = $(e.target);
	if(( clicked.is('.basket') || clicked.parents('.basket').length ) )
		return true;
	
	$('#basket').hide();
});

	
});

// main handler for data if basket data changes
function basketDataChanged(data){
	
	if( $('.basketcontent').is(':visible') ){
		$('.basket').html(data.html);
		$('#basket').show();
	}else{
		$('.basket').html(data.html);
	}
}

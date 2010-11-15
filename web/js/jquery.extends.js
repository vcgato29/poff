(function($) {
    $.fn.extend({
        isChildOf: function( filter_string ) {
          var parents = $(this).parents().get();
          for ( j = 0; j < parents.length; j++ ) {
           if ( $(parents[j]).is(filter_string) ) {
      return true;}
       else
       {return false;
           }
          }
          return false;
        }
    });
})(jQuery);


(function ($) {
    $.fn.vAlign = function() {
        return this.each(function(i){
            var h = $(this).height();
            var oh = $(this).outerHeight();
            var mt = (h + (oh - h)) / 2;
            $(this).css("margin-top", "-" + mt + "px");
            $(this).css("top", "50%");
            $(this).css("position", "absolute");
        });
    };
})(jQuery);


(function ($) {
    $.fn.hAlign = function() {
        return this.each(function(i){
            var w = $(this).width();
            var ow = $(this).outerWidth();
            var ml = (w + (ow - w)) / 2;
            $(this).css("margin-left", "-" + ml + "px");
            $(this).css("left", "50%");
            $(this).css("position", "absolute");
        });
    };
})(jQuery);


jQuery.extend({
/**
* Returns get parameters.
*
* If the desired param does not exist, null will be returned
*
* @example value = $.getURLParam("paramName");
*/
 getURLParam: function(strParamName){
	  var strReturn = "";
	  var strHref = window.location.href;
	  var bFound=false;

	  var cmpstring = strParamName + "=";
	  var cmplen = cmpstring.length;

	  if ( strHref.indexOf("?") > -1 ){
	    var strQueryString = strHref.substr(strHref.indexOf("?")+1);
	    var aQueryString = strQueryString.split("&");
	    for ( var iParam = 0; iParam < aQueryString.length; iParam++ ){
	      if (aQueryString[iParam].substr(0,cmplen)==cmpstring){
	        var aParam = aQueryString[iParam].split("=");
	        strReturn = aParam[1];
	        bFound=true;
	        break;
	      }

	    }
	  }
	  if (bFound==false) return '';
	  return strReturn;
	}
});

jQuery.fn.outerHTML = function(s) {
return (s)
? this.before(s).remove()
: jQuery("<p>").append(this.eq(0).clone()).html();
}
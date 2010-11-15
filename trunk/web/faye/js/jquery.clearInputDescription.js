jQuery.fn.clearInputDescription = function() {
	return this.each(function() {
	$(this)
		.focus(function(){
			if(this.value == this.title)this.value = '';
	})
		.blur(function(){
			if(this.value == '')this.value = this.title;

	});
	
	});
};
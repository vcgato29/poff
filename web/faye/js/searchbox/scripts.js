jQuery.fn.liveSearch = function (conf) {
	var config = jQuery.extend({
		url:			'/', 
		id:				'jquery-live-search', 
		duration:		0, 
		typeDelay:		200,
		loadingClass:	'loading', 
		onSlideUp:		function () {}, 
		uptadePosition:	false
	}, conf);

	// search result holder
	var liveSearch	= jQuery('#' + config.id);
	
	// Close live-search when clicking outside it
	jQuery(document.body).click(function(event) {
		var clicked = jQuery(event.target);

		if (!(clicked.is('#' + config.id) || clicked.parents('#' + config.id).length || clicked.is('input'))) {
			liveSearch.slideUp(config.duration, function () {
				config.onSlideUp();
			});
		}
	});

	return this.each(function () {
		var input	= jQuery(this).attr('autocomplete', 'off');

		// Shows live-search for this input
		var showLiveSearch = function () {
			liveSearch.slideDown(config.duration);
		};

		// Hides live-search for this input
		var hideLiveSearch = function () {
			liveSearch.slideUp(config.duration, function () {
				config.onSlideUp();
			});
		};

		input
			// On focus, if the live-search is empty, perform an new search
			// If not, just slide it down. 
			.focus(function () {
				if (this.value !== '') { //Only do this if there's something in the input
					
					if (liveSearch.html() == '') { // Perform a new search if there are no search results
						this.lastValue = '';
						input.keyup();
					}
					// If there are search results show live search
					else {
						showLiveSearch();
					}
				}
			})
			// Auto update live-search onkeyup
			.keyup(function () {
				// Don't update live-search if it's got the same value as last time
				if (this.value != this.lastValue) {
					input.addClass(config.loadingClass);

					var q = this.value;

					// Stop previous ajax-request
					if (this.timer) {
						clearTimeout(this.timer);
					}

					// Start a new ajax-request in X ms
					this.timer = setTimeout(function () {
						jQuery.get(config.url + q, function (data) {
							input.removeClass(config.loadingClass);

							// Show live-search if results and search-term aren't empty
							if (data.length && q.length) {
								liveSearch.html(data);
								showLiveSearch();
							}else{
								hideLiveSearch();
							}
						});
					}, config.typeDelay);

					this.lastValue = this.value;
				}
			});
	});
};

		function collectSelectedNodes(){
			var allVals = [];
			$(".structcheck:input:checked").each( function(){
				allVals.push($(this).val());
			} );

			return allVals;
		}

		
		function arrayToQuery( ar, ar_name ){
			var query = '?';
			for( i = 0; i < ar.length; ++i ){
				query = query + ar_name + '=' + ar[i] + '&'; 
			}
			return query;
		} 

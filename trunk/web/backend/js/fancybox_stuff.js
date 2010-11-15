$(document).ready(function(){
	$(".struct_node").click(function() {
		
		var array = this.href.split( "::" );
		frameWidth = array[1] ? array[1] : 100;
		frameHeight = array[2] ? array[2] : 100;
		link = array[0] ? array[0] : this.href;
		
		$.fancybox( {
			'href'	: this.href
		}, {
			frameWidth			: frameWidth + '%',
			frameHeight			: frameHeight + '%',
			type				: 'iframe',
			onCleanup	:	function() {
                parent.$.fancybox.close();
    			parent.location.reload(true);
			}

		});
		
		return false;
	});
	
		$(".lang_node").click(function() {
		
		$.fancybox( {
			'href'	: this.href
		}, {
			frameWidth			: '50%',
			frameHeight			: '50%',
			type				: 'iframe',
			onCleanup	:	function() {
                parent.$.fancybox.close();
    			parent.location.reload(true);
			}

		});
	});
	
		$(".struct_layout").click(function() {
		
		$.fancybox( {
			'href'	: this.href
		}, {
			frameWidth			: '70%',
			frameHeight			: '100%',
			type				: 'iframe',
			onCleanup	:	function() {
			}

		});
	});

	
		var checked_status = false;
		$("#checkboxall").click(function()
		{
			checked_status = !checked_status;
			$('#checkboxall_real').attr(
				'checked',
				checked_status
			);
		
			$("input[type='checkbox']").each(function(){
				this.checked = $('#checkboxall_real').is(':checked');
			});
		});
		

	$("#add_button").click(function() {
		
		$.fancybox( {
			'href'	: this.href
		}, {
			frameWidth			: '100%',
			frameHeight			: '100%',
			type				: 'iframe',
			onCleanup	:	function() {
                parent.$.fancybox.close();
    			parent.location.reload(true);
			}	
		});
	});
	
	$("#addlang_tab").click(function() {
		
		$.fancybox( {
			'href'	: this.href
		}, {
			frameWidth			: '50%',
			frameHeight			: '50%',
			type				: 'iframe',
			onCleanup	:	function() {
                parent.$.fancybox.close();
    			parent.location.reload(true);
			}	
		});
	});
	
	
	
	$('.common_action_tab').click( function(){
		
		var array = this.href.split( "::" );
		
		 var selectedNodes = collectSelectedNodes();
		 if( selectedNodes.length == 0 ){
		 	return false;
		 }
		 var query = arrayToQuery( selectedNodes, 'struct[]' );
		 
		 $.fancybox( {
			'href'	: array[0] + query
		}, {
			frameWidth			: array[1] + '%',
			frameHeight			: array[2] + '%',
			type				: 'iframe',
			onCleanup	:	function() {
				if( array[3] == 1 ){ 
                	parent.$.fancybox.close();
    				parent.location.reload(true);
    			}
			}
		});
		 return false;
	});
	
});


			
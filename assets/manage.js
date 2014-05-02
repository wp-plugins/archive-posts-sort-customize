jQuery(document).ready(function($) {

	$('.apsc .postbox .handlediv').on('click', function( ev ) {
		if( $(ev.target).parent().hasClass('closed') ) {
			$(ev.target).parent().removeClass('closed');
			$(ev.target).parent().children('.inside').show();
		} else {
			$(ev.target).parent().addClass('closed');
			$(ev.target).parent().children('.inside').hide();
		}
	});

	$('.posts_per_page_settings .posts_per_page_fields label input[type=radio]').on('click', function( ev ) {
		post_per_page_toggle();
	});

	function post_per_page_toggle() {

		var PostsPerPage = '';

		$('.apsc .postbox').each( function( box_key , box_el ) {
			$(box_el).find('.posts_per_page_settings .posts_per_page_fields').each( function( key , el ) {
				if( $(el).find('input[type=radio]').prop('checked') ) {
	
					PostsPerPage = $(el).find('input[type=radio]').val();
	
					if( PostsPerPage == 'set' ) {
			
						$(el).parent().find('.posts_per_page_num').removeClass( 'disabled' );
						$(el).parent().find('.posts_per_page_num input').prop( 'disabled' , false );
			
					} else {
			
						$(el).parent().find('.posts_per_page_num').addClass( 'disabled' );
						$(el).parent().find('.posts_per_page_num input').prop( 'disabled' , true );
			
					}
	
				}
			});
		});
		
	}
	post_per_page_toggle();

	$('.orderby_settings .orderby_fields select').on('change', function( ev ) {
		order_by_toggle();
	});

	function order_by_toggle() {

		var OrderBy = '';

		$('.apsc .postbox').each( function( box_key , box_el ) {
				
			OrderBy = $(box_el).find('.orderby_settings .orderby_fields select option:selected').val();

			if( OrderBy == 'custom_fields' ) {
					
				$(box_el).find('.orderby_customfields_settings .orderby_custom_fields').slideDown();
		
			} else {
		
				$(box_el).find('.orderby_customfields_settings .orderby_custom_fields').slideUp();
		
			}

		});

	}
	order_by_toggle();

	$('.apsc .postbox .orderby_custom_fields .all_custom_fields').on('click', function ( ev ) {
		
		$(ev.target).parent().parent().find('.custom_fields_lists').slideDown();
		
		return false;

	});

	$('.apsc .postbox .orderby_custom_fields .custom_fields_lists li .custom_fields_target_click').on('click', function ( ev ) {
		
		$(ev.target).parent().parent().parent().find('.orderby_set').val( $(ev.target).text() );
		
		return false;

	});

	$('.apsc .postbox .inside .use_val').on('click', function ( ev ) {
		
		if( $(ev.target).prop('checked') ) {
			
			$(ev.target).parent().parent().find('table.form-table').removeClass( 'disabled' );
			
		} else {
			
			$(ev.target).parent().parent().find('table.form-table').addClass( 'disabled' );
			
		}
		
	});

});

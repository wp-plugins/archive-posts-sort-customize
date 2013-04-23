jQuery(document).ready(function($) {

	var $Form = $("#archive_posts_sort_customize_form");
	
	var $PostPerPageSet = $(".posts_per_page_num input" , $Form);

	var $SortTargetSet = $(".orderby_custom_fields" , $Form);
	var $SortTargetInput = $(".orderby_custom_fields #orderby_set" , $Form);

	// posts par page setting
	$(".posts_per_page input[type=radio]" , $Form).click(function() {
		$PostPerPage = $(this).val();

		if( $PostPerPage == 'set' ) {
			$PostPerPageSet.attr( 'disabled' , false );
			$PostPerPageSet.removeClass( 'disabled' );
		} else {
			$PostPerPageSet.attr( 'disabled' , true );
			$PostPerPageSet.addClass( 'disabled' );
		}
	});

	// orderby setting
	$(".orderby select" , $Form).change(function() {
		$SortTarget = $(this).val();

		if( $SortTarget == 'custom_fields' ) {
			$SortTargetSet.removeClass( 'disabled' );
			$SortTargetInput.attr( 'disabled' , false );
			$SortTargetInput.removeClass( 'disabled' );
		} else {
			$SortTargetSet.addClass( 'disabled' );
			$SortTargetInput.attr( 'disabled' , true );
			$SortTargetInput.addClass( 'disabled' );
		}
		
	});


	// default

	// post par page setting
	$PostParPageChecked = $(".posts_per_page input[type=radio]:checked" , $Form);
	if( $PostParPageChecked.val() != 'set' ) {
		$PostPerPageSet.attr( 'disabled' , true );
		$PostPerPageSet.addClass( 'disabled' );
	}

	// orderby setting
	$SortTargetSelected = $(".orderby select option:selected" , $Form);
	if( $SortTargetSelected.val() != 'custom_fields' ) {
		$SortTargetSet.addClass( 'disabled' );
		$SortTargetInput.attr( 'disabled' , true );
		$SortTargetInput.addClass( 'disabled' );
	}

	$(".all_custom_fields").click(function() {
		$(".custom_fields_lists").slideToggle();
	});
	
	$(".custom_fields_target_click").click(function() {
		$SortTargetInput.val( $(this).text() );
	});

});

<?php

class APSC_Filter
{

	function init() {
		
		if( !is_admin() ) {

			add_action( 'pre_get_posts' , array( $this , 'archive_sort' ) );

		}

	}

	function archive_sort( $query ) {
		
		global $wpdb;
		global $APSC;
		
		
		if( $query->is_main_query() ) {

			$Data = $this->get_data( $query );
			
			if( !empty( $Data ) && !empty( $Data['posts_per_page'] ) ) {
				
				if( $Data['posts_per_page'] == 'all' ) {

					$query->set( 'posts_per_page' , -1 );

				} elseif( $Data['posts_per_page'] == 'set' && !empty( $Data['posts_per_page_num'] ) ) {

					$query->set( 'posts_per_page' , intval( $Data['posts_per_page_num'] ) );

				}
				
				if( !empty( $Data["orderby"] ) ) {

					if( $Data['orderby'] != 'date' ) {

						if( $Data["orderby"] == 'custom_fields' && !empty( $Data["orderby_set"] ) ) {
	
							$custom_fields = $wpdb->get_col( "SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE `meta_key` LIKE '%" . strip_tags( $Data['orderby_set'] ) . "%' ORDER BY meta_value" );
							
							$numeric = true;

							foreach( $custom_fields as $cf ) {

								if( !is_numeric( $cf ) ) {

									$numeric = false;
									break;

								}

							}

							if( $numeric ) {

								$query->set( 'orderby' , 'meta_value_num' );

							} else {

								$query->set( 'orderby' , 'meta_value' );

							}

							$query->set( 'meta_key' , strip_tags( $Data['orderby_set'] ) );

						} else {
							
							$query->set( 'orderby' , strip_tags( $Data['orderby'] ) );
							
						}

					}

				}

				if( !empty( $Data['order'] ) ) {

					if( $Data["order"] != 'desc' ) {

						$query->set( 'order' , 'ASC' );

					} else {

						$query->set( 'order' , 'DESC' );

					}

				}

			}
			
		}
		
	}
	
	function get_data( $query ) {
		
		$Data = array();
		$APSC_Data = new APSC_Data();

		if( $query->is_home() ) {

			$GetData = $APSC_Data->get_data( 'home' );

		} elseif( $query->is_category() ) {

			$CatData = $APSC_Data->get_data( 'cat' );
			$current_cat_id = $query->get_queried_object()->cat_ID;

			if( !empty( $CatData[$current_cat_id] ) && !empty( $CatData[$current_cat_id]['use'] ) ) {

				$GetData['default'] = $CatData[$current_cat_id];

			} elseif( !empty( $CatData['default'] ) ) {

				$GetData['default'] = $CatData['default'];
				
			} elseif( !empty( $CatData['default'] ) ) {

				$GetData = '';
				
			}

		} elseif( $query->is_tag() ) {

			$GetData = $APSC_Data->get_data( 'tag' );

		} elseif( $query->is_search() ) {

			$GetData = $APSC_Data->get_data( 'search' );

		} elseif( $query->is_archive() && $query->is_month() ) {

			$GetData = $APSC_Data->get_data( 'monthly' );

		}

		if( !empty( $GetData ) && !empty( $GetData['default'] ) ) {

			$Data = $GetData['default'];

		}
		
		return $Data;
		
	}

}
?>
<?php

$ViewLink = '';

if( $this->SetArchive == 'home' ) {
	$ViewLink = array( home_url( '/' ) , __( 'Home' ) );
} elseif( $this->SetArchive == 'cat' ) {
	$Category = get_categories( array( 'number' => 1 , 'orderby' => 'ID' , 'hide_empty' => true) );
	if( !empty( $Category ) ) {
		$ViewLink = array( get_category_link( $Category[0]->cat_ID ) , __( 'Categories' ) );
	}
} elseif( $this->SetArchive == 'tag' ) {
	$Tag = get_tags( array( 'number' => 1 , 'orderby' => 'ID' , 'hide_empty' => true) );
	if( !empty( $Tag ) ) {
		$ViewLink = array( get_tag_link( $Tag[0]->term_id ) , __( 'Tags' ) );
	}
} elseif( $this->SetArchive == 'search' ) {
	$ViewLink = array( get_search_link( 'Hello' ) , __( 'Search' ) );
} elseif( $this->SetArchive == 'monthly' ) {
	$currentDate = array( "y" => gmdate( 'Y' , current_time( 'timestamp' ) ) , "m" => gmdate( 'm' , current_time('timestamp') ) );
	$ViewLink = array( get_month_link( $currentDate["y"] , $currentDate["m"] ) , __( 'Monthly' , $this->ltd ) . __( 'Archives' ) );
}



// include js css
$ReadedJs = array( 'jquery' , 'jquery-ui-sortable' );
wp_enqueue_script( $this->PageSlug ,  $this->Url . $this->PluginSlug . '.js', $ReadedJs , $this->Ver );
wp_enqueue_style( $this->PageSlug , $this->Url . $this->PluginSlug . '.css', array() , $this->Ver );

// get data
$Data = $this->get_data( $this->SetArchive );

?>

<div class="wrap">
	<div class="icon32" id="icon-options-general"></div>
	<h2><?php echo $this->SetTitle; ?></h2>
	<?php echo $this->Msg; ?>
	<p><?php _e( 'Please set your favorite.' , $this->ltd ); ?></p>
	
	<?php if( !empty( $ViewLink ) ) : ?>
		<p><?php _e( 'View' ); ?> : <a href="<?php echo $ViewLink[0]; ?>" target="_blank"><?php echo $ViewLink[1]; ?></a></p>
	<?php endif; ?>

	<div class="metabox-holder columns-2 <?php echo $this->ltd; ?>">

		<div id="postbox-container-1" class="postbox-container">

			<form id="archive_posts_sort_customize_form" method="post" action="<?php echo remove_query_arg( $this->MsgQ ); ?>">
				<input type="hidden" name="<?php echo $this->UPFN; ?>" value="Y">
				<?php wp_nonce_field( $this->Nonces["value"] , $this->Nonces["field"] ); ?>
				<input type="hidden" name="record_field" value="<?php echo $this->SetArchive; ?>" />

				<div class="postbox">

					<h3><?php _e( 'Sort settings' , $this->ltd ); ?></h3>

					<div class="inside">

						<table class="form-table">
							<tbody>

								<?php $field = 'posts_per_page'; ?>
								<tr>
									<th><?php _e( 'Number of posts per page' , $this->ltd ); ?></th>
									<td>
										<?php $posts_per_page = false; ?>
										<?php if( !empty( $Data[$field] ) ) : ?>
											<?php $posts_per_page = $Data[$field]; ?>
										<?php endif; ?>
										<?php $posts_per_page_num = false; ?>
										<?php if( !empty( $Data[$field . '_num'] ) ) : ?>
											<?php $posts_per_page_num = $Data[$field . '_num']; ?>
										<?php endif; ?>
										<?php $this->get_sorting_posts_per_page( $posts_per_page , $posts_per_page_num ); ?>
									</td>
								</tr>

								<?php $field = 'orderby'; ?>
								<tr>
									<th><?php _e( 'Sort target' , $this->ltd ); ?></th>
									<td>
										<?php $orderby = false; ?>
										<?php if( !empty( $Data[$field] ) ) : ?>
											<?php $orderby = $Data[$field]; ?>
										<?php endif; ?>
										<?php $orderbyset = false; ?>
										<?php if( !empty( $Data[$field . '_set'] ) ) : ?>
											<?php $orderbyset = $Data[$field . '_set']; ?>
										<?php endif; ?>
										<?php $this->get_sorting_orderby( $orderby , $orderbyset ); ?>
									</td>
								</tr>

								<?php $field = 'order'; ?>
								<tr>
									<th><?php _e( 'Order' ); ?></th>
									<td>
										<?php $order = false; ?>
										<?php if( !empty( $Data[$field] ) ) : ?>
											<?php $order = $Data[$field]; ?>
										<?php endif; ?>
										<?php $this->get_sorting_order( $order ); ?>
									</td>
								</tr>
							</tbody>
						</table>

						<p class="submit">
							<input type="submit" class="button-primary" name="update" value="<?php _e( 'Save' ); ?>" />
						</p>

					</div>
	
				</div>

				<p class="submit reset">
					<span class="description"><?php _e( 'Reset all settings?' , $this->ltd ); ?></span>
					<input type="submit" class="button-secondary" name="reset" value="<?php _e( 'Reset settings' , $this->ltd ); ?>" />
				</p>

			</form>

		</div>

		<div id="postbox-container-2" class="postbox-container">

			<?php include_once 'donation.php'; ?>

		</div>

		<div class="clear"></div>

	</div>

</div>

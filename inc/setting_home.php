<?php

if( !empty( $_POST["reset"] ) ) {
	$this->update_reset();
} elseif( !empty( $_POST["update"] ) ) {
	$this->update();
}

// include js css
$ReadedJs = array( 'jquery' , 'jquery-ui-sortable' , 'thickbox' );
wp_enqueue_script( $this->Slug ,  $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.js', $ReadedJs , $this->Ver );
wp_enqueue_style( $this->Slug , $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.css', array() , $this->Ver );
wp_enqueue_style( 'thickbox' );

// get data
$Data = $this->get_data( 'home' );

?>

<div class="wrap">
	<div class="icon32" id="icon-options-general"></div>
	<h2><?php _e( 'Home Archive Sort Customize' , $this->ltd ); ?></h2>
	<?php echo $this->Msg; ?>
	<p><?php _e( 'Please set your favorite.' , $this->ltd ); ?></p>
	<?php $Url = get_option( 'home' ); ?>
		<p><?php _e( 'View' ); ?> : <a href="<?php echo $Url; ?>?TB_iframe=1" class="thickbox"><?php echo _e( 'Home' ); ?></a></p>

	<div class="metabox-holder columns-2 <?php echo $this->ltd; ?>">

		<div id="postbox-container-1" class="postbox-container">

			<form id="archive_posts_sort_customize_form" method="post" action="">
				<input type="hidden" name="<?php echo $this->UPFN; ?>" value="Y">
				<?php wp_nonce_field(); ?>

				<input type="hidden" name="set_sort" value="home" />
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
					<input type="submit" class="button-secondary" name="reset" value="<?php _e( 'Reset' ); ?>" />
				</p>

			</form>

		</div>

		<div id="postbox-container-2" class="postbox-container">

			<?php include_once 'donation.php'; ?>

		</div>

		<div class="clear"></div>

	</div>

</div>

<?php

if( !empty( $_POST["reset"] ) ) {
	$this->update_reset();
} elseif( !empty( $_POST["update"] ) ) {
	$this->update();
}

// include js css
$ReadedJs = array( 'jquery' , 'jquery-ui-sortable' );
wp_enqueue_script( $this->Slug ,  $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.js', $ReadedJs , $this->Ver );
wp_enqueue_style( $this->Slug , $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.css', array() , $this->Ver );

// get data
$Data = $this->get_data( 'tag' );

?>

<div class="wrap">
	<div class="icon32" id="icon-options-general"></div>
	<h2><?php _e( 'Tag Archive Sort Customize' , $this->ltd ); ?></h2>
	<?php echo $this->Msg; ?>
	<p><?php _e( 'Please set your favorite.' , $this->ltd ); ?></p>

	<div class="metabox-holder columns-2 <?php echo $this->ltd; ?>">

		<div id="postbox-container-1" class="postbox-container">

			<form id="archive_posts_sort_customize_form" method="post" action="">
				<input type="hidden" name="<?php echo $this->UPFN; ?>" value="Y">
				<?php wp_nonce_field(); ?>

				<input type="hidden" name="set_sort" value="tag" />
				<div class="postbox">

					<h3><?php _e( 'Sort settings' , $this->ltd ); ?></h3>

					<div class="inside">

						<table class="form-table">
							<tbody>

								<?php $field = 'posts_per_page'; ?>
								<tr>
									<th><?php _e( 'Number of posts per page' , $this->ltd ); ?></th>
									<td>
										<p><?php echo sprintf( __( 'The default is <strong>%s</strong>.' , $this->ltd ) , __( 'Follow Reading Setting' , $this->ltd ) ); ?></p>
										<?php
											$PostParPageList = array(
												"all" => __( 'View all posts' , $this->ltd ) , "default" => __( 'Follow Reading Setting' , $this->ltd ) , "set" => __( 'Set the number of posts' , $this->ltd )
											);
										?>
										
										<?php foreach( $PostParPageList as $type => $type_label ) : ?>
											<?php $Checked = ''; ?>
											<?php if( !empty( $Data[$field] ) ) : ?>
												<?php if( $Data[$field] == $type ) : ?>
													<?php $Checked = 'checked="checked"'; ?>
												<?php endif; ?>
											<?php endif; ?>
											<div class="<?php echo $field; ?>">
												<label>
													<input type="radio" name="data[<?php echo $field ?>]" value="<?php echo $type; ?>" <?php echo $Checked; ?> /> <?php echo $type_label; ?>
													<?php if( $type == 'default' ) : ?>
														<span class="description"><?php _e( 'Current number of Reading Setting' , $this->ltd ); ?> : </span> <strong><?php echo get_option( 'posts_per_page' ); ?></strong><?php _e( 'posts' ); ?>
													<?php endif; ?>
												</label>
												<?php if( $type == 'set' ) : ?>
													<span class="<?php echo $field; ?>_num">
														<?php $val = ''; ?>
														<?php if( !empty( $Data[$field] ) && $Data[$field] == 'set' && !empty( $Data[$field.'_num'] ) ) : ?>
															<?php $val = strip_tags( $Data[$field.'_num'] ); ?>
														<?php endif; ?>
														<input type="text" class="small-text" id="<?php echo $field; ?>_num" name="data[<?php echo $field ?>_num]" value="<?php echo $val; ?>" /> <?php _e( 'posts' ); ?>
													</span>
												<?php endif; ?>
											</div>
										<?php endforeach; ?>
										<p>&nbsp;</p>
									</td>
								</tr>

								<?php $field = 'orderby'; ?>
								<tr>
									<th><?php _e( 'Sort target' , $this->ltd ); ?></th>
									<td>
										<p><?php echo sprintf( __( 'The default is <strong>%s</strong>.' , $this->ltd ) , __( 'Date' ) ); ?></p>
										<?php
											$SortTarget = array(
												"date" => __( 'Date' ) , "title" => __( 'Title' ) , "author" => __( 'Author' ) ,
												"comment_count" => __( 'Comments Count' , $this->ltd ) , "id" => 'ID' , "custom_fields" => __( 'Custom Fields' )
											);
										?>
										
										<div class="<?php echo $field; ?>">
											<select name="data[<?php echo $field; ?>]">
												<?php foreach( $SortTarget as $type => $type_label ) : ?>
													<?php $Selected = ''; ?>
													<?php if( !empty( $Data[$field] ) ) : ?>
														<?php if( $Data[$field] == $type ) : ?>
															<?php $Selected = 'selected="selected"'; ?>
														<?php endif; ?>
													<?php endif; ?>
													<option value="<?php echo $type; ?>" <?php echo $Selected; ?>><?php echo $type_label; ?></option>
												<?php endforeach; ?>
											</select>
										</div>

										<div class="<?php echo $field; ?>_custom_fields">
											<p class="description"><?php _e( 'Please enter the name of the custom field you want to sort.' , $this->ltd ); ?></p>
											<?php $val = ''; ?>
											<?php if( !empty( $Data[$field] ) && $Data[$field] == 'custom_fields' && !empty( $Data['orderby_set'] ) ) : ?>
												<?php $val = strip_tags( $Data['orderby_set'] ); ?>
											<?php endif; ?>
											<p><?php _e( 'Custom Fields Name' , $this->ltd ); ?> : <input type="text" class="regular-text" id="<?php echo $field; ?>_set" name="data[<?php echo $field ?>_set]" value="<?php echo $val; ?>" /></p>
											<p><a href="javascript:void(0);" class="all_custom_fields"><?php _e( 'Click here, please look for the required custom fields if you do not know the name of the custom field.' , $this->ltd ); ?></a></p>
											<div class="custom_fields_lists">
												<?php $this->get_custom_fields(); ?>
											</div>
										</div>
										<p>&nbsp;</p>
									</td>
								</tr>

								<?php $field = 'order'; ?>
								<tr>
									<th><?php _e( 'Order' ); ?></th>
									<td>
										<?php $Sort = array( "desc" => __( 'Descending' ) , "asc" => __( 'Ascending' ) ); ?>

										<p><?php echo sprintf( __( 'The default is <strong>%s</strong>.' , $this->ltd ) , __( 'Descending' ) ); ?></p>
										<select name="data[<?php echo $field; ?>]">
											<?php foreach( $Sort as $type => $type_label ) : ?>
												<?php $Selected = ''; ?>
												<?php if( !empty( $Data[$field] ) ) : ?>
													<?php if( $Data[$field] == $type ) : ?>
														<?php $Selected = 'selected="selected"'; ?>
													<?php endif; ?>
												<?php endif; ?>
												<option value="<?php echo $type; ?>" <?php echo $Selected; ?>><?php echo $type_label; ?></option>
											<?php endforeach; ?>
										</select>
										<p><strong><?php _e( 'Ascending' ); ?></strong> : <?php _e( 'From old to new' , $this->ltd ); ?> &amp; <?php _e( 'From small to many' , $this->ltd ); ?> &amp; A to Z</p>
										<p><strong><?php _e( 'Descending' ); ?></strong> : <?php _e( 'From new to old' , $this->ltd ); ?> &amp; <?php _e( 'From many to small' , $this->ltd ); ?> &amp;  Z to A</p>
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
					<span class="description"><?php _e( 'Would initialize?' , $this->ltd ); ?></span>
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

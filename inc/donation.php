<?php
$donatedKey = get_option( $this->ltd . '_donated' );
if( $donatedKey == $this->DonateKey ) : 
?>
			<span class="description"><?php _e( 'Thank you for your donate.' , $this->ltd_p ); ?></span>

<?php else: ?>

			<div class="stuffbox" style="border-color: #FFC426; border-width: 3px;">
				<h3 style="background: #FFF2D0; border-color: #FFC426;"><span class="hndle"><?php _e( 'How may I help you?' , $this->ltd_p ); ?></span></h3>
				<div class="inside">
					<p style="float: right;">
						<img src="<?php echo $this->Schema; ?>www.gravatar.com/avatar/7e05137c5a859aa987a809190b979ed4?s=46" width="46" /><br />
						<a href="<?php echo $this->AuthorUrl; ?>contact-us/?utm_source=use_plugin&utm_medium=side&utm_content=<?php echo $this->ltd; ?>&utm_campaign=<?php echo str_replace( '.' , '_' , $this->Ver ); ?>" target="_blank">gqevu6bsiz</a>
					</p>
					<p><?php _e( 'I am good at Admin Screen Customize.' , $this->ltd_p ); ?></p>
					<p><?php _e( 'Please consider the request to me if it is good.' , $this->ltd_p ); ?></p>
					<p>
						<a href="http://wpadminuicustomize.com/blog/category/example/?utm_source=use_plugin&utm_medium=side&utm_content=<?php echo $this->ltd; ?>&utm_campaign=<?php echo str_replace( '.' , '_' , $this->Ver ); ?>" target="_blank"><?php _e ( 'Example Customize' , $this->ltd_p ); ?></a> :
						<a href="<?php echo $this->AuthorUrl; ?>contact-us/?utm_source=use_plugin&utm_medium=side&utm_content=<?php echo $this->ltd; ?>&utm_campaign=<?php echo str_replace( '.' , '_' , $this->Ver ); ?>" target="_blank"><?php _e( 'Contact me' , $this->ltd_p ); ?></a></p>
				</div>
			</div>

			<div class="stuffbox" id="donationbox">
				<div class="inside">
					<p style="color: #FFFFFF; font-size: 20px;"><?php _e( 'Please donate.' , $this->ltd_p ); ?></p>
					<p style="color: #FFFFFF;"><?php _e( 'You are contented with this plugin?<br />By the laws of Japan, Japan\'s new paypal user can not make a donate button.<br />So i would like you to buy this plugin as the replacement for the donate.' , $this->ltd_p ); ?></p>
					<p>&nbsp;</p>
					<p style="text-align: center;">
						<a href="<?php echo $this->AuthorUrl; ?>line-break-first-and-end/?utm_source=use_plugin&utm_medium=donate&utm_content=<?php echo $this->ltd; ?>&utm_campaign=<?php echo str_replace( '.' , '_' , $this->Ver ); ?>" class="button-primary" target="_blank">Line Break First and End</a>
					</p>
					<p>&nbsp;</p>
					<div class="donation_memo">
						<p><strong><?php _e( 'Features' , $this->ltd_p ); ?></strong></p>
						<p><?php _e( 'Line Break First and End plugin is In the visual editor TinyMCE, It is a plugin that will help when you will not be able to enter a line break.' , $this->ltd_p ); ?></p>
					</div>
					<div class="donation_memo">
						<p><strong><?php _e( 'The primary use of donations' , $this->ltd_p ); ?></strong></p>
						<ul>
							<li>- <?php _e( 'Liquidation of time and value' , $this->ltd_p ); ?></li>
							<li>- <?php _e( 'Additional suggestions feature' , $this->ltd_p ); ?></li>
							<li>- <?php _e( 'Maintain motivation' , $this->ltd_p ); ?></li>
							<li>- <?php _e( 'Ensure time as the father of Sunday' , $this->ltd_p ); ?></li>
						</ul>
					</div>

					<form id="donation_form" method="post" action="">
						<h4 style="color: #FFF;"><?php _e( 'If you have already donated to.' , $this->ltd_p ); ?></h4>
						<p style="color: #FFF;"><?php _e( 'Please enter the \'Donate delete key\' that have been described in the \'Line Break First and End download page\'.' , $this->ltd_p ); ?></p>
						<input type="hidden" name="<?php echo $this->UPFN; ?>" value="Y" />
						<?php wp_nonce_field(); ?>
						<label for="donate_key"><span style="color: #FFF; "><?php _e( 'Donate delete key' , $this->ltd_p ); ?></span></label>
						<input type="text" name="donate_key" id="donate_key" value="" class="small-text" />
						<input type="submit" class="button-secondary" name="update" value="<?php _e( 'Submit' ); ?>" />
					</form>

				</div>
			</div>

<?php endif; ?>

			<div class="stuffbox" id="aboutbox">
				<h3><span class="hndle"><?php _e( 'About plugin' , $this->ltd_p ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Version check' , $this->ltd_p ); ?> : 3.4.2 - 3.6</p>
					<ul>
						<li><a href="<?php echo $this->AuthorUrl; ?>?utm_source=use_plugin&utm_medium=side&utm_content=<?php echo $this->ltd; ?>&utm_campaign=<?php echo str_replace( '.' , '_' , $this->Ver ); ?>" target="_blank"><?php _e( 'Developer\'s site' , $this->ltd_p ); ?></a></li>
						<li><a href="http://wordpress.org/support/plugin/<?php echo $this->PluginSlug; ?>" target="_blank"><?php _e( 'Support Forums' ); ?></a></li>
						<li><a href="http://wordpress.org/support/view/plugin-reviews/<?php echo $this->PluginSlug; ?>" target="_blank"><?php _e( 'Reviews' , $this->ltd_p ); ?></a></li>
						<li><a href="https://twitter.com/gqevu6bsiz" target="_blank">twitter</a></li>
						<li><a href="http://www.facebook.com/pages/Gqevu6bsiz/499584376749601" target="_blank">facebook</a></li>
					</ul>
					<?php $mofile = $this->TransFileCk(); ?>
					<?php if( empty( $mofile ) ) : ?>
						<p>
							I am looking for a translator for this plugin.<br />
							<a href="<?php echo $this->AuthorUrl; ?>please-translation/?utm_source=use_plugin&utm_medium=side&utm_content=<?php echo $this->ltd; ?>&utm_campaign=<?php echo str_replace( '.' , '_' , $this->Ver ); ?>" target="_blank">Please translation.</a>
						</p>
					<?php endif; ?>
					<p><?php echo sprintf( __( 'Do you have a proposal you want to improve? Please contact to %s if it is necessary.' , $this->ltd_p ) , '<a href="http://wordpress.org/support/plugin/' . $this->PluginSlug . '" target="_blank">' . __( 'Support Forums' ) . '</a>' ); ?></p>
				</div>
			</div>

			<div class="stuffbox" id="usefulbox">
				<h3><span class="hndle"><?php _e( 'Useful plugins' , $this->ltd_p ); ?></span></h3>
				<div class="inside">
					<p><strong><a href="http://wordpress.org/extend/plugins/wp-admin-ui-customize/" target="_blank">WP Admin UI Customize</a></strong></p>
					<p class="description"><?php _e( 'Customize a variety of screen management.' , $this->ltd_p ); ?></p>
					<p><strong><a href="http://wordpress.org/extend/plugins/post-lists-view-custom/" target="_blank">Post Lists View Custom</a></strong></p>
					<p class="description"><?php _e( 'Customize the list of the post and page. custom post type page, too. You can customize the column display items freely.' , $this->ltd_p ); ?></p>
					<p><strong><a href="http://wordpress.org/extend/plugins/custom-options-plus-post-in/" target="_blank">Custom Options Plus Post in</a></strong></p>
					<p class="description"><?php _e( 'The plugin that allows you to add the value of the options. Option value that you have created, can be used in addition to the template tag, Short code can be used in the body of the article.' , $this->ltd_p ); ?></p>
					<p>&nbsp;</p>
				</div>
			</div>

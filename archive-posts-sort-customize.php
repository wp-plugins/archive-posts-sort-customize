<?php
/*
Plugin Name: Archive Posts Sort Customize
Description: Customize the display order of the list of Archive Posts.
Plugin URI: http://wordpress.org/extend/plugins/archive-posts-sort-customize/
Version: 1.0
Author: gqevu6bsiz
Author URI: http://gqevu6bsiz.chicappa.jp/?utm_source=use_plugin&utm_medium=list&utm_content=apsc&utm_campaign=1_0
Text Domain: apsc
Domain Path: /languages
*/

/*  Copyright 2012 gqevu6bsiz (email : gqevu6bsiz@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/





class APSC
{

	var $Ver,
		$Name,
		$Dir,
		$ltd,
		$ltd_do,
		$Slug,
		$RecordBaseName,
		$UPFN,
		$Msg;


	function __construct() {
		$this->Ver = '1.0';
		$this->Name = 'Archive Post Sort Customize';
		$this->Dir = WP_PLUGIN_URL . '/' . dirname( plugin_basename( __FILE__ ) ) . '/';
		$this->ltd = 'apsc';
		$this->ltd_do = $this->ltd . '_donation';
		$this->Slug = 'archive_posts_sort_customize';
		$this->RecordBaseName = '_archive_posts_sort_custom';
		$this->UPFN = 'Y';
		$this->DonateKey = 'd77aec9bc89d445fd54b4c988d090f03';
		$this->Msg = '';

		$this->PluginSetup();
		add_action( 'init' , array( $this , 'FilterStart' ) );
	}

	// PluginSetup
	function PluginSetup() {
		// load text domain
		load_plugin_textdomain( $this->ltd , false , basename( dirname( __FILE__ ) ) . '/languages' );
		load_plugin_textdomain( $this->ltd_do , false , basename( dirname( __FILE__ ) ) . '/languages' );

		// plugin links
		add_filter( 'plugin_action_links' , array( $this , 'plugin_action_links' ) , 10 , 2 );

		// add menu
		add_action( 'admin_menu' , array( $this , 'admin_menu' ) );
	}

	// PluginSetup
	function plugin_action_links( $links , $file ) {
		if( plugin_basename(__FILE__) == $file ) {

			$mofile = $this->TransFileCk();
			if( $mofile == false ) {
				$translation_link = '<a href="http://gqevu6bsiz.chicappa.jp/please-translation/?utm_source=use_plugin&utm_medium=side&utm_content=' . $this->ltd . '&utm_campaign=' . str_replace( '.' , '_' , $this->Ver ) . '" target="_blank">Please translation</a>'; 
				array_unshift( $links, $translation_link );
			}
			$support_link = '<a href="http://wordpress.org/support/plugin/archive-posts-sort-customize" target="_blank">' . __( 'Support Forums' ) . '</a>';
			array_unshift( $links, $support_link );
			array_unshift( $links, '<a href="' . admin_url( 'admin.php?page=' . $this->Slug ) . '">' . __('Settings') . '</a>' );

		}
		return $links;
	}

	// PluginSetup
	function admin_menu() {
		add_menu_page( __( 'Category Archive Sort Customize' , $this->ltd ) , __( 'Category Archive Sort Customize' , $this->ltd ) , 'administrator', $this->Slug , array( $this , 'setting_cat') );
		add_submenu_page( $this->Slug , __( 'Tag Archive Sort Customize' , $this->ltd ) , __( 'Tag Archive Sort Customize' , $this->ltd ) , 'administrator' , 'page' . $this->RecordBaseName , array( $this , 'setting_tag' ) );
	}

	// Translation File Check
	function TransFileCk() {
		$file = false;
		$moFile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $this->ltd . '-' . get_locale() . '.mo';
		if( file_exists( $moFile ) ) {
			$file = true;
		}
		return $file;
	}



	// SettingPage
	function setting_cat() {
		add_filter( 'admin_footer_text' , array( $this , 'layout_footer' ) );
		$this->DisplayDonation();
		include_once 'inc/setting_cat.php';
	}

	// SettingPage
	function setting_tag() {
		add_filter( 'admin_footer_text' , array( $this , 'layout_footer' ) );
		$this->DisplayDonation();
		include_once 'inc/setting_tag.php';
	}



	// Data get
	function get_data( $type ) {
		$GetData = get_option( $type . $this->RecordBaseName );

		$Data = array();
		if( !empty( $GetData ) ) {
			$Data = $GetData;
		}
		
		return $Data;
	}


	// Setting Item
	function get_custom_fields() {
		global $wpdb;

		$Contents = '';
		
		// All Post Custom Field meta
		$Acfk = $wpdb->get_col( "SELECT meta_key FROM $wpdb->postmeta GROUP BY meta_key HAVING meta_key NOT LIKE '\_%' ORDER BY meta_key" );
		if(!empty($Acfk)) {
			natcasesort($Acfk);
		}
		
		echo '<ul>';
		foreach( $Acfk as $field_name ) {
			echo '<li><a href="javascript:void(0);" class="custom_fields_target_click">' . $field_name . '</a></li>';
		}
		echo '</ul>';
	}
	

	// Update Setting
	function update() {
		$UPFN = strip_tags( $_POST[$this->UPFN] );
		if( $UPFN == 'Y' ) {
			unset( $_POST[$this->UPFN] );

			// donated
			if( !empty( $_POST["donate_key"] ) ) {

				$SubmitKey = md5( strip_tags( $_POST["donate_key"] ) );
				if( $this->DonateKey == $SubmitKey ) {
					update_option( $this->ltd . '_donated' , $SubmitKey );
					$this->Msg .= '<div class="updated"><p><strong>' . __( 'Thank you for your donation.' , $this->ltd_do ) . '</strong></p></div>';
				}

			} elseif( !empty( $_POST["data"] ) ) {

				$Update = array();
				foreach($_POST["data"] as $key => $val) {
					if( !empty( $val ) ) {
						$Update[strip_tags( $key )] = strip_tags( $val );
					}
				}
	
				if(!empty( $Update )) {
					$Record = strip_tags( $_POST["set_sort"] ) . $this->RecordBaseName;
					update_option( $Record , $Update );
					$this->Msg .= '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
				}

			}

		}
	}

	// Update Reset
	function update_reset() {
		$Record = strip_tags( $_POST["set_sort"] ) . $this->RecordBaseName;
		delete_option( $Record );
		$this->Msg .= '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
	}


	// FilterStart
	function FilterStart() {
		if( !is_admin() ) {
			// front only
			add_action( 'pre_get_posts' , array( $this , 'Archive_Sort' ) );
		}
	}

	// FilterStart
	function Archive_Sort( $query ) {
		global $wpdb;
		$Data = array();
		
		if( $query->is_category() ) {
			$GetData = $this->get_data( 'category' );
			if( !empty( $GetData ) ) {
				$Data = $GetData;
			}
		} elseif( $query->is_tag() ) {
			$GetData = $this->get_data( 'tag' );
			if( !empty( $GetData ) ) {
				$Data = $GetData;
			}
		}
		
		if( !empty( $Data ) && $query->is_main_query() ) {
			// posts_per_page
			if( !empty( $Data["posts_per_page"] ) ) {
				if( $Data["posts_per_page"] == 'all' ) {
					$query->set( 'post_per_page' , -1 );
				} elseif( $Data["posts_per_page"] == 'set' ) {
					$query->set( 'posts_per_page' , strip_tags( $Data["posts_per_page_num"] ) );
				}
			}
			// orderby
			if( !empty( $Data["orderby"] ) ) {
				if( $Data["orderby"] != 'date' ) {
					if( $Data["orderby"] == 'custom_fields' ) {
						$Pcf = $wpdb->get_col( "SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE `meta_key` LIKE '%" . strip_tags( $Data["orderby_set"] ) . "%' ORDER BY meta_value" );
						$numeric = true;
						foreach( $Pcf as $cf ) {
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
						$query->set( 'meta_key' , strip_tags( $Data["orderby_set"] ) );
					} else {
						$query->set( 'orderby' , strip_tags( $Data["orderby"] ) );
					}
				}
			}
			// order
			if( !empty( $Data["order"] ) ) {
				if( $Data["order"] != 'desc' ) {
					$query->set( 'order' , 'ASC' );
				}
			}
		}
		
	}

	

	// FilterStart
	function layout_footer( $text ) {
		$text = '<img src="http://www.gravatar.com/avatar/7e05137c5a859aa987a809190b979ed4?s=18" width="18" /> Plugin developer : <a href="http://gqevu6bsiz.chicappa.jp/?utm_source=use_plugin&utm_medium=footer&utm_content=' . $this->ltd . '&utm_campaign=' . str_replace( '.' , '_' , $this->Ver ) . '" target="_blank">gqevu6bsiz</a>';
		return $text;
	}

	// FilterStart
	function DisplayDonation() {
		$donation = get_option( $this->ltd . '_donated' );
		if( $this->DonateKey != $donation ) {
			$this->Msg .= '<div class="error"><p><strong>' . __( 'Please consider a donation if you are satisfied with this plugin.' , $this->ltd_do ) . '</strong></p></div>';
		}
	}


}

$APSC = new APSC();

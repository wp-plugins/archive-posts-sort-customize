<?php
/*
Plugin Name: Archive Posts Sort Customize
Description: Customize the display order of the list of Archive Posts.
Plugin URI: http://wordpress.org/extend/plugins/archive-posts-sort-customize/
Version: 1.2.4
Author: gqevu6bsiz
Author URI: http://gqevu6bsiz.chicappa.jp/?utm_source=use_plugin&utm_medium=list&utm_content=apsc&utm_campaign=1_2_4
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
		$Url,
		$Site,
		$AuthorUrl,
		$ltd,
		$Record,
		$PageSlug,
		$PluginSlug,
		$Nonces,
		$Schema,
		$SetArchive,
		$SetTitle,
		$UPFN,
		$MsgQ,
		$Msg;


	function __construct() {
		$this->Ver = '1.2.4';
		$this->Name = 'Archive Post Sort Customize';
		$this->Dir = plugin_dir_path( __FILE__ );
		$this->Url = plugin_dir_url( __FILE__ );
		$this->Site = 'http://gqevu6bsiz.chicappa.jp/';
		$this->AuthorUrl = $this->Site;
		$this->ltd = 'apsc';
		$this->Record = array(
			"home" => $this->ltd . '_home',
			"tag" => $this->ltd . '_tag',
			"cat" => $this->ltd . '_cat',
			"search" => $this->ltd . '_search',
			"monthly" => $this->ltd . '_monthly',
			"donate" => $this->ltd . '_donated',
		);
		$this->PageSlug = 'archive_posts_sort_customize';
		$this->PluginSlug = dirname( plugin_basename( __FILE__ ) );
		$this->Nonces = array( "field" => $this->ltd . '_field' , "value" => $this->ltd . '_value' );
		$this->Schema = is_ssl() ? 'https://' : 'http://';
		$this->SetArchive = 'home';
		$this->SetTitle = '';
		
		$this->UPFN = 'Y';
		$this->DonateKey = 'd77aec9bc89d445fd54b4c988d090f03';
		$this->MsgQ = $this->ltd . '_msg';
		$this->Msg = '';

		$this->PluginSetup();
		add_action( 'init' , array( $this , 'FilterStart' ) );
	}

	// PluginSetup
	function PluginSetup() {
		// load text domain
		load_plugin_textdomain( $this->ltd , false , $this->PluginSlug . '/languages' );

		// plugin links
		add_filter( 'plugin_action_links' , array( $this , 'plugin_action_links' ) , 10 , 2 );

		// add menu
		add_action( 'admin_menu' , array( $this , 'admin_menu' ) );

		// data update
		add_action( 'admin_init' , array( $this , 'dataUpdate') );
	}

	// PluginSetup
	function plugin_action_links( $links , $file ) {
		if( plugin_basename(__FILE__) == $file ) {
			$link = '<a href="' . self_admin_url( 'admin.php?page=' . $this->PageSlug ) . '">' . __( 'Settings' ) . '</a>';
			$support_link = '<a href="http://wordpress.org/support/plugin/' . $this->PluginSlug . '" target="_blank">' . __( 'Support Forums' ) . '</a>';
			array_unshift( $links, $link , $support_link  );
		}
		return $links;
	}

	// PluginSetup
	function admin_menu() {
		add_menu_page( sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Home' ) , __( 'Archives' ) ) , __( 'Archive Posts Sort Customize' , $this->ltd ) , 'administrator', $this->PageSlug , array( $this , 'setting_home') );

		add_submenu_page( $this->PageSlug , sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Categories' ) , __( 'Archives' ) ) , __( 'Categories' ) , 'administrator' , $this->Record["cat"] , array( $this , 'setting_cat' ) );
		add_submenu_page( $this->PageSlug , sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Tags' ) , __( 'Archives' ) ) , __( 'Tags' ) , 'administrator' , $this->Record["tag"] , array( $this , 'setting_tag' ) );
		add_submenu_page( $this->PageSlug , sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Search' ) , __( 'Archives' ) ) , __( 'Search' ) , 'administrator' , $this->Record["search"] , array( $this , 'setting_search' ) );
		add_submenu_page( $this->PageSlug , sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Monthly' , $this->ltd ) , __( 'Archives' ) ) , sprintf( '%1$s ( %2$s )' , __( 'Archives' ) , __( 'Monthly' , $this->ltd ) ) , 'administrator' , $this->Record["monthly"] , array( $this , 'setting_monthly' ) );
	}



	// SettingPage
	function setting_home() {
		$this->SetTitle = sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Home' ) , __( 'Archives' ) );
		$this->display_msg();
		add_filter( 'admin_footer_text' , array( $this , 'layout_footer' ) );
		$this->DisplayDonation();
		include_once 'inc/settings.php';
	}

	// SettingPage
	function setting_cat() {
		$this->SetArchive = 'cat';
		$this->SetTitle = sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Categories' ) , __( 'Archives' ) );
		$this->display_msg();
		add_filter( 'admin_footer_text' , array( $this , 'layout_footer' ) );
		$this->DisplayDonation();
		include_once 'inc/settings.php';
	}

	// SettingPage
	function setting_tag() {
		$this->SetArchive = 'tag';
		$this->SetTitle = sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Tags' ) , __( 'Archives' ) );
		$this->display_msg();
		add_filter( 'admin_footer_text' , array( $this , 'layout_footer' ) );
		$this->DisplayDonation();
		include_once 'inc/settings.php';
	}

	// SettingPage
	function setting_search() {
		$this->SetArchive = 'search';
		$this->SetTitle = sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Search' ) , __( 'Archives' ) );
		$this->display_msg();
		add_filter( 'admin_footer_text' , array( $this , 'layout_footer' ) );
		$this->DisplayDonation();
		include_once 'inc/settings.php';
	}

	// SettingPage
	function setting_monthly() {
		$this->SetArchive = 'monthly';
		$this->SetTitle = sprintf( __( '%1$s %2$s for %3$s %4$s' , $this->ltd ) , __( 'Customize' ) ,  __( 'Sort' , $this->ltd ) , __( 'Monthly' , $this->ltd ) , __( 'Archives' ) );
		$this->display_msg();
		add_filter( 'admin_footer_text' , array( $this , 'layout_footer' ) );
		$this->DisplayDonation();
		include_once 'inc/settings.php';
	}



	// Data get
	function get_data( $record ) {
		$record = strip_tags( $record );
		$GetData = get_option( $this->Record[$record] );

		$Data = array();
		if( !empty( $GetData ) ) {
			$Data = $GetData;
		}
		
		return $Data;
	}



	// Setting Item
	function get_sorting_posts_per_page( $posts_per_page , $posts_per_page_num ) {

		echo '<p>' . sprintf( __( 'The default is <strong>%s</strong>.' , $this->ltd ) , __( 'Follow Reading Setting' , $this->ltd ) ) . '</p>';

		$Sort = array( "all" => __( 'View all posts' , $this->ltd ) , "default" => __( 'Follow Reading Setting' , $this->ltd ) , "set" => __( 'Set the number of posts' , $this->ltd ) );
		foreach( $Sort as $type => $type_label ) {
			$Checked = '';
			if( !empty( $posts_per_page ) && $posts_per_page == $type ) {
				$Checked = 'checked="checked"';
			}
			echo '<div class="posts_per_page">';
			
			echo '<label>';
			echo '<input type="radio" name="data[posts_per_page]" value="' . $type . '" ' . $Checked . ' />';
			echo $type_label;
			if( $type == 'default' ) {
				echo sprintf( '<span class="description">%1$s</span> <strong>%2$s</strong>%3$s' , __( 'Current number of Reading Setting' , $this->ltd ) , get_option( 'posts_per_page' ) , __( 'posts' ) );
			}
			echo '</label>';
			
			if( $type == 'set' ) {
				echo '<span class="posts_per_page_num">';
				$val = '';
				if( !empty( $posts_per_page ) && $posts_per_page == 'set' && !empty( $posts_per_page_num ) ) {
					$val = strip_tags( $posts_per_page_num );
				}
				echo '<input type="text" class="small-text" id="posts_per_page_num" name="data[posts_per_page_num]" value="' . $val . '" /> ' . __( 'posts' );
				echo '</span>';
			}
			
			echo '</div>';
		}

	}
	
	// Setting Item
	function get_sorting_orderby( $orderby , $orderby_set ) {

		echo '<p>' . sprintf( __( 'The default is <strong>%s</strong>.' , $this->ltd ) , __( 'Date' ) ) . '</p>';

		$Sort = array( "date" => __( 'Date' ) , "title" => __( 'Title' ) , "author" => __( 'Author' ) , "comment_count" => __( 'Comments Count' , $this->ltd ) , "id" => 'ID' , "modified" => __( 'Last Modified' ) , "custom_fields" => __( 'Custom Fields' ) );

		echo '<div class="orderby">';
		echo '<select name="data[orderby]">';
		foreach( $Sort as $type => $type_label ) {
			$Selected = '';
			if( !empty( $orderby ) && $orderby == $type ) {
				$Selected = 'selected="selected"';
			}
			echo sprintf( '<option value="%1$s" %2$s>%3$s</option>' , $type , $Selected , $type_label );
		}
		echo '</select>';
		echo '</div>';
		
		echo '<div class="orderby_custom_fields">';
			echo '<p class="description">' . __( 'Please enter the name of the custom field you want to sort.' , $this->ltd ) . '</p>';
			$val = '';
			if( !empty( $orderby ) && $orderby == 'custom_fields' && !empty( $orderby_set ) ) {
				$val = strip_tags( $orderby_set );
			}
			echo '<p>' . __( 'Custom Fields Name' , $this->ltd ) . ' : ';
			echo '<input type="text" class="regular-text" id="orderby_set" name="data[orderby_set]" value="' . $val . '" />';
			echo '</p>';
			echo '<p><a href="javascript:void(0);" class="all_custom_fields">' . __( 'Click here, please look for the required custom fields if you do not know the name of the custom field.' , $this->ltd ) . '</a></p>';
			echo '<div class="custom_fields_lists">';
			$this->get_custom_fields();
			echo '</div>';
		echo '</div>';

	}
	
	// Setting Item
	function get_sorting_order( $order ) {

		echo '<p>' . sprintf( __( 'The default is <strong>%s</strong>.' , $this->ltd ) , __( 'Descending' ) ) . '</p>';
		echo '<select name="data[order]">';

		$Sort = array( "desc" => __( 'Descending' ) , "asc" => __( 'Ascending' ) );

		foreach( $Sort as $type => $type_label ) {
			$Selected = '';
			if( !empty( $order ) && $order == $type ) {
				$Selected = 'selected="selected"';
			}
			echo sprintf( '<option value="%1$s" %2$s>%3$s</option>' , $type , $Selected , $type_label . ' (' . $type . ')' );
		}

		echo '</select>';
		echo '<p><strong>' . __( 'Descending' ) . '</strong> : ' . __( 'From new to old' , $this->ltd ) . ' &amp; ' . __( 'From many to small' , $this->ltd ) . ' &amp; Z to A</p>';
		echo '<p><strong>' . __( 'Ascending' ) . '</strong> : ' . __( 'From old to new' , $this->ltd ) . ' &amp; ' . __( 'From small to many' , $this->ltd ) . ' &amp; A to Z</p>';
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
			echo '<li><a href="javascript:void(0);" class="custom_fields_target_click button">' . $field_name . '</a></li>';
		}
		echo '</ul>';
	}



	// DataUpdate
	function dataUpdate() {

		$RecordField = false;
		
		if( !empty( $_POST["record_field"] ) ) {
			$RecordField = strip_tags( $_POST["record_field"] );
		}

		if( !empty( $RecordField ) && !empty( $_POST["update"] ) ) {
			$this->update();
		}

		if( !empty( $RecordField ) && !empty( $_POST["reset"] ) ) {
			$this->update_reset( $RecordField );
		}

		if( !empty( $_POST["donate_key"] ) && !empty( $_POST["update"] ) ) {
			$this->DonatingCheck();
		}

	}

	// DataUpdate
	function update_validate() {
		$Update = array();

		if( !empty( $_POST[$this->UPFN] ) ) {
			$UPFN = strip_tags( $_POST[$this->UPFN] );
			if( $UPFN == $this->UPFN ) {
				$Update["UPFN"] = strip_tags( $_POST[$this->UPFN] );
			}
		}

		return $Update;
	}

	// DataUpdate
	function DonatingCheck() {
		$Update = $this->update_validate();

		if( !empty( $Update ) && check_admin_referer( $this->Nonces["value"] , $this->Nonces["field"] ) ) {
			if( !empty( $_POST["donate_key"] ) ) {
				$SubmitKey = md5( strip_tags( $_POST["donate_key"] ) );
				if( $this->DonateKey == $SubmitKey ) {
					update_option( $this->ltd . '_donated' , $SubmitKey );
					wp_redirect( add_query_arg( $this->MsgQ , 'donated' , remove_query_arg( $this->MsgQ ) ) );
					exit;
				}
			}
		}

	}
	// Update Setting
	function update() {
		$Update = $this->update_validate();
		
		if( !empty( $Update ) && check_admin_referer( $this->Nonces["value"] , $this->Nonces["field"] ) ) {
			unset( $Update["UPFN"] );
			if( !empty( $_POST["data"] ) ) {

				foreach($_POST["data"] as $key => $val) {
					if( !empty( $val ) ) {
						$Update[strip_tags( $key )] = strip_tags( $val );
					}
				}
				
				if( !empty( $Update ) ) {
					$Record = $this->Record[strip_tags( $_POST["record_field"] )];
					update_option( $Record , $Update );
					wp_redirect( add_query_arg( $this->MsgQ , 'update' , remove_query_arg( $this->MsgQ ) ) );
					exit;
				}
				
			}
		}
	}

	// Update Reset
	function update_reset() {
		if( check_admin_referer( $this->Nonces["value"] , $this->Nonces["field"] ) ) {
			$Record = $this->Record[strip_tags( $_POST["record_field"] )];
			delete_option( $Record );
			wp_redirect( add_query_arg( $this->MsgQ , 'delete' , remove_query_arg( $this->MsgQ ) ) );
			exit;
		}
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

		if( $query->is_home() ) {
			$GetData = $this->get_data( 'home' );
			if( !empty( $GetData ) ) {
				$Data = $GetData;
			}
		} elseif( $query->is_category() ) {
			$GetData = $this->get_data( 'cat' );
			if( !empty( $GetData ) ) {
				$Data = $GetData;
			}
		} elseif( $query->is_tag() ) {
			$GetData = $this->get_data( 'tag' );
			if( !empty( $GetData ) ) {
				$Data = $GetData;
			}
		} elseif( $query->is_search() ) {
			$GetData = $this->get_data( 'search' );
			if( !empty( $GetData ) ) {
				$Data = $GetData;
			}
		} elseif( $query->is_archive() && $query->is_month() ) {
			$GetData = $this->get_data( 'monthly' );
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
					if( $Data["orderby"] == 'custom_fields' && !empty( $Data["orderby_set"] ) ) {
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
				} else {
					$query->set( 'order' , 'DESC' );
				}
			}
		}
		
	}

	

	// FilterStart
	function display_msg() {
		if( !empty( $_GET[$this->MsgQ] ) ) {
			$msg = strip_tags(  $_GET[$this->MsgQ] );
			if( $msg == 'update' or $msg == 'delete' ) {
				$this->Msg .= '<div class="updated"><p><strong>' . __( 'Settings saved.' ) . '</strong></p></div>';
			} elseif( $msg == 'donated' ) {
				$this->Msg .= '<div class="updated"><p><strong>' . __( 'Thank you for your donation.' , $this->ltd ) . '</strong></p></div>';
			}
		}
	}

	// FilterStart
	function layout_footer( $text ) {
		$text = '<img src="' . $this->Schema . 'www.gravatar.com/avatar/7e05137c5a859aa987a809190b979ed4?s=18" width="18" />
		Plugin developer : <a href="' . $this->AuthorUrl . '?utm_source=use_plugin&utm_medium=footer&utm_content=' . $this->ltd . '&utm_campaign=' . str_replace( '.' , '_' , $this->Ver ) . '" target="_blank">gqevu6bsiz</a>';
		return $text;
	}

	// FilterStart
	function DisplayDonation() {
		$donation = get_option( $this->ltd . '_donated' );
		if( $this->DonateKey != $donation ) {
			$this->Msg .= '<div class="error"><p><strong>' . __( 'Please consider a donate if you are satisfied with this plugin.' , $this->ltd ) . '</strong></p></div>';
		}
	}


}

$APSC = new APSC();

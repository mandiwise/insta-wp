<?php

/*
Plugin Name: Insta WP
Plugin URI: http://mandiwise.com/wordpress/insta-wp/
Description: A WordPress implementation of the jQuery Spectragram plugin. Use this plugin to create and use simple shortcodes that embed an image feed based on a username or hash tag.
Version: 1.1
Author: Mandi Wise
Author URI: http://mandiwise.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
  
*/

class Insta_WP {
	 
	// * Constructor *
		// - initializes the plugin by setting localization, filters, and administration functions -
		
	function __construct() {
	
		// - load plugin text domain -
		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		// - register admin styles and scripts -
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// - register site styles and scripts -
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );

        // - require the settings and initiate the plugin settings class -
		require_once(sprintf("%s/views/admin.php", dirname(__FILE__)));
		$InstaWP_Settings = new InstaWP_Settings();

		add_action( 'instawp_after_form', array( $this, 'generate_insta_shortcode' ) );
        
		// - register the shortcode for the Instagram feed -
		add_action( 'init', array( $this, 'register_shortcodes') );

	} // - end constructor -

	// * Load the plugin text domain for translation *
	public function plugin_textdomain() {
		$domain = 'insta-wp-locale';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}


	// * Register and enqueue admin-specific styles *
	public function register_admin_styles() {
		wp_enqueue_style( 'insta-wp-admin-styles', plugins_url( 'insta-wp/css/admin.css' ) );
	}

	// * Register and enqueue admin-specific JavaScript *	
	public function register_admin_scripts() {
		wp_enqueue_script( 'insta-wp-admin-script', plugins_url( 'insta-wp/js/admin.js' ), array( 'jquery' ) );
	}
	
	// * Register and enqueue plugin-specific styles *
	public function register_plugin_styles() {
		wp_enqueue_style( 'insta-wp-plugin-styles', plugins_url( 'insta-wp/css/display.css' ) );
	}
	
	// * Register and enqueue plugin-specific scripts *
	public function register_plugin_scripts() { 
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'insta-wp-jquery-script', plugins_url( 'insta-wp/js/spectragram.js' ), array( 'jquery' ), false, true );
		wp_register_script( 'insta-wp-display-script', plugins_url( 'insta-wp/js/display.js' ), array( 'jquery' ), false, true );
		wp_register_script( 'insta-wp-hash-script', plugins_url( 'insta-wp/js/display.hash.js' ), array( 'jquery' ), false, true );
		wp_register_script( 'insta-wp-user-script', plugins_url( 'insta-wp/js/display.user.js' ), array( 'jquery' ), false, true );
	}

	// * Core Functions *
    
    function generate_insta_shortcode() {
		$feed_display = instawp_option( 'displayby' );
		$hash = instawp_option( 'hash' );
		$username = instawp_option( 'username' );
		$show = instawp_option( 'max' );
		$size = instawp_option( 'size' );

		if ( $feed_display != 'none' ) {
			echo '<div id="insta-shortcode">';
			echo '<h3>'. __( 'Volia! Your Shorcode', 'insta-wp-locale' ) .'</h3>';
			echo '<p>'. __( 'Paste this shortcode into the WordPress post or page editor.', 'insta-wp-locale' ) .'</p>';
		
			if ( $feed_display == 'byhash' ) {
				echo '<pre class="insta-shortcode">[insta-hash tag="'.$hash.'" size="'.$size.'" show="'.$show.'"]</pre>';
			}
		
			elseif ( $feed_display == 'byuser' ) {
				echo '<pre class="insta-shortcode">[insta-user username="'.$username.'" size="'.$size.'" show="'.$show.'"]</pre>';
			}
			
			else {
				return;
			}
			echo '<p><strong>'. __( 'Play it safe! ', 'insta-wp-locale') .'</strong>'. __( 'Only add one of each type of Insta WP shortcode per post/page.', 'insta-wp-locale' ) .'</p>';
			echo '</div>';
		}
		else { 
			return; 
		}
    }
	
	// - creates shortcodes, enqueues and localizes the related display script -
	function insta_wp_hash( $atts ) {
		extract( shortcode_atts( array(
			'tag' => '',
			'size' => 'medium',
			'show' => '10'
		), $atts ));
		
		if ( !$tag ) {
			
			$error = '<p style="color: red;"><em>'. __( 'Danger Will Robinson! Your shortcode is missing a hash tag. Try generating and pasting your shortcode directly from the Insta WP settings page.', 'insta-wp-locale' ) .'</em></p>';
			return $error;

		} else {
			
			$clientid = instawp_option( 'clientID' );
			$token = instawp_option( 'accessToken' );
		
			wp_enqueue_script( 'insta-wp-jquery-script' );
			wp_enqueue_script( 'insta-wp-display-script' );
			wp_localize_script( 'insta-wp-display-script', 'api_vars', array(
					'api_clientid' => $clientid,
					'api_token' => $token
				) 
			);
			
			wp_enqueue_script( 'insta-wp-hash-script' );
			wp_localize_script( 'insta-wp-hash-script', 'tag_vars', array(
					'tag_query' => $tag,
					'tag_size' => $size,
					'tag_max' => $show
				) 
			);
		
			$output = '<ul class="insta-hash '.$tag.'"></ul>';
			return $output;
		}
	}
	
	function insta_wp_user( $atts ) {
		extract( shortcode_atts( array(
			'username' => '',
			'size' => 'medium',
			'show' => '10'
		), $atts ));
		
		if ( !$username ) {
			
			$error = '<p style="color: red;"><em>'. __( 'Danger Will Robinson! Your shortcode is missing a username. Try generating and pasting your shortcode directly from the Insta WP settings page.', 'insta-wp-locale' ) .'</em></p>';
			return $error;

		} else {
		
			$clientid = instawp_option( 'clientID' );
			$token = instawp_option( 'accessToken' );
		
			wp_enqueue_script( 'insta-wp-jquery-script' );
			wp_enqueue_script( 'insta-wp-display-script' );
			wp_localize_script( 'insta-wp-display-script', 'api_vars', array(
					'api_clientid' => $clientid,
					'api_token' => $token
				) 
			);
			
			wp_enqueue_script( 'insta-wp-user-script' );
			wp_localize_script( 'insta-wp-user-script', 'user_vars', array(
					'user_query' => $username,
					'user_size' => $size,
					'user_max' => $show
				) 
			);
		
			$output = '<ul class="insta-user '.$username.'"></ul>';
			return $output;
		}
	}
	
	function register_shortcodes() {
		add_shortcode( 'insta-hash', array( $this, 'insta_wp_hash' ) );
		add_shortcode( 'insta-user', array( $this, 'insta_wp_user' ) );
	}
  
} // - end class -

$plugin_name = new Insta_WP();
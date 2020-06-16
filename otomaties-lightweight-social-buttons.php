<?php
/*
Plugin Name: Lightweight Social Buttons
Plugin URI: http://tombroucke.be
Description: Add social buttons to news or custom post types.
Author: Tom Broucke
Version: 1.1
Author URI: http://tombroucke.be
Text Domain: lightweight-sb
Domain Path: /languages/
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class LightWeighSocialButtons
{

	public $text_domain = 'leightweight-sb';

	function __construct(){

		$this->includes();
		$this->init_hooks();

		new LWSB_Admin( $this->text_domain );

	}

	public function load_textdomain() {

		load_plugin_textdomain( $this->text_domain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 

	}

	public function includes(){

		include_once( 'includes/class-admin.php' );

	}

	public function init_hooks(){

		add_action( 'plugins_loaded', array( $this, 'load_textdomain') );
		add_action( 'the_content', array( $this, 'render_buttons' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'add_settings_link' ) );

	}

	public function render_buttons( $content ){
		
		if( !isset( get_option('lwsb_social_media_post_type')[get_post_type()] ) ){
			
			return $content;

		}
		if( !is_single() && !get_option( 'lwsb_social_media_show_in_overview' ) ){

			return $content;

		}

		if( !empty( get_option( 'lwsb_social_media' ) ) ){
			$content .= '<div class="social-media-share-btns">';
			?>
			
			<?php

			foreach ( get_option( 'lwsb_social_media' ) as $social_media_name => $value) {
				$content .= $this->render_styled_button( $social_media_name );
			}

			?>
			<?php
			$content .= '</div>';
			return $content;
		}

	}

	private function render_styled_button( $type ){

		switch ( $type ) {
			case 'facebook':
			return '<div class="social-media-share-btn social-media-facebook"><a class="social-media-popup" href="http://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() . '"><i class="fab fa-facebook"></i></a></div>';
			break;
			case 'linkedin':
			return '<div class="social-media-share-btn social-media-linkedin"><a class="social-media-popup" href="https://www.linkedin.com/cws/share?url=' . get_the_permalink() . '"><i class="fab fa-linkedin"></i></a></div>';
			break;
			case 'twitter':
			return '<div class="social-media-share-btn social-media-twitter"><a class="social-media-popup" href="https://twitter.com/intent/tweet?text=' . get_the_permalink() . '"><i class="fab fa-twitter"></i></a></div>';
			break;
			case 'google':
			return '<div class="social-media-share-btn social-media-google"><a class="social-media-popup" href="https://plus.google.com/share?url=' . get_the_permalink() . '"><i class="fab fa-google-plus"></i></a></div>';
			break;
			case 'pinterest':
			return '<div class="social-media-share-btn social-media-pinterest"><a class="social-media-popup" href="http://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '"><i class="fab fa-pinterest"></i></a></div>';
			break;
			case 'email':
			return '<div class="social-media-share-btn social-media-email"><a href="mailto:?body=' . get_the_permalink() . '"><i class="fa fa-envelope"></i></a></div>';
			break;
			
			default:
			return;
			break;
		}

	}

	public function enqueue_scripts(){

		wp_enqueue_style( 'lightweight-social-media-style', plugins_url( 'public/css/lwsb-style.css' , __FILE__ ), array() );
		wp_enqueue_script( 'lightweight-social-media-script', plugins_url( 'public/js/lwsb-script.js' , __FILE__ ), array( 'jquery' ) );

	}
	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=leightweigt_social_buttons">' . __( 'Settings', 'lightweight-sb' ) . '</a>';
		array_push( $links, $settings_link );
		return $links;
	}

}

new LightWeighSocialButtons();

?>

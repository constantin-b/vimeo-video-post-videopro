<?php
/*
* Plugin Name: Vimeo Video Post PRO - Theme VideoPro compatibility
* Plugin URI: https://codeflavors.com/vimeo-video-post/
* Description: Add-on plugin for Vimeo Video Post PRO - Vimeo videos WordPress importer which introduces compatibility with theme VideoPro by CactusThemes
* Author: CodeFlavors
* Version: 1.0
* Author URI: https://codeflavors.com
*/

class CVM_Videopro_Compatibility{
	/**
	 * Holds compatible theme name
	 */
	const THEME = 'VideoPro';
	/**
	 * Holds class instance
	 * @var CVM_Videopro_Compatibility|null
	 */
	private static $instance = null;

	/**
	 * CVM_Videopro_Compatibility constructor.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'on_init' ) );
	}

	/**
	 * @return CVM_Videopro_Compatibility|null
	 */
	public static function get_instance(){
		if( null === self::$instance ){
			self::$instance = new CVM_Videopro_Compatibility();
		}
		return self::$instance;
	}

	/**
	 * Hook "init" callback, verifies that plugin is loaded and
	 * that loaded theme is the right theme
	 */
	public function on_init(){
		if( !class_exists( 'CVM_Vimeo_Videos' ) ){
			return;
		}
		$theme = $this->get_theme();
		if( !$theme ||  strtolower( self::THEME ) != strtolower( $theme->get('Name') ) ){
			return;
		}

		require_once plugin_dir_path( __FILE__ ) . '/includes/class.cvm-videopro-compatibility.php';
		new CVM_Videopro_Actions_Compatibility( self::THEME );
	}

	/**
	 * Get currently installed parent theme
	 * @return bool|false|WP_Theme
	 */
	private function get_theme(){
		// get template details
		$theme = wp_get_theme();
		if( is_a( $theme, 'WP_Theme' ) ){
			// check if it's child theme
			if( is_a( $theme->parent(), 'WP_Theme' ) ){
				// set theme to parent
				$theme = $theme->parent();
			}
		}else{
			$theme = false;
		}
		return $theme;
	}
}
CVM_Videopro_Compatibility::get_instance();

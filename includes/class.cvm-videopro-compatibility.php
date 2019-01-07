<?php

class CVM_Videopro_Actions_Compatibility {
	/**
	 * Theme name
	 * @var string
	 */
	private $theme_name;

	/**
	 * CVM_Videopro_Actions_Compatibility constructor.
	 *
	 * @param string $theme_name
	 */
	public function __construct( $theme_name ) {
		$this->theme_name = $theme_name;
		add_filter( 'cvm_theme_support', array( $this, 'theme_support' ) );
		add_filter( 'cvm_post_insert', array( $this, 'add_post_meta' ), 10, 4 );
	}

	/**
	 * @param array $themes
	 *
	 * @return array
	 */
	public function theme_support( $themes ) {
		$theme_name = strtolower( $this->theme_name );
		$themes[ $theme_name ] = array(
			'post_type'    => 'post',
			'taxonomy'     => false,
			'tag_taxonomy' => 'post_tag',
			'post_meta'    => array(
				'url' => 'tm_video_url'
			),
			'post_format'  => 'video',
			'theme_name'   => $this->theme_name,
			'url'          => 'https://themeforest.net/item/videopro-video-wordpress-theme/16677956?ref=cboiangiu',
		);

		return $themes;
	}

	/**
	 * @param $post_id
	 * @param $video
	 * @param $theme_import
	 * @param $post_type
	 *
	 * @return string
	 */
	public function add_post_meta( $post_id, $video, $theme_import, $post_type ) {
		if ( ! $theme_import ) {
			return;
		}

		update_post_meta( $post_id, 'video_duration', $video['_duration'] );
		update_post_meta( $post_id, '_video_network_views', $video['stats']['views'] );
		update_post_meta( $post_id, '_video_network_likes', $video['stats']['likes'] );
		update_post_meta( $post_id, '_video_network_comments', $video['stats']['comments'] );
	}
}
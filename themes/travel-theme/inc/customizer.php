<?php
/**
 * wanderer Theme Customizer
 *
 * @package wanderer
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function travel_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'travel_theme_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'travel_theme_customize_partial_blogdescription',
		) );
	}


	/**
	 * PANELS
	 */
	// Social Media Panel
	$wp_customize->add_panel( 'travel_theme_social_media_panel', array(
		'title' => esc_html__( 'Social Media', 'travel_theme' ),
		'capability' => 'edit_theme_options',
	) );

	/**
	 * SECTIONS
	 */
	// Facebook
	$wp_customize->add_section( 'travel_theme_facebook_section', array(
		'title' => esc_html__( 'Facebook', 'travel_theme' ),
		'capability' => 'edit_theme_options',
		'panel' => 'travel_theme_social_media_panel',
	) );
	// Twitter
	$wp_customize->add_section( 'travel_theme_twitter_section', array(
		'title' => esc_html__( 'Twitter', 'travel_theme' ),
		'capability' => 'edit_theme_options',
		'panel' => 'travel_theme_social_media_panel',
	) );
	// Instagram
	$wp_customize->add_section( 'travel_theme_instagram_section', array(
		'title' => esc_html__( 'Instagram', 'travel_theme' ),
		'capability' => 'edit_theme_options',
		'panel' => 'travel_theme_social_media_panel',
	) );
	// YouTube
	$wp_customize->add_section( 'travel_theme_youtube_section', array(
		'title' => esc_html__( 'YouTube', 'travel_theme' ),
		'capability' => 'edit_theme_options',
		'panel' => 'travel_theme_social_media_panel',
	) );

	/**
	 * SETTINGS
	 */
	// Facebook
	$wp_customize->add_setting( 'travel_theme_facebook_url', array(
		'transport' => 'refresh',
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	// Twitter
	$wp_customize->add_setting( 'travel_theme_twitter_url', array(
		'transport' => 'refresh',
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	// Instagram
	$wp_customize->add_setting( 'travel_theme_instagram_url', array(
		'transport' => 'refresh',
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	// YouTube
	$wp_customize->add_setting( 'travel_theme_youtube_url', array(
		'transport' => 'refresh',
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	/**
	 * CONTROLS
	 */
	// Facebook
	$wp_customize->add_control( 'travel_theme_facebook_url', array(
		'label' => esc_html__( 'URL', 'travel_theme' ),
		'description' => esc_html__( 'Add URL to display Facebook icon/link', 'travel_theme' ),
		'section' => 'travel_theme_facebook_section',
		'type' => 'input',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'https://facebook.com', 'travel_theme' ),
		),
	) );
	// Twitter
	$wp_customize->add_control( 'travel_theme_twitter_url', array(
		'label' => esc_html__( 'URL', 'travel_theme' ),
		'description' => esc_html__( 'Add URL to display Twitter icon/link', 'travel_theme' ),
		'section' => 'travel_theme_twitter_section',
		'type' => 'input',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'https://twitter.com', 'travel_theme' ),
		),
	) );
	// Instagram
	$wp_customize->add_control( 'travel_theme_instagram_url', array(
		'label' => esc_html__( 'URL', 'travel_theme' ),
		'description' => esc_html__( 'Add URL to display Instagram icon/link', 'travel_theme' ),
		'section' => 'travel_theme_instagram_section',
		'type' => 'input',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'https://instagram.com', 'travel_theme' ),
		),
	) );
	// YouTube
	$wp_customize->add_control( 'travel_theme_youtube_url', array(
		'label' => esc_html__( 'URL', 'travel_theme' ),
		'description' => esc_html__( 'Add URL to display YouTube icon/link', 'travel_theme' ),
		'section' => 'travel_theme_youtube_section',
		'type' => 'input',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'https://youtube.com', 'travel_theme' ),
		),
	) );
}

add_action( 'customize_register', 'travel_theme_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function travel_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function travel_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function travel_theme_customize_preview_js() {
	wp_enqueue_script( 'travel-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'travel_theme_customize_preview_js' );

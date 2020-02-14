<?php

/**
 * wanderer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wanderer
 */

if (!function_exists('travel_theme_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function travel_theme_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wanderer, use a find and replace
		 * to change 'travel-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('travel-theme', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'menu-1' => esc_html__('Primary', 'travel-theme'),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('travel_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support('custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		));
	}
endif;
add_action('after_setup_theme', 'travel_theme_setup');

/**
 * Add support for default core block styles.
 */
add_theme_support('wp-block-styles');

/**
 * Add support for full width block alignment
 */
add_theme_support('align-wide');

/**
 * Add support for custom color palette
 */
add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => esc_html__('Aqua', 'travel-theme'),
			'slug'  => 'aqua',
			'color' => '#82F5F1',
		),
		array(
			'name'  => esc_html__('Medium Blue', 'travel-theme'),
			'slug'  => 'mediumblue',
			'color' => '#3B47FA',
		),
		array(
			'name'  => esc_html__('Light Blue', 'travel-theme'),
			'slug'  => 'lightblue',
			'color' => '#6AAADE',
		),
		array(
			'name'  => esc_html__('Aquamarine', 'travel-theme'),
			'slug'  => 'aquamarine',
			'color' => '#6ADE9E',
		),
		array(
			'name'  => esc_html__('Light Green', 'travel-theme'),
			'slug'  => 'lightgreen',
			'color' => '#86FF7A',
		)
	)
);

/**
 * Add support for disabling custom colors
 */
add_theme_support('disable-custom-colors');

/**
 * Add support for font sizes
 */
add_theme_support(
	'editor-font-sizes',
	array(
		array(
			'name' => esc_html__('Normal', 'travel-theme'),
			'size' => 16,
			'slug' => 'regular'
		),
		array(
			'name' => esc_html__('Small', 'travel-theme'),
			'size' => 12,
			'slug' => 'small'
		),
		array(
			'name' => esc_html__('Large', 'travel-theme'),
			'size' => 36,
			'slug' => 'large'
		),
		array(
			'name' => esc_html__('Huge', 'travel-theme'),
			'size' => 50,
			'slug' => 'huge'
		)
	)
);

/**
 * Add support for responsive embedded content
 */
add_theme_support('responsive-embeds');

/** 
 * Add custom block - Border
 */

function wanderers_custom_block_border()
{
	wp_register_script('custom-blocks-js', get_template_directory_uri() . '/assets/js/custom-blocks.js', array('wp-blocks'));
	register_block_type('wanderers/custom-border', array(
		'editor_script' => 'custom-blocks-js'
	));
}
add_action('init', 'wanderers_custom_block_border');
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function travel_theme_content_width()
{
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters('travel_theme_content_width', 640);
}
add_action('after_setup_theme', 'travel_theme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function travel_theme_widgets_init()
{
	register_sidebar(array(
		'name'          => esc_html__('Sidebar', 'travel-theme'),
		'id'            => 'sidebar-1',
		'description'   => esc_html__('Add widgets here.', 'travel-theme'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'travel_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function travel_theme_scripts()
{
// 	wp_enqueue_style('travel-theme-style', get_stylesheet_uri());

// 	wp_enqueue_script('travel-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

// 	wp_enqueue_script('travel-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

	// adding new files here

	wp_enqueue_style('travel-foundation', get_template_directory_uri() . '/assets/css/vendor/foundation.min.css', null, '6.5.1');
	wp_enqueue_script('travel-theme-what-input', get_template_directory_uri() . '/assets/js/vendor/what-input.js', array('jquery'), '6.5.1', true);
	wp_enqueue_script('travel-theme-what-input', get_template_directory_uri() . '/assets/js/vendor/foundation.min.js', array('jquery', 'travel-theme-what-input'), '6.5.1', true);

	// pushed the foundation files above our custom files otherwise it was overriding our styles


	// loading the custom CSS file
	wp_enqueue_style('travel-theme-style', get_stylesheet_directory_uri() . '/assets/css/travel.css', array());



	// enqueuing the temporary CSS file (EWAN) 
	/* wp_enqueue_style('travel-ewan-style', get_stylesheet_directory_uri() . '/assets/css/ewan.css', array());
	wp_enqueue_style('travel-ian-style', get_stylesheet_directory_uri() . '/assets/css/ian.css', array());
	wp_enqueue_style('travel-kat-style', get_stylesheet_directory_uri() . '/assets/css/kat.css', array()); */


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'travel_theme_scripts');

/**
 * Enqueque google fonts Montserrat and Just Another Hand
 */
function wanderers_add_google_fonts()
{
	wp_enqueue_style('montserrat', 'https://fonts.googleapis.com/css?family=Montserrat&display=swap', false);
	wp_enqueue_style('just_another_hand', 'https://fonts.googleapis.com/css?family=Just+Another+Hand&display=swap', false);
}
add_action('wp_enqueue_script', 'wanderers_add_google_fonts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer block editor
 */
require get_template_directory() . '/inc/block-editor.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}



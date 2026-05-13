<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('neom_business_locale_css')):
	function neom_business_locale_css($uri)
	{
		if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css')) {
			$uri = get_template_directory_uri() . '/rtl.css';
		}
		return $uri;
	}
endif;
add_filter('locale_stylesheet_uri', 'neom_business_locale_css');

// Step 1: Update neom_business_theme_setup function.
function neom_business_theme_setup()
{
	// Check if this is a fresh theme setup by looking for the custom flag.
	if (!get_option('neom_theme_setup_done')) {
		// Set the default settings for the blogy theme.
		// set_theme_mod( 'neom_archive_blog_design', 'design2' );
		set_theme_mod('neom_primary_color_1', '#d61523');
		set_theme_mod('neom_primary_bg_color_1', '#d61523');

		update_option('neom_theme_setup_done', true);
	}
}

// Hook the setup function to the theme activation hook.
add_action('after_switch_theme', 'neom_business_theme_setup');


// Hook the setup function.
add_action('after_setup_theme', 'neom_business_theme_setup');

// Step 2: Enqueue Styles and Add Inline CSS.
function neom_business_theme_enqueue_styles()
{
	// Enqueue parent theme style.
	wp_enqueue_style(
		'neom_business_parent',
		trailingslashit(get_template_directory_uri()) . 'style.css',
		array(
			'owl-carousel-min',
			'font-awesome-6',
			'font-awesome-brand',
			'font-awesome-solid',
			'font-awesome-shims',
			'neom-editor-style',
			'neom-skin-default',
			'neom-theme-css',
			'neom-meanmenu',
			'neom-widgets',
			'neom-main',
			'neom-media-query',
			'neom-woocommerce',
			'animate',
			'magnific-popup-min',
			'neom-loading-icon',
		)
	);

	// Enqueue child theme style.
	wp_enqueue_style('neom_business', trailingslashit(get_stylesheet_directory_uri()) . 'style.css', array('neom_business_parent'), '1.0.0');

	// Add inline style for custom colors.


	$neom_business_primary_color_1 = get_theme_mod('neom_primary_color_1', '#d61523');
	$neom_business_primary_bg_color_1 = get_theme_mod('neom_primary_bg_color_1', '#d61523');
	$custom_color_css = '
	:root {
		--sp-primary: ' . esc_attr($neom_business_primary_color_1) . ';
		--sp-primary2: ' . esc_attr($neom_business_primary_bg_color_1) . ';
		--sp-gradient1: linear-gradient( -137deg , ' . esc_attr($neom_business_primary_color_1) . ' 0%, #d61523 100%) !important;
		--sp-gradient2: linear-gradient( -137deg , ' . esc_attr($neom_business_primary_bg_color_1) . ' 0%, #242526 100%) !important;
	}';
	wp_add_inline_style('neom_business', $custom_color_css);
}

// Hook the enqueue styles function with a higher priority.
add_action('wp_enqueue_scripts', 'neom_business_theme_enqueue_styles', 20);

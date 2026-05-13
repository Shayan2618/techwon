<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;


/**
 * Setup My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function apsro_child_theme_setup()
{
    load_child_theme_textdomain('apsro-child', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'apsro_child_theme_setup');

if (!function_exists('apsro_child_thm_parent_css')) :
    function apsro_child_thm_parent_css()
    {
        // loading parent styles
        wp_enqueue_style('apsro-parent-style', get_template_directory_uri() . '/style.css', array('apsro-fonts', 'apsro-icons', 'bootstrap', 'fontawesome'));

        // loading child style based on parent style
        wp_enqueue_style('apsro-style', get_stylesheet_directory_uri() . '/style.css', array('apsro-parent-style'));
    }

endif;
add_action('wp_enqueue_scripts', 'apsro_child_thm_parent_css');

// END ENQUEUE PARENT ACTION
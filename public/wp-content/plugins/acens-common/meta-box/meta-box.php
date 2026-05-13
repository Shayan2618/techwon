<?php
/**
 * Plugin Name: Meta Box
 * Plugin URI:  https://metabox.io
 * Description: Create custom meta boxes and custom fields in WordPress.
 * Version:     5.3.3
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 * Text Domain: meta-box
 * Domain Path: /languages/
 *
 * @package Meta Box
 */

if ( defined( 'ABSPATH' ) && ! defined( 'RWMB_VER' ) ) {
	register_activation_hook( __FILE__, 'rwmb_check_php_version' );

	/**
	 * Display notice for old PHP version.
	 */
	function rwmb_check_php_version() {
		if ( version_compare( phpversion(), '5.3', '<' ) ) {
			die( esc_html__( 'Meta Box requires PHP version 5.3+. Please contact your host to upgrade.', 'meta-box' ) );
		}
	}




	require_once dirname( __FILE__ ) . '/inc/loader.php';
	$rwmb_loader = new RWMB_Loader();
	$rwmb_loader->init();


	add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {

	$prefix = '_cmb_';


  // Open Code


    $meta_boxes[] = array(
        'id'         => 'post_setting',
        'title'      => 'Post Setting',
        'pages'      => array('post'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        //'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
        'fields' => array(
        	array(
                'name' => 'Featured Image Blog Grid',
                'desc' => 'Show in Featured Blog Grid',
                'id'   => $prefix . 'img_featured',
                'type'    => 'single_image',
            ),
            array(
                'name' => 'Single Select',
                'desc' => 'Select Type Show Single',
                'id'   => $prefix . 'post_select',
                'type'    => 'select',
                'options'   => array(
                    'dark'       => 'Dark',
                    'light' => 'Light',
                ),
                'default' => 'light',

                'placeholder'     => 'Select Single Type',
            ),
            array(
                'name' => 'Comments Select',
                'desc' => 'Select Type Show Single',
                'id'   => $prefix . 'comment_detail',
                'type'    => 'select',
                'options'   => array(
                    'demo'       => 'Comments Demo',
                    'defail' => 'Comments Detail',
                ),
                'default' => 'light',

                'placeholder'     => 'Select Single Type',
            ),
        )
    );

    
    $meta_boxes[] = array(
        'id'         => 'services_setting',
        'title'      => 'Services Setting',
        'pages'      => array('services'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        //'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
        'fields' => array(
            array(
                'name' => 'Services Select',
                'desc' => 'Select Type Show Single',
                'id'   => $prefix . 'service_select',
                'type'    => 'select',
                'options'   => array(
                    'dark'       => 'Dark',
                    'light' => 'Light',
                ),
                'default' => 'light',

                'placeholder'     => 'Select Single Type',
            ),
            array(
                'name' => 'Icon',
                'desc' => 'Show in icon Services',
                'id'   => $prefix . 'icon',
                'type'    => 'text',
            ),
            
        )
    );
    $meta_boxes[] = array(
        'id'         => 'projects_setting',
        'title'      => 'Projects Setting',
        'pages'      => array('projects'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        //'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
        'fields' => array(
            array(
                'name' => 'Projects Select',
                'desc' => 'Select Type Show Single',
                'id'   => $prefix . 'projects_select',
                'type'    => 'select',
                'options'   => array(
                    'dark'       => 'Dark',
                    'light' => 'Light',
                ),
                'default' => 'light',

                'placeholder'     => 'Select Single Type',
            ),
            
        )
    );
    $meta_boxes[] = array(
        'id'         => 'team_setting',
        'title'      => 'Team Setting',
        'pages'      => array('team'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        //'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
        'fields' => array(
            array(
                'name' => 'Team Select',
                'desc' => 'Select Type Show Single',
                'id'   => $prefix . 'team_select',
                'type'    => 'select',
                'options'   => array(
                    'dark'       => 'Dark',
                    'light' => 'Light',
                ),
                'default' => 'light',

                'placeholder'     => 'Select Single Type',
            ),
            
        )
    );
    $meta_boxes[] = array(
        'id'         => 'event_setting',
        'title'      => 'Event Setting',
        'pages'      => array('event'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        //'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
        'fields' => array(
            array(
                'name' => 'Event Select',
                'desc' => 'Select Type Show Single',
                'id'   => $prefix . 'event_select',
                'type'    => 'select',
                'options'   => array(
                    'dark'       => 'Dark',
                    'light' => 'Light',
                ),
                'default' => 'light',

                'placeholder'     => 'Select Single Type',
            ),
            
        )
    );
    

    
// End Code



    return $meta_boxes;
});
}

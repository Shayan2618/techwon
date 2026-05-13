<?php
/**
 * Plugin Name: Acens Elementor
 * Description: Create unlimited widgets with Elementor Page Builder.
 * Plugin URI:  http://shtheme.com
 * Version:     1.0.0
 * Author:      Nasir Uddin Mandal
 * Author URI:  http://shtheme.com
 * Text Domain: bdevs-elementor
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Bdevs Elementor Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class BdevsElementor {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.5';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var BdevsElementor The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return BdevsElementor An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'bdevs-elementor' );

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		add_action( 'elementor/init', [ $this, 'add_elementor_category' ], 1 );

		// Add Plugin actions
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_frontend_scripts' ], 10 );

		// Register Widget Styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_frontend_styles' ] );

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

		// Register controls
		//add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'bdevs-elementor' ),
			'<strong>' . esc_html__( 'Acens Elementor', 'bdevs-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'bdevs-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'bdevs-elementor' ),
			'<strong>' . esc_html__( 'Acens Elementor', 'bdevs-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'bdevs-elementor' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'bdevs-elementor' ),
			'<strong>' . esc_html__( 'Acens Elementor', 'bdevs-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'bdevs-elementor' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Add Elementor category.
	 */
	public function add_elementor_category() {
		\Elementor\Plugin::instance()->elements_manager->add_category('single-elementor',
	      	array(
					'title' => __( 'Acens Single Elementor', 'bdevs-elementor' ),
					'icon'  => 'fa fa-plug',
	      	) 
	    );
	    \Elementor\Plugin::instance()->elements_manager->add_category('blog-elementor',
	      	array(
					'title' => __( 'Acens Blog Elementor', 'bdevs-elementor' ),
					'icon'  => 'fa fa-plug',
	      	) 
	    );
	    \Elementor\Plugin::instance()->elements_manager->add_category('pages-elementor',
	      	array(
					'title' => __( 'Home Parallax Image Elementor', 'bdevs-elementor' ),
					'icon'  => 'fa fa-plug',
	      	) 
	    );
	    \Elementor\Plugin::instance()->elements_manager->add_category('home-slider-elementor',
	      	array(
					'title' => __( 'Home Slider Image Elementor', 'bdevs-elementor' ),
					'icon'  => 'fa fa-plug',
	      	) 
	    );
	    \Elementor\Plugin::instance()->elements_manager->add_category('home-video-elementor',
	      	array(
					'title' => __( 'Home Video Elementor', 'bdevs-elementor' ),
					'icon'  => 'fa fa-plug',
	      	) 
	    );
	    \Elementor\Plugin::instance()->elements_manager->add_category('home-slideshow-elementor',
	      	array(
					'title' => __( 'Home Slideshow Elementor', 'bdevs-elementor' ),
					'icon'  => 'fa fa-plug',
	      	) 
	    );
	    \Elementor\Plugin::instance()->elements_manager->add_category('other-pages-elementor',
	      	array(
					'title' => __( 'Other Pages Elementor', 'bdevs-elementor' ),
					'icon'  => 'fa fa-plug',
	      	) 
	    );
	}

	/**
	* Register Frontend Scripts
	*
	*/
	public function register_frontend_scripts() {
	wp_register_script( 'bdevs-elementor', plugin_dir_url( __FILE__ ) . 'assets/js/bdevs-elementor.js', array( 'jquery' ), self::VERSION );
	}


	/**
	* Register Frontend styles
	*
	*/
	public function register_frontend_styles() {
	wp_register_style( 'bdevs-elementor', plugin_dir_url( __FILE__ ) . 'assets/css/bdevs-elementor.css', self::VERSION );
	}




	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Single Full
		require_once plugin_dir_path( __FILE__ ) . 'widgets/single/banner-single-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/single/content-projects-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/single/content-team-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/single/skill-team-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/single/event-detail-widget.php';
		// Blog Full
		require_once plugin_dir_path( __FILE__ ) . 'widgets/blog/banner-blog-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/blog/blog-dark-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/blog/lets-talk-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/blog/blog-grid-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/blog/blog-grid-2-widget.php';
		// Home Parallax Image
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-parallax-image/slider-parallax-image-widget.php';
		
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-parallax-image/services-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-parallax-image/projects-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-parallax-image/video-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-parallax-image/team-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-parallax-image/events-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-parallax-image/testimonial-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-parallax-image/blog-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-parallax-image/clients-widget.php';
		// Home Slider Image
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-slider/slider-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-slider/services-home-slider-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-slider/blog-home-slider-widget.php';
		// Home Video
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-video/slider-video-widget.php';
		// Home Slideshow
		require_once plugin_dir_path( __FILE__ ) . 'widgets/home-slideshow/slider-slideshow-widget.php';
		// Other Pages
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/banner-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/projects-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/about-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/about-services-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/pricing-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/team-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/testimonial-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/gallery-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/gallery-video-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/faqs-pages-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/other-pages/contact-pages-widget.php';


		// Single Full
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsBannerSingle() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsContentProjects() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsContentTeam() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsSkillTeam() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsEventDetail() );
		// Blog Full
		
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsBannerBlog() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsBlogDark() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsLetsTalk() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsBlogGrid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsBlogGrid2() );
		// Home Parallax Image 
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsSliderParallaxImage() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsServices() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsProjects() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsVideo() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsTeam() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsEvents() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsTestimonial() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsBlog() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\Bdevsclients() );
		// Home Slider Image
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsSlider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsServicesHomeSlider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsBlogHomeSlider() );
		// Home Video
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsSliderVideo() );
		// Home Slideshow
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsSliderSlideshow() );
		// Other Pages
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsBannerPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsProjectsPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsAboutPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsAboutServicesPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsPricingPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsTeamPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsTestimonialPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsGalleryPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsGalleryVideoPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsFAQsPages() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \BdevsElementor\Widget\BdevsContactPages() );
	}

	/** 
	 * register_controls description
	 * @return [type] [description]
	 */
	public function register_controls() {

		$controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control( 'slider-widget', new Test_Control1() );
	
	}

	/**
	 * Prints the Elementor Page content.
	 */
	public static function get_content( $id = 0 ) {
		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			echo do_shortcode( '[elementor-template id="' . $id . '"]' );
		} else {
			echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id );
		}
	}

}

BdevsElementor::instance();

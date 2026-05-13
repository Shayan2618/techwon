<?php
namespace BdevsElementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Bdevs Elementor Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class BdevsAboutServicesPages extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Bdevs Elementor widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'bdevs-about-services-pages';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Bdevs Elementor widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'About Services Other Pages', 'bdevs-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Bdevs Slider widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slideshow';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Bdevs Slider widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'other-pages-elementor' ];
	}

	public function get_keywords() {
		return [ 'About Services Pages', 'carousel' ];
	}

	public function get_script_depends() {
		return [ 'bdevs-elementor'];
	}

	// BDT Position
	protected function element_pack_position() {
	    $position_options = [
	        ''              => esc_html__('Default', 'bdevs-elementor'),
	        'top-left'      => esc_html__('Top Left', 'bdevs-elementor') ,
	        'top-center'    => esc_html__('Top Center', 'bdevs-elementor') ,
	        'top-right'     => esc_html__('Top Right', 'bdevs-elementor') ,
	        'center'        => esc_html__('Center', 'bdevs-elementor') ,
	        'center-left'   => esc_html__('Center Left', 'bdevs-elementor') ,
	        'center-right'  => esc_html__('Center Right', 'bdevs-elementor') ,
	        'bottom-left'   => esc_html__('Bottom Left', 'bdevs-elementor') ,
	        'bottom-center' => esc_html__('Bottom Center', 'bdevs-elementor') ,
	        'bottom-right'  => esc_html__('Bottom Right', 'bdevs-elementor') ,
	    ];

	    return $position_options;
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_About_Services',
			[
				'label' => esc_html__( 'About Services Other Pages', 'bdevs-elementor' ),
			]	
		);
		$this->add_control(
			'image',
			[
				'label'       => esc_html__( 'Background Image', 'bdevs-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'description' => esc_html__( 'Upload Background Image', 'bdevs-elementor' ),
			]
		);	
		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Title', 'bdevs-elementor' ),
				'default'     => __( 'Acens.', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Subtitle', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Subtitle', 'bdevs-elementor' ),
				'default'     => __( 'Digital Agency Studio, New York / USA', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'image2',
			[
				'label'       => esc_html__( 'Background Image 2', 'bdevs-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'description' => esc_html__( 'Upload Background Image 2', 'bdevs-elementor' ),
			]
		);	
		$this->add_control(
			'title2',
			[
				'label'       => __( 'Title Image 2', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Title Image 2', 'bdevs-elementor' ),
				'default'     => __( 'Office', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'subtitle2',
			[
				'label'       => __( 'Subtitle Image 2', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Subtitle Image 2', 'bdevs-elementor' ),
				'default'     => __( 'Toronto / Canada', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);		
		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Services Items', 'bdevs-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title'   => esc_html__( 'Services #1', 'bdevs-elementor' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'bdevs-elementor' ),
					]
				],
				'fields' => [
					[
						'name'        => 'heading',
						'label'       => esc_html__( 'Heading', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Who we are' , 'bdevs-elementor' ),
						'label_block' => true,
					],
					[
						'name'        => 'subheading',
						'label'       => esc_html__( 'Subheading', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXTAREA,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Lorem posuere tortoran in the nisan semere sceriun miss etiam ornare iros metusan the ravidane the sodan vesaire lacus.' , 'bdevs-elementor' ),
						'label_block' => true,
					],
					[
						'name'        => 'link',
						'label'       => esc_html__( 'Link', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( '#' , 'bdevs-elementor' ),
						'label_block' => true,
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdevs-elementor' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'bdevs-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'bdevs-elementor' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'bdevs-elementor' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'bdevs-elementor' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'bdevs-elementor' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'description'  => 'Use align to match position',
				'default'      => 'left',
			]
		);

		$this->end_controls_section();

	}

	public function render() {

		$settings  = $this->get_settings_for_display();
		extract($settings);
		?> 
<section class="about section-padding">
        <div class="container">
            <div class="row mb-60">
            	<?php if ( '' !== $settings['image']['url'] )  : ?>
                <div class="col-md-8">
                    <div class="item">
                        <div class="wrap">
                            <div class="img"> <img src="<?php print esc_url($settings['image']['url']); ?>" class="img-fluid"> </div>
                            <div class="title">
                            	<?php if ( '' !== $settings['title'] )  : ?>
                                <h4><?php echo wp_kses_post($settings['title']); ?></h4>
                                <?php endif; ?>
                                <?php if ( '' !== $settings['subtitle'] )  : ?>
	                            <h6><?php echo wp_kses_post($settings['subtitle']); ?></h6>
	                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ( '' !== $settings['image2']['url'] )  : ?>
                <div class="col-md-4">
                    <div class="item">
                        <div class="wrap">
                            <div class="img"> <img src="<?php print esc_url($settings['image2']['url']); ?>" class="img-fluid"> </div>
                            <div class="title">
                            	<?php if ( '' !== $settings['title2'] )  : ?>
                                <h4><?php echo wp_kses_post($settings['title2']); ?></h4>
                                <?php endif; ?>
                                <?php if ( '' !== $settings['subtitle2'] )  : ?>
	                            <h6><?php echo wp_kses_post($settings['subtitle2']); ?></h6>
	                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- About Box -->
            <div class="about-box">
                <div class="row">
                	<?php
			        	$idd = 0;
			        	foreach ( $settings['tabs'] as $item ) :
			        	$idd++;
			    	?>
                    <div class="col-md-4">
                        <div class="item">
                            <div class="wrap">
                                <div class="con">
                                    <a href="<?php echo wp_kses_post($item['link']); ?>"><h4><?php echo wp_kses_post($item['heading']); ?></h4></a>
                                    <p><?php echo wp_kses_post($item['subheading']); ?></p>
                                    <div class="icon-2"> <a href="<?php echo wp_kses_post($item['link']); ?>"><span class="fa-sharp fa-light fa-arrow-right"></span></a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
	<?php
	}

}

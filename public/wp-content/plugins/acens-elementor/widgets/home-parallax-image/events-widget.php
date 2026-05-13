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
class BdevsEvents extends \Elementor\Widget_Base {

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
		return 'bdevs-events';
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
		return __( 'Events Home Parallax Image', 'bdevs-elementor' );
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
		return 'eicon-favorite';
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
		return [ 'pages-elementor' ];
	}

	public function get_keywords() {
		return [ 'Events' ];
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
			'section_content_Events',
			[
				'label' => esc_html__( 'Events', 'bdevs-elementor' ),
			]	
		);	
		$this->add_control(
			'subheading',
			[
				'label'       => __( 'Subheading', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your sub heading', 'bdevs-elementor' ),
				'default'     => __( 'Upcoming', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);		

		$this->add_control(
			'heading',
			[
				'label'       => __( 'Heading', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your heading', 'bdevs-elementor' ),
				'default'     => __( 'Digital Events', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Event Items', 'bdevs-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title'   => esc_html__( 'Event #1', 'bdevs-elementor' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'bdevs-elementor' ),
					]
				],
				'fields' => [	
					[
						'name'        => 'day_event',
						'label'       => esc_html__( ' Day Event', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( '22' , 'bdevs-elementor' ),
						'label_block' => true,
					],	
					[
						'name'        => 'month_year_event',
						'label'       => esc_html__( ' Month Year Event', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( ' Nov 2025' , 'bdevs-elementor' ),
						'label_block' => true,
					],		
									
					[
						'name'        => 'time_event',
						'label'       => esc_html__( 'Time Event', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( '8:00 AM - 5:00 PM' , 'bdevs-elementor' ),
						'label_block' => true,
					],
					[
						'name'        => 'title',
						'label'       => esc_html__( 'Title Event', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'London Leading Design' , 'bdevs-elementor' ),
						'label_block' => true,
					],
					[
						'name'        => 'subtitle',
						'label'       => esc_html__( 'Subtitle Event', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Bedford Way, London' , 'bdevs-elementor' ),
						'label_block' => true,
					],
					[
						'name'    => 'image',
						'label'   => esc_html__( 'Image', 'bdevs-elementor' ),
						'type'    => Controls_Manager::MEDIA,
						'dynamic' => [ 'active' => true ],
						'default'     => esc_html__( '' , 'bdevs-elementor' ),
					],
					[
						'name'        => 'button',
						'label'       => esc_html__( 'Button', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Details' , 'bdevs-elementor' ),
						'label_block' => true,
					],
					[
						'name'        => 'link_button',
						'label'       => esc_html__( 'Link Button', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( '#' , 'bdevs-elementor' ),
						'label_block' => true,
					],
				],
			]
		);
		$this->add_control(
			'line',
			[
				'label'       => __( 'Line', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Line', 'bdevs-elementor' ),
				'default'     => __( 'line-vr-section', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);
		$this->end_controls_section();
		
		/** 
		*	Layout section 
		**/
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
<section id="events" data-scroll-index="4" class="events section-padding bg-drk">
    <div class="container">
    	<?php if ( '' !== $settings['subheading'] )  : ?>
        <div class="row mb-30">
            <div class="col-md-12 text-center">
                <h6 class="wow" data-splitting><?php echo wp_kses_post($settings['subheading']); ?></h6>
                <?php if ( '' !== $settings['heading'] )  : ?>
                <h1 class="wow" data-splitting><?php echo wp_kses_post($settings['heading']); ?></h1>
                <?php endif; ?>
                <div class="line-hr-section center"></div>
            </div>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
            	<?php
		        	$idd = 0;
		        	foreach ( $settings['tabs'] as $item ) :
		        	$idd++;
		    	?>
                <div class="item">
                    <div class="row">
                        <div class="col-md-3 d-flex align-items-center">
                            <div class="date md-mb30"> 
                            	<?php if ( '' !== $item['day_event'] )  : ?>
                            	<span><?php echo wp_kses_post($item['day_event']); ?></span>
                            	<?php endif; ?>
                                <div>
                                	<?php if ( '' !== $item['month_year_event'] )  : ?>
                                	<span><?php echo wp_kses_post($item['month_year_event']); ?></span>
                                	<?php endif; ?>
                                	<?php if ( '' !== $item['time_event'] )  : ?>
                                	<span><?php echo wp_kses_post($item['time_event']); ?></span>
                                	<?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-start">
                            <div class="text">
                            	<?php if ( '' !== $item['title'] )  : ?>
                                <h5><?php echo wp_kses_post($item['title']); ?></h5>
                                <?php endif; ?>
                                <?php if ( '' !== $item['subtitle'] )  : ?>
                                <p><?php echo wp_kses_post($item['subtitle']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ( '' !== $item['image'] )  : ?>
                        <div class="col-md-3 position-re">
                            <div class="img img-grayscale"> <img src="<?php print esc_url($item['image']['url']); ?>" alt=""> </div>
                        </div>
                        <?php endif; ?>
                        <?php if ( '' !== $item['button'] )  : ?>
                        <div class="col-md-2 d-flex align-items-center justify-content-end"> <a href="<?php echo wp_kses_post($item['link_button']); ?>" class="btn-3 mr-0"><?php echo wp_kses_post($item['button']); ?></a> </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!-- divider line -->
<?php if ( '' !== $settings['line'] )  : ?>
<div class="<?php echo wp_kses_post($settings['line']); ?>"></div>
<?php endif; ?>
	<?php
	}

}
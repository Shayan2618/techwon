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
class BdevsAboutPages extends \Elementor\Widget_Base {

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
		return 'bdevs-about-pages';
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
		return __( 'About Other Pages', 'bdevs-elementor' );
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
		return [ 'About Pages', 'carousel' ];
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
			'section_content_About',
			[
				'label' => esc_html__( 'About Other Pages', 'bdevs-elementor' ),
			]	
		);

		$this->add_control(
			'subheading',
			[
				'label'       => __( 'Subheading', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Subheading', 'bdevs-elementor' ),
				'default'     => __( 'Creative Agency', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'heading',
			[
				'label'       => __( 'Heading', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your heading', 'bdevs-elementor' ),
				'default'     => __( 'Who We Are?', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'text',
			[
				'label'       => __( 'Text', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter Text About', 'bdevs-elementor' ),
				'default'     => __( '<p>Nulla posuere tortoran nisan sempere scelerisque etiam ornare iros metusan the avidan sodales vesaire. Integer ac molestie nisi orci varius natoque senatis magnis in miss the durution parturient montes, nascetur ridiculus mus.</p>
<p>Phasellus et lacus suscipit congue nisl the volutpat magna done miss the rana risus miss tincidunt convallis velit orci congue tortor eu dignissim ipsum suam non odio esuntion imperdiet metus in the miss lorem ipsum amet ornare.</p>', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);		
		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Testimonial Items', 'bdevs-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title'   => esc_html__( 'Testimonial #1', 'bdevs-elementor' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'bdevs-elementor' ),
					]
				],
				'fields' => [
					[
						'name'        => 'desc',
						'label'       => esc_html__( 'Description', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Branding Strategy' , 'bdevs-elementor' ),
						'label_block' => true,
					],
				],
			]
		);
		$this->add_control(
			'button',
			[
				'label'       => __( 'Button', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Button', 'bdevs-elementor' ),
				'default'     => __( 'Our Services', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'link_button',
			[
				'label'       => __( 'Link Button', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Link Button', 'bdevs-elementor' ),
				'default'     => __( '#', 'bdevs-elementor' ),
				'label_block' => true,
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
				'label'       => __( 'Title Image', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Title Image', 'bdevs-elementor' ),
				'default'     => __( 'Enrico Brown', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Subtitle Image', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Subtitle Image', 'bdevs-elementor' ),
				'default'     => __( 'CEO / Founder', 'bdevs-elementor' ),
				'label_block' => true,
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
        <div class="row">
            <div class="col-md-7">
            	<?php if ( '' !== $settings['subheading'] )  : ?>
                <h6><?php echo wp_kses_post($settings['subheading']); ?></h6>
                <?php endif; ?>
                <?php if ( '' !== $settings['heading'] )  : ?>
                <h1><?php echo wp_kses_post($settings['heading']); ?></h1>
                <?php endif; ?>
                <?php if ( '' !== $settings['text'] )  : ?>
                <?php echo wp_kses_post($settings['text']); ?>
                <?php endif; ?>
                <!-- list -->
                <ul class="list-unstyled list mb-30">
                	<?php
			        	$idd = 0;
			        	foreach ( $settings['tabs'] as $item ) :
			        	$idd++;
			    	?>
                    <li>
                        <div class="list-icon"> <i class="fa-solid fa-check"></i> </div>
                        <div class="list-text">
                            <p><?php echo wp_kses_post($item['desc']); ?></p>
                        </div>
                    </li>
                    <?php endforeach; ?>

                </ul> 
                <?php if ( '' !== $settings['button'] )  : ?>
                <a href="<?php echo wp_kses_post($settings['link_button']); ?>" class="btn-1 mt-15"> <?php echo wp_kses_post($settings['button']); ?></a>
                <?php endif; ?>
            </div>
            <div class="col-md-5">
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
        </div>
    </div>
</section>
<!-- divider line -->
<div class="line-vr-section"></div>
	<?php
	}

}

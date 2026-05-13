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
class BdevsContactPages extends \Elementor\Widget_Base {

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
		return 'bdevs-contact-pages';
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
		return __( 'Contact Other Pages', 'bdevs-elementor' );
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
		return [ 'Contact', 'carousel' ];
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
			'section_content_Contact',
			[
				'label' => esc_html__( 'Contact Other Pages', 'bdevs-elementor' ),
			]	
		);
		$this->add_control(
			'heading',
			[
				'label'       => __( 'Heading', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your heading', 'bdevs-elementor' ),
				'default'     => __( 'Central Office', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'text',
			[
				'label'       => __( 'Text', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter Text About', 'bdevs-elementor' ),
				'default'     => __( 'Nulla posuere tortoran nisan sempere scelerisque etiam ornare iros metusan the ravidane sodales vesaire. Integer ac molestie nisi orci varius the natose nenatis magnis the duru parturient montes ridiculus.', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'icon_phone',
			[
				'label'       => __( 'Icon Phone', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Icon Phone', 'bdevs-elementor' ),
				'default'     => __( 'fa-solid fa-phone', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'phone',
			[
				'label'       => __( 'Phone', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Phone', 'bdevs-elementor' ),
				'default'     => __( '1 800 123 4567', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'icon_mail',
			[
				'label'       => __( 'Icon Mail', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Icon Mail', 'bdevs-elementor' ),
				'default'     => __( 'fa-solid fa-envelope', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'mail',
			[
				'label'       => __( 'Mail', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Mail', 'bdevs-elementor' ),
				'default'     => __( 'hello@yourmail.com', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'icon_address',
			[
				'label'       => __( 'Icon Address', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Icon Address', 'bdevs-elementor' ),
				'default'     => __( 'fa-solid fa-location', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'address',
			[
				'label'       => __( 'Address', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Address', 'bdevs-elementor' ),
				'default'     => __( '0665 Broadway, NY, 10001 USA', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => __( 'Title Opening Hours', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Opening Hours', 'bdevs-elementor' ),
				'default'     => __( 'Opening Hours', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Opening Hours Items', 'bdevs-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title'   => esc_html__( 'Opening Hours #1', 'bdevs-elementor' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'bdevs-elementor' ),
					]
				],
				'fields' => [
					[
						'name'        => 'title_opening',
						'label'       => esc_html__( 'Title Opening', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Monday - Friday' , 'bdevs-elementor' ),
						'label_block' => true,
					],
					[
						'name'        => 'subtitle_opening',
						'label'       => esc_html__( 'Subtitle Opening', 'bdevs-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( '8:00 AM - 7:00 PM' , 'bdevs-elementor' ),
						'label_block' => true,
					],
				],
			]
		);
		$this->add_control(
			'title_contact',
			[
				'label'       => __( 'Title Contact Form', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Title Contact Form', 'bdevs-elementor' ),
				'default'     => __( 'Get in touch!', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'contact_form',
			[
				'label'       => __( 'Contact Form', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your Contact Form', 'bdevs-elementor' ),
				'default'     => __( '[contact-form-7 id="5837263" title="Contact Us Form"]', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);	
		$this->add_control(
			'map',
			[
				'label'       => __( 'Map', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your Map', 'bdevs-elementor' ),
				'default'     => __( 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1573147.7480448114!2d-74.84628175962355!3d41.04009641088412!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25856139b3d33%3A0xb2739f33610a08ee!2s1616%20Broadway%2C%20New%20York%2C%20NY%2010019%2C%20Amerika%20Birle%C5%9Fik%20Devletleri!5e0!3m2!1str!2str!4v1646760525018!5m2!1str!2str', 'bdevs-elementor' ),
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
<section class="contact section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-60">
                <div class="row mb-60">
                    <div class="col-md-12">
                    	<?php if ( '' !== $settings['heading'] )  : ?>
                        <h5><?php echo wp_kses_post($settings['heading']); ?></h5>
                        <?php endif; ?>
                        <?php if ( '' !== $settings['text'] )  : ?>
                        <p><?php echo wp_kses_post($settings['text']); ?></p>
                        <?php endif; ?>
                        <div class="con">
                        	<?php if ( '' !== $settings['icon_phone'] )  : ?>
                            <div class="icon"> <span class="<?php echo wp_kses_post($settings['icon_phone']); ?>"></span> </div>
                            <?php endif; ?>
                            <?php if ( '' !== $settings['phone'] )  : ?>
                            <div class="con-content">
                                <p class="text"><a href="tel:<?php echo wp_kses_post($settings['phone']); ?>"><?php echo wp_kses_post($settings['phone']); ?></a></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="con">
                        	<?php if ( '' !== $settings['icon_mail'] )  : ?>
                            <div class="icon"> <span class="<?php echo wp_kses_post($settings['icon_mail']); ?>"></span> </div>
                            <?php endif; ?>
                            <?php if ( '' !== $settings['mail'] )  : ?>
                            <div class="con-content">
                                <p class="text"><a href="mailto:<?php echo wp_kses_post($settings['mail']); ?>"><?php echo wp_kses_post($settings['mail']); ?></a></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="con">
                        	<?php if ( '' !== $settings['icon_address'] )  : ?>
                            <div class="icon"> <span class="<?php echo wp_kses_post($settings['icon_address']); ?>"></span> </div>
                            <?php endif; ?>
                            <?php if ( '' !== $settings['address'] )  : ?>
                            <div class="con-content">
                                <p class="text"><?php echo wp_kses_post($settings['address']); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5><?php echo wp_kses_post($settings['title']); ?></h5>
                        <div class="opening-hours">
                            <ul>
                            	<?php
						        	$idd = 0;
						        	foreach ( $settings['tabs'] as $item ) :
						        	$idd++;
						    	?>
                                <li>
                                    <div class="tit"><?php echo wp_kses_post($item['title_opening']); ?></div>
                                    <div class="dots"></div> <span><?php echo wp_kses_post($item['subtitle_opening']); ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
            	<?php if ( '' !== $settings['title_contact'] )  : ?>
                <h5><?php echo wp_kses_post($settings['title_contact']); ?></h5>
                <?php endif; ?>
                <?php if ( '' !== $settings['contact_form'] )  : ?>
                <?php echo do_shortcode($settings['contact_form']); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- Maps -->
<?php if ( '' !== $settings['map'] )  : ?>
<section id="map">
    <div class="full-width">
        <div class="google-map">
            <iframe src="<?php echo do_shortcode($settings['map']); ?>" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>
<?php endif; ?>
	<?php
	}

}

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
class BdevsServices extends \Elementor\Widget_Base {

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
		return 'bdevs-services';
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
		return __( 'Services Home Parallax Image', 'bdevs-elementor' );
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
		return [ 'pages-elementor' ];
	}

	public function get_keywords() {
		return [ 'services', 'carousel' ];
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
			'section_content_services',
			[
				'label' => esc_html__( 'Services', 'bdevs-elementor' ),
			]	
		);	
		
		$this->add_control(
			'subheading',
			[
				'label'       => __( 'Subheading', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your sub heading', 'bdevs-elementor' ),
				'default'     => __( 'What We Do', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);		

		$this->add_control(
			'heading',
			[
				'label'       => __( 'Heading', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your heading', 'bdevs-elementor' ),
				'default'     => __( 'Our Services', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'post_number',
			[
				'label'     => esc_html__( 'Post Count', 'bdevs-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '6',
			]
		);
		$this->add_control(
			'orderpost',
			[
				'label'     => esc_html__( 'Post Order', 'bdevs-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'asc'  => esc_html__( 'ASC', 'bdevs-elementor' ),
					'desc' => esc_html__( 'DESC', 'bdevs-elementor' ),
				],
				'default'   => 'desc',
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'bdevs-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'date'  => esc_html__( 'Date', 'bdevs-elementor' ),
					'title' => esc_html__( 'Title', 'bdevs-elementor' ),
					'rand' => esc_html__( 'Random', 'bdevs-elementor' ),
				],
				'default'   => 'desc',
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
		$wp_query = new \WP_Query(array('post_type' => 'services', 'posts_per_page' => $settings['post_number'],'orderby' => $settings['orderby'], 'order' => $settings['orderpost'],));
		extract($settings);
		?> 
<section id="services" data-scroll-index="1" class="services section-padding">
    <div class="container">
    	<?php if ( '' !== $settings['heading'] )  : ?>
       <div class="row mb-30">
            <div class="col-md-12 text-center">
            	<?php if ( '' !== $settings['subheading'] )  : ?>
                <h6 class="wow" data-splitting><?php echo wp_kses_post($settings['subheading']); ?></h6>
                <?php endif; ?>
                
                <h1 class="wow" data-splitting><?php echo wp_kses_post($settings['heading']); ?></h1>
                
                <div class="line-hr-section center"></div>
            </div>
        </div>
        <?php endif; ?>
        <div class="row">
        	<?php
        		$i=0;
	            while($wp_query->have_posts()): $wp_query->the_post();
	           	$i++;
            ?> 
            <?php $icon = get_post_meta(get_the_ID(),'_cmb_icon', true); ?>
            <div class="col-lg-4 col-md-6 mb-25">
            	<?php if($i==1){ ?>
                <div class="item active">
                <?php }else{ ?>
                <div class="item">
                <?php } ?>
                    <div class="wrap">
                        <div class="icon-1"> <i class="<?php echo esc_attr($icon);?>"></i> </div>
                        <div class="con">
                            <h4><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
                            <p><?php if(isset($acens_redux_demo['services_excerpt'])){?>
                            <?php echo esc_attr(acens_excerpt2($acens_redux_demo['services_excerpt'])); ?>
                            <?php }else{?>
                            <?php echo esc_attr(acens_excerpt2(15)); } ?></p>
                            <div class="icon-2">
                                <a href="<?php the_permalink();?>"><span class="fa-sharp fa-light fa-arrow-right"></span></a>
                            </div>
                        </div>
                        <div class="numb"><?php echo esc_attr($i);?></div>
                    </div>
                </div>
            </div> 
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php if ( '' !== $settings['line'] )  : ?>
<div class="<?php echo wp_kses_post($settings['line']); ?>"></div>
<?php endif; ?>
	<?php
	}

}

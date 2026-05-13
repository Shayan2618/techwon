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
class BdevsBlogHomeSlider extends \Elementor\Widget_Base {

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
		return 'bdevs-blog-home-slider';
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
		return __( 'Blog Home Slider ', 'bdevs-elementor' );
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
		return [ 'home-slider-elementor' ];
	}

	public function get_keywords() {
		return [ 'Blog', 'carousel' ];
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
			'section_content_ServicesHomeSlider',
			[
				'label' => esc_html__( 'Blog Home Slider', 'bdevs-elementor' ),
			]
		);
		$this->add_control(
			'subheading',
			[
				'label'       => __( 'Subheading', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your sub heading', 'bdevs-elementor' ),
				'default'     => __( 'News & Blog', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);		

		$this->add_control(
			'heading',
			[
				'label'       => __( 'Heading', 'bdevs-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your heading', 'bdevs-elementor' ),
				'default'     => __( 'Latest News', 'bdevs-elementor' ),
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'number',
			[
				'label'     => esc_html__( 'Post number', 'bdevs-elementor' ),
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
<section class="blog-home section-padding bg-drk">
    <div class="container">
        <div class="row mb-30">
            <div class="col-md-12 text-center">
                <?php if ( '' !== $settings['subheading'] )  : ?>
                <h6 class="wow" data-splitting><?php echo wp_kses_post($settings['subheading']); ?></h6>
                <?php endif; ?>
                <?php if ( '' !== $settings['heading'] )  : ?>
                <h1 class="wow" data-splitting><?php echo wp_kses_post($settings['heading']); ?></h1>
                <?php endif; ?>
                <div class="line-hr-section center"></div>
            </div>
        </div>
    </div>
    <div class="full-width">
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel owl-theme">
                    <?php 
                        $q = new \WP_Query(array(
                            'post_type'     => 'post',
                            'posts_per_page'=> $number,
	                        'orderby'       => $orderby,
	                        'order'         => $orderpost,
                        ));
                    while($q->have_posts()): $q->the_post();  
                        $cates = get_the_terms(get_the_ID(),'category');
                    $cate_name = '';
                    $cate_slug = '';
                    foreach((array)$cates as $cate){
                        if(count($cates)>0){
                            $cate_name .= $cate->name.' ';
                            $cate_slug .= $cate->slug.' ';
                        }
                    }
                    ?>
                    <?php $img_featured = get_post_meta(get_the_ID(),'_cmb_img_featured', true); ?>
                    <div class="item">
                        <div class="wrap img-grayscale">
                        	<?php if (wp_get_attachment_url($img_featured) !='')  { ?>
                            <div class="img img-grayscale"> <img src="<?php echo wp_get_attachment_url($img_featured);?>" class="img-fluid"> </div>
                            <?php } else {?>
                            <div class="img img-grayscale"> <img src="https://shthemes.net/demosd/acens/wp-content/uploads/2024/03/6.jpg" class="img-fluid"> </div>
		                    <?php } ?>

                            <div class="title">
                                <h6><?php echo  get_the_category_list();?></h6>
                                <h4><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
                                <div class="icon-box"><a href="<?php the_permalink();?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- divider line -->
<div class="line-vr-section"></div>
<?php if (is_admin()) { ?>
<script type="text/javascript">
	$('.blog-home .owl-carousel').owlCarousel({
        loop: true
        , margin: 30
        , mouseDrag: true
        , autoplay: false
        , autoplayTimeout: 5000
        , dots: true
        , nav: false
        , navText: ['<i class="fa-solid fa-angle-left"></i>', '<i class="fa-solid fa-angle-right"></i>']
        , autoplayHoverPause:true
        , responsiveClass: true
        , responsive: {
            0: {
                items: 1,
                dots: true
            , }
            , 600: {
                items: 2,
                dots: true
            }
            , 1000: {
                items: 3
            }
        }
    });
    
</script>
<?php }  ?>
	<?php
	}

}

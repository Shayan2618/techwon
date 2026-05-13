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
class BdevsBlogGrid2 extends \Elementor\Widget_Base {

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
		return 'bdevs-blog-grid-2';
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
		return __( 'Blog Grid 2', 'bdevs-elementor' );
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
		return [ 'blog-elementor' ];
	}

	public function get_keywords() {
		return [ 'Blog Grid 2', 'carousel' ];
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
			'section_content_blog2',
			[
				'label' => esc_html__( 'Blog Grid 2', 'bdevs-elementor' ),
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
				'default'   => 'asc',
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
		<section class="blog2 section-padding bg-drk">
    <div class="container">
        <div class="row">
            <?php 
			$order = $settings['orderpost'];
			$post_number = $settings['number'];
			$order_by = $settings['orderby'];
			if ( get_query_var('paged') ) {
		            $paged = get_query_var('paged');
		        } elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
		            $paged = get_query_var('page');
		        } else {
		            $paged = 1;
		        }
		        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$loop = new \WP_Query(array('posts_per_page' => $post_number,'paged' => $paged, 'post_type' => 'post', 'order' => $order, 'orderby' => $order_by));

			if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
            <?php $img_featured = get_post_meta(get_the_ID(),'_cmb_img_featured', true); ?>
            <div class="col-lg-4 col-md-6 mb-25">
                <div class="item">
                    <?php if (wp_get_attachment_url($img_featured) !='')  { ?>
                    <div class="img">
                        <a href="<?php the_permalink();?>"><img src="<?php echo wp_get_attachment_url($img_featured);?>" alt=""></a>
                    </div>
                	<?php } else {?>
                	<div class="img">
                        <a href="<?php the_permalink();?>"><img src="https://shthemes.net/demosd/acens/wp-content/uploads/2024/03/6.jpg" alt=""></a>
                    </div>
                    <?php } ?>
                    <div class="wrapper">
                        <div class="date">
                            <a href="<?php the_permalink();?>"><?php the_time(get_option( 'date_format'));?></a>
                        </div>
                        <div class="con">
                            <div class="category">
                                <i class="fa-regular fa-user"></i><?php the_author_posts_link(); ?>
                                <i class="fa-regular fa-tag"></i><?php echo  get_the_category_list();?>
                            </div>
                            <div class="text">
                                <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                            </div>
                            <a href="<?php the_permalink();?>" class="icon-btn"><span class="fa-sharp fa-light fa-arrow-right"></span></a>
                        </div>
                    </div>
                </div>
            </div> 
            <?php endwhile; ?>
        </div>
        <!-- pagination -->
        <div class="row">
            <div class="col-md-12 mt-60 text-center">
                <?php if ($loop->max_num_pages > 1) : // custom pagination  ?>
				<?php
                  $orig_query = $loop; // fix for pagination to work
                  $big = 999999999;
                  echo paginate_links(array(
                  	'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                  	'format' => '?paged=%#%',
                  	'prev_text' => wp_specialchars_decode( '<i class="fa-solid fa-caret-left"></i>',ENT_QUOTES),
                  	'next_text' => wp_specialchars_decode( '<i class="fa-solid fa-caret-right"></i>',ENT_QUOTES),
                  	'current' => max(1, get_query_var('paged')),
                  	'total' => $orig_query->max_num_pages
                  ));  
                  
                  ?>
              	<?php endif; ?>

              	<?php wp_reset_postdata(); else: echo '<p>'.__('Sorry, no tours matched your criteria.').'</p>'; endif; ?>
            </div>
        </div>
    </div>
</section>

	<?php
	}

}

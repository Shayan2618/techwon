<?php
/**
 * Recent_Posts widget class
 *
 * @since 2.8.0
 */
class acens_widget_newss extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_news', 'description' => esc_html__( "The most recent posts on your site", 'acens') );
        parent::__construct('recent-posts', esc_html__('Acens Recent Posts', 'acens'), $widget_ops);
        $this->alt_option_name = 'widget_news';

    }

    function widget($args, $instance) {
        $cache = wp_cache_get('acens_widget_newss', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo wp_specialchars_decode(esc_attr($cache[ $args['widget_id'] ]));
            return;
        }

        ob_start();
        extract($args);

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Posts', 'acens' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number )
            $number = 10;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
?>
                
        <?php echo wp_specialchars_decode(esc_attr($before_widget),ENT_QUOTES); ?>
        <?php if ( $title ) echo wp_specialchars_decode(esc_attr($before_title),ENT_QUOTES) . esc_attr($title) . wp_specialchars_decode(esc_attr($after_title),ENT_QUOTES); ?>
        <ul class="recent">
        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
        <?php $img_recent = get_post_meta(get_the_ID(),'_cmb_img_recent', true); ?>
        <?php $title_recent = get_post_meta(get_the_ID(),'_cmb_title_recent', true); ?>
        <li>
            <div class="thum"> <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id());?>" alt="<?php the_title_attribute(); ?>"> </div> 
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
        </li>
        <?php endwhile; ?> 
        </ul>
    <?php echo wp_specialchars_decode(esc_attr($after_widget)); ?>
                
<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('acens_widget_newss', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = (bool) $new_instance['show_date'];

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_news']) )
            delete_option('widget_news');

        return $instance;
    }


    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of posts to show:', 'acens' ); ?></label>
        <input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" />
        <label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php esc_html_e( 'Display post date?', 'acens' ); ?></label></p>
<?php
    }
}









class acens_widget_search extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_search', 'description' => esc_html__( "Search on your site", 'acens') );
        parent::__construct('search', esc_html__('acens Search', 'acens'), $widget_ops);
        $this->alt_option_name = 'widget_search';

    }

    function widget($args, $instance) {
        $cache = wp_cache_get('acens_widget_search', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo wp_specialchars_decode(esc_attr($cache[ $args['widget_id'] ]));
            return;
        }

        ob_start();
        extract($args);

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Search', 'acens' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        ?>
                
                <?php echo wp_specialchars_decode(esc_attr($before_widget),ENT_QUOTES); ?>
                <div class="search">
                <form action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="text" name="s" placeholder="<?php echo esc_attr__('Type here ...', 'acens' );?>" value="<?php echo get_search_query() ?>">
                    <button type="submit"><i class="fa-regular fa-magnifying-glass" aria-hidden="true"></i></button>
                </form>
                </div>
                <?php echo wp_specialchars_decode(esc_attr($after_widget)); ?>
                
<?php
        // Reset the global $the_post as this query will have stomped on it
   

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('acens_widget_search', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_search']) )
            delete_option('widget_search');

        return $instance;
    }

    

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
?>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

      
<?php
    }
}






class acens_widget_footercontact extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_footercontact', 'description' => esc_html__( "Footer Contact", 'acens') );
        parent::__construct('footercontact', esc_html__('acens Footer Contact', 'acens'), $widget_ops);
        $this->alt_option_name = 'widget_footercontact';

    }

    function widget($args, $instance) {
        $cache = wp_cache_get('acens_widget_footercontact', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo wp_specialchars_decode(esc_attr($cache[ $args['widget_id'] ]));
            return;
        }

        ob_start();
        extract($args);

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Title Contact', 'acens' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $subtitle = ( ! empty( $instance['subtitle'] ) ) ? $instance['subtitle'] : esc_html__( 'Subtitle Contact', 'acens' );
        $subtitle = apply_filters( 'widget_title', $subtitle, $instance, $this->id_base );
        $phone = ( ! empty( $instance['phone'] ) ) ? $instance['phone'] : esc_html__( 'phone Contact', 'acens' );
        $email = ( ! empty( $instance['email'] ) ) ? $instance['email'] : esc_html__( 'email Contact', 'acens' );
        $instagram = ( ! empty( $instance['instagram'] ) ) ? $instance['instagram'] : esc_html__( 'instagram', 'acens' );
        $twitter = ( ! empty( $instance['twitter'] ) ) ? $instance['twitter'] : esc_html__( 'twitter', 'acens' );
        $youtube = ( ! empty( $instance['youtube'] ) ) ? $instance['youtube'] : esc_html__( 'youtube', 'acens' );
        $facebook = ( ! empty( $instance['facebook'] ) ) ? $instance['facebook'] : esc_html__( 'facebook', 'acens' );
        $pinterest = ( ! empty( $instance['pinterest'] ) ) ? $instance['pinterest'] : esc_html__( 'pinterest', 'acens' );

        ?>
        <?php echo wp_specialchars_decode(esc_attr($before_widget),ENT_QUOTES); ?>
        <div class="footer-column footer-contact">
            <?php if($instance['title'] != ''){?>
            <h3 class="footer-title"><?php echo esc_attr($title); ?></h3>
            <?php } ?> 
            <?php if($instance['subtitle'] != ''){?>
            <p class="footer-contact-text"><?php echo esc_attr($subtitle); ?>
            </p>
            <?php } ?> 
            <div class="footer-contact-info">
                <?php if($instance['phone'] != ''){?>
                <p class="footer-contact-phone"><?php echo esc_attr($phone); ?></p>
                <?php } ?> 
                <?php if($instance['email'] != ''){?>
                <p class="footer-contact-mail"><?php echo esc_attr($email); ?></p>
                <?php } ?> 
            </div>
            <div class="footer-about-social-list"> 
                <?php if($instance['instagram'] != ''){?>
                <a href="<?php echo esc_attr($instagram); ?>"><i class="ti-instagram"></i></a>
                <?php } ?>  
                <?php if($instance['twitter'] != ''){?>
                <a href="<?php echo esc_attr($twitter); ?>"><i class="ti-twitter"></i></a> 
                <?php } ?> 
                <?php if($instance['youtube'] != ''){?>
                <a href="<?php echo esc_attr($youtube); ?>"><i class="ti-youtube"></i></a> 
                <?php } ?> 
                <?php if($instance['facebook'] != ''){?>
                <a href="<?php echo esc_attr($facebook); ?>"><i class="ti-facebook"></i></a> 
                <?php } ?> 
                <?php if($instance['pinterest'] != ''){?>
                <a href="<?php echo esc_attr($pinterest); ?>"><i class="ti-pinterest"></i></a> 
                <?php } ?> 
            </div>
        </div>
        <?php echo wp_specialchars_decode(esc_attr($after_widget)); ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
   

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('acens_widget_footercontact', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['subtitle'] = strip_tags($new_instance['subtitle']);
        $instance['phone'] = strip_tags($new_instance['phone']);
        $instance['email'] = strip_tags($new_instance['email']);
        $instance['instagram'] = strip_tags($new_instance['instagram']);
        $instance['twitter'] = strip_tags($new_instance['twitter']);
        $instance['youtube'] = strip_tags($new_instance['youtube']);
        $instance['facebook'] = strip_tags($new_instance['facebook']);
        $instance['pinterest'] = strip_tags($new_instance['pinterest']);

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_footercontact']) )
            delete_option('widget_footercontact');
        return $instance;
    }

    

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $subtitle     = isset( $instance['subtitle'] ) ? esc_attr( $instance['subtitle'] ) : '';
        $phone     = isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';
        $email     = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
        $instagram     = isset( $instance['instagram'] ) ? esc_attr( $instance['instagram'] ) : '';
        $twitter     = isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : '';
        $youtube     = isset( $instance['youtube'] ) ? esc_attr( $instance['youtube'] ) : '';
        $facebook     = isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : '';
        $pinterest     = isset( $instance['pinterest'] ) ? esc_attr( $instance['pinterest'] ) : '';
?>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'subtitle' )); ?>"><?php esc_html_e( 'Subtitle:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'subtitle' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'subtitle' )); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>"><?php esc_html_e( 'Phone:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone' )); ?>" type="text" value="<?php echo esc_attr($phone); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'email' )); ?>"><?php esc_html_e( 'Email:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'email' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'email' )); ?>" type="text" value="<?php echo esc_attr($email); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>"><?php esc_html_e( 'Instagram:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'instagram' )); ?>" type="text" value="<?php echo esc_attr($instagram); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>"><?php esc_html_e( 'Twitter:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'twitter' )); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>"><?php esc_html_e( 'Youtube:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'youtube' )); ?>" type="text" value="<?php echo esc_attr($youtube); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>"><?php esc_html_e( 'Facebook:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'facebook' )); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>"><?php esc_html_e( 'Pinterest:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pinterest' )); ?>" type="text" value="<?php echo esc_attr($pinterest); ?>" /></p>

      
<?php
    }
}




class acens_widget_worktime extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_worktime', 'description' => esc_html__( "Work Time", 'acens') );
        parent::__construct('worktime', esc_html__('acens Footer Work Time', 'acens'), $widget_ops);
        $this->alt_option_name = 'widget_worktime';

    }

    function widget($args, $instance) {
        $cache = wp_cache_get('acens_widget_worktime', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo wp_specialchars_decode(esc_attr($cache[ $args['widget_id'] ]));
            return;
        }

        ob_start();
        extract($args);
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Work Time', 'acens' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $monday = ( ! empty( $instance['monday'] ) ) ? $instance['monday'] : esc_html__( 'Monday', 'acens' );
        $monday = apply_filters( 'widget_title', $monday, $instance, $this->id_base );
        $time_monday = ( ! empty( $instance['time_monday'] ) ) ? $instance['time_monday'] : esc_html__( 'Time Monday', 'acens' );
        $tuesday = ( ! empty( $instance['tuesday'] ) ) ? $instance['tuesday'] : esc_html__( 'Tuesday', 'acens' );
        $time_tuesday = ( ! empty( $instance['time_tuesday'] ) ) ? $instance['time_tuesday'] : esc_html__( 'Time Tuesday', 'acens' );
        $thursday = ( ! empty( $instance['thursday'] ) ) ? $instance['thursday'] : esc_html__( 'Thursday', 'acens' );
        $time_thursday = ( ! empty( $instance['time_thursday'] ) ) ? $instance['time_thursday'] : esc_html__( 'Time Thursday', 'acens' );
        $friday = ( ! empty( $instance['friday'] ) ) ? $instance['friday'] : esc_html__( 'Friday', 'acens' );
        $time_friday = ( ! empty( $instance['time_friday'] ) ) ? $instance['time_friday'] : esc_html__( 'Time Friday', 'acens' );
        $saturday = ( ! empty( $instance['saturday'] ) ) ? $instance['saturday'] : esc_html__( 'saturday', 'acens' );
        $time_saturday = ( ! empty( $instance['time_saturday'] ) ) ? $instance['time_saturday'] : esc_html__( 'Time Saturday', 'acens' );
        $weekend = ( ! empty( $instance['weekend'] ) ) ? $instance['weekend'] : esc_html__( 'Weekend', 'acens' );
        $time_weekend = ( ! empty( $instance['time_weekend'] ) ) ? $instance['time_weekend'] : esc_html__( 'Time Weekend', 'acens' );
        ?>
        <?php echo wp_specialchars_decode(esc_attr($before_widget),ENT_QUOTES); ?>
        <div class="item opening">
            <?php if($instance['title'] != ''){?>
            <h3 class="footer-title"><?php echo esc_attr($title); ?></h3>
            <?php } ?> 
            <ul>
                <?php if($instance['monday'] != ''){?>
                <li>
                    <div class="tit"><?php echo esc_attr($monday); ?></div>
                    <div class="dots"></div> <span><?php echo esc_attr($time_monday); ?></span>
                </li>
                <?php } ?> 
                <?php if($instance['tuesday'] != ''){?>
                <li>
                    <div class="tit"><?php echo esc_attr($tuesday); ?></div>
                    <div class="dots"></div> <span><?php echo esc_attr($time_tuesday); ?></span>
                </li>
                <?php } ?> 
                <?php if($instance['thursday'] != ''){?>
                <li>
                    <div class="tit"><?php echo esc_attr($thursday); ?></div>
                    <div class="dots"></div> <span><?php echo esc_attr($time_thursday); ?></span>
                </li>
                <?php } ?> 
                <?php if($instance['friday'] != ''){?>
                <li>
                    <div class="tit"><?php echo esc_attr($friday); ?></div>
                    <div class="dots"></div> <span><?php echo esc_attr($time_friday); ?></span>
                </li>
                <?php } ?> 
                <?php if($instance['saturday'] != ''){?>
                <li>
                    <div class="tit"><?php echo esc_attr($saturday); ?></div>
                    <div class="dots"></div> <span><?php echo esc_attr($time_saturday); ?></span>
                </li>
                <?php } ?> 
                <?php if($instance['weekend'] != ''){?>
                <li>
                    <div class="tit"><?php echo esc_attr($weekend); ?></div>
                    <div class="dots"></div> <span><?php echo esc_attr($time_weekend); ?></span>
                </li>
                <?php } ?> 
            </ul>
        </div>
        <?php echo wp_specialchars_decode(esc_attr($after_widget)); ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
   

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('acens_widget_worktime', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['monday'] = strip_tags($new_instance['monday']);
        $instance['time_monday'] = strip_tags($new_instance['time_monday']);
        $instance['tuesday'] = strip_tags($new_instance['tuesday']);
        $instance['time_tuesday'] = strip_tags($new_instance['time_tuesday']);
        $instance['thursday'] = strip_tags($new_instance['thursday']);
        $instance['time_thursday'] = strip_tags($new_instance['time_thursday']);
        $instance['friday'] = strip_tags($new_instance['friday']);
        $instance['time_friday'] = strip_tags($new_instance['time_friday']);
        $instance['saturday'] = strip_tags($new_instance['saturday']);
        $instance['time_saturday'] = strip_tags($new_instance['time_saturday']);
        $instance['weekend'] = strip_tags($new_instance['weekend']);
        $instance['time_weekend'] = strip_tags($new_instance['time_weekend']);

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_worktime']) )
            delete_option('widget_worktime');
        return $instance;
    }

    

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $monday     = isset( $instance['monday'] ) ? esc_attr( $instance['monday'] ) : '';
        $time_monday     = isset( $instance['time_monday'] ) ? esc_attr( $instance['time_monday'] ) : '';
        $tuesday     = isset( $instance['tuesday'] ) ? esc_attr( $instance['tuesday'] ) : '';
        $time_tuesday     = isset( $instance['time_tuesday'] ) ? esc_attr( $instance['time_tuesday'] ) : '';
        $thursday     = isset( $instance['thursday'] ) ? esc_attr( $instance['thursday'] ) : '';
        $time_thursday     = isset( $instance['time_thursday'] ) ? esc_attr( $instance['time_thursday'] ) : '';
        $friday     = isset( $instance['friday'] ) ? esc_attr( $instance['friday'] ) : '';
        $time_friday     = isset( $instance['time_friday'] ) ? esc_attr( $instance['time_friday'] ) : '';
        $saturday     = isset( $instance['saturday'] ) ? esc_attr( $instance['saturday'] ) : '';
        $time_saturday     = isset( $instance['time_saturday'] ) ? esc_attr( $instance['time_saturday'] ) : '';
        $weekend     = isset( $instance['weekend'] ) ? esc_attr( $instance['weekend'] ) : '';
        $time_weekend     = isset( $instance['time_weekend'] ) ? esc_attr( $instance['time_weekend'] ) : '';
?>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'monday' )); ?>"><?php esc_html_e( 'Monday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'monday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'monday' )); ?>" type="text" value="<?php echo esc_attr($monday); ?>" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'time_monday' )); ?>"><?php esc_html_e( 'Time Monday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'time_monday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'time_monday' )); ?>" type="text" value="<?php echo esc_attr($time_monday); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'tuesday' )); ?>"><?php esc_html_e( 'Tuesday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tuesday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tuesday' )); ?>" type="text" value="<?php echo esc_attr($tuesday); ?>" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'time_tuesday' )); ?>"><?php esc_html_e( 'Time Tuesday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'time_tuesday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'time_tuesday' )); ?>" type="text" value="<?php echo esc_attr($time_tuesday); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'thursday' )); ?>"><?php esc_html_e( 'Thursday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'thursday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'thursday' )); ?>" type="text" value="<?php echo esc_attr($thursday); ?>" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'time_thursday' )); ?>"><?php esc_html_e( 'Time Thursday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'time_thursday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'time_thursday' )); ?>" type="text" value="<?php echo esc_attr($time_thursday); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'friday' )); ?>"><?php esc_html_e( 'Friday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'friday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'friday' )); ?>" type="text" value="<?php echo esc_attr($friday); ?>" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'time_friday' )); ?>"><?php esc_html_e( 'Time Friday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'time_friday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'time_friday' )); ?>" type="text" value="<?php echo esc_attr($time_friday); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'saturday' )); ?>"><?php esc_html_e( 'Saturday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'saturday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'saturday' )); ?>" type="text" value="<?php echo esc_attr($saturday); ?>" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'time_saturday' )); ?>"><?php esc_html_e( 'Time saturday:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'time_saturday' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'time_saturday' )); ?>" type="text" value="<?php echo esc_attr($time_saturday); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'weekend' )); ?>"><?php esc_html_e( 'Weekend:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'weekend' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'weekend' )); ?>" type="text" value="<?php echo esc_attr($weekend); ?>" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'time_weekend' )); ?>"><?php esc_html_e( 'Time Weekend:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'time_weekend' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'time_weekend' )); ?>" type="text" value="<?php echo esc_attr($time_weekend); ?>" /></p>

      
<?php
    }


}



class acens_widget_subscribe extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_subscribe', 'description' => esc_html__( "Subscribe", 'acens') );
        parent::__construct('subscribe', esc_html__('acens Footer Subscribe', 'acens'), $widget_ops);
        $this->alt_option_name = 'widget_subscribe';

    }

    function widget($args, $instance) {
        $cache = wp_cache_get('acens_widget_subscribe', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo wp_specialchars_decode(esc_attr($cache[ $args['widget_id'] ]));
            return;
        }

        ob_start();
        extract($args);
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Work Time', 'acens' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $subtitle = ( ! empty( $instance['subtitle'] ) ) ? $instance['subtitle'] : esc_html__( 'Subtitle', 'acens' );
        $contact_form = ( ! empty( $instance['contact_form'] ) ) ? $instance['contact_form'] : esc_html__( 'Contact Form', 'acens' );
        ?>
        <?php echo wp_specialchars_decode(esc_attr($before_widget),ENT_QUOTES); ?>
        <div class="footer-column footer-explore clearfix">
            <?php if($instance['title'] != ''){?>
            <h3 class="footer-title"><?php echo esc_attr($title); ?></h3>
            <?php } ?> 
            <div class="row subscribe">
                <div class="col-md-12">
                    <?php if($instance['subtitle'] != ''){?>
                    <p><?php echo esc_attr($subtitle); ?></p>
                    <?php } ?> 
                    <?php echo do_shortcode($contact_form); ?>
                </div>
            </div>
        </div>
        <?php echo wp_specialchars_decode(esc_attr($after_widget)); ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
   

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('acens_widget_subscribe', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['subtitle'] = strip_tags($new_instance['subtitle']);
        $instance['contact_form'] = strip_tags($new_instance['contact_form']);


        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_subscribe']) )
            delete_option('widget_subscribe');
        return $instance;
    }

    

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $subtitle     = isset( $instance['subtitle'] ) ? esc_attr( $instance['subtitle'] ) : '';
        $contact_form     = isset( $instance['contact_form'] ) ? esc_attr( $instance['contact_form'] ) : '';
?>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'subtitle' )); ?>"><?php esc_html_e( 'Subtitle:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'subtitle' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'subtitle' )); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'contact_form' )); ?>"><?php esc_html_e( 'Contact Form:', 'acens' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'contact_form' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'contact_form' )); ?>" type="text" value="<?php echo esc_attr($contact_form); ?>" /></p>

      
<?php
    }


}


function acens_register_custom_widgets() {
    register_widget( 'acens_widget_search' );
    register_widget( 'acens_widget_newss' );
    register_widget( 'acens_widget_footercontact' );
    register_widget( 'acens_widget_worktime' );
    register_widget( 'acens_widget_subscribe' );
}
add_action( 'widgets_init', 'acens_register_custom_widgets' );    
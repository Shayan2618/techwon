<?php
/**
 * Theme Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package neom
 */
$neom_business_archive_blog_design   = get_theme_mod( 'neom_archive_blog_design', 'design1' );
$neom_business_blog_content_ordering = get_theme_mod( 'neom_blog_content_ordering', array( 'meta-one', 'title', 'meta-two', 'content' ) );

/* is sidebar active. */
if ( is_active_sidebar( 'neom-sidebar-primary' ) ) {
	$div_classes = 'theme-column-6 av-md-column-6';
} else {
	$div_classes = 'theme-column-4 av-md-column-6';
}


?>
<!-- Page.php file -->
<div class="<?php echo esc_attr( $div_classes ); ?>">
	<article class="post-items">
		<?php if ( has_post_thumbnail() ) { ?>
			<figure class="post-image 
			<?php
			if ( 'design1' === $neom_business_archive_blog_design ) {
				?>
				post-image-absolute <?php } ?>">
				<div class="featured-image">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-hover">
						<?php the_post_thumbnail(); ?>
					</a>
				</div>
			</figure>
		<?php } ?>
		<div class="post-content">
			<?php foreach ( $neom_business_blog_content_ordering as $neom_business_blog_content_order ) : ?>
				<?php if ( 'meta-one' === $neom_business_blog_content_order ) : ?>
					<span class="post-date"> 
						<a href="<?php echo esc_url( get_month_link( get_post_time( 'Y' ), get_post_time( 'm' ) ) ); ?>">
							<span><?php echo esc_html( get_the_date( 'j' ) ); ?></span>
							<?php echo esc_html( get_the_date( 'M, Y' ) ); ?>
						</a> 
					</span>
					<?php
				elseif ( 'title' === $neom_business_blog_content_order ) :
					if ( is_single() ) :

						the_title( '<h5 class="post-title">', '</h5>' );

						else :

							the_title( sprintf( '<h5 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );

					endif;
						?>
					<?php
				elseif ( 'meta-two' === $neom_business_blog_content_order ) :
					$neom_business_cat_list = get_the_category_list();
					if ( ! empty( $neom_business_cat_list ) ) {
						?>

							<span class="cat-links"><i class="fa fa-thin fa-list"></i> <?php the_category( ', ' ); ?> </span>
							<br>
						<?php
					}
					$neom_business_tag_list = get_the_tag_list();
					if ( ! empty( $neom_business_tag_list ) ) {
						?>

							<span class="tag-links"><i class="fa fa-solid fa-tags"></i> <?php the_tags( '', ', ', '' ); ?> </span>

					<?php } ?>

				<?php elseif ( 'content' === $neom_business_blog_content_order ) : ?>
					<div class="post-footer">
						<?php
						$neom_business_excerpt_disabled = get_theme_mod( 'neom_excerpt_disabled', true );
						if ( true === $neom_business_excerpt_disabled ) {
							the_excerpt();
						} else {
							the_content(
								sprintf(
								/* translators: %s: Name of current post. */
									wp_kses( __( 'Read More %s <span class="meta-nav">&rarr;</span>', 'neom-business' ), array( 'span' => array( 'class' => array() ) ) ),
									the_title( '<span class="screen-reader-text">"', '"</span>', false )
								)
							);
						}
						?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</article>
</div>

<?php
/**
 * The template for displaying single posts.
 *
 * @package Open_Frame
 */

get_header();
?>
<div class="of-container of-content-area">
	<div class="<?php echo esc_attr( open_frame_layout_classes() ); ?>">
		<main id="main" class="site-main of-primary">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'single' );

				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous', 'open-frame' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next', 'open-frame' ) . '</span> <span class="nav-title">%title</span>',
					)
				);

				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile;
			?>
		</main>

		<?php get_sidebar(); ?>
	</div>
</div>
<?php
get_footer();

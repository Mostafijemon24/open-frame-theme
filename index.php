<?php
/**
 * The main template file (blog index / fallback).
 *
 * @package Open_Frame
 */

get_header();
?>
<div class="of-container of-content-area">
	<div class="<?php echo esc_attr( open_frame_layout_classes() ); ?>">
		<main id="main" class="site-main of-primary">
			<?php if ( have_posts() ) : ?>

				<?php if ( is_home() && ! is_front_page() ) : ?>
					<header class="page-header">
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
				<?php endif; ?>

				<div class="<?php echo esc_attr( open_frame_posts_grid_classes() ); ?>">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
					?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'mid_size'           => 1,
						'prev_text'          => esc_html__( 'Previous', 'open-frame' ),
						'next_text'          => esc_html__( 'Next', 'open-frame' ),
						'screen_reader_text' => esc_html__( 'Posts navigation', 'open-frame' ),
					)
				);
				?>

			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</main>

		<?php get_sidebar(); ?>
	</div>
</div>
<?php
get_footer();

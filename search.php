<?php
/**
 * The template for displaying search results.
 *
 * @package Open_Frame
 */

get_header();
?>
<div class="of-container of-content-area">
	<div class="<?php echo esc_attr( open_frame_layout_classes() ); ?>">
		<main id="main" class="site-main of-primary">
			<?php if ( have_posts() ) : ?>
				<header class="page-header">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search results for: %s', 'open-frame' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
						?>
					</h1>
				</header>

				<div class="posts-grid posts-grid--list">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'search' );
					endwhile;
					?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'prev_text' => esc_html__( 'Previous', 'open-frame' ),
						'next_text' => esc_html__( 'Next', 'open-frame' ),
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

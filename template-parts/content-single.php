<?php
/**
 * Template part for displaying a single post.
 *
 * @package Open_Frame
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-single' ); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php open_frame_entry_meta(); ?>
	</header>

	<?php open_frame_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses_post(
					/* translators: %s: post title. */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'open-frame' )
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'open-frame' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer class="entry-footer">
		<?php open_frame_entry_footer(); ?>
	</footer>
</article>

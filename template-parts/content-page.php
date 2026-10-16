<?php
/**
 * Template part for displaying a page.
 *
 * @package Open_Frame
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-single' ); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<?php open_frame_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'open-frame' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>
</article>

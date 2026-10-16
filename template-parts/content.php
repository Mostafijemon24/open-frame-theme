<?php
/**
 * Template part for displaying a post in lists/archives.
 *
 * @package Open_Frame
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card' ); ?>>
	<?php open_frame_post_thumbnail( 'open-frame-card' ); ?>

	<div class="entry-card-body">
		<header class="entry-header">
			<?php
			if ( is_sticky() && ! is_paged() ) {
				echo '<span class="sticky-badge">' . esc_html__( 'Featured', 'open-frame' ) . '</span>';
			}
			$open_frame_cats = get_the_category();
			if ( ! empty( $open_frame_cats ) && 'post' === get_post_type() ) {
				printf(
					'<a class="entry-category" href="%1$s">%2$s</a>',
					esc_url( get_category_link( $open_frame_cats[0]->term_id ) ),
					esc_html( $open_frame_cats[0]->name )
				);
			}
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			open_frame_entry_meta();
			?>
		</header>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

		<footer class="entry-footer">
			<a class="read-more" href="<?php the_permalink(); ?>">
				<?php esc_html_e( 'Read more', 'open-frame' ); ?>
				<span class="screen-reader-text"><?php the_title(); ?></span>
				<span aria-hidden="true">&rarr;</span>
			</a>
		</footer>
	</div>
</article>

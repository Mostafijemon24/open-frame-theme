<?php
/**
 * Template part for displaying a search result.
 *
 * @package Open_Frame
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-search' ); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php
		if ( 'post' === get_post_type() ) {
			open_frame_entry_meta(); }
		?>
	</header>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
</article>

<?php
/**
 * Template Name: Full Width
 * Template Post Type: page
 *
 * @package Open_Frame
 */

get_header();
?>
<div class="of-container of-content-area">
	<main id="main" class="site-main of-primary">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'page' );

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
		?>
	</main>
</div>
<?php
get_footer();

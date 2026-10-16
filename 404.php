<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Open_Frame
 */

get_header();
?>
<div class="of-container of-content-area">
	<main id="main" class="site-main of-primary layout-narrow">
		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'This page could not be found', 'open-frame' ); ?></h1>
			</header>
			<div class="page-content">
				<p><?php esc_html_e( 'The page you are looking for may have moved or no longer exists. Try a search instead.', 'open-frame' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</section>
	</main>
</div>
<?php
get_footer();

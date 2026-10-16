<?php
/**
 * The template for displaying comments.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$open_frame_count = get_comments_number();
			if ( '1' === (string) $open_frame_count ) {
				esc_html_e( 'One comment', 'open-frame' );
			} else {
				printf(
					/* translators: %s: comment count number. */
					esc_html( _n( '%s comment', '%s comments', $open_frame_count, 'open-frame' ) ),
					esc_html( number_format_i18n( $open_frame_count ) )
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
					'callback'    => 'open_frame_comment',
				)
			);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => esc_html__( 'Previous', 'open-frame' ),
				'next_text' => esc_html__( 'Next', 'open-frame' ),
			)
		);
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'open-frame' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>

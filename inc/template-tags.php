<?php
/**
 * Template tags: reusable output helpers.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'open_frame_posted_on' ) ) :
	/**
	 * Print HTML with meta information for the current post date.
	 *
	 * @return void
	 */
	function open_frame_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated screen-reader-text" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			esc_html__( 'Posted on', 'open-frame' ),
			esc_url( get_permalink() ),
			$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
		);
	}
endif;

if ( ! function_exists( 'open_frame_posted_by' ) ) :
	/**
	 * Print HTML with meta information for the current author.
	 *
	 * @return void
	 */
	function open_frame_posted_by() {
		printf(
			'<span class="byline"><span class="screen-reader-text">%1$s </span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
			esc_html__( 'By', 'open-frame' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'open_frame_entry_meta' ) ) :
	/**
	 * Print a combined meta block (date, author, comments).
	 *
	 * @return void
	 */
	function open_frame_entry_meta() {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		echo '<div class="entry-meta">';
		open_frame_posted_on();
		open_frame_posted_by();

		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				esc_html__( 'Leave a comment', 'open-frame' ),
				esc_html__( '1 Comment', 'open-frame' ),
				esc_html__( '% Comments', 'open-frame' )
			);
			echo '</span>';
		}
		echo '</div>';
	}
endif;

if ( ! function_exists( 'open_frame_entry_footer' ) ) :
	/**
	 * Print categories and tags.
	 *
	 * @return void
	 */
	function open_frame_entry_footer() {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		$categories_list = get_the_category_list( esc_html__( ', ', 'open-frame' ) );
		if ( $categories_list ) {
			printf(
				'<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				esc_html__( 'Categories', 'open-frame' ),
				wp_kses_post( $categories_list )
			);
		}

		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'open-frame' ) );
		if ( $tags_list ) {
			printf(
				'<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				esc_html__( 'Tags', 'open-frame' ),
				wp_kses_post( $tags_list )
			);
		}
	}
endif;

if ( ! function_exists( 'open_frame_post_thumbnail' ) ) :
	/**
	 * Display a responsive post thumbnail with sensible loading behavior.
	 *
	 * @param string $size Image size name.
	 * @return void
	 */
	function open_frame_post_thumbnail( $size = 'open-frame-wide' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) {
			?>
			<figure class="post-thumbnail">
				<?php the_post_thumbnail( $size, array( 'fetchpriority' => 'high' ) ); ?>
			</figure>
			<?php
		} else {
			?>
			<figure class="post-thumbnail">
				<a class="post-thumbnail-link" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'open-frame-card', array( 'loading' => 'lazy' ) ); ?>
				</a>
			</figure>
			<?php
		}
	}
endif;

if ( ! function_exists( 'open_frame_comment' ) ) :
	/**
	 * Callback for a single comment.
	 *
	 * @param WP_Comment $comment Comment object.
	 * @param array      $args    Arguments.
	 * @param int        $depth   Depth.
	 * @return void
	 */
	function open_frame_comment( $comment, $args, $depth ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment-item' ); ?>>
			<article class="comment-body">
				<footer class="comment-meta">
					<span class="comment-author vcard"><?php echo get_avatar( $comment, 48 ); ?><b class="fn"><?php comment_author_link(); ?></b></span>
					<span class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>"><?php printf( '%1$s', esc_html( get_comment_date() ) ); ?></time>
						</a>
					</span>
				</footer>
				<?php if ( '0' === $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'open-frame' ); ?></p>
				<?php endif; ?>
				<div class="comment-content"><?php comment_text(); ?></div>
				<div class="reply">
					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
							)
						)
					);
					?>
				</div>
			</article>
		<?php
		// The closing list tag is handled by WordPress.
	}
endif;

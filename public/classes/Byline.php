<?php

namespace AdditionalAuthors;

/**
 * Appends the additional authors to the byline a standard theme renders.
 *
 * Off by default - a plugin update must not silently change what a site outputs.
 * Enable it with:
 *
 *     add_filter( 'additional_authors_auto_byline', '__return_true' );
 *
 * There is no single hook that covers both theme generations, so this hooks four:
 * the two classic template tags and the two core blocks that render an author.
 * Themes that call neither still work the way they always did, through
 * do_action( 'additional_authors_the_authors' ).
 */
class Byline {

	private Plugin $plugin;

	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;

		// Registered unconditionally and gated inside the callbacks: whether the
		// feature is on is decided by a filter, and other plugins add theirs on
		// init or later - after this constructor has run.
		add_filter( 'the_author', array( $this, 'the_author' ) );
		add_filter( 'the_author_posts_link', array( $this, 'the_author_posts_link' ), 10, 3 );
		add_filter( 'render_block_core/post-author', array( $this, 'render_post_author' ), 10, 3 );
		add_filter( 'render_block_core/post-author-name', array( $this, 'render_post_author_name' ), 10, 3 );
	}

	/**
	 * Whether the byline should be extended for this request.
	 */
	private function isActive(): bool {
		if ( is_admin() || wp_doing_ajax() || is_feed() ) {
			return false;
		}
		// The REST API already exposes the additional_authors field, and a headless
		// consumer parsing rendered HTML should not suddenly find extra names in it.
		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			return false;
		}

		return (bool) apply_filters( Plugin::FILTER_AUTO_BYLINE, false );
	}

	/**
	 * The post whose byline is currently being rendered, or 0.
	 *
	 * in_the_loop() is the guard that keeps get_the_archive_title() out: on an author
	 * archive it calls get_the_author() for the heading, outside the loop. Without
	 * this the heading would read "Author: Anna, Mark, David".
	 */
	private function loopPostId(): int {
		if ( ! in_the_loop() ) {
			return 0;
		}
		$id = get_the_ID();

		return $id ? (int) $id : 0;
	}

	/**
	 * The additional author ids of a post - everything after the main author.
	 *
	 * @return int[]
	 */
	private function additionalIds( int $post_id ): array {
		$ids = $this->plugin->get_ids( $post_id );

		return array_slice( $ids, 1 );
	}

	/**
	 * Builds the string appended after the main author's name.
	 *
	 * @param int    $post_id The post being rendered.
	 * @param bool   $linked  Whether the names should be links.
	 * @param string $context Which hook is asking, for the filter.
	 * @return string Markup to append, or "" when there is nothing to add.
	 */
	private function suffix( int $post_id, bool $linked, string $context ): string {
		$ids = $this->additionalIds( $post_id );
		if ( empty( $ids ) ) {
			return '';
		}

		$names = array();
		foreach ( $ids as $id ) {
			// display_name is already escaped in the database - WordPress runs
			// sanitize_text_field, wp_filter_kses and _wp_specialchars on it when the
			// user is saved. Escaping again here would double-encode entities and
			// would not match what core itself outputs.
			$name = get_the_author_meta( 'display_name', $id );
			if ( '' === $name ) {
				continue;
			}
			if ( $linked ) {
				$name = sprintf(
					'<a href="%s" rel="author">%s</a>',
					esc_url( get_author_posts_url( $id ) ),
					$name
				);
			}
			$names[] = $name;
		}

		if ( empty( $names ) ) {
			return '';
		}

		$separator = apply_filters( Plugin::FILTER_BYLINE_SEPARATOR, ', ', $post_id, $context );
		$suffix    = $separator . implode( $separator, $names );

		/**
		 * The finished suffix, for sites that want "Anna und Mark" or a different
		 * wording entirely.
		 */
		return (string) apply_filters( Plugin::FILTER_BYLINE_SUFFIX, $suffix, $ids, $post_id, $context );
	}

	/**
	 * the_author - used by the_author() and by themes that build their own link,
	 * such as Twenty Twenty-One.
	 *
	 * Plain names only: a theme is free to run the result through esc_html(), and
	 * Twenty Twenty-One does, so markup here would end up visible on the page.
	 *
	 * @param string $display_name
	 * @return string
	 */
	public function the_author( $display_name ) {
		if ( ! $this->isActive() ) {
			return $display_name;
		}

		$post_id = $this->loopPostId();
		if ( ! $post_id ) {
			return $display_name;
		}

		// Only extend the name when it is this post's main author. Keeps the filter
		// out of comment lists, widgets and anything else printing a user's name
		// while a post happens to be set up.
		global $authordata;
		if ( ! is_object( $authordata )
			|| (int) $authordata->ID !== (int) get_post_field( 'post_author', $post_id ) ) {
			return $display_name;
		}

		return $display_name . $this->suffix( $post_id, false, 'the_author' );
	}

	/**
	 * the_author_posts_link - the linked byline of most classic themes.
	 *
	 * The incoming $link cannot be reused: get_the_author_posts_link() builds it from
	 * get_the_author(), which the filter above has already extended, so the anchor
	 * text would contain every name while pointing at the main author alone. The
	 * link for the main author is therefore rebuilt here in core's exact shape, and
	 * the additional authors are appended as links of their own.
	 *
	 * @param string $link
	 * @param string $author Display name as core assembled it - unused, see above.
	 * @param string $title  Title attribute text core assembled - unused.
	 * @return string
	 */
	public function the_author_posts_link( $link, $author = '', $title = '' ) {
		if ( ! $this->isActive() ) {
			return $link;
		}

		$post_id = $this->loopPostId();
		if ( ! $post_id ) {
			return $link;
		}

		global $authordata;
		if ( ! is_object( $authordata )
			|| (int) $authordata->ID !== (int) get_post_field( 'post_author', $post_id ) ) {
			return $link;
		}

		$suffix = $this->suffix( $post_id, true, 'the_author_posts_link' );
		if ( '' === $suffix ) {
			return $link;
		}

		$main = sprintf(
			'<a href="%s" rel="author">%s</a>',
			esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
			get_the_author_meta( 'display_name', $authordata->ID )
		);

		return $main . $suffix;
	}

	/**
	 * core/post-author-name - the byline block of the bundled block themes.
	 *
	 * @param string    $content
	 * @param array     $parsed_block
	 * @param \WP_Block $block
	 * @return string
	 */
	public function render_post_author_name( $content, $parsed_block, $block ) {
		if ( ! $this->isActive() || '' === trim( (string) $content ) ) {
			return $content;
		}

		$post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : 0;
		if ( ! $post_id ) {
			return $content;
		}

		$linked = ! empty( $parsed_block['attrs']['isLink'] );
		$suffix = $this->suffix( $post_id, $linked, 'core/post-author-name' );
		if ( '' === $suffix ) {
			return $content;
		}

		// The block renders <div {wrapper}>{name}</div>. Appending inside that div
		// keeps the wrapper attributes, alignment and link colour the block computed.
		return $this->insertBefore( $content, '</div>', $suffix );
	}

	/**
	 * core/post-author - avatar, optional byline label, name, optional biography.
	 *
	 * @param string    $content
	 * @param array     $parsed_block
	 * @param \WP_Block $block
	 * @return string
	 */
	public function render_post_author( $content, $parsed_block, $block ) {
		if ( ! $this->isActive() || '' === trim( (string) $content ) ) {
			return $content;
		}

		$post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : 0;
		if ( ! $post_id ) {
			return $content;
		}

		// With showBio on, the block prints one author's biography. Adding names above
		// a biography that belongs to only one of them reads as if it described all of
		// them, so this variant is left alone.
		if ( ! empty( $parsed_block['attrs']['showBio'] ) ) {
			return $content;
		}

		// Mirrors the block's own condition for linking the name.
		$linked = ! empty( $parsed_block['attrs']['isLink'] ) && ! empty( $parsed_block['attrs']['linkTarget'] );
		$suffix = $this->suffix( $post_id, $linked, 'core/post-author' );
		if ( '' === $suffix ) {
			return $content;
		}

		$marker = 'class="wp-block-post-author__name"';
		$start  = strpos( $content, $marker );
		if ( false === $start ) {
			return $content;
		}
		$end = strpos( $content, '</p>', $start );
		if ( false === $end ) {
			return $content;
		}

		return substr( $content, 0, $end ) . $suffix . substr( $content, $end );
	}

	/**
	 * Splices a string in before the last occurrence of a closing tag.
	 */
	private function insertBefore( string $content, string $tag, string $insert ): string {
		$pos = strrpos( $content, $tag );
		if ( false === $pos ) {
			return $content;
		}

		return substr( $content, 0, $pos ) . $insert . substr( $content, $pos );
	}
}

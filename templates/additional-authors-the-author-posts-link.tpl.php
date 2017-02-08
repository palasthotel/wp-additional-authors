<?php
/**
 * @var \AdditionalAuthors\Render $this
 * @var array $author_id
 */

printf(
	'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
	esc_url( get_author_posts_url( $author_id ) ),
	sprintf(
		esc_attr__( 'Posts by %s' ),
		$display_name
	),
	$display_name
);

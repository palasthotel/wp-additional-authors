<?php

defined( 'ABSPATH' ) || exit;

/**
 * @var array $attributes
 */

if ( ! is_archive() ) {
	return;
}

$show_prefix = isset( $attributes['showPrefix'] ) ? (bool) $attributes['showPrefix'] : true;
if ( ! $show_prefix ) {
	add_filter( 'get_the_archive_title_prefix', '__return_empty_string', 1 );
}
// This called additional_authros_get_archive_author_title() when the prefix was
// turned off - a function that does not exist, so the page ended in a fatal error.
$title = additional_authors_get_archive_author_title();
if ( ! $show_prefix ) {
	remove_filter( 'get_the_archive_title_prefix', '__return_empty_string', 1 );
}

$align_class_name   = empty( $attributes['textAlign'] ) ? '' : 'has-text-align-' . sanitize_html_class( $attributes['textAlign'] );
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $align_class_name ) );

// get_block_wrapper_attributes() escapes what it returns. The title is markup -
// core's archive title wraps the name in a <span> - so it goes through wp_kses_post.
printf( '<h1 %1$s>%2$s</h1>', $wrapper_attributes, wp_kses_post( $title ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- see above

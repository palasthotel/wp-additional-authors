<?php
/**
 * @var array $attributes
 */

// Only an author archive has a user as its queried object. Anywhere else this read
// the ID of whatever was queried - a post or a term - and printed the biography of
// the user who happened to have the same ID, or warned about a property of null.
$additional_author_archive_object = get_queried_object();
if ( ! ( $additional_author_archive_object instanceof WP_User ) ) {
	return;
}

// The description is filtered through wp_filter_kses when it is saved, and core's
// own post-author-biography block prints it the same way.
$additional_author_archive_biography = get_the_author_meta( 'description', $additional_author_archive_object->ID );

$align_class_name   = empty( $attributes['textAlign'] ) ? '' : 'has-text-align-' . sanitize_html_class( $attributes['textAlign'] );
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $align_class_name ) );

printf( '<div %1$s>%2$s</div>', $wrapper_attributes, $additional_author_archive_biography );

<?php
/**
 * @var \AdditionalAuthors\Render $this
 * @var array $additional_authors_ids
 * @var * $additional_vars
 * @package AdditionalAuthors
 */

$additional_authors_names = array();
foreach ( $additional_authors_ids as $author_id ) {
	$additional_authors_names[] = get_the_author_meta( 'display_name', $author_id );
}
if ( count( $additional_authors_names ) > 0 ) {
	echo implode( ', ', $additional_authors_names );
}

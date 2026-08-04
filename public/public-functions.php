<?php

use AdditionalAuthors\Plugin;

/**
 * @return Plugin
 */
function additional_authors_get_plugin(){
	return Plugin::instance();
}

/**
 * Quite similar to the_author().
 * Echo the additional authors as a string, beginning with ",", e.g.
 * ", Mark, Anna, David".
 * For use in frontend.
 *
 * @param null|int $post_id The Post ID we want to get the additional authors from.
 *
 * @param mixed $additional_vars
 */
function additional_authors_the_authors( $post_id = NULL,  $additional_vars = null ) {
	additional_authors_get_plugin()->render->the_authors( $post_id, $additional_vars );
}

/**
 * Quite similar to the_author_posts_link().
 *
 * @param null|int $post_id The Post ID we want to get the additional authors from.
 *
 * @param mixed $additional_vars
 */
function additional_authors_the_authors_posts_links( $post_id = NULL, $additional_vars = null ) {
	additional_authors_get_plugin()->render->the_authors_posts_links( $post_id, $additional_vars );
}

/**
 * For use in frontend.
 *
 * @param null|int $post_id
 *
 * @return array User IDs as int
 */
function additional_authors_get_the_authors_ids( $post_id = NULL) {
	return additional_authors_get_plugin()->get_ids( $post_id );
}

/**
 * solr indexing authors filter
 *
 * @param $author_ids
 * @param $post_id
 *
 * @return array
 */
function additional_authors_solr_author_ids($author_ids, $post_id){
	$author_ids = additional_authors_get_the_authors_ids($post_id);
	return $author_ids;
}
add_filter('solr_index_update_author_ids', 'additional_authors_solr_author_ids', 10, 2);


/**
 * Helpers for gutenberg blocks
 * replacements for core functions
 */
function additional_authors_get_the_author(){
    $additional_author_archive_object = get_queried_object();
    return apply_filters( 'the_author', is_object( $additional_author_archive_object ) ? $additional_author_archive_object->display_name : '' );
}

function additional_authors_get_archive_author_title() {
    $title  = __( 'Archives' );
    $prefix = '';

    if ( is_author() ) {
        $title  = additional_authors_get_the_author();
        $prefix = _x( 'Author:', 'author archive title prefix' );
    }

    $original_title = $title;

    /**
     * Filters the archive title prefix.
     *
     * @since 5.5.0
     *
     * @param string $prefix Archive title prefix.
     */
    $prefix = apply_filters( 'get_the_archive_title_prefix', $prefix );
    if ( $prefix ) {
        $title = sprintf(
        /* translators: 1: Title prefix. 2: Title. */
            _x( '%1$s %2$s', 'archive title' ),
            $prefix,
            '<span>' . $title . '</span>'
        );
    }

    /**
     * Filters the archive title.
     *
     * @since 4.1.0
     * @since 5.5.0 Added the `$prefix` and `$original_title` parameters.
     *
     * @param string $title          Archive title to be displayed.
     * @param string $original_title Archive title without prefix.
     * @param string $prefix         Archive title prefix.
     */
    return apply_filters( 'get_the_archive_title', $title, $original_title, $prefix );
}


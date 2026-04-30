<?php


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

$is_archive = is_archive();
$title = "";

if ( $is_archive ) {
    $show_prefix = isset( $attributes['showPrefix'] ) ? $attributes['showPrefix'] : true;
    if ( ! $show_prefix ) {
        add_filter( 'get_the_archive_title_prefix', '__return_empty_string', 1 );
        $title  = __( 'Archives' );
        $prefix = '';
        $title = additional_authros_get_archive_author_title();
        remove_filter( 'get_the_archive_title_prefix', '__return_empty_string', 1 );
    } else {
        $title = additional_authors_get_archive_author_title();
    }

    $align_class_name   = empty( $attributes['textAlign'] ) ? '' : "has-text-align-{$attributes['textAlign']}";
    $wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $align_class_name ) );

    $additional_author_archive_title = sprintf( '<h1 %1$s>', $wrapper_attributes ) . $title . '</h1>';
}

?>
<?php print($additional_author_archive_title);?>

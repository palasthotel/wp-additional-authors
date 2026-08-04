<?php
$is_archive = is_archive();
$title = "";

$additional_author_archive_title = '';
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

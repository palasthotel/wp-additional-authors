<?php
$additional_author_archive_biography = "";
$additional_author_archive_object = get_queried_object();
$additional_author_archive_biography = get_the_author_meta( 'description', $additional_author_archive_object->ID );

if ( empty( $additional_author_archive_biography ) ) {
    $additional_author_archive_biography = "";
}

$align_class_name   = empty( $attributes['textAlign'] ) ? '' : "has-text-align-{$attributes['textAlign']}";
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $align_class_name ) );

$additional_author_archive_biography = sprintf( '<div %1$s>', $wrapper_attributes ) . $additional_author_archive_biography . '</div>';

?>

<?php echo($additional_author_archive_biography); ?>

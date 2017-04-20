<?php

function additional_authors_get_plugin(){
	return \AdditionalAuthors\Plugin::get_instance();
}

/**
* Quite similar to the_author().
* Echo the additional authors as a string, beginning with ",", e.g.
* ", Mark, Anna, David".
* For use in frontend.
*
* @param  int $post_id The Post ID we want to get the additional authors from.
*
* @return null
*/
function additional_authors_the_authors( $post_id = NULL,  $additional_vars = null ) {
	additional_authors_get_plugin()->render->the_authors( $post_id, $additional_vars );
}

/**
* Quite similar to the_author_posts_link().
*
* @param  int $post_id The Post ID we want to get the additional authors from.
*
* @return array List of authors posts links
*/
function additional_authors_the_authors_posts_links( $post_id = NULL, $additional_vars = null ) {
	additional_authors_get_plugin()->render->the_authors_posts_links( $post_id, $additional_vars );
}

/**
* For use in frontend.
* @return array User IDs as int
*/
function additional_authors_get_the_authors_ids( $post_id = NULL) {
	return additional_authors_get_plugin()->get_ids( $post_id );
}

/**
* solr indexing authors filter
* @param $auhtor_ids
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
 * Class AdditionalAuthors
 * @deprecated
 */
class AdditionalAuthors extends AdditionalAuthors\Plugin{};
<?php

namespace AdditionalAuthors\Table;


function get_author_ids( $post_id = null ) {
	/**
	 * first id is main author
	 */
	$post                   = get_post( $post_id );
	$additional_authors_ids = array(
		intval($post->post_author),
	);

	global $wpdb;
	$additional_authors_ids_as_string = $wpdb->get_col("SELECT author_id FROM ".tablename()." WHERE post_id = {$post->ID}");

	if ( ! empty( $additional_authors_ids_as_string ) ) {
		foreach ( $additional_authors_ids_as_string as $author_id_as_string ) {
			if ( is_numeric( $author_id_as_string ) ) {
				$author_id = intval( $author_id_as_string );
				if ( $author_id > 0 ) {
					$additional_authors_ids[] = $author_id;
				}
			}
		}
	}

	/**
	 * than get all additional ids
	 */
	$unique = array_unique( $additional_authors_ids );
	$result = array();
	foreach ($unique as $u){
		$result[] = $u;
	}
	return $result;
}

/**
 * update additional author on post
 * @param $post_id
 * @param $author_id
 *
 * @return false|int
 */
function set($post_id, $author_id){
	global $wpdb;
	return $wpdb->replace(
		tablename(),
		array(
			'post_id' => $post_id,
			'author_id' => $author_id,
		),
		array(
			'%d',
			'%d',
		)
	);
}

/**
 * delete author
 *
 * @return false|int
 */
function delete($post_id, $auhtor_id){
	global $wpdb;
	return $wpdb->delete(
		tablename(),
		array(
			"post_id" => $post_id,
			"author_id" => $auhtor_id,
		),
		array(
			'%d',
			'%d',
		)
	);
}

/**
 *
 * delete all additional authors of post
 * @param $post_id
 *
 * @return false|int
 */
function delete_all_of_post($post_id){
	global $wpdb;
	return $wpdb->delete(
		tablename(),
		array(
			"post_id" => $post_id,
		),
		array(
			'%d',
		)
	);
}


/**
 *
 * delete all connections for author
 * @param $post_id
 *
 * @return false|int
 */
function delete_all_of_author($author_id){
	global $wpdb;
	return $wpdb->delete(
		tablename(),
		array(
			"author_id" => $author_id,
		),
		array(
			'%d',
		)
	);
}

/**
 * table name of
 * @return string
 */
function tablename(){
	global $wpdb;
	return $wpdb->prefix."additional_authors";
}

/**
 * install flags table
 */
function install(){
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta("CREATE TABLE IF NOT EXISTS ".tablename()." 
		(
		 id bigint(20) unsigned not null auto_increment ,
		 post_id bigint(20) unsigned not null,
		 author_id bigint(20) unsigned not null,
		 primary key (id),
		 unique key element (post_id, author_id),
		 key (post_id),
		 key (author_id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
}
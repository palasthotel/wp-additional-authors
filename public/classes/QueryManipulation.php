<?php

namespace AdditionalAuthors;
use WP_Query;

/**
 * Class QueryManipulation
 * @package AdditionalAuthors
 */
class QueryManipulation {
	private Plugin $plugin;
	private Database $database;

	/**
	 * Query constructor.
	 *
	 * @param Plugin $plugin
	 */
	function __construct( Plugin $plugin ) {

		$this->plugin = $plugin;
		$this->database = $plugin->database;
		// Manipulate author query to show also posts, where this author is set
		// in a post meta field.
		add_filter( 'posts_where', array( $this, 'posts_where' ), 10, 2 );
		add_filter( 'get_usernumposts', array( $this, 'change_num_posts' ), 10, 4 );

		// WP_User query
		add_action('pre_user_query', array($this, 'pre_user_query'));
	}

	/**
	 * @param WP_Query $wp_query
	 *
	 * @return bool
	 */
	private function isIgnored($wp_query){
		return $wp_query->get('author_ignore_additional', apply_filters(Plugin::FILTER_WP_QUERY_IGNORE_ADDITIONAL_DEFAULT, false)) !== false;
	}

	/**
	 * @param WP_Query $wp_query
	 *
	 * @return false|int
	 */
	private function getAuthorId($wp_query){

		$author_id = $wp_query->get('author');
		if( (is_int($author_id) && $author_id > 0) || (is_string($author_id) && $author_id != "" && intval($author_id)."" === $author_id)){
			return intval($author_id);
		}

		return false;
	}

	/**
	 * @param WP_Query $wp_query
	 * @return false|int[]
	 */
	private function getNotIn($wp_query){
		$ids = $wp_query->get('author__not_in');
		if(!empty($ids)){
			return array_map('intval', $ids);
		}
		return false;
	}

	/**
	 * @param WP_Query $wp_query
	 * @return false|int[]
	 */
	private function getIn($wp_query){
		$ids = $wp_query->get('author__in');
		if(!empty($ids)){
			return array_map('intval', $ids);
		}
		return false;
	}

	/**
	 * @param WP_Query $wp_query
	 *
	 * @return bool
	 */
	private function isManipulationNeeded($wp_query){
		$author_id = $this->getAuthorId($wp_query);
		$include = $this->getIn($wp_query);
		return (false !== $author_id || false !== $include)
		       && (is_author() || !$this->isIgnored($wp_query));

	}


	/**
	 * WHERE statement
	 *
	 * @param  string $where The WHERE clause of the query.
	 *
	 * @param WP_Query $wp_query
	 *
	 * @return string $where
	 */
	function posts_where( $where, $wp_query ) {

		if ( !$this->isManipulationNeeded($wp_query) ) {
			return $where;
		}

		global $wpdb;
		$author_id = $this->getAuthorId($wp_query);

		$author_ids = [];
		if($author_id){
			$author_ids[] = $author_id;
		}

		$include = $this->getIn($wp_query);
		if(!empty($include)){
			$author_ids = array_unique(array_merge($include, $author_ids));
		}

		$author_id = implode(",", $author_ids);

		if(empty($author_ids)){
			return $where;
		}

		$where = str_replace(
			"$wpdb->posts.post_author = $author_id",
			"( $wpdb->posts.ID IN (SELECT post_id FROM " . $this->database->table . " WHERE author_id = $author_id) OR $wpdb->posts.post_author = $author_id )",
			$where
		);

		$where = str_replace(
			"$wpdb->posts.post_author IN ($author_id)",
			"( $wpdb->posts.post_author IN ($author_id) OR $wpdb->posts.ID IN ( SELECT post_id FROM " . $this->database->table . " WHERE author_id IN ($author_id)) )",
			$where
		);

		return $where;
	}

	function change_num_posts( $count, $userid, $post_type, $public_only ) {

		global $wpdb;

		$select = "SELECT count(*) FROM {$wpdb->posts} WHERE {$wpdb->posts}.ID IN ( SELECT post_id FROM ".$this->database->table." WHERE author_id = $userid)";

		if(is_array($post_type)){
			if(count($post_type) > 0 && !in_array("any", $post_type)){

				$values = array_filter($post_type, function($type){
					return post_type_exists($type);
				});
				$values = implode(", ", array_map(function($type){
					return "'$type'";
				}, $values));

				$select.= " AND post_type IN ($values)";
			}
		} else if($post_type != "any") {
			$select.= " AND post_type = '$post_type'";
		}

		$additional_count = $wpdb->get_var( $select );

		return (int)$count + (int)$additional_count;
	}

	/**
	 * @param \WP_User_Query $query
	 */
	function pre_user_query($query){
		global $wpdb;
		if(
			($query->get("has_published_posts") === true || !empty($query->get("has_published_posts")))
		   &&
			$query->get(Plugin::WP_USER_QUERY_ARG_IGNORE_PUBLISHED_AS_ADDITIONAL_AUTHOR) !== true
		) {
			$start_string = "AND $wpdb->users.ID IN ( ";

			$inject_where_additional_authors = " $wpdb->users.ID IN ( SELECT author_id FROM ".$this->database->table." ) ";

			$new_start    = "AND ( $inject_where_additional_authors OR $wpdb->users.ID IN ( ";
			$end_string   = ") )";

			$where = $query->query_where;
			$start = strpos( $where, $start_string );
			$end   = strpos( $where, $end_string, $start );

			$where = substr_replace( $where, ") ", $end, 0 );

			$where = str_replace( $start_string, $new_start, $where );

			$query->query_where = $where;
		}
	}
}

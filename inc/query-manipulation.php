<?php

namespace AdditionalAuthors;

/**
 * Class QueryManipulation
 * @package AdditionalAuthors
 * @deprecated Use taxonomy solution
 */
class QueryManipulation {

	/**
	 * @var string author query
	 */
	private $author_name;

	/**
	 * Query constructor.
	 *
	 * @param Plugin $plugin
	 */
	function __construct( Plugin $plugin ) {

		$this->plugin = $plugin;

		// Manipulate author query to show also posts, where this author is set
		// in a post meta field.
		add_filter( 'posts_join', array( $this, 'posts_join' ) );
		add_filter( 'posts_where', array( $this, 'posts_where' ) );
		add_filter( 'posts_groupby', array( $this, 'posts_groupby' ) );
		add_filter( 'get_usernumposts', array( $this, 'change_num_posts' ), 10, 4 );
	}

	/**
	 * JOIN statement
	 *
	 * @param  string $join The JOIN clause of the query.
	 *
	 * @return string $join
	 */
	function posts_join( $join ) {

		// Only manipulate SQL on author page.
		if ( is_admin() || ! is_author() || ! is_main_query() ) {
			return $join;
		}

		global $wpdb;
		$join .= "INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)";

		return $join;
	}

	/**
	 * WHERE statement
	 *
	 * @param  string $where The WHERE clause of the query.
	 *
	 * @return string $where
	 */
	function posts_where( $where ) {

		// Only manipulate SQL on author page.
		if ( is_admin() || ! is_author() || ! is_main_query() ) {
			return $where;
		}

		$author_id = get_query_var( 'author', false );
		if ( $author_id === false || ! is_int( $author_id ) ) {
			return $where;
		}

		global $wpdb;
		$where .= "OR ( " .
		          "{$wpdb->postmeta}.meta_key = '" . \AdditionalAuthors::META_POST_ADDITIONAL_AUTHORS . "' AND " .
		          "CAST({$wpdb->postmeta}.meta_value AS CHAR) = '{$author_id}' AND " .
		          "{$wpdb->posts}.post_password = '' AND " .
		          "{$wpdb->posts}.post_type = 'post' AND " .
		          "({$wpdb->posts}.post_status = 'publish' OR {$wpdb->posts}.post_status = 'private') " .
		          ")";

		return $where;
	}

	/**
	 * GROUP BY statement
	 *
	 * @param  string $groupby The GROUP BY clause of the query.
	 *
	 * @return string $groupby
	 */
	function posts_groupby( $groupby ) {

		// Only manipulate SQL on author page.
		if ( is_admin() || ! is_author() || ! is_main_query() ) {
			return $groupby;
		}

		global $wpdb;
		$groupby = "{$wpdb->posts}.ID";

		return $groupby;
	}

	function change_num_posts( $count, $userid, $post_type, $public_only ) {

		global $wpdb;

		$select = "SELECT count(*) FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON post_id = ID ";
		$where = "WHERE meta_key = '".Plugin::META_POST_ADDITIONAL_AUTHORS."' AND meta_value = '$userid'";
		if($post_type != "any") $where.= " AND post_type = '$post_type'";


		$additional_count = $wpdb->get_var( $select.$where );

		return (int)$count + (int)$additional_count;
	}
}

<?php

namespace AdditionalAuthors;

/**
 * Plugin Name: Additional Authors
 * Description: Provides a meta box for additional authors from existing users or taxonomy.
 * Version: 1.1
 * Author: PALASTHOTEL (by Kim-Christian Meyer, Edward Bock)
 * Author URI: https://palasthotel.de
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class AdditionalAuthors
 */
class Plugin {

	/**
	 * all outputs via themes
	 */
	const THEME_FOLDER = "plugin-parts";
	const TEMPLATE_THE_AUTHORS = "additional-authors-the-authors.tpl.php";
	const TEMPLATE_THE_AUTHORS_POSTS_LINKS = "additional-authors-the-authors-posts-links.tpl.php";
	const TEMPLATE_THE_AUTHOR_POSTS_LINK = "additional-authors-the-author-posts-link.tpl.php";

	/**
	 * all actions
	 */
	const ACTION_THE_AUTHORS = "additional_authors_the_authors";
	const ACTION_THE_AUTHORS_POSTS_LINKS = "additional_authors_the_authors_posts_links";
	const ACTION_THE_AUTHOR_POSTS_LINK = "additional_authors_the_author_posts_link";

	// migration action
	const ACTION_ADDITIONAL_AUTHOR_DESTINATION = "additional_authors_load_additional_author_destination";

	/**
	 * meta values
	 */
	const META_POST_ADDITIONAL_AUTHORS = "_additional_authors";
	const META_USER_GENERATED = "_additional_authors_generated_user";

	private static $instance;

	static function get_instance() {
		if ( self::$instance == null ) {
			self::$instance = new Plugin();
		}

		return self::$instance;
	}

	/**
	 * variables
	 */
	public $dir;
	public $url;

	/**
	 * AdditionalAuthors constructor.
	 */
	function __construct() {

		/**
		 * base paths
		 */
		$this->dir = plugin_dir_path( __FILE__ );
		$this->url = plugin_dir_url( __FILE__ );

		require dirname( __FILE__ ) . "/inc/query-manipulation.php";
		$this->query_manipulation = new QueryManipulation( $this );

		require dirname( __FILE__ ) . "/inc/meta-box.php";
		$this->meta_box = new MetaBox( $this );

		require dirname( __FILE__ ) . "/inc/user.php";
		$this->user = new User( $this );

		require dirname( __FILE__ ) . "/inc/render.php";
		$this->render = new Render( $this );

		require dirname( __FILE__ ) . "/inc/migrate.php";
		$this->migrate = new Migrate( $this );

	}

	/**
	 * get the additions authors user ids
	 *
	 * @param null|int $post_id
	 *
	 * @return array
	 */
	public function get_ids( $post_id = null ) {
		/**
		 * first id is main author
		 */
		$post                   = get_post( $post_id );
		$additional_authors_ids = array(
			$post->post_author,
		);

		/**
		 * than get all additional ids
		 */
		if ( ! empty( $post_id ) ) {
			$additional_authors_ids_as_string = get_post_custom_values( self::META_POST_ADDITIONAL_AUTHORS, $post_id );
		} else {
			$additional_authors_ids_as_string = get_post_custom_values( self::META_POST_ADDITIONAL_AUTHORS );
		}
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

		return array_unique( $additional_authors_ids );
	}

	/**
	 * Add an unguessable string to end
	 *
	 * @return string
	 */
	public function generateUnguessableString() {
		return bin2hex( openssl_random_pseudo_bytes( 20 ) );
	}

	/**
	 * generate a strong password
	 * @return string
	 */
	public function generatePassword() {
		return wp_generate_password( 20, true );
	}
}

/**
 * init plugin and make it accessible
 */
Plugin::get_instance();

require_once dirname( __FILE__ ) . "/public-functions.php";
<?php
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
class AdditionalAuthors {

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

		require plugin_dir_path( __FILE__ ) . "class/query-manipulation.php";
		new \AdditionalAuthors\QueryManipulation( $this );

		require plugin_dir_path( __FILE__ ) . "class/meta-box.php";
		new \AdditionalAuthors\MetaBox( $this );

		require plugin_dir_path( __FILE__ ) . "class/render.php";
		$this->render = new \AdditionalAuthors\Render( $this );

		require plugin_dir_path( __FILE__ ) . "class/migrate.php";
		$this->migrate = new \AdditionalAuthors\Migrate( $this );

	}

	/**
	 * get the additions authors user ids
	 *
	 * @param null|int $post_id
	 *
	 * @return array
	 */
	public function get_ids( $post_id = NULL ) {
		/**
		 * first id is main author
		 */
		$post = get_post($post_id);
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

		return $additional_authors_ids;
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
	public function generatePassword(){
		return wp_generate_password(20, true);
	}
}

/**
 * init plugin and make it accessible
 */
global $additional_authors;
$additional_authors = new AdditionalAuthors();

/**
 * -------------------------------
 * public functions
 * -------------------------------
 */

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
	global $additional_authors;
	$additional_authors->render->the_authors( $post_id, $additional_vars );
}

/**
 * Quite similar to the_author_posts_link().
 *
 * @param  int $post_id The Post ID we want to get the additional authors from.
 *
 * @return array List of authors posts links
 */
function additional_authors_the_authors_posts_links( $post_id = NULL, $additional_vars = null ) {
	global $additional_authors;
	$additional_authors->render->the_authors_posts_links( $post_id, $additional_vars );
}

/**
 * For use in frontend.
 * @return array User IDs as int
 */
function additional_authors_get_the_authors_ids( $post_id = NULL) {
	global $additional_authors;

	return $additional_authors->get_ids( $post_id );
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
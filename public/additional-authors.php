<?php

namespace AdditionalAuthors;

/**
 * Plugin Name: Additional Authors
 * Plugin URI: https://github.com/palasthotel/wp-additional-authors
 * Description: Provides a meta box for additional authors from existing users or taxonomy.
 * Version: 1.2.7
 * Author: PALASTHOTEL (by Kim-Christian Meyer, Edward Bock, Stephan Kroppenstedt)
 * Author URI: https://palasthotel.de
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class AdditionalAuthors
 * @property Database database
 * @property QueryManipulation query_manipulation
 * @property Assets assets
 * @property MetaBox meta_box
 * @property User user
 * @property Render render
 * @property Migrate migrate
 * @property Update update
 * @property REST rest
 * @property Gutenberg gutenberg
 */
class Plugin {

	const OPTION_DATA_VERSION = "additional_authors_data_version";

	/**
	 * WP_User_Query arguments
	 */
	const WP_USER_QUERY_ARG_IGNORE_PUBLISHED_AS_ADDITIONAL_AUTHOR = "ignore_published_as_additional_author";

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
	const ACTION_META_BOX_BEFORE = "additional_authors_meta_box_before";
	const ACTION_META_BOX_AFTER = "additional_authors_meta_box_after";

	// migration action
	const ACTION_ADDITIONAL_AUTHOR_DESTINATION = "additional_authors_load_additional_author_destination";

	/**
	 * all filters
	 */
	const FILTER_TEMPLATE_PATH = "additional_authors_template_paths";
	const FILTER_META_BOX_GET_USERS = "additional_authors_meta_box_get_users";
	const FILTER_WP_QUERY_IGNORE_ADDITIONAL_DEFAULT = "additional_authors_wp_query_ignore_additional_default";

	/**
	 * rest fields
	 */
	const REST_FIELD_ADDITIONAL_AUTHORS = "additional_authors";

	const HANDLE_GUTENBERG_JS = "additional_authors_js";
	const HANDLE_META_BOX_JS = "additional_authors_meta_box_js";
	const HANDLE_META_BOX_CSS = "additional_authors_meta_box_css";

	/**
	 * meta values
	 */
	// @deprecated
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
	public $path;
	public $url;

	/**
	 * AdditionalAuthors constructor.
	 */
	function __construct() {

		/**
		 * base paths
		 */
		$this->path = plugin_dir_path( __FILE__ );
		$this->url  = plugin_dir_url( __FILE__ );

		require_once dirname(__FILE__)."/vendor/autoload.php";

		$this->database = new Database();
		$this->query_manipulation = new QueryManipulation( $this );
		$this->assets = new Assets($this);
		$this->rest = new REST($this);

		$this->meta_box = new MetaBox( $this );
		$this->gutenberg = new Gutenberg($this);
		$this->user = new User( $this );
		$this->render = new Render( $this );
		$this->migrate = new Migrate( $this );

		$this->update = new Update( $this );

		/**
		 * on activate or deactivate plugin
		 */
		register_activation_hook(__FILE__, array($this, "activation"));
	}

	/**
	 * get the additions authors user ids
	 *
	 * @param null|int $post_id
	 *
	 * @return array
	 */
	public function get_ids( $post_id = null ) {
		return $this->database->get_author_ids($post_id);
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

	/**
	 * on plugin activation
	 */
	function activation(){
		$this->database->install();
	}

}

/**
 * init plugin and make it accessible
 */
Plugin::get_instance();

require_once dirname( __FILE__ ) . "/public-functions.php";
require_once dirname( __FILE__ ) . "/deprecated.php";
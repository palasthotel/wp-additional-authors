<?php

namespace AdditionalAuthors;

/**
 * Plugin Name: Additional Authors
 * Plugin URI: https://github.com/palasthotel/wp-additional-authors
 * Description: Provides a meta box for additional authors from existing users or taxonomy.
 * Author: PALASTHOTEL (by Kim-Christian Meyer, Edward Bock, Stephan Kroppenstedt)
 * Author URI: https://palasthotel.de
 * Text Domain: additional-authors
 * Domain Path: /languages
 * Version: 1.3.5
 * Requires at least: 5.0
 * Tested up to: 6.4.2
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * feature classes
 */
require_once dirname(__FILE__)."/vendor/autoload.php";

/**
 * Class AdditionalAuthors
 */
class Plugin extends Components\Plugin {

	const DOMAIN = "additional-authors";

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
	const HANDLE_GUTENBERG_CSS = "additional_authors_css";
	const HANDLE_META_BOX_JS = "additional_authors_meta_box_js";
	const HANDLE_META_BOX_CSS = "additional_authors_meta_box_css";
	const HANDLE_USERS_TABLE_JS = "additional_authors_users_table_js";

	/**
	 * meta values
	 */
	// @deprecated
	const META_POST_ADDITIONAL_AUTHORS = "_additional_authors";
	const META_USER_GENERATED = "_additional_authors_generated_user";
	public Database $database;
	public QueryManipulation $query_manipulation;
	public Assets $assets;
	public REST $rest;
	public PostsTable $postsTable;
	public MetaBox $meta_box;
	public Ajax $ajax;
	public Gutenberg $gutenberg;
	public User $user;
	public Render $render;
	public Migrate $migrate;
	public Update $update;

	/**
	 * AdditionalAuthors constructor.
	 */
	function onCreate() {

		/**
		 * load translations
		 */
		$this->loadTextdomain(
			self::DOMAIN,
			'languages'
		);

		$this->database = new Database();
		$this->query_manipulation = new QueryManipulation( $this );
		$this->assets = new Assets($this);
		$this->rest = new REST($this);
		$this->ajax = new Ajax();

		$this->postsTable = new PostsTable($this);
		$this->meta_box = new MetaBox( $this );
		$this->gutenberg = new Gutenberg($this);
		$this->user = new User( $this );
		$this->render = new Render( $this );
		$this->migrate = new Migrate( $this );

		$this->update = new Update( $this );

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
	function onSiteActivation(){
		$this->database->install();
	}

	/**
	 * @deprecated use instance() instead
	 * @return Plugin|mixed
	 */
	public static function get_instance(){
		return static::instance();
	}

}

/**
 * init plugin and make it accessible
 */
Plugin::instance();

require_once dirname( __FILE__ ) . "/public-functions.php";
require_once dirname( __FILE__ ) . "/deprecated.php";

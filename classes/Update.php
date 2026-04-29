<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 27.06.17
 * Time: 08:35
 */

namespace AdditionalAuthors;

/**
 * Class Update
 * @package AdditionalAuthors
 */
class Update {

	const VERSION = 1;
	private Plugin $plugin;

	/**
	 * Update constructor.
	 *
	 * @param Plugin $plugin
	 */
	function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		add_action('plugins_loaded', array($this, "check_and_run"));
	}

	function has_version(){
		return (get_site_option(Plugin::OPTION_DATA_VERSION) !== false);
	}

	function get_version(){
		return get_site_option(Plugin::OPTION_DATA_VERSION, 0);
	}

	function set_version($version){
		return update_site_option(Plugin::OPTION_DATA_VERSION, $version);
	}

	/**
	 * check for updates and run them if needed
	 */
	function check_and_run(){
		$current_version = $this->get_version();
		// skip if latest version
		if ( $current_version == self::VERSION ) {
			return;
		}

		for ( $i = $current_version + 1; $i <= self::VERSION; $i ++ ) {
			$method = "update_{$i}";
			if ( method_exists( $this, $method ) ) {
				$this->$method();
				$this->set_version( $i );
			}
		}
	}

	function update_1(){

		$this->plugin->database->install();
		$table = $this->plugin->database->table;

		global $wpdb;
		$query = "
		INSERT INTO $table (post_id, author_id) 
		SELECT DISTINCT post_id, meta_value as author_id FROM {$wpdb->postmeta} 
		WHERE meta_key = %s AND meta_value IS NOT NULL
		";
		$wpdb->query( $wpdb->prepare($query, '_additional_authors'));

	}

}

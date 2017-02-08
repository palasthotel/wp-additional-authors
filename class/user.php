<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 24.11.16
 * Time: 18:43
 */

namespace AdditionalAuthors;


class User {
	/**
	 * User constructor.
	 *
	 * @param \AdditionalAuthors $plugin
	 */
	function __construct(\AdditionalAuthors $plugin) {
		add_action( 'delete_user', array($this, 'delete_user') );
	}
	
	
	/**
	 * delete all additional author meta if user is deleted
	 * @param $user_id
	 * @param $old_user_data
	 */
	function delete_user($user_id, $old_user_data){
		global $wpdb;
		$wpdb->delete($wpdb->prefix.'postmeta',
			array(
				'meta_key' => \AdditionalAuthors::META_POST_ADDITIONAL_AUTHORS,
				'meta_value' => $user_id,
			),
			array(
				'%s',
				'%d',
			)
		);
	}
}
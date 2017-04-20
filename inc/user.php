<?php

namespace AdditionalAuthors;


class User {
	/**
	 * User constructor.
	 *
	 * @param Plugin $plugin
	 */
	function __construct( Plugin $plugin) {
		$this->plugin = $plugin;
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
	
	/**
	 * create an user for additional users on the fly
	 * @param $name
	 *
	 * @return int|\WP_Error
	 */
	function create($name){
		
		$user = (object)array();
		
		$user->user_nicename = $name;
		
		$unguessable_string = $this->plugin->generateUnguessableString();
		$user->user_login = strtolower(preg_replace("/[^A-Za-z0-9 ]/","",$name));
		
		// max 60 chars for login name
		$diff = 60-(strlen($user->user_login)+strlen($unguessable_string));
		if($diff < 0){
			$unguessable_string = substr($unguessable_string,0,$diff);
		}
		
		$user->user_login = $user->user_login.$unguessable_string;
		
		
		$parts = explode(' ',$name);
		$user->first_name = $parts[0];
		if(count($parts)> 1){
			$user->last_name = end($parts);
		}
		
		$user->user_email = $user->user_login."@localhost.local";
		
		$user->user_pass = $this->plugin->generatePassword();
		$user->role = "author";
		
		return wp_insert_user($user);
	}
}
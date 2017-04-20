<?php

namespace AdditionalAuthors;


class Migrate {
	
	const PREFIX = "additional_authors:";
	const FIELD_USERS = "users";
	
	const FIELD_USERS_ID = "id";
	const FIELD_USERS_IS_MAIN = "is_main";
	
	/**
	 * Migrate constructor.
	 *
	 * @param Plugin $plugin
	 */
	function __construct( Plugin $plugin ) {
		add_action( Plugin::ACTION_ADDITIONAL_AUTHOR_DESTINATION, array($this, 'author_destination') );
		add_action( 'ph_migrate_register_field_handlers',array($this, 'handler_register') );
	}
	
	/**
	 * load author destination for migrate
	 */
	function author_destination(){
		require_once('migrate.additional-author-destination.php');
	}
	
	/**
	 * register migrate handler
	 */
	function handler_register(){
		ph_migrate_register_field_handler( 'ph_post_destination', Migrate::PREFIX, 'AdditionalAuthors\migration_handler' );
	}
}



/**
 * function that handles the migrate process
 * @param  $post array with post details
 * @param  $fields array with migration data (additional_authors:users)
 *
 */
function migration_handler($post, $fields)
{
	$post_id = $post['ID'];
	
	/**
	 * get user ids
	 */
	$users = $fields[Migrate::PREFIX.Migrate::FIELD_USERS];
	
	if(!is_array($users)){
		echo "WARNING: Additional Authors needs to be an array of integer or an array of arrays.\n";
		return;
	}
	
	/**
	 * check if there are ids only
	 */
	$ids_only=true;
	foreach($users as $additional_author){
		if(is_array($additional_author)){
			// nope there is an array
			$ids_only = false;
			break;
		}
	}
	
	/**
	 * save authors to db
	 */
	$main_author = false;
	foreach ( $users as $idx => $additional_author ) {
		
		if(is_array($additional_author)){
			
			if( empty($additional_author[Migrate::FIELD_USERS_ID]) ){
				echo " ----> WARNING: There is no id Field for author\n";
				echo "All users:\n";
				var_dump($users);
				echo "Problem user:\n";
				var_dump($additional_author);
				echo " <---- \n";
				continue;
			}
			
			if( !empty($additional_author[Migrate::FIELD_USERS_IS_MAIN]) && $additional_author[Migrate::FIELD_USERS_IS_MAIN] === true){
				
				if($main_author){
					/**
					 * if there was already an main author
					 */
					echo " ---> WARNING: There is more than one main author in additional authors! Author will be additional";
					echo "All users:\n";
					var_dump($users);
					echo "Problem user:\n";
					var_dump($additional_author);
					 echo " <---- \n";
					
					 // make author additional, so info doesnt get lost
					add_post_meta( $post_id, Plugin::META_POST_ADDITIONAL_AUTHORS, $additional_author[Migrate::FIELD_USERS_ID] );
					 
					continue;
				}
				
				/**
				 * is main author
				 */
				wp_update_post(array(
					"ID" => $post_id,
					"post_author" => $additional_author[Migrate::FIELD_USERS_ID],
				));
				$main_author=true;
			} else {
				
				/**
				 * no main author so additional
				 */
				add_post_meta( $post_id, Plugin::META_POST_ADDITIONAL_AUTHORS, $additional_author[Migrate::FIELD_USERS_ID] );
			}
			
			
		} else {
			/**
			 * if ids only set first one to main author
			 */
			if($idx == 0 && $ids_only){
				wp_update_post(array(
					"ID" => $post_id,
					"post_author" => $additional_author,
				));
			} else {
				add_post_meta( $post_id, Plugin::META_POST_ADDITIONAL_AUTHORS, $additional_author );
			}
		}
		
	}
	
}

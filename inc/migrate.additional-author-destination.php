<?php

class additional_authors_destination extends ph_user_destination
{
	
	public function save($item)
	{
		/**
		 * if there is no email I guess its an user that should not login.
		 * So generate secure credentials.
		 */
		$handled = false;
		$unguessable_string="";
		if( empty($item->user_email) ){
			$handled = true;
			
			if(empty($item->user_login)){
				$item->user_login = strtolower(preg_replace("/[^A-Za-z0-9 ]/","",$item->first_name))
				                    ."_".
				                    strtolower(preg_replace("/[^A-Za-z0-9 ]/","",$item->last_name));
			}
			
			$additional_authors = AdditionalAuthors\Plugin::get_instance();
			$item->user_email = $item->user_login."@localhost.local";
			$item->user_nicename = $item->user_login;
			$unguessable_string = $additional_authors->generateUnguessableString();
			
			// max 60 chars for login name
			$diff = 60-(strlen($item->user_login)+strlen($unguessable_string));
			if($diff < 0){
				$unguessable_string = substr($unguessable_string,0,$diff);
			}
			
			$item->user_login = $item->user_login.$unguessable_string;
			$item->user_pass = $additional_authors->generatePassword();
			$item->role = "author";
			
		}
		
		/**
		 * create user with parent class
		 */
		$user_id = parent::save($item);
		
		
		if($handled){
			// save so we can cut it out on making a real loginable author
			update_user_meta($user_id, \AdditionalAuthors\Plugin::META_USER_GENERATED, $unguessable_string);
		}
		
		return $user_id;
	}
}
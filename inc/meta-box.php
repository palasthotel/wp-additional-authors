<?php

namespace AdditionalAuthors;


class MetaBox {
	
	const POST_AUTORS = "additional_authors";
	
	/**
	 * MetaBox constructor.
	 *
	 * @param Plugin $plugin
	 */
	function __construct( Plugin $plugin) {
		$this->plugin = $plugin;
		add_action( 'add_meta_boxes_post', array($this,'add_meta_box') );
		add_action( 'save_post', array($this,'save'), 10, 2 );
	}
	
	function add_meta_box() {
		add_meta_box(
			'additional-authors-meta-box',
			__( 'Additional Authors', 'additional_authors' ),
			array($this,'additional_authors_html'),
			'post',
			'side',
			'high'
		);
	}
	
	function additional_authors_html( $post ) {
		wp_nonce_field( '_additional_authors_nonce', 'additional_authors_nonce' );
		
		wp_enqueue_style("additional_authors_meta_box_style", $this->plugin->url."/css/meta-box.css");
		wp_enqueue_script("additional_authors_meta_box_script", $this->plugin->url."/js/bundle/main.js",array(),1, true);
		
		/**
		 * get selected users
		 */
		$selected=array();
		$selected[]=$post->post_author;
		$additional = get_post_custom_values( Plugin::META_POST_ADDITIONAL_AUTHORS, $post->ID );
		$additional = ($additional != null)? array_unique($additional) : array();
		if(is_array($additional)) {
			$selected = array_merge( $selected, $additional );
		}
		
		/**
		 * get all users
		 * // TODO: async request because of too many users better
		 */
		$users = get_users(
			array(
				'who' => 'authors',
				'orderby' => 'display_name',
				'fields' => array( 'ID', 'display_name', 'user_login', 'user_nicename' ),
			)
		);
		
		$config = array(
			"users" => $users,
			"selected" => $selected,
			"language" => array(
				"label" => __('Search for author:'),
				"description" => __('Selected authors.'),
			),
			"root_id" => "meta_additional_authors",
			
		);
		wp_localize_script('additional_authors_meta_box_script', 'AdditionalAuthors', $config);
		
		?>
		<div id="meta_additional_authors"></div>
		<?php
	}
	
	
	
	function save( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		// Verifying the nonce
		if ( ! isset( $_POST['additional_authors_nonce'] ) )
			return;
		if ( ! wp_verify_nonce( $_POST['additional_authors_nonce'], '_additional_authors_nonce' ) )
			return;
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
		
		// @see http://wordpress.stackexchange.com/a/10845
		if ( $parent_id = wp_is_post_revision( $post_id ) ) {
			$post_id = $parent_id;
		}
		
		if(isset($_POST) && is_array($_POST[self::POST_AUTORS])){
			/**
			 * we are in post edit form action
			 */
			delete_post_meta( $post_id, Plugin::META_POST_ADDITIONAL_AUTHORS );
			
			foreach ( $_POST[self::POST_AUTORS]["ids"] as $index => $additional_author ) {
				
				/**
				 * skip first because it is main author and saved on post
				 */
				if($index == 0) continue;
				
				if(intval($additional_author) <= 0){
					$name = $_POST[self::POST_AUTORS]["names"][$index];
					$additional_author = $this->plugin->user->create($name);
					if(is_wp_error($additional_author)){
						 // TODO: error display
					}
				}
				
				add_post_meta( $post_id, Plugin::META_POST_ADDITIONAL_AUTHORS, $additional_author );
			}
			
		} else {
			// something else called wp_update_post
			$user_ids = $this->plugin->get_ids($post_id);
			
			for($i = 1; $i < count($user_ids); $i++){
				if($post->post_author == $user_ids[$i]){
					// additional author is now main author
					delete_post_meta($post_id,Plugin::META_POST_ADDITIONAL_AUTHORS, $post->post_author);
					break;
				}
			}
			
		}
		
	}

}
<?php

namespace AdditionalAuthors;


class MetaBox {
	
	const POST_AUTORS = "additional_authors";
	
	/**
	 * MetaBox constructor.
	 *
	 * @param \AdditionalAuthors $plugin
	 */
	function __construct( \AdditionalAuthors $plugin) {
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
		
		$users = get_users(
			array(
				'who' => 'authors',
				'orderby' => 'display_name',
				'fields' => array( 'ID', 'display_name', 'user_login', 'user_nicename' ),
			)
		);
		
		$selected=array();
		$selected[]=$post->post_author;
		
		$additional = get_post_custom_values( \AdditionalAuthors::META_POST_ADDITIONAL_AUTHORS, $post->ID );
		if(is_array($additional)){
			$selected = array_merge($selected,$additional);
		}
		
		?>
		
		<div id="meta_additional_authors"></div>
		
		<script type="text/javascript">
			
			window.additional_authors = {
				users: [],
				selected: [<?php echo implode(",", $selected); ?>],
				root: document.getElementById("meta_additional_authors"),
				language:{
					label: "<?php _e('Search for author:'); ?>",
					description: "<?php _e('Selected authors.'); ?>",
				},
				onAuthorsChange:function(ids){
				}
			};
			
			<?php foreach ( $users as $user ) : ?>
			window.additional_authors.users.push({
				id: <?php echo $user->ID; ?>,
				display_name: "<?php echo $user->display_name; ?>",
				user_login: "<?php echo $user->user_login; ?>",
				user_nicename: "<?php echo $user->user_nicename; ?>",
			});
			<?php endforeach; ?>
			
		</script>
		
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
			delete_post_meta( $post_id, \AdditionalAuthors::META_POST_ADDITIONAL_AUTHORS );
			
			foreach ( $_POST[self::POST_AUTORS] as $index => $additional_author ) {
				
				/**
				 * skip first because it is main author and saved on post
				 */
				if($index == 0) continue;
				
				add_post_meta( $post_id, \AdditionalAuthors::META_POST_ADDITIONAL_AUTHORS, $additional_author );
			}
			
		} else {
			// something else called wp_update_post
			$user_ids = $this->plugin->get_ids($post_id);
			
			for($i = 1; $i < count($user_ids); $i++){
				if($post->post_author == $user_ids[$i]){
					// additional author is now main author
					delete_post_meta($post_id,\AdditionalAuthors::META_POST_ADDITIONAL_AUTHORS,$post->post_author);
					break;
				}
			}
			
		}
		
	}

}
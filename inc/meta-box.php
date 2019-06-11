<?php

namespace AdditionalAuthors;


class MetaBox {

	const POST_AUTHORS = "additional_authors";

	const POST_AUTHORS_IS_GUTENGERG = "additional_authors_is_gutenberg";

	public $screens;

	/**
	 * MetaBox constructor.
	 *
	 * @param Plugin $plugin
	 */
	function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
		$this->screens = array( 'post' );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );
	}

	function add_meta_box() {
		$args = array(
			'_builtin' => false
		);
		$posttypes = get_post_types( $args );
		foreach( $posttypes as $posttype ) {
			if ( post_type_supports( $posttype, 'author' ) ) {
				$this->screens[] = $posttype;
			}
		}
		add_meta_box(
			'additional-authors-meta-box',
			__( 'Additional Authors', 'additional_authors' ),
			array( $this, 'additional_authors_html' ),
			$this->screens,
			'side',
			'high'
		);
	}

	function additional_authors_html( $post ) {
		wp_nonce_field( '_additional_authors_nonce', 'additional_authors_nonce' );

		wp_enqueue_style( "additional_authors_meta_box_style", $this->plugin->url . "/css/meta-box.css" );

		$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG == true ) ? "" : ".min";
		wp_enqueue_script(
			"additional_authors_meta_box_script",
			$this->plugin->url . "/js/bundle/main" . $min . ".js",
			array(),
			1,
			true
		);


		/**
		 * get selected users
		 */
		$selected = Table\get_author_ids( $post->ID );

		/**
		 * get all users
		 */
		$users = get_users(
			array(
				'who'     => 'authors',
				'orderby' => 'display_name',
				'fields'  => array(
					'ID',
					'display_name',
					'user_login',
					'user_nicename',
				),
			)
		);
		array_shift( $users );
		$config = array(
			"users"    => $users,
			"selected" => $selected,
			"language" => array(
				"label"       => __( 'Search for author:' ),
				"description" => __( 'Selected authors.' ),
			),
			"root_id"  => "meta_additional_authors",
		);
		wp_localize_script( 'additional_authors_meta_box_script', 'AdditionalAuthors', $config );

		do_action( Plugin::ACTION_META_BOX_BEFORE, $post );
		?>
		<div id="meta_additional_authors"></div>
		<?php
		do_action( Plugin::ACTION_META_BOX_AFTER, $post );
	}

	/**
	 * @param $post_id int
	 * @param $post \WP_Post
	 */
	function save( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Verifying the nonce
		if ( ! isset( $_POST['additional_authors_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['additional_authors_nonce'], '_additional_authors_nonce' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// @see http://wordpress.stackexchange.com/a/10845
		if ( $parent_id = wp_is_post_revision( $post_id ) ) {
			$post_id = $parent_id;
		}

		if ( isset( $_POST ) && is_array( $_POST[ self::POST_AUTHORS ] ) ) {
			/**
			 * we are in post edit form action
			 */
			delete_post_meta( $post_id, Plugin::META_POST_ADDITIONAL_AUTHORS );
			Table\delete_all_of_post( $post_id );
			$is_gutenberg = (
				isset( $_POST[ self::POST_AUTHORS_IS_GUTENGERG ] )
				&&
				$_POST[ self::POST_AUTHORS_IS_GUTENGERG ] == "it-is"
			);

			foreach ( $_POST[ self::POST_AUTHORS ]["ids"] as $index => $additional_author ) {

				/**
				 * skip first because it is main author and saved on post
				 * only if is not gutenberg
				 */
				if ( $index == 0 && !$is_gutenberg ) {
					remove_action( 'save_post', array( $this, 'save' ) );
					wp_update_post( array(
						"ID"          => $post_id,
						"post_author" => $additional_author,
					) );
					add_action( 'save_post', array( $this, 'save' ), 10, 2 );
					continue;
				}

				// to not add main author as additional author
				if(intval($additional_author) > 0 && $additional_author == $post->post_author){
					continue;
				}

				if ( intval( $additional_author ) <= 0 ) {
					$name              = $_POST[ self::POST_AUTHORS ]["names"][ $index ];
					$additional_author = $this->plugin->user->create( $name );
					if ( is_wp_error( $additional_author ) ) {
						// TODO: error display
					}
				}
				// @deprecated
//				add_post_meta( $post_id, Plugin::META_POST_ADDITIONAL_AUTHORS, $additional_author );
				Table\set( $post_id, $additional_author );
			}

		} else {
			// something else called wp_update_post
			$user_ids = $this->plugin->get_ids( $post_id );

			for ( $i = 1; $i < count( $user_ids ); $i ++ ) {
				if ( $post->post_author == $user_ids[ $i ] ) {
					// additional author is now main author
					delete_post_meta( $post_id, Plugin::META_POST_ADDITIONAL_AUTHORS, $post->post_author );
					Table\delete( $post_id, $post->post_author );
					break;
				}
			}

		}

	}

}

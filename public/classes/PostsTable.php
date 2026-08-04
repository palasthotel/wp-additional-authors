<?php


namespace AdditionalAuthors;

class PostsTable {
	private Plugin $plugin;

	/**
	 * PostsTable constructor.
	 *
	 * @param Plugin $plugin
	 */
	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		add_filter( 'manage_posts_columns' , array($this, 'add_column') );
		add_filter( 'manage_pages_columns' , array($this, 'add_column') );

		add_action( 'manage_posts_custom_column' , array($this,'custom_columns'), 10, 2 );
		add_action( 'manage_pages_custom_column' , array($this,'custom_columns'), 10, 2 );

	}

	public function add_column($columns){

		global $current_screen;
		if(
			!($current_screen instanceof \WP_Screen) ||
			!in_array($current_screen->post_type, SettingsStore::getSupportedPostTypes())
		) return $columns;

		$newCols = array();
		$added = false;
		foreach ($columns as $key => $label){
			$newCols[$key] = $label;
			if( !$added && $key == "author" ){
				$added = true;
				$newCols['additional-authors'] = __('All authors', Plugin::DOMAIN);
			}
		}

		if($added == false){
			$newCols['additional-authors'] = __('All authors', Plugin::DOMAIN);
		}

		return $newCols;
	}



	public function custom_columns($column, $post_id){
		if($column == 'additional-authors'){
			$authors = $this->plugin->database->get_author_ids($post_id);
			$strings = [];
			foreach ($authors as $authorId){
				$user = get_user_by("ID", $authorId);
				if ( ! ( $user instanceof \WP_User ) ) {
					// The user was deleted but the row survived - skip it rather than
					// reading display_name off false.
					continue;
				}

				// This used to pass get_the_author_meta('ID'), the author of whatever
				// post the loop was on, so every link in the column pointed at the
				// same user.
				$url = add_query_arg(
					array(
						'post_type' => get_post_type($post_id),
						'author'    => $authorId,
					),
					'edit.php'
				);

				$strings[] = sprintf(
					'<a href="%s">%s</a>',
					esc_url( $url ),
					esc_html( $user->display_name )
				);
			}

			echo implode(", ", $strings);

		}
	}

}

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
				$args = array(
					'post_type' => get_post_type($post_id),
					'author'    => get_the_author_meta( 'ID' ),
				);
				$url = add_query_arg( $args, 'edit.php' );

				$class_html   = '';
				$aria_current = '';
				if ( ! empty( $class ) ) {
					$class_html = sprintf(
						' class="%s"',
						esc_attr( $class )
					);

					if ( 'current' === $class ) {
						$aria_current = ' aria-current="page"';
					}
				}

				$user = get_user_by("ID", $authorId);

				$strings[] = sprintf(
					'<a href="%s"%s%s>%s</a>',
					esc_url( $url ),
					$class_html,
					$aria_current,
					$user->display_name
				);
			}

			echo implode(", ", $strings);

		}
	}

}

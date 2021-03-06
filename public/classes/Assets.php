<?php


namespace AdditionalAuthors;


/**
 * @property Plugin plugin
 */
class Assets {

	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
	}

	public function enqueueMetaBox($config){
		wp_enqueue_style(
			Plugin::HANDLE_META_BOX_CSS,
			$this->plugin->url . "/dist/additional-authors-meta-box.css",
			[],
			filemtime($this->plugin->path."/dist/additional-authors-meta-box.css")
		);
		$info = include $this->plugin->path . "/dist/additional-authors-meta-box.asset.php";
		wp_enqueue_script(
			Plugin::HANDLE_META_BOX_JS,
			$this->plugin->url . "/dist/additional-authors-meta-box.js",
			$info["dependencies"],
			$info["version"],
			true
		);
		wp_localize_script( Plugin::HANDLE_META_BOX_JS, 'AdditionalAuthors', $config );
	}

	public function enqueueGutenberg(){
		wp_enqueue_style(
			Plugin::HANDLE_GUTENBERG_CSS,
			$this->plugin->url . "/dist/additional-authors.css",
			[],
			filemtime($this->plugin->path."/dist/additional-authors.css")
		);
		$info = include $this->plugin->path . "/dist/additional-authors.asset.php";
		wp_enqueue_script(
			Plugin::HANDLE_GUTENBERG_JS,
			$this->plugin->url. "/dist/additional-authors.js",
			$info["dependencies"],
			$info["version"]
		);
		$users = get_users(
			apply_filters(
				Plugin::FILTER_META_BOX_GET_USERS,
				array(
					'role__in'     => ['authors', 'editor', 'administrator'],
					'orderby' => 'display_name',
					'fields'  => array(
						'ID',
						'display_name',
						'user_login',
						'user_nicename',
					),
				)
			)
		);
		wp_localize_script(
			Plugin::HANDLE_GUTENBERG_JS,
			"AdditionalAuthors",
			[
				"users" => $users,
				"selected" => $this->plugin->database->get_author_ids( get_the_ID()),
				"i18n" => array(
					"label"       => __( 'Additional Authors', Plugin::DOMAIN ),
					"search_404" => __( 'No author found.', Plugin::DOMAIN ),
				),
			]
		);
	}

}
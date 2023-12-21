<?php


namespace AdditionalAuthors;

class Assets {

	private Plugin $plugin;

	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
	}

	public function admin_enqueue_scripts($hook) {
		if($hook == "users.php"){
			$this->enqueueUsersTable();
		}
	}
	public function enqueueUsersTable(){
		$info = include $this->plugin->getPath("/dist/users-table.asset.php");
		wp_enqueue_script(
			Plugin::HANDLE_USERS_TABLE_JS,
			$this->plugin->getUrl( "/dist/users-table.js"),
			$info["dependencies"],
			$info["version"],
			true
		);
		wp_localize_script(
			Plugin::HANDLE_USERS_TABLE_JS,
			"AdditionalAuthors",
			[
				"postsUrl" => admin_url("edit.php"),
				"ajaxUrl" => admin_url('admin-ajax.php'),
			]
		);
	}

	public function enqueueMetaBox($config){
		wp_enqueue_style(
			Plugin::HANDLE_META_BOX_CSS,
			$this->plugin->getUrl("/dist/additional-authors-meta-box.css"),
			[],
			filemtime($this->plugin->getPath("/dist/additional-authors-meta-box.css"))
		);
		$info = include $this->plugin->getPath("/dist/additional-authors-meta-box.asset.php");
		wp_enqueue_script(
			Plugin::HANDLE_META_BOX_JS,
			$this->plugin->getUrl("/dist/additional-authors-meta-box.js"),
			$info["dependencies"],
			$info["version"],
			true
		);
		wp_localize_script( Plugin::HANDLE_META_BOX_JS, 'AdditionalAuthors', $config );
	}

	public function enqueueGutenberg(){
		wp_enqueue_style(
			Plugin::HANDLE_GUTENBERG_CSS,
			$this->plugin->getUrl( "/dist/additional-authors.css"),
			[],
			filemtime($this->plugin->getPath("/dist/additional-authors.css"))
		);
		$info = include $this->plugin->getPath("/dist/additional-authors.asset.php");
		wp_enqueue_script(
			Plugin::HANDLE_GUTENBERG_JS,
			$this->plugin->getUrl("/dist/additional-authors.js"),
			$info["dependencies"],
			$info["version"]
		);
		$users = get_users(
			apply_filters(
				Plugin::FILTER_META_BOX_GET_USERS,
				array(
					'role__in'     => ['author', 'editor', 'administrator'],
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

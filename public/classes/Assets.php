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
		$info = include $this->plugin->path . "/dist/additional-authors.asset.php";
		wp_enqueue_script(
			Plugin::HANDLE_GUTENBERG_JS,
			$this->plugin->url. "/dist/additional-authors.js",
			$info["dependencies"],
			$info["version"]
		);
		wp_localize_script(
			Plugin::HANDLE_GUTENBERG_JS,
			"AdditionalAuthors",
			[
				"i18n" => array(
					"label"       => __( 'Search for author:' ),
					"description" => __( 'Selected authors.' ),
				),
			]
		);
	}

}
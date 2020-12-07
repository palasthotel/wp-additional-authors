<?php


namespace AdditionalAuthors;


/**
 * @property Plugin plugin
 */
class Assets {

	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
	}

	public function enqueueMetaBox(){

	}

	public function enqueueGutenberg(){
		$info = include $this->plugin->path . "/dist/gutenberg.asset.php";
		wp_enqueue_script(
			Plugin::HANDLE_GUTENBERG,
			$this->plugin->url. "/dist/gutenberg.js",
			$info["dependencies"],
			$info["version"]
		);
	}

}
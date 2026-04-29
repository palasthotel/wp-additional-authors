<?php


namespace AdditionalAuthors;

class Gutenberg {
	private Plugin $plugin;

	public function __construct(Plugin $plugin){
		$this->plugin = $plugin;
		add_action( 'enqueue_block_editor_assets', [$this, 'enqueue_assets'], 15 );
	}

	public function enqueue_assets(){
		if(SettingsStore::isSupportedPostType(get_post_type())){
			$this->plugin->assets->enqueueGutenberg();
		}
	}
}

<?php


namespace AdditionalAuthors;


/**
 * @property Plugin plugin
 */
class Gutenberg {
	public function __construct(Plugin $plugin){
		$this->plugin = $plugin;
		add_action( 'enqueue_block_editor_assets', [$this, 'enqueue_assets'], 15 );
	}

	public function enqueue_assets(){
		if(is_post_type_viewable(get_post_type())){
			$this->plugin->assets->enqueueGutenberg();
		}
	}
}
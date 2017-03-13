<?php

namespace AdditionalAuthors;

/**
 * Class Render
 * @package AdditionalAuthors
 */
class Render {
	/**
	 * Render constructor.
	 *
	 * @param Plugin $plugin
	 */
	function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		add_action(Plugin::ACTION_THE_AUTHORS, array($this, "the_authors"));
		add_action(Plugin::ACTION_THE_AUTHORS_POSTS_LINKS, array($this, "the_authors_posts_links"));
		add_action(Plugin::ACTION_THE_AUTHOR_POSTS_LINK, array($this, "the_author_posts_link"));
	}
	
	/**
	 * @param null|int $post_id
	 */
	public function the_authors($post_id = null, $additional_vars = null ) {
		$additional_authors_ids = $this->plugin->get_ids( $post_id );
		include $this->get_template_path(Plugin::TEMPLATE_THE_AUTHORS);
	}
	
	/**
	 * @param null|int $post_id
	 *
	 * @return array
	 */
	public function the_authors_posts_links($post_id = null , $additional_vars = null){
		$additional_authors_ids = $this->plugin->get_ids( $post_id );
		include $this->get_template_path(Plugin::TEMPLATE_THE_AUTHORS_POSTS_LINKS);
	}
	
	public function the_author_posts_link($author_id , $additional_vars = null){
		include $this->get_template_path(Plugin::TEMPLATE_THE_AUTHOR_POSTS_LINK);
	}
	
	/**
	 * get path for template file
	 *
	 * @param $template
	 *
	 * @return string
	 */
	function get_template_path($template){
		if ( $overridden_template = locate_template( Plugin::THEME_FOLDER."/".$template ) ) {
			return $overridden_template;
		} else {
			return $this->plugin->dir . '/templates/'.$template;
		}
	}
}
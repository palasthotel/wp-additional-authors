<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 24.11.16
 * Time: 14:00
 */

namespace AdditionalAuthors;

/**
 * Class Render
 * @package AdditionalAuthors
 */
class Render {
	/**
	 * Render constructor.
	 *
	 * @param \AdditionalAuthors $plugin
	 */
	function __construct(\AdditionalAuthors $plugin) {
		$this->plugin = $plugin;
		add_action(\AdditionalAuthors::ACTION_THE_AUTHORS, array($this, "the_authors"));
		add_action(\AdditionalAuthors::ACTION_THE_AUTHORS_POSTS_LINKS, array($this, "the_authors_posts_links"));
		add_action(\AdditionalAuthors::ACTION_THE_AUTHOR_POSTS_LINK, array($this, "the_author_posts_link"));
	}
	
	/**
	 * @param null|int $post_id
	 */
	public function the_authors($post_id = null, $additional_vars = null ) {
		$additional_authors_ids = $this->plugin->get_ids( $post_id );
		include $this->get_template_path(\AdditionalAuthors::TEMPLATE_THE_AUTHORS);
	}
	
	/**
	 * @param null|int $post_id
	 *
	 * @return array
	 */
	public function the_authors_posts_links($post_id = null , $additional_vars = null){
		$additional_authors_ids = $this->plugin->get_ids( $post_id );
		include $this->get_template_path(\AdditionalAuthors::TEMPLATE_THE_AUTHORS_POSTS_LINKS);
	}
	
	public function the_author_posts_link($author_id , $additional_vars = null){
		include $this->get_template_path(\AdditionalAuthors::TEMPLATE_THE_AUTHOR_POSTS_LINK);
	}
	
	/**
	 * get path for template file
	 *
	 * @param $template
	 *
	 * @return string
	 */
	function get_template_path($template){
		if ( $overridden_template = locate_template( \AdditionalAuthors::THEME_FOLDER."/".$template ) ) {
			return $overridden_template;
		} else {
			return $this->plugin->dir . '/templates/'.$template;
		}
	}
}
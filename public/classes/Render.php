<?php

namespace AdditionalAuthors;

/**
 * Class Render
 * @package AdditionalAuthors
 */
class Render {
	private Plugin $plugin;
	/**
	 * @var null|array
	 */
	private $sub_dirs;
	function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		$this->sub_dirs = null;
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
	 */
	public function the_authors_posts_links($post_id = null , $additional_vars = null){
		$additional_authors_ids = $this->plugin->get_ids( $post_id );
		include $this->get_template_path(Plugin::TEMPLATE_THE_AUTHORS_POSTS_LINKS);
	}

	public function the_author_posts_link($author_id , $additional_vars = null){
		include $this->get_template_path(Plugin::TEMPLATE_THE_AUTHOR_POSTS_LINK);
	}

	/**
	 * Look for existing template path
	 * @return string|false
	 */
	function get_template_path( $template ) {

		// theme or child theme
		if ( $overridden_template = locate_template( $this->get_template_dirs($template) ) ) {
			return $overridden_template;
		}

		// parent theme
		foreach ($this->get_template_dirs($template) as $path){
			if( is_file( get_template_directory()."/$path")){
				return get_template_directory()."/$path";
			}
		}

		// other plugins
		$paths = apply_filters(Plugin::FILTER_TEMPLATE_PATH, array());
		// add default templates at last position
		$paths[] = $this->plugin->getPath('templates');
		// find templates
		foreach ($paths as $path){
			if(is_file("$path/$template")){
				return "$path/$template";
			}
		}

		// if nothing found...
		return false;
	}

	/**
	 * get array of possible template files in theme
	 * @param $template
	 *
	 * @return array
	 */
	function get_template_dirs($template){
		$dirs = array(
			Plugin::THEME_FOLDER . "/" . $template,
		);
		foreach ($this->get_sub_dirs() as $sub){
			$dirs[] = $sub.'/'.$template;
		}
		return $dirs;
	}

	/**
	 * paths for locate_template
	 * @return array
	 */
	function get_sub_dirs(){
		if($this->sub_dirs == null){
			$this->sub_dirs = array();
			$dirs = array_filter(glob(get_template_directory().'/'.Plugin::THEME_FOLDER.'/*'), 'is_dir');
			foreach($dirs as $dir){
				$this->sub_dirs[] = str_replace(get_template_directory().'/', '', $dir);
			}
		}
		return $this->sub_dirs;
	}


}

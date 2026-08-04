<?php


namespace AdditionalAuthors;

class Blocks
{
	private Plugin $plugin;
	//note: add all blocks, that need t18n here
	private array $blocks;

	public function __construct(Plugin $plugin)
	{
		$this->plugin = $plugin;
		// The blocks this plugin actually registers, by the name in their block.json -
		// which is not the directory name. This list used to name five blocks from a
		// different plugin, so wp_set_script_translations() ran for handles that do
		// not exist here and the real blocks got no translations.
		$this->blocks = ['author-archive-title', 'author-archive-biography'];
		add_action('init', [$this, 'register_gutenberg_blocks']);
		add_filter('block_categories_all', [$this, 'add_custom_gutenberg_categories']);
		add_action('enqueue_block_editor_assets', [$this, 'wp_set_script_translations']);
	}

	/**
	 * register gutenberg blocks
	 */
	public function register_gutenberg_blocks()
	{
		$path = plugin_dir_path( __DIR__ ); // plugin root
		$dirs = glob("$path/build/blocks/*", GLOB_ONLYDIR);

		foreach ($dirs as $dir) {
			register_block_type($dir);
		}
	}

	/**
	 * add new gutenberg block category
	 */
	public function add_custom_gutenberg_categories($categories)
	{

		array_unshift(
			$categories,
			[
				'slug' => $this->plugin::DOMAIN,
				'title' => 'Additional Authors'
			]
		);

		return $categories;
	}


	/**
	 * Translations
	 */

	/**
	 * Load JSON language files for Gutenberg editor. Necessary if using a custom
	 * languages path instead of wp-content/languages.
	 */
	public function wp_set_script_translations()
	{
		foreach ($this->blocks as $block) {
			$scriptHandle = generate_block_asset_handle(
				$this->plugin::DOMAIN	. "/{$block}",
				'editorScript'
			);
			wp_set_script_translations(
				$scriptHandle,
				$this->plugin::DOMAIN,
				$this->plugin->getPath('languages')
			);
		}
	}
}

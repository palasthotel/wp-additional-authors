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
		$this->blocks = ['card', 'magazine', 'ticker-carousel', 'menu-block', 'post-age-notice'];
		add_action('init', [$this, 'register_gutenberg_blocks']);
		add_filter('block_categories_all', [$this, 'add_custom_gutenberg_categories']);
		add_action('plugins_loaded', [$this, 'load_plugin_textdomain']);
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
	 * Load .mo translation file for PHP.
	 *
	 * We need 'plugins_loaded' here, because 'init' runs only after some translations already failed
	 *
	 * We need to name the .mo file after this pattern: {text-domain}-{locale}.mo
	 *
	 * dekoder-blocks-de_DE.mo instead of de_DE.mo
	 * np-custom-gutenberg-blocks-de.mo
	 */
	public function load_plugin_textdomain()
	{
		load_plugin_textdomain(
			$this->plugin::DOMAIN,
			false,
			dirname(plugin_basename(__FILE__)) . '/languages'
		);
	}

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
				plugin_dir_path(__FILE__) . 'languages'
			);
		}
	}
}

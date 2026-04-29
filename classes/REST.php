<?php


namespace AdditionalAuthors;

class REST {

	private Plugin $plugin;

	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		add_action('rest_api_init', [$this, 'rest_api_init']);
	}


	public function rest_api_init() {
		register_rest_field(
			SettingsStore::getSupportedPostTypes(),
			Plugin::REST_FIELD_ADDITIONAL_AUTHORS,
			[
				'get_callback'        => function ( $post ) {
					return $this->plugin->database->get_author_ids( $post["id"] );
				},
				'update_callback'     => function ( $value, $post ) {
					if(is_array($value)){
						$ids = array_map('intval', $value);
						$this->plugin->database->delete_all_of_post($post->ID);
						foreach ($ids as $userId){
							$this->plugin->database->set($post->ID, $userId);
						}
					}
				},
				'permission_callback' => function ( $request ) {
					return current_user_can( 'edit_post', $request["id"] );
				},
			]
		);
	}
}

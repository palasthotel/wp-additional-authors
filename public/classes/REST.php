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
					// register_rest_field() knows get_callback, update_callback and
					// schema - a permission_callback here was silently ignored, so the
					// check is done in the callback itself. Core already refuses the
					// request without edit_post; this is belt and braces, and it keeps
					// the check where it actually runs.
					if ( ! current_user_can( 'edit_post', $post->ID ) ) {
						return new \WP_Error(
							'additional_authors_cannot_edit',
							'You are not allowed to edit the authors of this post.',
							array( 'status' => rest_authorization_required_code() )
						);
					}
					if(is_array($value)){
						$ids = array_filter(array_map('intval', $value), function($id){
							return $id > 0 && get_userdata($id) !== false;
						});
						$this->plugin->database->delete_all_of_post($post->ID);
						foreach ($ids as $userId){
							$this->plugin->database->set($post->ID, $userId);
						}
					}
				},
				'schema'              => array(
					'description' => 'User IDs of all authors of this post, the main author first.',
					'type'        => 'array',
					'items'       => array( 'type' => 'integer' ),
					'context'     => array( 'view', 'edit' ),
				),
			]
		);
	}
}

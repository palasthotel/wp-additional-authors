<?php

namespace AdditionalAuthors;

class Ajax {

	const ACTION_COUNT_POSTS = "additional_authors_count_posts";
	const NONCE_ACTION = "additional_authors_count_posts_nonce";

	public function __construct() {
		// No wp_ajax_nopriv_ counterpart: the only caller is the users list table in
		// wp-admin. The nopriv registration that used to be here pointed at
		// count_post(), a method that does not exist, so an unauthenticated request
		// to this action produced a fatal error.
		add_action("wp_ajax_" . self::ACTION_COUNT_POSTS, [$this, 'count_posts']);
	}

	/**
	 * Returns the number of posts per user id, additional authorships included.
	 *
	 * Requires list_users - the same capability WordPress requires to see the users
	 * list table this is called from.
	 */
	public function count_posts(){
		if(!current_user_can('list_users')){
			wp_send_json_error(null, 403);
		}
		check_ajax_referer(self::NONCE_ACTION);

		if(empty($_GET["user_ids"])) {
			wp_send_json_error(["message" => "missing user_ids"], 400);
		}

		$raw = $_GET["user_ids"];
		if(is_string($raw)){
			$ids = explode(",", $raw);
		} elseif(is_array($raw)) {
			$ids = $raw;
		} else {
			wp_send_json_error(["message" => "invalid user_ids"], 400);
		}

		$ids = array_filter(array_map('intval', $ids), function($id){
			return $id > 0;
		});

		$result = [];
		foreach ($ids as $id) {
			$result[$id] = count_user_posts($id);
		}

		wp_send_json($result);
	}

}

<?php

namespace AdditionalAuthors;

class Ajax {

	public function __construct() {
		add_action("wp_ajax_nopriv_additional_authors_count_posts", [$this, 'count_post']);
		add_action("wp_ajax_additional_authors_count_posts", [$this, 'count_posts']);
	}

	public function count_posts(){
		if(empty($_GET["user_ids"])) return;
		if(is_string($_GET["user_ids"])){
			$ids = explode(",", $_GET["user_ids"]);
		} else {
			$ids = $_GET["user_ids"];
		}

		if(!is_array($ids)) return;

		$ids = array_map('intval', $ids);

		$result = [];
		foreach ($ids as $id) {
			$result[$id] = count_user_posts($id);
		}

		wp_send_json($result);

	}

}
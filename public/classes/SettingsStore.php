<?php


namespace AdditionalAuthors;


class SettingsStore {
	public static function getSupportedPostTypes(){
		return get_post_types([
			'public' => true,
		]);
	}

	public static function isSupportedPostType($post_type){
		return in_array($post_type, static::getSupportedPostTypes());
	}
}
<?php
/**
 * @var \AdditionalAuthors\Render $this
 * @var array $additional_authors_ids
 */

foreach ( $additional_authors_ids as $author_id ) {
	do_action(AdditionalAuthors::ACTION_THE_AUTHOR_POSTS_LINK, $author_id);
}

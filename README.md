# Additional Authors

This is a WordPress plugin to add as much authors to a post as you wish.

## Installation

Like always: copy to wp-content/plugins/additional-authors and activate in backend.

## Usage

Best practice: Use ```do_action('additional_authors_the_authors')``` to render. Optional second parameter can be the post_id if not in context of loop.

## Templates

You can overwrite templates by copying from plugins folder templates to your theme/plugin-parts/*.

## WP_User_Query

If you don't want additional authors to show up when using ```has_published_posts``` argument than you can set ```ignore_published_as_additional_author``` to `TRUE to ignore them.
=== Additional Authors ===
Contributors: palasthotel, edwardbock, greatestview
Donate link: http://palasthotel.de/
Tags: author, meta fields
Requires at least: 4.0
Tested up to: 5.0.3
Stable tag: 1.2.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl

Let's you add more than one author to your posts.

== Description ==

Let's you add more than one author to your posts.

== Installation ==

1. Upload `additional-authors-wordpress.zip` to the `/wp-content/plugins/` directory
1. Extract the Plugin to a `Additional Authors` Folder
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==


== Screenshots ==


== Changelog ==

= 1.2.1 =
 * Feature: Link to user profile page

= 1.2.0 =
 * Ready for 5.0 and Gutenberg
 * Optimization: With Gutenberg editor only the additional authors will be visible in post meta box. The post author was removed and needs to be handle with default post edit controls.
 * Info: post_meta _additional_authors is deprecated and will be will not be saved anymore
 * Bugfix: Delete user

= 1.1.5 =
 * Bugfix: Add empty additional author fix
 * Bugfix: Listen to wordpress author field change

= 1.1.4 =
 * BugFix: authors could not be added because of bad timing with onBlur
 * BugFix: keep order of additional authors
 * Feature: All WP_Query will use additional authors not only on authors page
 * Feature: new filter to set the default for ignoring or using additional authors with WP_Query
 * Optimization: Query manipulation optimization for author page

= 1.1.3 =
 * BugFix: IE11

= 1.1.2 =
 * Extendable meta box

= 1.1.1 =
* Added Gutenberg support
* CSS styles

= 1.1 =
* Author keys move from postmeta to custom table
* SQL Performance optimization

= 1.0 =
* First release

== Upgrade Notice ==

There was an update on query manipulation. Please make shure your results are still as expected/before.


== Arbitrary section ==



